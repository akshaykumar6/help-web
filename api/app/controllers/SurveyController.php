<?php

class SurveyController extends BaseController {

	public static function create(){
		$payloadArray = self::getAllParam();
		try{
			$payloadArray['surveyID'] = self::createNewSurveyEntry($payloadArray);
			self::insertQuestionsAndOptions($payloadArray);
			return json_encode(array(
							"surveyID"		=> $payloadArray['surveyID'],
							"surveyName"	=> $payloadArray['surveyName']
						));
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}

	public static function read($surveyID = null){
		try {
			$response = array();
			if(isset($surveyID)){
				$surveyDBInfo = Survey::where('sur_id', $surveyID)->get()->first();
				if($surveyDBInfo != null && count($surveyDBInfo)>0) {
					$response = self::returnSurveyInformation($surveyDBInfo);
					$questionDBInfo = Questions::where('ques_sur_id',$surveyID)->get()->toArray();
					if($questionDBInfo != null && count($questionDBInfo)>0 ) {
						$response["surveyDetails"] = self::returnQuestionRelatedToSurvey($questionDBInfo);
					} 
					else {
						$response["surveyDetails"] = null;
					}
				} else {
					$response = null;
				}
			} else {
				$surveyDBInfo = Survey::all()->toArray();
				if($surveyDBInfo != null && count($surveyDBInfo)>0) {
					foreach ($surveyDBInfo as  $survey) {
						$currentSurvey = self::returnSurveyInformation($survey);
						$questionDBInfo = Questions::where('ques_sur_id',$survey["sur_id"])->get()->toArray();
						if($questionDBInfo != null && count($questionDBInfo)>0 ) {
							$currentSurvey["surveyDetails"] = self::returnQuestionRelatedToSurvey($questionDBInfo);
							array_push($response, $currentSurvey);
						} else {
							$response["surveyDetails"] = null;
						}
					}
				} else {
					$response = null;
				}
			}
			return json_encode($response);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}

	public static function update($surveyID = null){
		/*try{*/
			$newSurvey = self::getAllParam();
			$originalSurvey = json_decode(self::read($surveyID), true);
			Survey::updateSurveyDetails($newSurvey, $originalSurvey);
			self::updateSurveyQuestionsAndOptions($newSurvey['surveyDetails'], $originalSurvey['surveyDetails'], $newSurvey['surveyID']);
			return self::read($surveyID);
		/*} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}*/
	}

	public static function delete($surveyID = null){
		try{
			Survey::where('sur_id', $surveyID)->delete();
			return json_encode(array("status"=>"success"));
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}

	private static function createNewSurveyEntry($payloadArray){
		$surveyID = Survey::insertGetId(array(
						'sur_name' 			=> $payloadArray['surveyName'],
						'sur_description' 	=> $payloadArray['surveyDescription'],
						'sur_is_sample' 	=> $payloadArray['surveyIsSample']
						));
		return $surveyID;
	}

	private static function insertQuestionsAndOptions(&$questions){
		$insertQuestionData = array();
		$insertOptionData = array();
		self::prepareQuestionAndAnswers($questions, $insertQuestionData, $insertOptionData);
		Questions::insert($insertQuestionData);
		QuestionOptions::insert($insertOptionData);
	}
	private static function prepareQuestionAndAnswers(&$questions, &$insertQuestionData, &$insertOptionData){
		$dbCurrentIndex = -1;
		foreach ($questions["surveyDetails"] as &$question) {
			if($dbCurrentIndex == -1){
				$dbCurrentIndex = Questions::insertQuestionReturnID($question, $questions['surveyID']);
			} else {
				$dbCurrentIndex++;
				$insertQuestionArray = self::prepareQuestionArray($question, $questions['surveyID']);
				array_push($insertQuestionData, $insertQuestionArray);
			}
			$insertOptionArray = self::prepareOptionsArray($question["options"], $dbCurrentIndex);
			$insertOptionData = array_merge($insertOptionData, $insertOptionArray);
			$question["questionID"] = $dbCurrentIndex;
		}
	}

	private static function prepareOptionsArray($options, $questionID){
		$insertOptionData = array();
		if($options!=null && count($options)!=0){
			foreach ($options as $option) {
				array_push($insertOptionData, array(
						"qopt_ques_id"=>$questionID,
						"qopt_description"=>$option["option"]
					));
			}
		}
		return $insertOptionData;
	}

	private static function prepareQuestionArray($question, $surveyID){
		return array(
						"ques_qtype_id"		=> $question["questionType"],
						"ques_description"	=> $question["question"],
						"ques_sur_id"		=> $surveyID
					);
	}
	private static function returnSurveyInformation($surveyDBInfo) {
		$surveyInfo = array();
		$surveyInfo["surveyName"] 		 = $surveyDBInfo['sur_name'];
		$surveyInfo["surveyDescription"] = $surveyDBInfo['sur_description'];
		$surveyInfo["surveyIsSample"]	 = $surveyDBInfo['sur_is_sample'];
		$surveyInfo["surveyID"]			 =	$surveyDBInfo['sur_id'];

		return $surveyInfo;

	}
	private static function returnQuestionRelatedToSurvey($questionDBInfo) {

		$questionsInformation = array();
		
		foreach ($questionDBInfo as  $question) {

         $data = array();
			$data["question"] = $question["ques_description"];
			$data["questionType"] = $question["ques_qtype_id"];
			$data["questionID"] = $question["ques_id"];

			$optionsDBInfo = QuestionOptions::where("qopt_ques_id",$question["ques_id"])->get()->toArray();
			if ($optionsDBInfo != null && count($optionsDBInfo)>0) {
			$data["options"] = self::returnOptionsRelatedToQuestion($optionsDBInfo);

			} else {
				$data["options"] = null;
			}	

			array_push($questionsInformation,$data);
		}
		
		return $questionsInformation;

	}
	private static function returnOptionsRelatedToQuestion($optionsDBInfo=null) {
		$optionsInformation = array();
		
		foreach ($optionsDBInfo as  $option) {
         $data = array();
			$data["option"] = $option["qopt_description"];
			$data["optionID"] = $option["qopt_id"];
			array_push($optionsInformation,$data);			
		}
		return $optionsInformation;
	}
	private static function updateSurveyQuestionsAndOptions($newSurveyQuestionsAndOptions, $originalSurveyQuestionsAndOptions, $surveyID){
		self::processQuestionsExceptDeletingThem($newSurveyQuestionsAndOptions, $originalSurveyQuestionsAndOptions, $surveyID);
	}
	private static function processQuestionsExceptDeletingThem($newSurveyQuestionsAndOptions, $originalSurveyQuestionsAndOptions, $surveyID){
		$questionsOperationArray = array();
		$questionsOperationArray["new"] = array();
		$questionsOperationArray["edit"] = array();
		$questionsOperationArray["delete"] = array();

		$optionsOperationArray = array();
		$optionsOperationArray["new"] = array();
		$optionsOperationArray["edit"] = array();
		$optionsOperationArray["delete"] = array();
		self::hashQuestionsAndOptions($originalSurveyQuestionsAndOptions);

		if($newSurveyQuestionsAndOptions!=null){
			foreach ($newSurveyQuestionsAndOptions as $questionWithOptions) {
				if(isset($questionWithOptions['questionID'])){
					$editedQuestion = self::generateQuestionUpdateArray($questionWithOptions, $originalSurveyQuestionsAndOptions[$questionWithOptions['questionID']]);
					if(count($editedQuestion)){
						array_push($questionsOperationArray['edit'], array($questionWithOptions['questionID']=>$editedQuestion));
					}
					self::iterateOnOptions($optionsOperationArray, $questionWithOptions, $originalSurveyQuestionsAndOptions[$questionWithOptions['questionID']]);
				} else {
					array_push($questionsOperationArray["new"], $questionWithOptions);
				}
			}
		} else {
			foreach ($originalSurveyQuestionsAndOptions as $question) {
				if(isset($question['options'])){
					foreach ($question['options'] as $option) {
						array_push($optionsOperationArray["delete"], $option['optionID']);
					}
				}
			}
		}
		$questionsOperationArray["delete"] = self::deleteQuestions($newSurveyQuestionsAndOptions, $originalSurveyQuestionsAndOptions);

		self::insertNewQuestionsAndOptions($questionsOperationArray, $optionsOperationArray, $surveyID);
		self::deleteQuestionsAndOptions($questionsOperationArray, $optionsOperationArray);
		self::editQuestionsAndOptions($questionsOperationArray, $optionsOperationArray);
	}
	private static function generateQuestionUpdateArray($newQuestion, $originalQuestion){
		$returnData = array();
		if($newQuestion['question'] != $originalQuestion['question']){
			$returnData['question'] = $newQuestion['question'];
		}
		if($newQuestion['questionType'] != $originalQuestion['questionType']){
			$returnData['questionType'] = $newQuestion['questionType'];
		}
		return $returnData;
	}

	private static function iterateOnOptions(&$optionsOperationArray, $newQuestion, $originalQuestion){
		$existingOptionsIDs = array();
		if($newQuestion['options'] != null){
			foreach ($newQuestion['options'] as $option) {
				if(isset($option['optionID'])){
					array_push($existingOptionsIDs, $option['optionID']);
					if($option['option'] != $originalQuestion['options'][$option['optionID']]['option']){
						$optionsOperationArray['edit'][$option['optionID']] = $option['option'];
					}
				} else {
					array_push($optionsOperationArray['new'], array($newQuestion['questionID']=>$option['option']));
				}
			}
		}
		$deleteOptionsArray = array();
		if($newQuestion['options']!= null && count($newQuestion['options'])){
			$deleteOptionsArray = self::deleteOptions($existingOptionsIDs, $originalQuestion['options']);
		} else if(count($originalQuestion['options'])) {
			$deleteOptionsArray = array_keys($originalQuestion['options']);
		}
		$optionsOperationArray['delete'] = array_merge($optionsOperationArray['delete'], $deleteOptionsArray);
	}
	private static function deleteOptions($newSurveyOptionsIDs, $originalOptions){
		$originalSurveyQuestionsIDs = array();
		if(count($originalOptions)){
			$originalSurveyQuestionsIDs = array_keys($originalOptions);
		}
		$deleteOptionIDs = array_diff($originalSurveyQuestionsIDs, $newSurveyOptionsIDs);
		return array_values($deleteOptionIDs);
	}
	private static function deleteQuestions($newSurveyQuestions, $originalSurvey){
		self::hashQuestionsAndOptions($newSurveyQuestions);
		$newSurveyQuestions = array_keys($newSurveyQuestions);
		$originalSurvey 	= array_keys($originalSurvey);
		$deleteQuestionIDs 	= array_diff($originalSurvey, $newSurveyQuestions);
		return array_values($deleteQuestionIDs);
	}
	private static function hashQuestionsAndOptions(&$questionsWithOptions){
		$hashedData = array();
		if($questionsWithOptions!=null){
			foreach ($questionsWithOptions as $question) {
				if(isset($question['questionID'])){
					if($question['options'] != null){
						$options = array();
						foreach ($question['options'] as $option) {
							if(isset($option['optionID'])){
								$options[$option['optionID']] = $option;
							}
						}
						$question['options'] = $options;
					}
					$hashedData[$question['questionID']] = $question;
				}
			}
		}
		$questionsWithOptions = $hashedData;
	}	
	private static function deleteQuestionsAndOptions($questionsOperationArray, $optionsOperationArray){
		if(count($questionsOperationArray["delete"])){
			Questions::whereIn('ques_id', $questionsOperationArray["delete"])->delete();
		}
		if(count($optionsOperationArray["delete"])){
			QuestionOptions::whereIn('qopt_id', $optionsOperationArray["delete"])->delete();
		}
	}
	private static function insertNewQuestionsAndOptions($questionsOperationArray, $optionsOperationArray, $surveyID){
		$questionsQuery = array();
		$optionsQuery = array();
		$questionsOperationArray['new'] = 	array(
												"surveyDetails"	=> $questionsOperationArray["new"],
												"surveyID"		=> $surveyID
											);
		self::prepareQuestionAndAnswers($questionsOperationArray['new'], $questionsQuery, $optionsQuery);
		$optionsCollection = array();
		foreach ($optionsOperationArray["new"] as $option) {
			foreach ($option as $questionID=>$optionDescription) {
				if(!isset($optionsCollection[$questionID])){
					$optionsCollection[$questionID] = array();
				}
				array_push($optionsCollection[$questionID], array("option"=>$optionDescription));
			}
		}
		foreach ($optionsCollection as $questionID => $options) {
			$optionsQuery = array_merge($optionsQuery, self::prepareOptionsArray($options, $questionID));
		}
		if(count($questionsQuery)){
			Questions::insert($questionsQuery);
		}
		if(count($optionsQuery)){
			QuestionOptions::insert($optionsQuery);
		}
	}
	private static function editQuestionsAndOptions($questionsOperationArray, $optionsOperationArray){
		if(count($optionsOperationArray['edit'])){
			$query = "UPDATE question_options SET qopt_description = CASE ";
			foreach ($optionsOperationArray['edit'] as $optionID => $option) {
				$query .= "WHEN qopt_id = '".$optionID."' THEN '".$option."' ";
			}
			$query .= "ELSE qopt_description END";
			DB::statement($query);
		}
		if(count($questionsOperationArray['edit'])){
			$queryMain = "UPDATE questions SET ";
			$descriptionQuery = "ques_description = CASE ";
			$descriptionSetFlag = 0;
			$typeQuery = "ques_qtype_id = CASE ";
			$typeSetFlag = 0;
			foreach ($questionsOperationArray['edit'] as $editQuestion) {
				foreach ($editQuestion as $questionID => $question) {
					if(isset($question["question"])){
						$descriptionSetFlag = 1;
						$descriptionQuery .= "WHEN ques_id = '".$questionID."' THEN '".$question["question"]."' ";
					}
					if(isset($question["questionType"])){
						$typeSetFlag = 1;
						$typeQuery .= "WHEN ques_id = '".$questionID."' THEN '".$question["questionType"]."' ";
					}
				}
			}
			if($descriptionSetFlag && $typeSetFlag){
				$queryMain = $queryMain.$descriptionQuery." ELSE ques_description END ,".$typeQuery. "ELSE ques_qtype_id END";
			} else {
				if($descriptionSetFlag){
					$queryMain = $queryMain.$descriptionQuery." ELSE ques_description END ";
				}
				if($typeSetFlag){
					$queryMain = $queryMain.$typeQuery. "ELSE ques_qtype_id END";
				}
			}
			DB::statement($queryMain);
		}
	}
}
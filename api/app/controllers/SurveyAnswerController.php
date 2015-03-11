<?php
    class SurveyAnswerController extends BaseController {
		

        public static function update(){
			try{
				$surveyAnswers = self::getAllParam();
				$status = self::insertSurveyAnswers($surveyAnswers);
				if($status) {
					return json_encode(array("status"=>"success"));
				}
				
			} catch(Exception $e) {
				return json_encode(array("status"=>$e->getMessage()));
			}
		}


        public static function read(){
            try{
                $payLoad = self::getAllParam();
                $queryData= SimulationUser::where('suser_sim_user_id', $payLoad['simUserID'])->where('suser_sur_id', $payLoad['surveyID'])->where('suser_sim_id', $payLoad['simulationID'])->select('suser_id')->get()->first();
                $questionDbInfo = self::getQuestionFromDb($payLoad['surveyID']);
                $questionIDS = self::getInnerValueFromArray($questionDbInfo,'ques_id');
                $userQuestionAnswerDbInfo = self::getuserQuestionAnswerDbInfo($questionIDS);
                $userQuestionAnswerOptionsDbInfo = self::getuserQuestionAnswerDbOptionsInfo($questionIDS);
                $optionIDS = self::getInnerValueFromArray($userQuestionAnswerOptionsDbInfo,'uqoa_qopt_id');
                $optionsDbInfo = self::getOptionsFromDb($optionIDS);
                $response = array();
                $response['surveyID']   = $payLoad['surveyID'];
                $response['userID']     = $queryData['suser_id'];
                $response['surveyAnswers'] = self::getAllAnswersOfUser($questionDbInfo,$userQuestionAnswerDbInfo,$optionsDbInfo); 
                return json_encode($response);
                 
           } catch(Exception $e) {
                return json_encode(array("status"=>$e->getMessage()));
            }
        }


        private static function getOptionsFromDb($optionIDS) { 
            $resultArray = array();
            $resultArray = QuestionOptions::whereIn('qopt_id',$optionIDS)->get()->toArray();
            return $resultArray;
        }


        private static function getuserQuestionAnswerDbOptionsInfo($questionIDS) { 
            $resultArray = array();
            $resultArray = UserQuestionOptionsAnswers::whereIn('uqoa_uqa_id',$questionIDS)->get()->toArray();
            return $resultArray;
        }


        private static function getuserQuestionAnswerDbInfo($questionIDS) { 
            $resultArray = array();
            $resultArray = UserQuestionAnswers::whereIn('uqa_ques_id',$questionIDS)->get()->toArray();
            return $resultArray;
        }


        private static function getQuestionFromDb($payLoad) { 
            $resultArray = array();
            $resultArray = Questions::where('ques_sur_id',$payLoad)->get()->toArray();
            return $resultArray;
        }


        private static function getInnerValueFromArray($sourceArray,$idName) { 
            $resultArray = array();
            foreach ($sourceArray as  $questionID) {
               
                array_push($resultArray,$questionID[$idName]);
            }
            return $resultArray;
        }
        private static function getAllAnswersOfUser($questionDbInfo,$userQuestionAnswerDbInfo,$optionsDbInfo) {
            $questionArray = array();
            foreach ($questionDbInfo as $questionData) {
                $questionID                     = $questionData['ques_id'];
                $data['questionID']             = $questionData['ques_id'];
                $data['questionDescription']    = $questionData['ques_description'];
                $data['questionType']           = $questionData['ques_qtype_id']; 
                if($data['questionType']==Constant::$SINGLE_ANSWER_MULTIPLE_CHOICE_QUESTION || $data['questionType']== Constant::$MULTIPLE_ANSWER_MULTIPLE_CHOICE_QUESTION ) {
                    $data['answer'] = self::getSelectedOptionDescription($optionsDbInfo,$questionID);
                } else if($data['questionType'] == Constant::$RATING_BASED_QUESTION){
                    $data['answer'] = self::getRatingAnswer($userQuestionAnswerDbInfo,$questionID);
                } else {
                     $data['answer'] = self::getCommentAnswer($userQuestionAnswerDbInfo,$questionID);   
                }
                array_push($questionArray, $data);
            }
            return $questionArray;      
        }


        private static function getRatingAnswer($userQuestionAnswerDbInfo,$questionID) {
            foreach ($userQuestionAnswerDbInfo as $answerData) {
                if( $answerData['uqa_ques_id'] == $questionID ) {
                    return $answerData['uqa_rating'];
                }
            }
            return null;
        }


        private static function getCommentAnswer($userQuestionAnswerDbInfo,$questionID) {
            foreach ($userQuestionAnswerDbInfo as $answerData) {
                if( $answerData['uqa_ques_id'] == $questionID ) {
                    return $answerData['uqa_comment'];
                }
            }
            return null;
        }


        private static function getSelectedOptionDescription($optionsDbInfo,$questionID) {
            $optionsArray = array();
                foreach ($optionsDbInfo as $optionData) {
                    if($optionData['qopt_ques_id'] == $questionID) {
                        $data['optionID'] = $optionData['qopt_id'];
                        $data['optionDescription'] = $optionData['qopt_description'];    
                    }
                    if($data!=null && count($data)>0) {
                        array_push($optionsArray, $data);
                    }
                }
            return $optionsArray;
        }


        public static function delete(){
             try{
                $payLoad = self::getAllParam();
                $queryData= SimulationUser::where('suser_sim_user_id', $payLoad['simUserID'])->where('suser_sur_id', $payLoad['surveyID'])->where('suser_sim_id', $payLoad['simulationID'])->select('suser_id')->get()->first();
               
                $status = self::deleteAnswersForUser($queryData['suser_id']); 
                if($status)  {
                    return json_encode(array("status"=>"success"));
                } else {
                    return json_encode(array("status"=>"failure"));
                    
                }
           } catch(Exception $e) {
                return json_encode(array("status"=>$e->getMessage()));
            }
            
        }


        private static function deleteAnswersForUser($userID){
            $status = UserQuestionAnswers::where('uqa_suser_id',$userID)->delete();
            return $status;
        }


		private static function insertSurveyAnswers($surveyAnswers){
			
			$queryArrayForAnswerTable = array();
			$queryArrayForOptionAnswerTable = array();
			
			foreach ($surveyAnswers['surveyAnswers'] as  $question) {

				switch ($question['questionType']) {
					case 1:
						
						$singleRow = self::insertSingleMCQ($question);
						$singleRow['user_question_answer_query']['uqa_rating'] = null;
						$singleRow['user_question_answer_query']['uqa_comment'] = null;
						break;
					case 2:
						
    					foreach ($question['answer'] as  $optionID) {
    							$data['uqoa_uqa_id'] = $question['questionID'];
    							$data['uqoa_qopt_id'] = $optionID;
    							array_push($queryArrayForOptionAnswerTable, $data);
    					}
						$singleRow['user_question_answer_query']['uqa_rating'] = null;
						$singleRow['user_question_answer_query']['uqa_comment'] = null;
						break;
					case 3:
						$singleRow = self::insertRatingBasedQuestion($question);
						break;
					case 4:
						$singleRow = self::insertCommentBasedQuestion($question);
						break;
					default:
						dd("Error Wrong Question Type");
						break;
				}
				$singleRow['user_question_answer_query']['uqa_suser_id'] = $surveyAnswers['userID'];
				$singleRow['user_question_answer_query']['uqa_ques_id'] = $question['questionID'];
				if($singleRow['user_question_answer_query']!=null && count($singleRow['user_question_answer_query'])>0) {
					array_push($queryArrayForAnswerTable, $singleRow['user_question_answer_query']);
				}
				
					
			}
			
		
			$queryStatus = UserQuestionAnswers::insert($queryArrayForAnswerTable);
			if($queryStatus) {
			$queryStatus = UserQuestionOptionsAnswers::insert($queryArrayForOptionAnswerTable);
			}
			return $queryStatus;
			
		}


		private static function insertSingleMCQ($question){
				$singleRow['user_question_options_answers_query'] = array();
				$singleRow['user_question_options_answers_query']['uqoa_uqa_id'] = $question['questionID'];
				$singleRow['user_question_options_answers_query']['uqoa_qopt_id'] = $question['answer'];
				return $singleRow;
		}	
		

		private static function insertRatingBasedQuestion($question){
				$singleRow['user_question_options_answers_query'] = array();
				$singleRow['user_question_answer_query']['uqa_comment'] = null;
				$singleRow['user_question_answer_query']['uqa_rating'] = $question['answer'];
				return $singleRow;
		}


		private static function insertCommentBasedQuestion($question){
				$singleRow['user_question_options_answers_query'] = array();
				$singleRow['user_question_answer_query']['uqa_rating'] = null;
				$singleRow['user_question_answer_query']['uqa_comment'] = $question['answer'];
				return $singleRow;
		}

	}

?>
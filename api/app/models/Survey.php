<?php
class Survey extends Eloquent{
	protected $table = 'survey';
	protected $primaryKey = 'sur_id';
    public $timestamps = false;

    public static function updateSurveyDetails($newSurvey, $originalSurvey){
    	$updateArray = array();
		if($newSurvey["surveyName"] != $originalSurvey["surveyName"]){
			$updateArray['sur_name'] = $newSurvey["surveyName"];
		}
		if($newSurvey["surveyDescription"] != $originalSurvey["surveyDescription"]){
			$updateArray['sur_description'] = $newSurvey["surveyDescription"];
		}
		if($newSurvey["surveyIsSample"] != $originalSurvey["surveyIsSample"]){
			$updateArray['sur_is_sample'] = $newSurvey["surveyIsSample"];
		}
		if(count($updateArray)){
			Survey::where('sur_id' , $newSurvey['surveyID'])->update($updateArray);
		}
	}
}
?>
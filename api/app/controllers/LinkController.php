<?php

class LinkController extends BaseController {

	public static function create()
	{
		$payloadArray = self::getAllParam();
		try{

			Survey::where('sur_id', $payloadArray['surveyID'])->update(array('sur_sim_id' => $payloadArray['simulationID']));
			$response['status'] = "success";
			return json_encode($response);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}
	public static function delete() {
		$payloadArray = self::getAllParam();
		try{
			$surveySimID = null;
			Survey::where('sur_id', $payloadArray['surveyID'])->where('sur_sim_id',  $payloadArray['simulationID'])->update(array('sur_sim_id' => null));

			$response['status'] = "success";
			return json_encode($response);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}
	public static function read($simulationID = null){
		try {
				if(isset($simulationID)) {
					$surveyDBInfo = Survey::where("sur_sim_id",$simulationID)->get()->toArray();
					if($surveyDBInfo!=null && count($surveyDBInfo)>0) {
					$response = self::getAlltheSurveyAssociated($surveyDBInfo);
					} else {
						$response = null;
					}
					
				} else {
					$simulationIDS = Simulation::select('sim_id')->get()->toArray();
					if($simulationIDS !=null && count($simulationIDS)>0) {
						$surveyDBInfo = Survey::whereIn('sur_sim_id', $simulationIDS)->get()->toArray();
						if($surveyDBInfo!=null && count($surveyDBInfo)>0) {
							$response = self::getAlltheSurveyAssociated($surveyDBInfo);
						} else {
							$response = null;
						}
					} else {
						$response = null;
					}
				}
				return json_encode($response);
			}
			 catch(Exception $e) {
				return json_encode(array("status"=>$e->getMessage()));
			}
	}
	private static function getAlltheSurveyAssociated($surveyDBInfo) {
		$surveyData = array();
		foreach ($surveyDBInfo as  $survey) {
			$data = array();
			$data["surveyID"] 	  = $survey['sur_id'];
			$data["surveyName"]	  = $survey['sur_name'];
			$data["simulationID"] = $survey['sur_sim_id'];
			array_push($surveyData, $data);
		}
		return $surveyData;
	}

}

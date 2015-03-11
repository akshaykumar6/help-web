<?php

class SimulationController extends BaseController {	
	public static function create(){
		$payloadArray = self::getAllParam();
		try{
			$payloadArray['simulationID'] = Simulation::insertGetId(array('sim_name' => $payloadArray['simulationName']));
			return json_encode($payloadArray);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}

	public static function read($simulationID = null){
		try{
			$returnData = array();
			if(isset($simulationID)){
				$simulationData = Simulation::where('sim_id', $simulationID)->select(
						'sim_id as simulationID',
						'sim_name as simulationName'
						)->get()->first();
			} else {
				$simulationData = Simulation::select(
						'sim_id as simulationID',
						'sim_name as simulationName'
					)->get();
			}
			return json_encode($simulationData);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}

	public static function update($simulationID = null){
		$payloadArray = self::getAllParam();
		try{
			Simulation::where('sim_id', $simulationID)->update(array("sim_name"=>$payloadArray['simulationName']));
			return json_encode(array("status"=>"success"));
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}

	public static function delete($simulationID = null){
		try{
			Simulation::where('sim_id', $simulationID)->delete();
			return json_encode(array("status"=>"success"));
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}	
}
<?php

class NeedController extends BaseController {

	public static function create()
	{
		$payloadArray = self::getAllParam();
		//var_dump($payloadArray);
		try{
			$payloadArray['ngoNeedID'] = Need::insertGetId(
										array('nneed_ngo_id' => $payloadArray['ngoID'],
										'nneed_title' 	      => $payloadArray['needTitle'],
										'nneed_desc'			  => $payloadArray['needDesc']
										
										));
			return json_encode($payloadArray);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}
	public static function update()
	{
		$payloadArray = self::getAllParam();
		try{
			$ngoID = Need::where('ngo_need_id', $payloadArray['ngoNeedID'])->update(
										array('nneed_ngo_id' => $payloadArray['ngoID'],
										'nneed_title' 	      => $payloadArray['needTitle'],
										'nneed_desc'			  => $payloadArray['needDesc']
										
										));
		
			return json_encode($payloadArray);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}


	public static function read($ngoNeedID = null){
		try{
			$returnData = array();
			if(isset($ngoNeedID)){
				$returnData = Need::where('ngo_need_id', $ngoNeedID)->select(
						'nneed_ngo_id as ngoID',
						'nneed_title as needTitle',
						'nneed_desc as needDesc'
						)->get()->first();
				
				
			} else {
				return json_encode(array("status"=>"ngoEventID not SET"));
			}
			return json_encode($returnData);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}
	public static function readAll($ngoUserID = null){
		try{
			$returnData = array();
			if(isset($ngoUserID)){
				$returnData = Need::where('nneed_ngo_id', $ngoUserID)->select(
						'ngo_need_id as ngoNeedID',
						'nneed_title as needTitle',
						'nneed_desc as needDesc'
						)->get()->toArray();
				
				
			} else {
				return json_encode(array("status"=>"ngoUserID not SET"));
			}
			return json_encode($returnData);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}

	public static function delete($ngoNeedID = null){
		try{
			$returnData = array();
			if(isset($ngoNeedID)){
				$returnData = Need::where('ngo_need_id', $ngoNeedID)->delete();
				
				
			} else {
				return json_encode(array("status"=>"ngoUserID not SET"));
			}
			return json_encode($returnData);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}



	

}

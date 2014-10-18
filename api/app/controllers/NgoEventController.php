<?php

class NgoEventController extends BaseController {

	public static function create()
	{
		$payloadArray = self::getAllParam();
		//var_dump($payloadArray);
		try{
			$payloadArray['ngoEventID'] = NgoEvent::insertGetId(
										array('nevnt_ngo_id' => $payloadArray['ngoID'],
										'nevnt_event_title' 	      => $payloadArray['eventTitle'],
										'nevnt_event_desc'			  => $payloadArray['eventDesc'],
										'nevnt_date'			      => $payloadArray['eventDate'],
										'nevnt_time'	 		      => $payloadArray['eventTime'],
										'nevnt_venue_desc'			  => $payloadArray['eventVenueDesc'],
										'nevnt_venue_latitude'	 	  => $payloadArray['eventVenueLatitude'],
										'nevnt_venue_longitude'  	  => $payloadArray['eventVenueLongitude']
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
			$ngoID = NgoEvent::where('ngo_event_id', $payloadArray['ngoEventID'])->update(
										array('nevnt_ngo_id' => $payloadArray['ngoID'],
										'nevnt_event_title' 	      => $payloadArray['eventTitle'],
										'nevnt_event_desc'			  => $payloadArray['eventDesc'],
										'nevnt_date'			      => $payloadArray['eventDate'],
										'nevnt_time'	 		      => $payloadArray['eventTime'],
										'nevnt_venue_desc'			  => $payloadArray['eventVenueDesc'],
										'nevnt_venue_latitude'	 	  => $payloadArray['eventVenueLatitude'],
										'nevnt_venue_longitude'  	  => $payloadArray['eventVenueLongitude']
										));
		
			return json_encode($payloadArray);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}


	public static function read($ngoEventID = null){
		try{
			$returnData = array();
			if(isset($ngoEventID)){
				$returnData = NgoEvent::where('ngo_event_id', $ngoEventID)->select(
						'nevnt_ngo_id as ngoID',
						'nevnt_event_title as eventTitle',
						'nevnt_event_desc as eventDesc',
						'nevnt_date as eventDate',
						'nevnt_time as eventTime',
						'nevnt_venue_desc as eventVenueDesc',
						'nevnt_venue_latitude as eventVenueLatitude',
						'nevnt_venue_longitude as eventVenueLongitude'
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
				$returnData = NgoEvent::where('nevnt_ngo_id', $ngoUserID)->select(
						'ngo_event_id as ngoEventID', 
						'nevnt_ngo_id as ngoID',
						'nevnt_event_title as eventTitle',
						'nevnt_event_desc as eventDesc',
						'nevnt_date as eventDate',
						'nevnt_time as eventTime',
						'nevnt_venue_desc as eventVenueDesc',
						'nevnt_venue_latitude as eventVenueLatitude',
						'nevnt_venue_longitude as eventVenueLongitude'
						)->get()->toArray();
				
				
			} else {
				return json_encode(array("status"=>"ngoUserID not SET"));
			}
			return json_encode($returnData);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}

	public static function delete($ngoEventID = null){
		try{
			$returnData = array();
			if(isset($ngoEventID)){
				$returnData = NgoEvent::where('ngo_event_id', $ngoEventID)->delete();
				
				
			} else {
				return json_encode(array("status"=>"ngoUserID not SET"));
			}
			return json_encode($returnData);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}



	

}

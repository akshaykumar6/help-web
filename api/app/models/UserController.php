<?php

class UserController extends BaseController {

	public static function create()
	{
		$payloadArray = self::getAllParam();
		try{
			$payloadArray['ngoUserID'] = User::insertGetId(array('ngo_user_username' => $payloadArray['userName'],
																 'ngo_user_password' => $payloadArray['password'],
																 'ngo_user_name'	 => $payloadArray['ngoUserName']));
			return json_encode($payloadArray);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}
	public static function update()
	{
		$payloadArray = self::getAllParam();
		try{
			$ngoID = User::where('ngo_user_id', $payloadArray['ngoUserID'])->update(
										array('ngo_user_username' => $payloadArray['userName'],
										'ngo_user_password' 	  => $payloadArray['password'],
										'ngo_user_name'			  => $payloadArray['ngoUserName'],
										'ngo_user_address'		  => $payloadArray['userAddress'],
										'ngo_user_city'	 		  => $payloadArray['userCity'],
										'ngo_user_desc'			  => $payloadArray['userDesc'],
										'ngo_user_latitude'	 	  => $payloadArray['userLatitude'],
										'ngo_user_longitude'  	  => $payloadArray['userLongitude'],
										'ngo_user_email'		  => $payloadArray['email'],
										'ngo_user_website'		  => $payloadArray['website'],
										'ngo_user_contact'		  => $payloadArray['contact'],
										));
			$insertArrayForCategory = array();
			echo $payloadArray['ngoUserID'];
			foreach ($payloadArray['category'] as  $categoryID) {
				$data = array();
				$data['ngo_category_cat_id']  =  $categoryID;
				$data['ngo_category_user_id'] =  $payloadArray['ngoUserID'];
				array_push($insertArrayForCategory,$data);
					
			}
			$status = NgoCategory::insert($insertArrayForCategory);
			return json_encode($payloadArray);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}


	public static function read($ngoUserID = null){
		try{
			$returnData = array();
			if(isset($ngoUserID)){
				$returnData = User::where('ngo_user_id', $ngoUserID)->select(
						'ngo_user_username as userName',
						'ngo_user_id as ngoUserID',
						'ngo_user_name as ngoUserName',
						'ngo_user_address as userAddress',
						'ngo_user_city as userCity',
						'ngo_user_desc as userDesc',
						'ngo_user_latitude as userLatitude',
						'ngo_user_longitude as userLongitude',
						'ngo_user_website as website',
						'ngo_user_contact as contact',
						'ngo_user_email as email')->get()->first();
				$returnData['category'] = self::getCategories($ngoUserID);
				
				
			} else {
				return json_encode(array("status"=>"ngoUserID not SET"));
			}
			return json_encode($returnData);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}
	public static function getCategories($ngoUserID = null) {
		$categoryArray = array();
		if(isset($ngoUserID)) {
			$categoryIDs = array();
			$returnData = NgoCategory::where('ngo_category_user_id', $ngoUserID)->get()->toArray();
			foreach ($returnData as  $category) {
				# code...
				
				array_push($categoryIDs, $category['ngo_category_cat_id']);
			}
			$categoryNames = Category::whereIn('category_id',$categoryIDs)->get()->toArray();
			foreach ($categoryNames as $name) {
				# code...
				$data = array();
				$data['categoryName'] = $name['category_name'];
				$data['categoryID']   = $name['category_id'];
				
				array_push($categoryArray,$data);

			}
			
				
		} else {
			echo "ngoUserID not set in category details";
		}
		return $categoryArray;
	}

	
	

	

}

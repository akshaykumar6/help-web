<?php

class CategoryController extends BaseController {

	


	public static function read(){
		try{
			$returnData = array();
			
				$returnData = Category::all()->toArray();
				
				
			
			return json_encode($returnData);
		} catch(Exception $e) {
			return json_encode(array("status"=>$e->getMessage()));
		}
	}
	

}

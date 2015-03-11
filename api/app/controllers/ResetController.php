<?php

class ResetController extends BaseController {

	public function reset() {					//Reset everything except
		try {
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');
			QuestionOptions::truncate();
			Questions::truncate();
			Simulation::truncate();
			SimulationUser::truncate();
			Survey::truncate();
			UserQuestionAnswers::truncate();
			UserQuestionOptionsAnswers::truncate();
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
			return json_encode(array("success"=>"true"));
		} catch(Exception $e) {
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
			return json_encode(array("status"=>$e->getMessage()));
		}
	}
}
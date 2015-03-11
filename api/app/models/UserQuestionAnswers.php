<?php
class UserQuestionAnswers extends Eloquent{
	protected $table = 'user_question_answers';
	protected $primaryKey = 'uqa_id';
	public $timestamps = false;
}
?>
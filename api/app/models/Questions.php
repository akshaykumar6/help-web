<?php
class Questions extends Eloquent{
	protected $table = 'questions';
	protected $primaryKey = 'ques_id';
    public $timestamps = false;

    public static function insertQuestionReturnID($question, $surveyID){
        $id = Questions::insertGetId(array(
                    'ques_qtype_id'     => $question['questionType'],
                    'ques_sur_id'       => $surveyID,
                    'ques_description'  => $question['question']
                ));
        return $id;
    }
}
?>
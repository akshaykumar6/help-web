<?php
class User extends Eloquent{
	protected $table = 'ngo_user';
	protected $primaryKey = 'ngo_user_id';
    public $timestamps = false;
   
    
}
?>
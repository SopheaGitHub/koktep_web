<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usergroup extends Model {

	protected $table = 'user_group';
	protected $fillable = ['name', 'permission', 'default'];

	public function getUsergroup($user_group_id) {
		$result = Usergroup::where('user_group_id', '=', $user_group_id)->first();
		return $result;
	}

	public function getUsergroups($filter_data=[]) {
		$db = Usergroup::orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

	public function destroyUserGroups($array_id) {
		$result = Usergroup::whereIn('user_group_id', $array_id)->delete();
		return $result;
	}

	public function validationForm($datas=[]) {
		$error = false;
		$rules = [
            'name' => 'required'
        ];

        $messages = [
        	'name.required' => 'The <b>User Group Name</b> field is required.'
        ];

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=>'Warning : save user group unsuccessfully!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}

}

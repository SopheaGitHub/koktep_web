<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Setting extends Model {

	public $timestamps = false;

	protected $table = 'setting';
	protected $fillable = ['website_id', 'code', 'key', 'value'];

	public function getSettings($website_id) {
		$db = Setting::where('website_id', '=', $website_id)->get();
		return $db;
	}

	public function editSetting($datas=[]) {
		$sql = '';
		foreach ($datas as $key => $value) {
			$sql .= " UPDATE `setting` SET `value`='".$value."' WHERE `key` = '".$key."'; ";
		}
		DB::connection()->getPdo()->exec($sql);
	}

	public function destroySetting($code, $website_id = 1) {
		DB::table('setting')->where('website_id', '=', $website_id)->where('code', '=', $code)->delete();
	}
	
	public function validationForm($datas=[]) {
		$error = false;
		$rules = [
            'config_meta_title'	=> 'required',
            'config_name'		=> 'required',
            'config_owner'		=> 'required',
            'config_address'	=> 'required',
            'config_email'		=> 'required',
            'config_telephone'	=> 'required',
            'config_limit_admin'=> 'required|integer'
        ];

        $messages = [
        	'config_meta_title.required'=> 'The <b>Meta Title</b> field is required.',
        	'config_name.required' 		=> 'The <b>Website Name</b> field is required.',
        	'config_owner.required' 	=> 'The <b>Website Owner</b> field is required.',
        	'config_address.required' 	=> 'The <b>Address</b> field is required.',
        	'config_email.required' 	=> 'The <b>E-Mail</b> field is required.',
        	'config_telephone.required' => 'The <b>Telephone</b> field is required.',
        	'config_limit_admin.required' => 'The <b>Default Lists Per Page (Admin)</b> field is required.',
        	'config_limit_admin.integer'=> 'The <b>Default Lists Per Page (Admin)</b> must be an integer.'
        ];

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=>'Warning : save setting unsuccessfully!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}

}

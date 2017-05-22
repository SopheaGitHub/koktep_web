<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {

	protected $table = 'language';
	protected $fillable = ['name', 'code', 'locale', 'image', 'directory', 'sort_order', 'status'];

	public function getLanguage($language_id) {
		$result = Language::where('language_id', '=', $language_id)->first();
		return $result;
	}

	public function getLanguages($filter_data=[]) {
		$db = Language::where('status', '=', '1')->orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

    public function destroyLanguages($array_id) {
        $result = Language::whereIn('language_id', $array_id)->delete();
        return $result;
    }

	public function validationForm($datas=[]) {
		$error = false;
		$rules = [
            'name'	=> 'required|between:3,32',
            'code'	=> 'required|max:5',
            'image'	=> 'required|max:64',
            'directory'	=> 'required|max:32',
            'sort_order'=> 'required|integer'
        ];

        $messages = [
        	'name.required' => 'The <b>Language Name</b> field is required.',
        	'name.between' => 'The <b>Language Name</b> must be between 3 and 32 characters.',
        	'code.required' => 'The <b>Code</b> field is required.',
        	'code.max' => 'The <b>Code</b> may not be greater than 5 characters.',
        	'image.required' => 'The <b>Image</b> field is required.',
        	'image.max' => 'The <b>Image</b> may not be greater than 64 characters.',
        	'directory.required' => 'The <b>Directory</b> field is required.',
        	'directory.max' => 'The <b>Directory</b> may not be greater than 32 characters.',
        	'sort_order.required' => 'The <b>Sort Order</b> field is required.',
        	'sort_order.integer' => 'The <b>Sort Order</b> must be an integer.'
        ];

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=>'Warning : save language unsuccessfully!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}

}

<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model {

	protected $table = 'currency';
	protected $fillable = ['title', 'code', 'symbol_left', 'symbol_right', 'decimal_place', 'value', 'status'];

	public function getCurrency($currency_id) {
		$result = Currency::where('currency_id', '=', $currency_id)->first();
		return $result;
	}

	public function getCurrencies($filter_data=[]) {
		$db = Currency::orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

	public function destroyCurrencies($array_id) {
		$result = Currency::whereIn('currency_id', $array_id)->delete();
		return $result;
	}

	public function validationForm($datas=[]) {
		$error = false;
		$rules = [
            'title'	=> 'required|between:3,32',
            'code'	=> 'required|between:3,3',
            'value'=> 'required|numeric'
        ];

        $messages = [
        	'title.required' => 'The <b>Currency Title</b> field is required.',
        	'title.between' => 'The <b>Currency Title</b> must be between 3 and 32 characters.',
        	'code.required' => 'The <b>Code</b> field is required.',
        	'code.between' => 'The <b>Code</b> must contain 3 characters.',
        	'value.required'	=> 'The <b>Value</b> field is required.',
        	'value.numeric'	=> 'The <b>Value</b> must be a number.'
        ];

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=>'Warning : save currency unsuccessfully!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}

}

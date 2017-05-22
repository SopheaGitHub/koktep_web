<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

	protected $table = 'country';
	protected $fillable = ['name', 'iso_code_2', 'iso_code_3', 'address_format', 'postcode_required', 'status'];

	public function getCountry($country_id) {
		$result = Country::where('country_id', '=', $country_id)->first();
		return $result;
	}

	public function getCountries($filter_data=[]) {
		$db = Country::orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

	public function destroyCountries($array_id) {
		$result = Country::whereIn('country_id', $array_id)->delete();
		return $result;
	}

	public function validationForm($datas=[]) {
		$error = false;
		$rules = [
            'name'			=> 'required',
            'iso_code_2'	=> 'between:2,2',
            'iso_code_3'	=> 'between:3,3',
        ];

        $messages = [
        	'name.required' => 'The <b>Country Name</b> field is required.',
        	'iso_code_2.between' => 'The <b>ISO Code (2)</b> must contain 2 characters.',
        	'iso_code_3.between' => 'The <b>ISO Code (3)</b> must contain 3 characters.',
        ];

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=>'Warning : save country unsuccessfully!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}

}

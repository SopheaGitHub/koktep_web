<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Zone extends Model {

	protected $table = 'zone';
	protected $fillable = ['country_id', 'name', 'code', 'status'];

	public function getZone($zone_id) {
		$result = Zone::where('zone_id', '=', $zone_id)->first();
		return $result;
	}

	public function getZones($filter_data=[]) {
		$db = DB::table('zone as z')
		->select('z.*', 'c.name as country_name')
		->join('country as c', 'c.country_id', '=', 'z.country_id')
		->orderBy('z.'.$filter_data['sort'], $filter_data['order']);
		return $db;
	}

	public function getZonesByContry($country_id) {
		$result = Zone::where('country_id', '=', $country_id)->orderBy('name', 'asc')->lists('name', 'zone_id');
		return $result;
	}

	public function getArrayZonesByContryID($country_id) {
		$result = DB::table('zone')->where('country_id', '=', $country_id)->where('status', '=', '1')->orderBy('name', 'asc')->get();
		return $result;
	}

	public function destroyZones($array_id) {
		$result = Zone::whereIn('zone_id', $array_id)->delete();
		return $result;
	}

	public function validationForm($datas=[]) {
		$error = false;
		$rules = [
            'name'			=> 'required',
            'code'			=> 'max:32',
        ];

        $messages = [
        	'name.required' => 'The <b>Country Name</b> field is required.',
        	'code.max' => 'The <b>Code</b> may not be greater than 32 characters.'
        ];

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=>'Warning : save zone unsuccessfully!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}

}

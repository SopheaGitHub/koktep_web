<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;

class GeoZone extends Model {

	protected $table = 'geo_zone';
	protected $fillable = ['name', 'description'];

	public function getGeoZone($geo_zone_id) {
		$result = GeoZone::where('geo_zone_id', '=', $geo_zone_id)->first();
		return $result;
	}

	public function getGeoZones($filter_data=[]) {
		$db = GeoZone::orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

	public function getZoneToGeoZones($geo_zone_id) {
		$result = DB::table('zone_to_geo_zone')->where('geo_zone_id', '=', $geo_zone_id)->get();
		return $result;
	}

	public function insertZoneToGeoZone($datas=[]) {
		$sql = '';
		if(isset($datas['zone_to_geo_zone_datas']) && count($datas['zone_to_geo_zone_datas']) > 0) {
			foreach ($datas['zone_to_geo_zone_datas'] as $zone_to_geo_zone) {
				$sql .= " INSERT INTO `zone_to_geo_zone`(`country_id`, `zone_id`, `geo_zone_id`) VALUES ('".$zone_to_geo_zone['country_id']."', '".$zone_to_geo_zone['zone_id']."', '".$datas['geo_zone_id']."'); ";
			}
			DB::connection()->getPdo()->exec($sql);
		}
	}

	public function deletedZoneToGeoZone($geo_zone_id) {
		DB::table('zone_to_geo_zone')->where('geo_zone_id', '=', $geo_zone_id)->delete();
	}

	public function destroyGeoZones($array_id) {
		$result = GeoZone::whereIn('geo_zone_id', $array_id)->delete();
		return $result;
	}

	public function validationForm($datas=[]) {
		$error = false;
		$rules = [
            'name'			=> 'required|max:32',
            'description'	=> 'required',
        ];

        $messages = [
        	'name.required' => 'The <b>Name</b> field is required.',
        	'name.max' => 'The <b>Name</b> may not be greater than 32 characters.',
        	'description.required' => 'The <b>Description</b> field is required.'
        ];

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=>'Warning : save geo-zone unsuccessfully!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}

}

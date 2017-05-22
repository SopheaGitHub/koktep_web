<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Module extends Model {

	public $timestamps = false;

	protected $table = 'module';
	protected $fillable = ['name', 'code', 'setting'];

	public function getLayouts($filter_data=[]) {
		$db = Layout::orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

	public function getModule($module_id) {
		$result = Module::where('module_id', '=', $module_id)->first();
		if (count($result) > 0) {
			return json_decode($result->setting, true);
		} else {
			return array();
		}
	}

	public function destroyModule($module_id) {
		DB::table('module')->where('module_id', '=', $module_id)->delete();
		DB::table('layout_module')->where('code', 'like', '%'.$module_id.'')->delete();
	}

	public function destroyModulesByCode($code) {
		DB::table('module')->where('code', '=', $code)->delete();
		DB::table('layout_module')->where('code', 'like', $code)->orWhere('code', 'like', '' . $code . '.%' . '')->delete();
	}

}

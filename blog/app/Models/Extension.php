<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Module;
use DB;

class Extension extends Model {

	
	public $timestamps = false;

	protected $table = 'extension';
	protected $fillable = ['type', 'code'];

	public function getInstalled($type) {
		$extension_data = [];
		$result = Extension::where('type', '=', $type)->orderBy('code', 'asc')->get()->toArray();
		foreach ($result as $key => $value) {
			$extension_data[] = $value['code'];
		}

		return $extension_data;
	}

	public function getModulesByCode($code) {
		$result = Module::where('code', '=', $code)->orderBy('name', 'asc')->get()->toArray();
		return $result;
	}

	public function installExtension($type, $code) {
		$extension = Extension::create(['type'=>$type, 'code'=>$code]);
		return $extension;
	}

	public function uninstallExtension($type, $code) {
		DB::table('extension')->where('type', '=', $type)->where('code', '=', $code)->delete();
	}

}

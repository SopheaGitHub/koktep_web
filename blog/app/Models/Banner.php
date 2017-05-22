<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BannerImage;
use DB;

class Banner extends Model {

	public $timestamps = false;

	protected $table = 'banner';
	protected $fillable = ['name', 'status'];

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	public function getBanner($banner_id) {
		$result = Banner::where('banner_id', '=', $banner_id)->first();
		return $result;
	}

	public function getBanners($filter_data=[]) {
		$db = Banner::orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

	public function getBannerImages($banner_id) {
		$banner_image_data = [];

		$banner_image_query = DB::select("SELECT * FROM banner_image WHERE banner_id = '" . $banner_id . "' ORDER BY sort_order ASC");

		foreach ($banner_image_query as $banner_image) {
			$banner_image_description_data = [];

			$banner_image_description_query = DB::select("SELECT * FROM banner_image_description WHERE banner_image_id = '" . $banner_image->banner_image_id . "' AND banner_id = '" . $banner_id . "'");

			foreach ($banner_image_description_query as $banner_image_description) {
				$banner_image_description_data[$banner_image_description->language_id] = ['title' => $banner_image_description->title];
			}

			$banner_image_data[] = [
				'banner_image_description' => $banner_image_description_data,
				'link'                     => $banner_image->link,
				'image'                    => $banner_image->image,
				'sort_order'               => $banner_image->sort_order
			];
		}

		return $banner_image_data;
	}

	public function insertBannerImage($datas=[]) {
		$sql = '';
		if (isset($datas['banner_image']) && count($datas['banner_image']) > 0) {
			foreach ($datas['banner_image'] as $banner_image) {
				$banner_imageDatas = [
					'banner_id' => $datas['banner_id'],
					'link' 		=> $banner_image['link'],
					'image' 	=> $banner_image['image'],
					'sort_order'=> $banner_image['sort_order']
				];

				$banner_imageObj = BannerImage::create($banner_imageDatas);

				$banner_image_id = $banner_imageObj->id;

				foreach ($banner_image['banner_image_description'] as $language_id => $banner_image_description) {
					$sql .= "INSERT INTO banner_image_description SET banner_image_id = '" . $banner_image_id . "', language_id = '" . $language_id . "', banner_id = '" . $datas['banner_id'] . "', title = '" .  $banner_image_description['title'] . "'; ";
				}
			}
			DB::connection()->getPdo()->exec($sql);
		}
	}

	public function deletedBannerImage($banner_id) {
		DB::table('banner_image')->where('banner_id', '=', $banner_id)->delete();
	}

	public function deletedBannerImageDescription($banner_id) {
		DB::table('banner_image_description')->where('banner_id', '=', $banner_id)->delete();
	}

	public function destroyBanners($array_id) {
		DB::table('banner')->whereIn('banner_id', $array_id)->delete();
		DB::table('banner_image')->whereIn('banner_id', $array_id)->delete();
		DB::table('banner_image_description')->whereIn('banner_id', $array_id)->delete();
	}

	public function validationForm($datas=[]) {
		$error = false;
		$rules = [
            'name'			=> 'required'
        ];

        $messages = [
        	'name.required' => 'The <b>Banner Name</b> field is required.',
        ];

        if(isset($datas['request']['banner_image'])) {
        	$i = 1;
        	foreach($datas['request']['banner_image'] as $key => $val) {
				$rules['banner_image.'.$key.'.sort_order'] = 'integer';
				$messages['banner_image.'.$key.'.sort_order.integer'] = 'The <b>Banner Image ('.$i.') Sort Order </b> must be an integer.';
				$i++;
			}
        }

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=>'Warning : save banner unsuccessfully!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Common\FilemanagerController;
use DB;

class ExhibitionRequest extends Model
{
    protected $table = 'exhibition_request';
	protected $fillable = ['exhibition_id', 'user_id', 'name', 'phone', 'category_id', 'file', 'title', 'description', 'sort_order', 'status'];

	public function getAllExhibitionRequests($filter_data=[]) {
		$db = DB::table('exhibition_request as er')->select('er.id AS request_id', 'er.file', 'cd.name AS category_name', 'title AS file_title');
		$db->join('category_description as cd', function($join) {
		  	$join->on('cd.category_id', '=', 'er.category_id');
		  	$join->on('cd.language_id', '=', DB::raw('1'));
		});
		$db->where('er.status', '=', '1')->orderBy('er.created_at', 'desc');
		return $db;
	}

	public function validationForm($datas=[]) {
        $filemanagerObj = new FilemanagerController();
        $json_error = '';
		$error = false;
		$rules = [
            'name'			=> 'required',
            'phone'			=> 'required',
            // 'email'			=> 'required|email',
            'category_id'	=> 'required',
            // 'file'          => 'required',
            'title'			=> 'required',
            'description'	=> 'required|max:255'
        ];

        $messages = [
        	'name.required' 	=> 'The <b>Name</b> field is required.',
        	'phone.required'		=> 'The <b>Phone</b> field is required.',
            // 'email.required'	=> 'The <b>Email</b> field is required.',
            // 'email.email'    => 'The <b>Email</b> field is invalid email.',
            'category_id.required'	=> 'The <b>Category</b> field is required.',
            // 'file.required'	=> 'The <b>Upload Image/Photo</b> field is required.',
            'title.required'	=> 'The <b>Title</b> field is required.',
            'description.required' => 'The <b>Description</b> field is required.',
            'description.max' => 'The <b>Description</b> may not be greater than 255 characters.'
        ];

        $file_respone = $filemanagerObj->storeFile($datas['request'], 0);
        if(isset($file_respone['json']['error'])) {
            foreach ($file_respone['json'] as $key => $value) {
                if($key=='error') {
                    $json_error .= 'The <b>Upload Image/Photo</b> field is '.$value.'<br />';
                    $rules['error_file'] = 'required';
                    $messages['error_file.required'] = str_replace('No file was uploaded', 'required', $json_error);
                }
            }
        }

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=>'Warning : Request exhibition unsuccessfully!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}
}

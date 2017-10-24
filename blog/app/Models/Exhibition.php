<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Common\FilemanagerController;
use DB;

class Exhibition extends Model
{
    protected $table = 'exhibition';
    protected $fillable = ['user_id', 'title', 'open_date', 'close_date', 'status'];

    public function checkIfUserExistRequest($user_id, $exhibition_id) {
    	// status = 3 refer to reject
    	$result = DB::table('exhibition_request AS er')
    	->where('user_id', '=', $user_id)
    	->where('exhibition_id', '=', $exhibition_id)
    	// ->where('category_id', '=', $category_id)
    	->where('status', '!=', '3')->get(['category_id', 'phone']);
        
    	return $result;
    }

    public function getExhibitionById($exhibition_id) {
        $result = DB::table('exhibition')->where('id', '=', $exhibition_id)->first();
        return $result;
    }

    public function getArrayCategories($data_filter=[]) {
        $db = DB::table('category_description AS cd')->where('cd.language_id', '=', '1');
        if(isset($data_filter['array_categories']) && count($data_filter['array_categories']) > 0) {
            $db->whereIn('cd.category_id', $data_filter['array_categories']);
        }
        $result = $db->orderBy('cd.category_id', 'asc')->lists('cd.name', 'cd.category_id');
        return $result;
    }

    public function getExhibitionApproved($exhibition_id) {
        $result = DB::table('exhibition_approved')->where('exhibition_id', '=', $exhibition_id)->first();
        return $result;
    }

    public function getAllApprovedToRequestDatas($data_filter=[]) {
        $result = [];
        $db = DB::table('exhibition_request AS er')
        ->join('users AS u', 'u.id', '=', 'er.user_id')
        ->select(DB::raw('
                er.id AS request_id,
                u.image AS user_profile,
                (SELECT SUM(star) AS total_rating FROM rating WHERE rating_of_id = er.id AND rating_type_id = 3 ) AS total_rating,
                (SELECT star FROM rating WHERE user_id = '.$data_filter['auth_id'].' AND rating_of_id = er.id AND rating_type_id = 3 ) AS auth_star,
                er.user_id,
                er.name,
                er.file,
                er.title,
                er.description
            '));

        if($data_filter['array_approved_id'] != '') {
            $db->whereIn('er.id', $data_filter['array_approved_id']);
        }
        if($data_filter['category_id'] != '') {
            $db->where('er.category_id', '=', $data_filter['category_id']);
        }

        $result = $db->get();
        return $result;
    }

}

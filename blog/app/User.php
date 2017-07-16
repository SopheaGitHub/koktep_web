<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image', 'first_cover', 'second_cover', 'description', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getUser($user_id) {
        $result = User::where('id', '=', $user_id)->first();
        return $result;
    }

    public function getUsers($filter_data=[]) {
        $db = DB::table('users as u')
        ->select(DB::raw('u.id AS people_id,
                        u.name AS people_name,
                        u.image AS image,
                        (SELECT SUM(viewed) FROM post WHERE author_id = u.id) AS viewed,
                        (SELECT COUNT(p.post_id) FROM post AS p INNER JOIN post_comment AS pc ON pc.post_id = p.post_id WHERE p.author_id = u.id) AS commented
                        '));

        // category condition join
        if($filter_data['category_id']!='') {
            $db->join(DB::raw("( SELECT uptc.category_id, up.post_id, up.author_id FROM post AS up INNER JOIN post_to_category AS uptc ON uptc.post_id = up.post_id WHERE uptc.category_id = '".$filter_data['category_id']."' ORDER BY uptc.post_id DESC LIMIT 1 ) AS category"), 'category.author_id', '=', 'u.id');
        }

        if($filter_data['search']!='') {
            $db->whereRaw(" u.name LIKE '%".$filter_data['search']."%' ");
        }

        if($filter_data['time']!='') {
            switch ($filter_data['time']) {
                case 'today':
                    $db->whereRaw(" DATE(u.created_at) = '" . date('Y-m-d') . "' ");
                    break;
                case 'this_week':
                    $db->whereRaw(" DATE(u.created_at) BETWEEN '".date('Y-m-d', strtotime('monday this week'))."' AND '".date('Y-m-d', strtotime('sunday this week'))."' ");
                    break;
                case 'this_month':
                    $db->whereRaw(" DATE(u.created_at) BETWEEN '".date('Y-m-d', strtotime('first day of this month'))."' AND '".date('Y-m-d', strtotime('last day of this month'))."' ");
                    break;
                case 'this_year':
                    $db->whereRaw(" DATE(u.created_at) BETWEEN '".date('Y-m-d', strtotime('first day of January '.date('Y') ))."' AND '".date('Y-m-d', strtotime('last day of December '.date('Y') ))."' ");
                    break;
                default:
                    # code...
                    break;
            }
        }

        if($filter_data['alpha']!='') {
            $db->whereRaw(" u.name LIKE '".$filter_data['alpha']."%' ");
        }

        if($filter_data['country_id']!='') {
            $db->join(DB::raw("(SELECT uac.country_id, uac.user_id FROM user_address AS uac WHERE uac.country_id = '".$filter_data['country_id']."' ORDER BY uac.sort_order DESC LIMIT 1) AS country"), 'country.user_id', '=', 'u.id');
        }

        if($filter_data['zone_id']!='') {
            $db->join(DB::raw("(SELECT uaz.zone_id, uaz.user_id FROM user_address AS uaz WHERE uaz.zone_id = '".$filter_data['zone_id']."' ORDER BY uaz.sort_order DESC LIMIT 1) AS zone"), 'zone.user_id', '=', 'u.id');
        }
        
        if($filter_data['browse']!='') {
            $db->orderBy($filter_data['browse'], $filter_data['order']);
        }

        $db->orderBy($filter_data['sort'], $filter_data['order']);
        return $db;
    }

    public function getAutocompleteUsers($filter_data=[]) {
        $db = DB::table(DB::raw('
                (
                    SELECT
                        u.id AS user_id,
                        u.name AS name
                    FROM
                        users AS u
                ) AS users
            '));
        if ($filter_data['filter_title']!='') {
            $db->where('name', 'like', '%'.$filter_data['filter_title'].'%');
        }
        $db->orderBy($filter_data['sort'], $filter_data['order'])->take($filter_data['limit']);
        $result = $db->get();
        return $result;
    }

    public function getTechnicalByUserId($user_id) {
        $result = DB::table('user_technical')->where('user_id', '=', $user_id)->orderBy('sort_order', 'asc')->get();
        return $result;
    }

    public function getAddressByUserId($user_id) {
        $result = DB::table('user_address')->where('user_id', '=', $user_id)->orderBy('sort_order', 'asc')->get();
        return $result;
    }

    public function getSocialMediaByUserId($user_id) {
        $result = DB::table('user_to_social_media AS utsm')
        ->select('utsm.*', 'sm.name AS social_media_name', 'sm.icon AS social_media_icon')
        ->join('social_media AS sm', 'sm.social_media_id', '=', 'utsm.social_media_id')
        ->where('utsm.user_id', '=', $user_id)->orderBy('utsm.sort_order', 'asc')->get();
        return $result;
    }

    public function getWatermarkByUserId($user_id) {
        $result = DB::table('user_watermark')
        ->where('user_id', '=', $user_id)->first();
        return $result;
    }

    public function insertUserTechnical($datas=[]) {
        $sql = '';
        if (isset($datas['user_technicals']) && count($datas['user_technicals']) > 0) {
            foreach ($datas['user_technicals'] as $user_technical) {
                $sql .= "INSERT INTO user_technical SET user_id = '" . $datas['user_id'] . "', skill = '" . htmlspecialchars($user_technical['skill']) . "', percent = '" . htmlspecialchars($user_technical['percent']) . "', min_charge = '" . htmlspecialchars($user_technical['min_charge']) . "', max_charge = '" . htmlspecialchars($user_technical['max_charge']) . "', sort_order = '" . htmlspecialchars($user_technical['sort_order']) . "'; ";
            }
            DB::connection()->getPdo()->exec($sql);
        }
    }

    public function insertUserAddress($datas=[]) {
        $sql = '';
        if (isset($datas['user_address']) && count($datas['user_address']) > 0) {
            foreach ($datas['user_address'] as $address) {
                $sql .= "INSERT INTO user_address SET user_id = '" . $datas['user_id'] . "', firstname = '" . htmlspecialchars($address['firstname']) . "', lastname = '" . htmlspecialchars($address['lastname']) . "', company = '" . htmlspecialchars($address['company']) . "', phone = '" . htmlspecialchars($address['phone']) . "', fax = '" . htmlspecialchars($address['fax']) . "', email = '" . htmlspecialchars($address['email']) . "', website = '" . htmlspecialchars($address['website']) . "', address = '" . htmlspecialchars($address['address']) . "', city = '" . htmlspecialchars($address['city']) . "', postcode = '" . htmlspecialchars($address['postcode']) . "', country_id = '" . htmlspecialchars($address['country_id']) . "', zone_id = '" . htmlspecialchars($address['zone_id']) . "', sort_order = '0'; ";
            }
            DB::connection()->getPdo()->exec($sql);
        }
    }

    public function insertUserSocialMedia($datas=[]) {
        $sql = '';
        if (isset($datas['user_social_medias']) && count($datas['user_social_medias']) > 0) {
            foreach ($datas['user_social_medias'] as $social_media) {
                $sql .= "INSERT INTO user_to_social_media SET user_id = '" . $datas['user_id'] . "', social_media_id = '" . htmlspecialchars($social_media['social_media_id']) . "', link = '" . htmlspecialchars($social_media['link']) . "', sort_order = '" . htmlspecialchars($social_media['sort_order']) . "'; ";
            }
            DB::connection()->getPdo()->exec($sql);
        }
    }

    public function insertUserWatermark($datas=[]) {
        $sql = '';
        if (isset($datas['user_watermarks']) && count($datas['user_watermarks']) > 0) {
            $sql .= "INSERT INTO user_watermark SET user_id = '" . $datas['user_id'] . "', image = '" . htmlspecialchars($datas['user_watermarks']['image']) . "', position = '" . htmlspecialchars($datas['user_watermarks']['position']) . "', status = '" . htmlspecialchars($datas['user_watermarks']['status']) . "'; ";
            DB::connection()->getPdo()->exec($sql);
        }
    }

    public function deletedUserTechnical($user_id) {
        DB::table('user_technical')->where('user_id', '=', $user_id)->delete();
    }

    public function deletedUserAddress($user_id) {
        DB::table('user_address')->where('user_id', '=', $user_id)->delete();
    }

    public function deletedUserSocialMedia($user_id) {
        DB::table('user_to_social_media')->where('user_id', '=', $user_id)->delete();
    }

    public function deletedWatermark($user_id) {
        DB::table('user_watermark')->where('user_id', '=', $user_id)->delete();
    }

    public function validationSettingForm($datas=[]) {
        $error = false;
        $rules = [];
        $messages = [];

        $rules['name'] = 'required|max:255';
        $rules['email'] = 'required|max:255|email';

        $messages['name.required'] = trans('text.name_required');
        $messages['name.max'] = trans('text.name_max255');
        
        $messages['email.required'] = trans('text.email_required');
        $messages['email.max'] = trans('text.email_max255');
        $messages['email.email'] = trans('text.email_valid');
        
        

        if(isset($datas['request']['user_technical'])) {
            $i = 1;
            foreach($datas['request']['user_technical'] as $key => $val) {
                $rules['user_technical.'.$key.'.skill'] = 'required|max:255';
                $rules['user_technical.'.$key.'.percent'] = 'integer';
                $rules['user_technical.'.$key.'.min_charge'] = 'integer';
                $rules['user_technical.'.$key.'.max_charge'] = 'integer';
                $rules['user_technical.'.$key.'.sort_order'] = 'integer';
                $messages['user_technical.'.$key.'.skill.required'] = trans('text.before_add_skill').' ('.$i.') '. trans('text.technical_skill_required') ;
                $messages['user_technical.'.$key.'.skill.max'] = trans('text.before_add_skill').' ('.$i.') '. trans('text.technical_skill_max') ;
                
                $messages['user_technical.'.$key.'.percent.integer'] = trans('text.before_add_skill').' ('.$i.') '. trans('text.technical_percent_integer') ;
                $messages['user_technical.'.$key.'.min_charge.integer'] = trans('text.before_add_skill').' ('.$i.') '. trans('text.technical_min_charge_integer') ;
                $messages['user_technical.'.$key.'.max_charge.integer'] = trans('text.before_add_skill').' ('.$i.') '. trans('text.technical_max_charge_integer') ;
                $messages['user_technical.'.$key.'.sort_order.integer'] = trans('text.before_add_skill').' ('.$i.') '. trans('text.technical_sort_order_integer') ;
                $i++;
            }
        }

        if(isset($datas['request']['user_address'])) {
            $i = 1;
            foreach($datas['request']['user_address'] as $key => $val) {
                $rules['user_address.'.$key.'.firstname'] = 'required|max:32';
                $rules['user_address.'.$key.'.lastname'] = 'required|max:32';
                $rules['user_address.'.$key.'.email'] = 'required|email|max:100';
                $rules['user_address.'.$key.'.address'] = 'required|max:255';
                $rules['user_address.'.$key.'.city'] = 'required|max:100';
                $rules['user_address.'.$key.'.country_id'] = 'required|integer';
                $rules['user_address.'.$key.'.zone_id'] = 'required|integer';
                $rules['user_address.'.$key.'.sort_order'] = 'integer';
                $messages['user_address.'.$key.'.firstname.required'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_firstname_required') ;
                $messages['user_address.'.$key.'.firstname.max'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_firstname_max') ;

                $messages['user_address.'.$key.'.lastname.required'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_lastname_required') ;
                $messages['user_address.'.$key.'.lastname.max'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_lastname_max') ;

                $messages['user_address.'.$key.'.email.required'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_email_required') ;
                $messages['user_address.'.$key.'.email.email'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_email_email') ;
                $messages['user_address.'.$key.'.email.max'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_email_max') ;

                $messages['user_address.'.$key.'.address.required'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_address_required') ;
                $messages['user_address.'.$key.'.address.max'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_address_max') ;

                $messages['user_address.'.$key.'.city.required'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_city_required') ;
                $messages['user_address.'.$key.'.city.max'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_city_max') ;

                $messages['user_address.'.$key.'.country_id.required'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_country_id_required') ;
                $messages['user_address.'.$key.'.country_id.integer'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_country_id_integer') ;
                $messages['user_address.'.$key.'.zone_id.required'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_zone_id_required') ;
                $messages['user_address.'.$key.'.zone_id.integer'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_zone_id_integer') ;
                $messages['user_address.'.$key.'.sort_order.integer'] = trans('text.before_add_address').' ('.$i.') '. trans('text.address_sort_order_integer') ;
                $i++;
            }
        }

        if(isset($datas['request']['user_social_media'])) {
            $i = 1;
            foreach($datas['request']['user_social_media'] as $key => $val) {
                $rules['user_social_media.'.$key.'.social_media_id'] = 'required|integer';
                $rules['user_social_media.'.$key.'.sort_order'] = 'integer';
                $rules['user_social_media.'.$key.'.link'] = 'max:100';
                $messages['user_social_media.'.$key.'.social_media_id.required'] = trans('text.before_add_social').' ('.$i.') '. trans('text.social_social_media_id_required') ;
                $messages['user_social_media.'.$key.'.social_media_id.integer'] = trans('text.before_add_social').' ('.$i.') '. trans('text.social_social_media_id_integer') ;
                $messages['user_social_media.'.$key.'.sort_order.integer'] = trans('text.before_add_social').' ('.$i.') '. trans('text.social_sort_order_integer') ;
                $messages['user_social_media.'.$key.'.link.max'] = trans('text.before_add_social').' ('.$i.') '. trans('text.social_link_max') ;
                $i++;
            }
        }


        $validator = \Validator::make($datas['request'], $rules, $messages);
        if ($validator->fails()) {
            $error = ['error'=>'1','success'=>'0','msg'=> (($datas['action']=='create')? trans('text.save'):trans('text.save_change')).' '.trans('text.unsuccessfully').'!','validatormsg'=>$validator->messages()];
        }
        return $error;
    }

    public function validationChangePasswordForm($datas=[]) {
        $error = false;
        $rules = [
            'current_password'  => 'required',
            'new_password' => 'required|min:6',
            'new_password_confirmation' => 'required|in:'.$datas['request']['new_password']
        ];

        $messages = [
            'current_password.required' => trans('text.current_password_required'),
            'new_password.required' => trans('text.new_password_required'),
            'new_password.min' => trans('text.new_password_min'),
            'new_password_confirmation.required' => trans('text.new_password_confirmation_required'),
            'new_password_confirmation.in' => trans('text.new_password_confirmation_in')
        ];

        if(!\Hash::check($datas['request']['current_password'], \Auth::user()->password)) {
            $rules['invalidpassword'] = 'required';
            $messages['invalidpassword.required'] = trans('text.current_password_in');
        }

        $validator = \Validator::make($datas['request'], $rules, $messages);
        if ($validator->fails()) {
            $error = ['error'=>'1','success'=>'0','msg'=> trans('text.save_change').' '.trans('text.unsuccessfully').'!','validatormsg'=>$validator->messages()];
        }
        return $error;
    }

}

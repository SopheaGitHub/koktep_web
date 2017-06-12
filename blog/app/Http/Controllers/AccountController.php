<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Country;
use App\Models\Zone;
use App\Models\GeoZone;
use App\Models\SocialMedia;
use App\Http\Controllers\Common\FilemanagerController;
use App\Http\Controllers\ConfigController;

use App\Http\Requests;
use DB;
use Auth;

class AccountController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        $this->middleware('auth');

        $this->data = new \stdClass();
        $this->user = New User();
        $this->country = new Country();
        $this->zone = new Zone();
        $this->geo_zone = new GeoZone();
        $this->social_media = new SocialMedia();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->data->web_title = 'Account';
        $this->data->auth_id = ((Auth::check())? Auth::user()->id:'0');
        $this->data->dir_image = $this->config->dir_image;
    }

    /**
     * Show the application account profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $request = \Request::all();
        // add system log
        $this->systemLogs('view', 'account', $request);
        // End
        return view('account.index');
    }

    public function getSettings() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('view', 'account', $request);
        // End
        // check if auth != get account id
        if($request['account_id']==$this->data->auth_id) {

            $this->data->text_title = trans('text.account_settings');
            $this->data->button_cancel = trans('button.cancel');
            $this->data->button_save_change = trans('button.save_change');

            $this->data->go_back = url('/overview-account?account_id='.$this->data->auth_id);
            $this->data->action_form = url('/account/settings-load-form');
            return view('account.settings', ['data'=>$this->data]);
        }else {
            return view('errors.504');
        }
    }

    public function getSettingsLoadForm() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_form', 'account', $request);
        // End
        $user = $this->user->getUser($this->data->auth_id);
        $user_technical = $this->user->getTechnicalByUserId($this->data->auth_id);
        $user_address = $this->user->getAddressByUserId($this->data->auth_id);
        $user_social_medias = $this->user->getSocialMediaByUserId($this->data->auth_id);

        $datas = [
            'icon' => 'icon_edit',
            'action' => url('/account/settings-update/'.$this->data->auth_id),
            'titlelist' => trans('button.edit'),
            'user'      => $user,
            'user_technical' => $user_technical,
            'user_address'  => $user_address,
            'user_social_medias'  => $user_social_medias
        ];
        echo $this->getSettingForm($datas);
        exit();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postSettingsUpdate($user_id)
    {
        $request = \Request::all();
        // add system log
        $this->systemLogs('submit_form', 'account', $request);
        // End
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                $validationError = $this->user->validationSettingForm(['request'=>$request, 'action'=>'edit']);
                if($validationError) {
                    return \Response::json($validationError);
                }

                // update user
                $userDatas = [
                    'name'          => $request['name'],
                    'email'         => $request['email'],
                    'description'   => $request['description'],
                    'image'         => $request['image'],
                    'first_cover'   => $request['first_cover'],
                    'second_cover'  => $request['second_cover']
                ];
                $post = $this->user->where('id', '=', $user_id)->update($userDatas);
                // End

                // update user technical
                $clear_user_technical = $this->user->deletedUserTechnical($user_id);
                $user_technicalDatas = [
                    'user_id'           => $user_id,
                    'user_technicals'   => ((isset($request['user_technical']))? $request['user_technical']:[])
                ];

                $user_technical = $this->user->insertUserTechnical($user_technicalDatas);
                // End

                // update user address
                $clear_user_address = $this->user->deletedUserAddress($user_id);
                $user_addressDatas = [
                    'user_id'           => $user_id,
                    'user_address'   => ((isset($request['user_address']))? $request['user_address']:[])
                ];

                $user_address = $this->user->insertUserAddress($user_addressDatas);
                // End

                // update user address
                $clear_user_address = $this->user->deletedUserSocialMedia($user_id);
                $user_social_mediaDatas = [
                    'user_id'           => $user_id,
                    'user_social_medias'   => ((isset($request['user_social_media']))? $request['user_social_media']:[])
                ];

                $user_address = $this->user->insertUserSocialMedia($user_social_mediaDatas);
                // End

                DB::commit();
                $return = ['error'=>'0','success'=>'1','action'=>'edit','msg'=> trans('text.save_change').' '.trans('text.successfully').'!', 'load_form'=>'none'];
                return \Response::json($return);
            } catch (Exception $e) {
                DB::rollback();
                echo $e->getMessage();
                exit();
            }
        }
        exit();
    } 

    public function getSettingForm($datas=[]) {
        $this->data->countries = $this->country->getCountries(['sort'=>'name','order'=>'asc'])->lists('name', 'country_id');
        $this->data->social_medias = $this->social_media->orderBy('name', 'asc')->lists('name', 'social_media_id');

        // define tap
        $this->data->tab_general = trans('text.tab_general');
        $this->data->tab_image = trans('text.tab_image');
        $this->data->tab_skill_charge = trans('text.tab_skill_charge');
        $this->data->tab_contact = trans('text.tab_contact');
        $this->data->tab_social_media = trans('text.tab_social_media');

        // define entry
        $this->data->entry_name = trans('text.entry_name');
        $this->data->entry_email = trans('text.entry_email');
        $this->data->entry_description = trans('text.entry_description');

        $this->data->entry_profile = trans('text.entry_profile');
        $this->data->entry_first_cover = trans('text.entry_first_cover');
        $this->data->entry_second_cover = trans('text.entry_second_cover');
        $this->data->entry_scale = trans('text.entry_scale');

        $this->data->entry_skill = trans('text.entry_skill');
        $this->data->entry_percent = trans('text.entry_percent');
        $this->data->entry_min_charge = trans('text.entry_min_charge');
        $this->data->entry_max_charge = trans('text.entry_max_charge');
        $this->data->entry_sort_order = trans('text.entry_sort_order');

        $this->data->entry_firstname = trans('text.entry_firstname');
        $this->data->entry_lastname = trans('text.entry_lastname');
        $this->data->entry_company = trans('text.entry_company');
        $this->data->entry_phone = trans('text.entry_phone');
        $this->data->entry_fax = trans('text.entry_fax');
        $this->data->entry_website = trans('text.entry_website');
        $this->data->entry_address = trans('text.entry_address');
        $this->data->entry_city = trans('text.entry_city');
        $this->data->entry_postcode = trans('text.entry_postcode');
        $this->data->entry_country = trans('text.entry_country');
        $this->data->entry_zone = trans('text.entry_zone');

        $this->data->entry_detail = trans('text.entry_address');

        $this->data->entry_social_media = trans('text.entry_social_media');
        $this->data->entry_link = trans('text.entry_link');

        // define input title
        $this->data->button_remove = trans('button.remove');
        $this->data->button_technical_add = trans('button.add');
        $this->data->button_contact_add = trans('button.add');
        $this->data->button_social_media_add = trans('button.add');

        // define text
        $this->data->text_select = trans('text.text_select');
        $this->data->text_title_email = trans('text.title_email_login');

        if(isset($datas['user'])) {
            $this->data->name = $datas['user']->name;
            $this->data->email = $datas['user']->email;
            $this->data->description = $datas['user']->description;
            $this->data->image = $datas['user']->image;
            $this->data->first_cover = $datas['user']->first_cover;
            $this->data->second_cover = $datas['user']->second_cover;
        }else {
            $this->data->name = '';
            $this->data->email = '';
            $this->data->description = '';
            $this->data->image = '';
            $this->data->first_cover = '';
            $this->data->second_cover = '';
        }

        if(isset($datas['user_technical'])) {
            $this->data->user_technicals = $datas['user_technical'];
        }else {
            $this->data->user_technicals = [];
        }

        if(isset($datas['user_address'])) {
            $this->data->user_address = $datas['user_address'];
        }else {
            $this->data->user_address = [];
        }

        if(isset($datas['user_social_medias'])) {
            $this->data->user_social_medias = $datas['user_social_medias'];
        }else {
            $this->data->user_social_medias = [];
        }

        // load image library
        if ($this->data->image && is_file($this->data->dir_image . $this->data->image)) {
            $this->data->thumb_image = $this->filemanager->resize($this->data->image, 100, 100);
        } else {
            $this->data->thumb_image = $this->filemanager->resize('no_image.png', 100, 100);
        }

        if ($this->data->first_cover && is_file($this->data->dir_image . $this->data->first_cover)) {
            $this->data->thumb_first_cover = $this->filemanager->resize($this->data->first_cover, 120, 80);
        } else {
            $this->data->thumb_first_cover = $this->filemanager->resize('no_image.png', 120, 80);
        }

        if ($this->data->second_cover && is_file($this->data->dir_image . $this->data->second_cover)) {
            $this->data->thumb_second_cover = $this->filemanager->resize($this->data->second_cover, 120, 80);
        } else {
            $this->data->thumb_second_cover = $this->filemanager->resize('no_image.png', 120, 80);
        }

        $this->data->placeholder = $this->filemanager->resize('no_image.png', 120, 80);
        $this->data->image_placeholder = $this->filemanager->resize('no_image.png', 100, 100);
        // End

        $this->data->load_zone_action = url('geo-zones/zone');

        $this->data->action = (($datas['action'])? $datas['action']:'');
        $this->data->titlelist = (($datas['titlelist'])? $datas['titlelist']:'');

        return view('account.settings_form', ['data' => $this->data]);
    }

    public function getChangePassword() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_form', 'account', $request);
        // End
        // check if auth != get account id
        if($request['account_id']==$this->data->auth_id) {
            $this->data->go_back = url('/overview-account?account_id='.$this->data->auth_id);
            $this->data->button_cancel = trans('button.cancel');
            $this->data->button_save_change = trans('button.save_change');
            $datas = [
                'action' => url('/account/update-change-password/'.$this->data->auth_id),
                'titlelist' => trans('text.account_change_password'),
            ];
            echo $this->getAccountChangePasswordForm($datas);
            exit();
        }else {
            return view('errors.504');
        }
    }

    public function postUpdateChangePassword($user_id)
    {
        $request = \Request::all();
        $request['user_id'] = $user_id;
        // add system log
        $this->systemLogs('submit_form', 'account', $request);
        // End
        $validationError = $this->user->validationChangePasswordForm(['request'=>$request]);
        if($validationError) {
            return \Response::json($validationError);
        }

        DB::beginTransaction();
        try {
            $userDatas = [
                'password'      => \Hash::make($request['new_password']),
            ];
            $user = $this->user->where('id', '=', $user_id)->update($userDatas);
            DB::commit();
            $return = ['error'=>'0','success'=>'1','action'=>'edit','msg'=> trans('text.save_change').' '.trans('text.successfully').'!'];
            return \Response::json($return);
        } catch (Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            exit();
        }
        exit();
    }

    public function getAccountChangePasswordForm($datas=[]) {
        $this->data->entry_title_form = trans('button.edit');
        

        $this->data->entry_current_password = trans('text.entry_current_password');
        $this->data->entry_new_password = trans('text.entry_new_password');
        $this->data->entry_confirm_new_password = trans('text.entry_confirm_new_password');

        // define input title
        $this->data->title_password = trans('text.title_password');

        $this->data->action = (($datas['action'])? $datas['action']:'');
        $this->data->titlelist = (($datas['titlelist'])? $datas['titlelist']:'');

        return view('account.change_password_form', ['data' => $this->data]);
    }

}

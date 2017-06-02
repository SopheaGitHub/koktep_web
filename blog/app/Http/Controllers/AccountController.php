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
        return view('account.index');
    }

    public function getSettings() {
        // check if auth != get account id
        $request = \Request::all();
        if($request['account_id']==$this->data->auth_id) {
            $this->data->go_back = url('/overview-account?account_id='.$this->data->auth_id);
            $this->data->action_form = url('/account/settings-load-form');
            return view('account.settings', ['data'=>$this->data]);
        }else {
            return view('errors.504');
        }
    }

    public function getSettingsLoadForm() {
        $request = \Request::all();
        $user = $this->user->getUser($this->data->auth_id);
        $user_technical = $this->user->getTechnicalByUserId($this->data->auth_id);
        $user_address = $this->user->getAddressByUserId($this->data->auth_id);
        $user_social_medias = $this->user->getSocialMediaByUserId($this->data->auth_id);

        $datas = [
            'icon' => 'icon_edit',
            'action' => url('/account/settings-update/'.$this->data->auth_id),
            'titlelist' => 'Setting',
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
                $return = ['error'=>'0','success'=>'1','action'=>'edit','msg'=>'Success : save change account setting successfully!', 'load_form'=>'none', 'post'=>$request];
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
        $this->data->tab_general = 'General';
        $this->data->tab_image = 'Images';
        $this->data->tab_skill_charge = 'Technical Skills &amp; Charge';
        $this->data->tab_contact = 'Contacts';
        $this->data->tab_social_media = 'Social Media';

        // define entry
        $this->data->entry_name = 'Name';
        $this->data->entry_email = 'E-Mail Address';
        $this->data->entry_description = 'Description';

        $this->data->entry_skill = 'Skill';
        $this->data->entry_percent = 'Skill Percent';
        $this->data->entry_min_charge = 'Min Charge (USD)';
        $this->data->entry_max_charge = 'Max Charge (USD)';
        $this->data->entry_sort_order = 'Sort Order';

        $this->data->entry_firstname = 'First Name';
        $this->data->entry_lastname = 'Last Name';
        $this->data->entry_company = 'Company';
        $this->data->entry_phone = 'Phone';
        $this->data->entry_fax = 'Fax';
        $this->data->entry_email = 'Email';
        $this->data->entry_website = 'Website';
        $this->data->entry_address = 'Address';
        $this->data->entry_city = 'City';
        $this->data->entry_postcode = 'Post Code';
        $this->data->entry_country = 'Country';
        $this->data->entry_zone = 'Region / State';

        $this->data->entry_detail = 'Detail';

        $this->data->entry_social_media = 'Social Media';
        $this->data->entry_link = 'Link';

        // define input title
        $this->data->button_remove = 'Remove';
        $this->data->button_technical_add = 'Add Technical';
        $this->data->button_contact_add = 'Add Contact';
        $this->data->button_social_media_add = 'Add Social Media';

        // define text
        $this->data->text_select = '-- Please Select --';
        $this->data->text_title_email = 'Use For Login';

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
        // check if auth != get account id
        if($request['account_id']==$this->data->auth_id) {
            $this->data->go_back = url('/overview-account?account_id='.$this->data->auth_id);
            $datas = [
                'action' => url('/account/update-change-password/'.$this->data->auth_id),
                'titlelist' => 'Change Password',
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
            $return = ['error'=>'0','success'=>'1','action'=>'edit','msg'=>'Success : change password user successfully!'];
            return \Response::json($return);
        } catch (Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            exit();
        }
        exit();
    }

    public function getAccountChangePasswordForm($datas=[]) {
        $this->data->entry_current_password = 'Current Password';
        $this->data->entry_new_password = 'New Password';
        $this->data->entry_confirm_new_password = 'Confirm New Password';

        // define input title
        $this->data->title_password = 'Must be enter at least 6 characters,<br /> You have to enter as Ex:@As!02';

        $this->data->action = (($datas['action'])? $datas['action']:'');
        $this->data->titlelist = (($datas['titlelist'])? $datas['titlelist']:'');

        return view('account.change_password_form', ['data' => $this->data]);
    }

}

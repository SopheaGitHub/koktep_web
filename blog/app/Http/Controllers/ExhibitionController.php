<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Exhibition;
use App\Models\ExhibitionRequest;
use App\Models\ExhibitionComment;
use App\Http\Controllers\Common\FilemanagerController;
use App\Http\Controllers\ConfigController;
use App\Models\Rating;
use App\Models\Category;
use App\User;
use Auth;
use DB;

class ExhibitionController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        $this->middleware('auth');

        $this->data = new \stdClass();
        $this->exhibition = New Exhibition();
        $this->exhibition_request = new ExhibitionRequest();
        $this->exhibition_comment = new ExhibitionComment();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->category = new Category();
        $this->user = New User();
        $this->rating = new Rating();
        $this->data->web_title = 'Exhibition';
        $this->data->auth_id = ((Auth::check())? Auth::user()->id:'0');
        $this->data->dir_image = $this->config->dir_image;
        $this->data->http_best_path = $this->config->http_best_path;
    }

    public function getIndex() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('view', 'exhibition', $request);
        // End

        $exhibition_id = '1';
        $array_exhibtion_categories = [];

        // $array = [
        //     ['category_id' => '1','thumb_image' => 'anasa.jpg','slide_image' => 'slice.jpg'],
        //     ['category_id' => '2','thumb_image' => 'anasa.jpg','slide_image' => 'slice.jpg'],
        //     ['category_id' => '3','thumb_image' => 'anasa.jpg','slide_image' => 'slice.jpg'],
        //     ['category_id' => '4','thumb_image' => 'anasa.jpg','slide_image' => 'slice.jpg']
        // ];

        // echo json_encode($array);
        // exit();

        $exhibition = $this->exhibition->getExhibitionById($exhibition_id);
        if($exhibition) {
            $array_exhibtion_categories = json_decode($exhibition->categories, true);

            $this->data->exhibition_title = $exhibition->title;
            $this->data->exhibition_open_date = date('d F Y', strtotime($exhibition->open_date));
            $this->data->exhibition_close_date = date('d F Y', strtotime($exhibition->close_date));

            // get slide image
            $array_exhibtion_categories = json_decode($exhibition->categories, true);

            foreach ($array_exhibtion_categories as $data) {
                if (!empty($data['slide_image']) && is_file($this->data->dir_image .'/exhibition/'. $data['slide_image'])) {
                    $this->data->thumb_slide[$data['category_id'].'-'.$data['category_name_en']] = $this->data->http_best_path.'/images/exhibition/'. $data['slide_image'];
                } else {
                    $this->data->thumb_slide[$data['category_id'].'-'.$data['category_name_en']] = $this->filemanager->resize('no_image.png', 1000, 500);
                }

                if (!empty($data['thumb_image']) && is_file($this->data->dir_image .'/exhibition/'. $data['thumb_image'])) {
                    $thumb_slide = $this->data->http_best_path.'/images/exhibition/'. $data['thumb_image'];
                } else {
                    $thumb_slide = $this->data->http_best_path.'/images/exhibition/'. 'all_sample.jpg';
                }

                $this->data->category_name[$data['category_id'].'-'.$data['category_name_en']] = $data['category_name_en'];

                $code = strtoupper(substr($data['category_name_en'], 0, 3));
                $this->data->data_categories[$data['category_id'].'-'.$data['category_name_en']] = [
                    'category_name' => 'View '.$data['category_name_en'].'\'s Exhibition',
                    'chart_title' => $data['category_name_en'].'\'s Rating',
                    'thumb_image' => $thumb_slide,
                    'name_charts' => [$code.'01', $code.'02', $code.'03', $code.'04', $code.'05', $code.'06', $code.'07', $code.'08', $code.'09'],
                    'data_charts' => [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4]
                ];
            }

            // echo '<pre>';
            //     // print_r($arrays);
            //     print_r($this->data->data_categories);
            // echo '</pre>';
            // exit();

        }else {
            $this->data->exhibition_title = '';
            $this->data->exhibition_open_date = date('d F Y', strtotime('today'));
            $this->data->exhibition_close_date = date('d F Y', strtotime('today'));
            $this->data->thumb_slide = [];
            $this->data->category_name = [];
            $this->data->data_categories = [];
        }

        return view('exhibition.index', ['data'=>$this->data]);
    }

    public function getList() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('exhibition', 'exhibitionx', $request);
        // End

        $paginate_url = [];
        $this->data->exhibition_requests = $this->exhibition_request->getAllExhibitionRequests($request)->paginate(10)->setPath(url('/exhibition/list'))->appends($paginate_url);
        if(count($this->data->exhibition_requests) > 0) {
            foreach ($this->data->exhibition_requests as $request) {
                if (!empty($request->file) && is_file($this->data->dir_image .'/exhibition/'. $request->file)) {
                    $this->data->thumb[$request->request_id] = $this->data->http_best_path.'/images/exhibition/'. $request->file;
                } else {
                    $this->data->thumb[$request->request_id] = $this->filemanager->resize('no_image.png', 120, 80);
                }
            }
        }

        $this->data->show = trans('text.show');
        $this->data->to = trans('text.to');
        $this->data->of = trans('text.of');
        $this->data->page = trans('text.page');
        $this->data->text_rating = trans('text.text_rating');

        return view('exhibition.list', ['data'=>$this->data]);
    }

    public function getRequest() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('view', 'exhibition', $request);
        // Ends

        $exist_categories_msg = '';
        $exhibition_id = '1';
        $exhibition_categories = [];
        $array_exhibtion_categories = [];
        $exhibition = $this->exhibition->getExhibitionById($exhibition_id);
        if($exhibition) {
            $array_exhibtion_categories = json_decode($exhibition->categories, true);
            if($array_exhibtion_categories) {
                foreach ($array_exhibtion_categories as $value) {
                    $exhibition_categories[] = $value['category_id'];
                }
            }
        }
        $categories = $this->exhibition->getArrayCategories(['array_categories'=>$exhibition_categories]);
        $user_request = $this->exhibition->checkIfUserExistRequest($this->data->auth_id, $exhibition_id);

        if(count($user_request) > 0) {
            $i=1;
            foreach ($user_request as $value) {
                $exist_categories_msg .= $categories[$value->category_id].(( (count($user_request)-1) == $i)? ' and ':', ');
                unset($categories[$value->category_id]);
                $i++;
            }

            $this->data->phone = end($user_request)->{'phone'};
        }else {
            $user_address = $this->user->getAddressByUserId($this->data->auth_id);
            $this->data->phone = ((isset($user_address['0']->{'phone'}))? $user_address['0']->{'phone'}:'');
        }

        $this->data->name = ((Auth::check())? Auth::user()->name:'');
        $this->data->user_request = $user_request;
        $this->data->categories_msg = 'You have requested for '.((count($user_request)>1)? 'categories':'category').' : '.substr($exist_categories_msg, 0, strlen($exist_categories_msg)-2);
        $this->data->categories = $categories;
        $this->data->action_request_exhibition = url('/exhibition/store');
    	return view('exhibition.request_form', ['data'=>$this->data]);
    }

    public function postStore() {
        $request = \Request::all();

        // add system log
        $this->systemLogs('submit_form', 'exhibition', $request);
        // End

        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                $file_name = '';
                $reload_page = url('/exhibition/list');

                $validationError = $this->exhibition_request->validationForm(['request'=>$request, 'action'=>'create']);
                if($validationError) {
                    return \Response::json($validationError);
                }

                if(\Request::hasFile('file')) {
                    $file_respone = $this->filemanager->storeFile($request, 1);
                    $file_name = $file_respone['file_name'];
                }

                $exhibitionDatas = [
                    'exhibition_id' => '1',
                    'user_id'       => $this->data->auth_id,
                    'name'          => $this->escape($request['name']),
                    'phone'          => $this->escape($request['phone']),
                    'category_id'   => $request['category_id'],
                    'file'          => $this->escape($file_name),
                    'title'         => $this->escape($request['title']),
                    'description'   => $this->escape($request['description']),
                    'sort_order'    => '0',
                    'status'        => '1'
                ];

                $exhibition = $this->exhibition_request->create($exhibitionDatas);
                // End

                DB::commit();
                $return = ['error'=>'0','success'=>'1','action'=>'create','msg'=>'Request exhibition successfully', 'reload_page'=>$reload_page];
                return \Response::json($return);
            } catch (Exception $e) {
                DB::rollback();
                echo $e->getMessage();
                exit();
            }
        }
        exit();
    }

    public function getViewExhibition() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('view', 'exhibition', $request);
        // End

        $type = '';
        $category_id = '0';
        $exhibition_id = '1';
        if(isset($request['category'])) {
            $category = explode('-', $request['category']);
            $type = $category['1'];
        }

        // $array = [
        //     '1'=>['code'=>'ART01','category_id'=>'1'],
        //     '6'=>['code'=>'ART02','category_id'=>'1'],
        //     '3'=>['code'=>'DES01','category_id'=>'2'],
        //     '11'=>['code'=>'DES02','category_id'=>'2'],
        //     '4'=>['code'=>'PHO01','category_id'=>'3'],
        //     '12'=>['code'=>'PHO02','category_id'=>'3'],
        //     '5'=>['code'=>'DEV01','category_id'=>'4'],
        //     '9'=>['code'=>'DEV02','category_id'=>'4']
        // ];

        // echo json_encode($array);
        // exit();
        $approval_data = [];
        $array_approved_id = [];
        $approval_to_request_data = [];
        $exhibition_approved = $this->exhibition->getExhibitionApproved($exhibition_id);
        if($exhibition_approved) {
            $approval_data = json_decode($exhibition_approved->requested_id, true);
            $array_approved_id = array_keys($approval_data);

            $data_filter = [
                'category_id' => $category['0'],
                'array_approved_id' => $array_approved_id,
                'auth_id' => $this->data->auth_id
            ];
            $approval_to_request_data = $this->exhibition->getAllApprovedToRequestDatas($data_filter);
        }

        if(count($approval_to_request_data) > 0) {
            foreach ($approval_to_request_data as $data) {

                if (!empty($data->file) && is_file($this->data->dir_image .'/exhibition/'. $data->file)) {
                    $thumb = $this->data->http_best_path.'/images/exhibition/'. $data->file;
                } else {
                    $thumb = $this->filemanager->resize('no_image.png', 120, 80);
                }

                if (!empty($data->user_profile) && is_file($this->data->dir_image . $data->user_profile)) {
                    $user_profile = $this->filemanager->resize($data->user_profile, 100, 100);
                } else {
                    $user_profile = $this->filemanager->resize('no_image.png', 100, 100);
                }

                $this->data->approval_to_request_data[$approval_data[$data->request_id]['code']] = [
                    'request_id' => $data->request_id,
                    'category_url' => url('/exhibition/view-exhibition?category='.$request['category']),
                    'thumb' => $thumb,
                    'user_id' => $data->user_id,
                    'user_name' => $data->name,
                    'user_profile' => $user_profile,
                    'user_url' => url('/overview-account?account_id='.$data->user_id),
                    'total_rating' => $data->total_rating,
                    'auth_star' => $data->auth_star,
                    'title' => $data->title,
                    'description' => str_replace('\\', '', (mb_substr(strip_tags(html_entity_decode($data->description, ENT_QUOTES, 'UTF-8')), 0, mb_strlen($data->description)))),
                ];
            }
        }else {
            $this->data->approval_to_request_data = [];
        }

        // order data by code
        ksort($this->data->approval_to_request_data);
        $this->data->type = $type;
        $this->data->action_rating = url('/exhibition/rating');
        return view('exhibition.view', ['data'=>$this->data]);
    }

    public function postRating() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('submit_form', 'exhibition', $request);
        // End

        $user_id = $this->data->auth_id;

        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                if($request['star']=='' || $request['star']=='0') {
                    // delete post rating
                    $rating = $this->rating->where('user_id', '=', $user_id)->where('rating_of_id', '=', $request['id'])->where('rating_type_id', '=', '3')->delete();
                }else {
                    $check_is_user_exit_raing = $this->rating->checkIfAlreadyRating($user_id, $request['id'], '3');
                    if($check_is_user_exit_raing) {
                        // edit post rating
                        $rating = $this->rating->where('user_id', '=', $user_id)->where('rating_of_id', '=', $request['id'])->where('rating_type_id', '=', '3')->update(['star' => $request['star'] ]);
                    } else {
                        // insert rating
                        $ratingDatas = [
                            'user_id'       => $user_id,
                            'rating_of_id'  => $request['id'],
                            'rating_type_id'=> '3',
                            'star'          => $request['star'],
                        ];

                        $rating = $this->rating->create($ratingDatas);
                        // End
                    }
                }

                // get post rating
                $totalRating = $this->rating->getTotalRatingPostByPostId($request['id'], '3');

                DB::commit();
                $return = ['error'=>'0','success'=>'1','action'=>'create','msg'=>'Thank you so much for your rating on my '.$request['type'].'.', 'total_rating' => $totalRating->total_rating ];
                return \Response::json($return);
            } catch (Exception $e) {
                DB::rollback();
                echo $e->getMessage();
                exit();
            }
        }
        exit();
    }

}

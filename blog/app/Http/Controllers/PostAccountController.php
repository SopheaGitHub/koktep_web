<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Rating;
use App\Models\Favorite;
use App\Models\PostVisitorViewDetail;
use App\Models\Category;
use App\Models\Language;
use App\User;
use App\Http\Controllers\Common\FilemanagerController;
use App\Http\Controllers\ConfigController;

use App\Http\Requests;
use DB;
use Auth;

class PostAccountController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');

        $this->data = new \stdClass();
        $this->post = New Post();
        $this->post_comment = new PostComment();
        $this->post_visitor_view_detail = new PostVisitorViewDetail();
        $this->category = new Category();
        $this->user = New User();
        $this->language = new Language();
        $this->rating = new Rating();
        $this->favorite = new Favorite();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->data->web_title = 'Overview';
        $this->data->auth_id = ((Auth::check())? Auth::user()->id:'0');
        $this->data->auth_image = ((Auth::check())? Auth::user()->image:'');
        $this->data->auth_name = ((Auth::check())? Auth::user()->name:'');
        $this->data->dir_image = $this->config->dir_image;
        $this->data->http_best_path = $this->config->http_best_path;
    }

    public function getDetail() {
        $request = \Request::all();

        // add system log
        $this->systemLogs('view', 'post-account', $request);
        // End
        if(\Session::has('locale')) {
            $locale = \Session::get('locale');
        }else {
            $locale = 'en';
        }
        $language_id = '1';
        $language = $this->language->getLanguageByCode( $locale );

        if($language) {
            $language_id = $language->language_id;
        }

        if(isset($request['post_id'])) {
            $post_id = $request['post_id'];
        }else {
            $post_id = 0;
        }

        if (!empty($this->data->auth_image) && is_file($this->data->dir_image . $this->data->auth_image)) {
            $this->data->auth_image = $this->filemanager->resize($this->data->auth_image, 100, 100);
        } else {
            $this->data->auth_image = $this->filemanager->resize('no_image.png', 100, 100);
        }

        $this->data->check_post = false;
        $post = $this->post->getPost($post_id);
        $post_description = $this->post->getPostDescription($post_id);

        if($post) {
            $this->data->check_post = true;
            // update post view
            $this->post->where('post_id', '=', $post_id)->update(['viewed'=>($post->viewed+1)]);
            // End

            // log visitor
            $datasPostVisitor = [
                'post_id' => $post_id,
                'visitor_id' => $this->data->auth_id,
                'ip' => \Request::ip()
            ];
            $this->post_visitor_view_detail->create($datasPostVisitor);
            // End

            if (!empty($post->image) && is_file($this->data->dir_image . $post->image)) {
                // $this->data->image = $this->filemanager->resize($post->image, 600, 400);
                $this->data->image = $this->data->http_best_path.'/images/'. $post->image;
            } else {
                $this->data->image = $this->filemanager->resize('no_image.png', 600, 400);
            }

            if (!empty($post->author_image) && is_file($this->data->dir_image . $post->author_image)) {
                $this->data->thumb_author = $this->filemanager->resize($post->author_image, 100, 100);
            } else {
                $this->data->thumb_author = $this->filemanager->resize('no_image.png', 100, 100);
            }
            $this->data->post_image = $post->image;
            $this->data->author_name = $post->author_name;
            $this->data->author_id = $post->author_id;
            $this->data->post_viewed = ($post->viewed+1);
            $this->data->post_created_at = $post->created_at;
            $this->data->title = $post->title;

            ///// get other 3 post /////
            // define filter data
            $filter_data = array(
                'status' => ['1'],
                'author_id' => $post->author_id,
                'category_id' => null,
                'search' => null,
                'browse' => null,
                'time' => null,
                'alpha' => null,
                'country_id' => null,
                'zone_id' => null,
                'except_id' => [$post_id],
                'sort'  => 'updated_at',
                'order' => 'desc'
            );

            $this->data->posts = $this->post->getPosts($filter_data)->limit(3)->get();

            if(count($this->data->posts) > 0) {
                foreach ($this->data->posts as $post) {
                    // thumb podt image
                    if (!empty($post->image) && is_file($this->data->dir_image . $post->image)) {
                        $this->data->thumb[$post->post_id] = $this->data->http_best_path.'/images/'. $post->image;
                    } else {
                        $this->data->thumb[$post->post_id] = $this->filemanager->resize('no_image.png', 600, 400);
                    }

                    // thumb author image
                    if (!empty($post->author_image) && is_file($this->data->dir_image . $post->author_image)) {
                        $this->data->thumb_user[$post->post_id] = $this->filemanager->resize($post->author_image, 100, 100);
                    } else {
                        $this->data->thumb_user[$post->post_id] = $this->filemanager->resize('no_image.png', 100, 100);
                    }
                }
            }
            //// end ////

        }else {
            $this->data->posts = [];
            $this->data->post_image = '';
            $this->data->image = $this->filemanager->resize('no_image.png', 600, 400);
            $this->data->author_name = $this->filemanager->resize('no_image.png', 100, 100);
            $this->data->author_id = '0';
            $this->data->post_viewed = '0';
            $this->data->post_created_at = '';
            $this->data->title = '';
        }

        if($post_description) {
            $this->data->description = $post_description->description;
            $this->data->tags = explode(',', $post_description->tag);
        }else {
            $this->data->description = '';
            $this->data->tags = [];
        }

        $post_to_categories = $this->post->getPostCategories($post_id);
        $this->data->post_categories = [];

        foreach ($post_to_categories as $post_to_category) {
            $category_info = $this->category->getCategory($post_to_category->category_id, $language_id);

            if ($category_info) {
                $this->data->post_categories[] = [
                    'category_id' => $category_info->category_id,
                    'name' => ($category_info->path) ? $category_info->path . ' &gt; ' . $category_info->name : $category_info->name
                ];
            }
        }

        $post_images = $this->post->getPostImages($post_id);
        $this->data->post_images = [];

        if(count($post_images) > 0) {
            foreach ($post_images as $post_image) {
                if (is_file($this->data->dir_image . $post_image->image)) {
                    $image = $post_image->image;
                    $thumb = $post_image->image;
                } else {
                    $image = '';
                    $thumb = 'no_image.png';
                }

                $this->data->post_images[] = [
                    'image'      => $image,
                    'thumb'      => $this->data->http_best_path.'/images/'.$thumb,
                    'sort_order' => $post_image->sort_order
                ];
            }
        }

        $this->data->icon_view = trans('icon.view');
        $this->data->icon_rating = trans('icon.rating');
        $this->data->icon_favorite = trans('icon.favorite');
        $this->data->icon_comment = trans('icon.comment');
        $this->data->icon_date = trans('icon.date');
        $this->data->icon_image = trans('icon.image');

        $this->data->tab_tags = trans('text.tab_tags');
        $this->data->tab_categories = trans('text.tab_categories');

        $this->data->entry_comment = trans('text.entry_comment');
        $this->data->entry_related_post = trans('text.entry_related_post');
        $this->data->entry_other_post = trans('text.entry_other_post');
        $this->data->your_text = trans('text.your_text');
        $this->data->text_comment = trans('text.text_comment');
        $this->data->text_rating = trans('text.text_rating');
        $this->data->text_bad = trans('text.text_bad');
        $this->data->text_good = trans('text.text_good');

        $this->data->url_tag = url('/?tag=');
        $this->data->url_category = url('/category?category_id=');
        $this->data->overview_account = url('/overview-account');
        $this->data->post_detail = url('/post-account/detail');
        $this->data->text_empty = '...';
        $this->data->action = url('/posts/comment');

        $this->data->count_rating = $this->rating->getTotalRatingPostByPostId($request['post_id'], '1');
        $this->data->check_is_user_exit_raing = $this->rating->checkIfAlreadyRating($this->data->auth_id, $post_id, '1');
        $this->data->action_rating = url('/posts/rating?user_id='.$this->data->auth_id);

        $this->data->count_favorite = $this->favorite->getTotalFavoritePostByPostId($request['post_id'], '1');
        $this->data->check_is_user_exit_favorite = $this->favorite->checkIfAlreadyFavorite($this->data->auth_id, $post_id, '1');
        $this->data->action_favorite = url('/posts/favorite?user_id='.$this->data->auth_id);

        $this->data->post_id = $post_id;
        $this->data->action_comment_form = url('/post-account/comment-form?post_id='.$post_id);
        $this->data->action_load_comment = url('/post-account/load-comment?post_id='.$post_id);
        $this->data->authorized = ((\Auth::check())? true:false);

        $this->data->action_show_rating = url('/rating-account/load-post-rating?post_id='.$post_id);
        $this->data->action_show_favorite = url('/favorite-account/load-post-favorite?post_id='.$post_id);

        return view('post_account.detail', ['data' => $this->data]);
    }

    public function getLoadComment() {
        $request = \Request::all();

        if(isset($request['post_id'])) {
            $post_id = $request['post_id'];
        }else {
            $post_id = 0;
        }

        $post = $this->post->getPostRating($post_id);

        if($post) {
            $this->data->post_commented = $post->commented;
        }else {
            $this->data->post_commented = '0';
        }

        $this->data->icon_comment = trans('icon.comment');

        $this->data->text_rating = trans('text.text_rating');
        return view('post_account.load_comment_form', ['data' => $this->data]);
    }

    public function getCommentForm() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_form', 'post-account', $request);
        // End
        if(isset($request['post_id'])) {
            $post_id = $request['post_id'];
        }else {
            $post_id = 0;
        }

        $this->data->post_comments = $this->post_comment->getPostCommentsByPostId($post_id);

        if(count($this->data->post_comments) > 0) {
            foreach ($this->data->post_comments as $post) {
                if (!empty($post->image) && is_file($this->data->dir_image . $post->image)) {
                    $this->data->thumb_user[$post->post_comment_id] = $this->filemanager->resize($post->image, 100, 100);
                } else {
                    $this->data->thumb_user[$post->post_comment_id] = $this->filemanager->resize('no_image.png', 100, 100);
                }
            }
        }

        $this->data->entry_comment = trans('text.entry_comment');
        $this->data->your_text = trans('text.your_text');
        $this->data->text_comment = trans('text.text_comment');
        $this->data->text_rating = trans('text.text_rating');
        $this->data->text_bad = trans('text.text_bad');
        $this->data->text_good = trans('text.text_good');

        $this->data->button_send = trans('button.send');

        $this->data->overview_account = url('/overview-account');
        $this->data->post_id = $post_id;
        return view('post_account.comment_list', ['data' => $this->data]);
    }

    public function getList() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_list', 'post-account', $request);
        // End
        // define account id
        if(isset($request['account_id'])) {
            $user_id = $request['account_id'];
        }else {
            $user_id = null;
        }

        // defind category id
        if(isset($request['category_id'])) {
            $category_id = $request['category_id'];
        }else {
            $category_id = null;
        }

        // defind search title, description, tag
        if(isset($request['search'])) {
            $search = $this->escape($request['search']);
        }else {
            $search = null;
        }

        // defind view loading people or posted
        if(isset($request['view_option'])) {
            if($request['view_option']=='default') {
                $view_option = 'posted';
            }else {
                $view_option = $request['view_option'];
            }
        }else {
            $view_option = null;
        }

        // defind view loading grid, grid large or list
        if(isset($request['view'])) {
            $view = $request['view'];
        }else {
            $view = null;
        }

        // defind browse
        if(isset($request['browse'])) {
            $browse = $request['browse'];
        }else {
            $browse = null;
        }

        // defind time
        if(isset($request['time'])) {
            $time = $request['time'];
        }else {
            $time = null;
        }

        // defind alpha
        if(isset($request['alpha'])) {
            $alpha = $request['alpha'];
        }else {
            $alpha = null;
        }

        // defind country id
        if(isset($request['country_id']) && $request['country_id']!='0') {
            $country_id = $request['country_id'];
        }else {
            $country_id = null;
        }

        // defind zone id
        if(isset($request['zone_id'])) {
            $zone_id = $request['zone_id'];
        }else {
            $zone_id = null;
        }

        $this->data->overview_account = url('/overview-account');
        $this->data->post_detail = url('/post-account/detail');

        // define data filter
        if (isset($request['sort'])) {
            $sort = $request['sort'];
        } else {
            $sort = 'updated_at';
        }

        if (isset($request['order'])) {
            $order = $request['order'];
        } else {
            $order = 'desc';
        }

        // define filter data
        $filter_data = array(
            'status' => ['1'],
            'author_id' => $user_id,
            'category_id' => $category_id,
            'search' => $search,
            'browse' => $browse,
            'time' => $time,
            'alpha' => $alpha,
            'country_id' => $country_id,
            'zone_id' => $zone_id,
            'sort'  => $sort,
            'order' => $order
        );

        // define paginate url
        $paginate_url = [
            'status' => ['1'],
            'account_id'=>$user_id, 
            'category_id'=>$category_id,
            'search' => $search,
            'view_option' => $view_option,
            'view' => $view,
            'browse' => $browse,
            'time' => $time,
            'alpha' => $alpha,
            'country_id' => $country_id,
            'zone_id' => $zone_id
        ];

        if (isset($request['sort'])) {
            $paginate_url['sort'] = $request['sort'];
        }

        if (isset($request['order'])) {
            $paginate_url['order'] = $request['order'];
        }

        $this->data->posts = [];
        $this->data->users = [];
        switch ($view_option) {
            case 'people':
                $this->data->users = $this->user->getUsers($filter_data)->paginate(20)->setPath(url('/post-account'))->appends($paginate_url);
                break;
            
            default:
                $this->data->posts = $this->post->getPosts($filter_data)->paginate( (($view=='grid')? 24:20) )->setPath(url('/post-account'))->appends($paginate_url);
                break;
        }

        $this->data->post_group_items = [];
        if(count($this->data->users) > 0) {
            foreach ($this->data->users as $user) {
                if (!empty($user->image) && is_file($this->data->dir_image . $user->image)) {
                    $this->data->thumb_user[$user->people_id] = $this->filemanager->resize($user->image, 100, 100);
                } else {
                    $this->data->thumb_user[$user->people_id] = $this->filemanager->resize('no_image.png', 100, 100);
                }

                $posts_to_user = $this->post->getPostsToUser($user->people_id);
                if(count($posts_to_user) > 0) {
                    $post_group_items = $this->post->getPostsByPostGroup(['array_post_group_id'=>$posts_to_user])->get();
                    if(count($post_group_items) > 0) {
                        foreach ($post_group_items as $post_group_items_info) {

                            if (!empty($post_group_items_info->image) && is_file($this->data->dir_image . $post_group_items_info->image)) {
                                $thumb_post = $this->filemanager->resize($post_group_items_info->image, 120, 80);
                            } else {
                                $thumb_post = $this->filemanager->resize('no_image.png', 120, 80);
                            }

                            $this->data->post_group_items[$user->people_id][] = [
                                'author_id' => $post_group_items_info->author_id,
                                'post_id'   => $post_group_items_info->post_id,
                                'category_id' => $post_group_items_info->category_id,
                                'category_name' => $post_group_items_info->category_name,
                                'thumb_post'     => $thumb_post
                            ];
                        }
                    }
                }
            }
        }

        if(count($this->data->posts) > 0) {
            foreach ($this->data->posts as $post) {
                // thumb podt image
                if (!empty($post->image) && is_file($this->data->dir_image . $post->image)) {
                    
                    // if($post->watermark_status=='1') {
                    //     $user_watermark = $this->user->getWatermarkByUserId($post->author_id);
                    //     $this->data->thumb[$post->post_id] = $this->filemanager->resizeWithWatermark($post->image, 600, 400, ((isset($user_watermark->image))? $user_watermark->image:'watermark_koktep.png'), ((isset($user_watermark->position))? $user_watermark->position:'center'));
                    // }else {
                    //     $this->data->thumb[$post->post_id] = $this->filemanager->resize($post->image, 600, 400);
                    // }
                    $this->data->thumb[$post->post_id] = $this->data->http_best_path.'/images/'. $post->image;

                } else {
                    $this->data->thumb[$post->post_id] = $this->filemanager->resize('no_image.png', 600, 400);
                }

                // thumb author image
                if (!empty($post->author_image) && is_file($this->data->dir_image . $post->author_image)) {
                    $this->data->thumb_user[$post->post_id] = $this->filemanager->resize($post->author_image, 100, 100);
                } else {
                    $this->data->thumb_user[$post->post_id] = $this->filemanager->resize('no_image.png', 100, 100);
                }
            }
        }

        // define data
        $this->data->sort = $sort;
        $this->data->order = $order;

        // define column sort
        $url = '';
        if ($order == 'asc') {
            $url .= '&order=desc';
        } else {
            $url .= '&order=asc';
        }

        if (isset($request['page'])) {
            $url .= '&page='.$request['page'];
        }

        $this->data->status = $this->status();

        $this->data->show = trans('text.show');
        $this->data->to = trans('text.to');
        $this->data->of = trans('text.of');
        $this->data->page = trans('text.page');

        $this->data->icon_view = trans('icon.view');
        $this->data->icon_rating = trans('icon.rating');
        $this->data->icon_favorite = trans('icon.favorite');
        $this->data->icon_comment = trans('icon.comment');
        $this->data->icon_image = trans('icon.image');

        $this->data->text_view_profile = trans('text.view_profile');
        $this->data->text_empty = trans('text.empty');

        if($view_option=='posted') {
            switch ($view) {
                case 'grid-large':
                    return view('post_account.grid_large', ['data' => $this->data]);
                    break;

                case 'grid':
                    return view('post_account.grid', ['data' => $this->data]);
                    break;

                case 'list':
                    return view('post_account.list', ['data' => $this->data]);
                    break;
                
                default:
                    return view('post_account.grid_large', ['data' => $this->data]);
                    break;
            }
        }else if($view_option=='people') {
            return view('post_account.people', ['data' => $this->data]);
        }else {
            return view('post_account.grid_large', ['data' => $this->data]);
        }

        exit();
    }

    public function getAutocomplete() {
        $request = \Request::all();
        $json = [];

        if (isset($request['filter_title'])) {

            if(isset($request['filter_view'])&&$request['filter_view']=='people') {
                $filter_data = [
                    'filter_title' => $request['filter_title'],
                    'category_id' => $request['category_id'],
                    'country_id' => $request['country_id'],
                    'zone_id' => $request['zone_id'],
                    'sort'        => 'name',
                    'order'       => 'ASC',
                    'start'       => 0,
                    'limit'       => 5
                ];

                $results = $this->user->getAutocompleteUsers($filter_data);
                foreach ($results as $result) {

                    if (!empty($result->image) && is_file($this->data->dir_image . $result->image)) {
                        $image = $this->filemanager->resize($result->image, 100, 100);
                    } else {
                        $image = $this->filemanager->resize('no_image.png', 100, 100);
                    }

                    $json[] = [
                        'user_id' => $result->user_id,
                        'title'   => "<img alt='' src='".$image."' style='width:30px; border-radius:50%;'> &nbsp; ".strip_tags(html_entity_decode($result->name, ENT_QUOTES, 'UTF-8')),
                        'title_text' => strip_tags(html_entity_decode($result->name, ENT_QUOTES, 'UTF-8')),
                    ];
                }

            }else {
                $filter_data = [
                    'filter_title' => $request['filter_title'],
                    'category_id' => $request['category_id'],
                    'country_id' => $request['country_id'],
                    'zone_id' => $request['zone_id'],
                    'sort'        => 'title',
                    'order'       => 'ASC',
                    'start'       => 0,
                    'limit'       => 5
                ];

                $results = $this->post->getAutocompletePosts($filter_data);

                foreach ($results as $result) {

                    if (!empty($result->image) && is_file($this->data->dir_image . $result->image)) {
                        $image = $this->filemanager->resize($result->image, 100, 100);
                    } else {
                        $image = $this->filemanager->resize('no_image.png', 100, 100);
                    }

                    $json[] = [
                        'post_id' => $result->post_id,
                        'title'   => "<img alt='' src='".$image."' style='width:30px;'> &nbsp; ".strip_tags(html_entity_decode($result->title, ENT_QUOTES, 'UTF-8')),
                        'title_text' => strip_tags(html_entity_decode($result->title, ENT_QUOTES, 'UTF-8')),
                    ];
                }
            }
        }

        $sort_order = [];

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['title'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        return json_encode($json);
    }

    public function getComposeAutocomplete() {
        $request = \Request::all();
        $json = [];

        if (isset($request['filter_title'])) {

            $filter_data = [
                'filter_title' => $request['filter_title'],
                'sort'        => 'name',
                'order'       => 'ASC',
                'start'       => 0,
                'limit'       => 5
            ];

            $results = $this->user->getAutocompleteUsers($filter_data);
            foreach ($results as $result) {

                if (!empty($result->image) && is_file($this->data->dir_image . $result->image)) {
                    $image = $this->filemanager->resize($result->image, 100, 100);
                } else {
                    $image = $this->filemanager->resize('no_image.png', 100, 100);
                }

                $json[] = [
                    'user_id' => $result->user_id,
                    'title'   => "<img alt='' src='".$image."' style='width:30px; border-radius:50%;'> &nbsp; ".strip_tags(html_entity_decode($result->name, ENT_QUOTES, 'UTF-8'))
                ];
            }
        }

        $sort_order = [];

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['title'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        return json_encode($json);
    }
    
}

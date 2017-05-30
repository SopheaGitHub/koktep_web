<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Category;
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
        $this->category = new Category();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->data->web_title = 'Overview';
        $this->data->auth_id = ((Auth::check())? Auth::user()->id:'0');
        $this->data->dir_image = $this->config->dir_image;
    }

    public function getDetail() {
        $request = \Request::all();
        $this->data->action_detail_form = url('/post-account/post-detail-form?post_id='.$request['post_id']);
        return view('post_account.detail', ['data' => $this->data]);
    }

    public function getPostDetailForm() {
        $request = \Request::all();

        if(isset($request['post_id'])) {
            $post_id = $request['post_id'];
        }else {
            $post_id = 0;
        }

        $post = $this->post->getPost($post_id);
        $post_description = $this->post->getPostDescription($post_id);

        if($post) {
            if (!empty($post->image) && is_file($this->data->dir_image . $post->image)) {
                $this->data->image = $this->filemanager->resize($post->image, 600, 400);
            } else {
                $this->data->image = $this->filemanager->resize('no_image.png', 600, 400);
            }
            $this->data->title = $post->title;
        }else {
            $this->data->image = $this->filemanager->resize('no_image.png', 600, 400);
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
            $category_info = $this->category->getCategory($post_to_category->category_id);

            if ($category_info) {
                $this->data->post_categories[] = [
                    'category_id' => $category_info->category_id,
                    'name' => ($category_info->path) ? $category_info->path . ' &gt; ' . $category_info->name : $category_info->name
                ];
            }
        }

        $post_relateds = $this->post->getPostRelated($post_id);
        $this->data->post_relateds = $this->post->getPostsByArrayPostID($post_relateds);

        if(count($this->data->post_relateds) > 0) {
            foreach ($this->data->post_relateds as $post) {
                if (!empty($post->image) && is_file($this->data->dir_image . $post->image)) {
                    $this->data->thumb[$post->post_id] = $this->filemanager->resize($post->image, 600, 400);
                } else {
                    $this->data->thumb[$post->post_id] = $this->filemanager->resize('no_image.png', 600, 400);
                }
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
                    'thumb'      => $this->filemanager->resize($thumb, 600, 400),
                    'sort_order' => $post_image->sort_order
                ];
            }
        }

        $this->data->url_tag = url('/?tag=');
        $this->data->url_category = url('/category?category_id=');
        $this->data->overview_account = url('/overview-account');
        $this->data->post_detail = url('/post-account/detail');
        $this->data->text_empty = 'There is no data!';
        $this->data->action = url('/posts/comment');
        $this->data->action_comment_form = url('/post-account/comment-form?post_id='.$post_id);
        
        return view('post_account.detail_form', ['data' => $this->data]);
    }

    public function getCommentForm() {
        $request = \Request::all();

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

        $this->data->overview_account = url('/overview-account');
        $this->data->post_id = $post_id;
        return view('post_account.comment_list', ['data' => $this->data]);
    }

    public function getList() {
        $request = \Request::all();
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
            $search = $request['search'];
        }else {
            $search = null;
        }

        $this->data->overview_account = url('/overview-account');
        $this->data->post_detail = url('/post-account/detail');

        // define data filter
        if (isset($request['sort'])) {
            $sort = $request['sort'];
        } else {
            $sort = 'created_at';
        }

        if (isset($request['order'])) {
            $order = $request['order'];
        } else {
            $order = 'desc';
        }

        // define filter data
        $filter_data = array(
            'author_id' => $user_id,
            'category_id' => $category_id,
            'search'    => $search,
            'sort'  => $sort,
            'order' => $order
        );

        // define paginate url
        $paginate_url = ['account_id'=>$user_id, 'category_id'=>$category_id];
        if (isset($request['sort'])) {
            $paginate_url['sort'] = $request['sort'];
        }

        if (isset($request['order'])) {
            $paginate_url['order'] = $request['order'];
        }

        $this->data->posts = $this->post->getPosts($filter_data)->paginate(1)->setPath(url('/post-account'))->appends($paginate_url);

        if(count($this->data->posts) > 0) {
            foreach ($this->data->posts as $post) {
                if (!empty($post->image) && is_file($this->data->dir_image . $post->image)) {
                    $this->data->thumb[$post->post_id] = $this->filemanager->resize($post->image, 600, 400);
                } else {
                    $this->data->thumb[$post->post_id] = $this->filemanager->resize('no_image.png', 600, 400);
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

        $this->data->status = $this->config->status;

        $this->data->text_empty = 'There is no data!';

        return view('post_account.list', ['data' => $this->data]);
    }
}

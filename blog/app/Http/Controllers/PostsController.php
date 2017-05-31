<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Language;
use App\Models\Layout;
use App\Models\UrlAlias;
use App\Models\Category;
use App\Http\Controllers\Common\FilemanagerController;
use App\Http\Controllers\ConfigController;

use App\Http\Requests;
use DB;
use Auth;

class PostsController extends Controller
{

    protected $data = null;

    public function __construct()
    {
        $this->middleware('auth');

        $this->data = new \stdClass();
        $this->post = New Post();
        $this->post_comment = new PostComment();
        $this->language = new Language();
        $this->layout = new Layout();
        $this->url_alias = new UrlAlias();
        $this->category = new Category();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->data->web_title = 'Posts';
        $this->data->auth_id = ((Auth::check())? Auth::user()->id:'0');
        $this->data->dir_image = $this->config->dir_image;
    }

    /**
     * Show the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $this->data->action_list = url('/posts/list');
        $this->data->add_post = url('/posts/create');
        return view('post.index', ['data'=>$this->data]);
    }

    public function getList() {
        $request = \Request::all();
        $this->data->edit_post = url('/posts/edit');
        $this->data->action_delete = url('/posts/delete');

        // define data filter

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

        // defind sort order
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

        // End

        // define filter data
        $filter_data = array(
            'author_id' => $this->data->auth_id,
            'category_id' => $category_id,
            'search'    => $search,
            'sort'  => $sort,
            'order' => $order
        );

        // define paginate url
        $paginate_url = ['account_id'=>$this->data->auth_id];
        if (isset($request['sort'])) {
            $paginate_url['sort'] = $request['sort'];
        }

        if (isset($request['order'])) {
            $paginate_url['order'] = $request['order'];
        }

        $this->data->posts = $this->post->getPosts($filter_data)->paginate(1)->setPath(url('/posts'))->appends($paginate_url);

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

        return view('post.list', ['data' => $this->data]);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return Response
     */
    public function getCreate()
    {
        $this->data->go_back = url('/posts');
        $this->data->action_form = url('/posts/create-load-form');
        return view('post.create', ['data'=>$this->data]);
    }

    public function getCreateLoadForm() {
        $datas = [
            'icon' => 'icon_create',
            'action' => url('/posts/store'),
            'titlelist' => 'Add New Post'
        ];
        echo $this->getPostForm($datas);
        exit();
    }

    /**
     * Store a newly created post in storage.
     *
     * @return Response
     */
    public function postStore()
    {
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                $request = \Request::all();
                $this->data->action_form = url('/posts/create-load-form');

                // $validationError = $this->post->validationForm(['request'=>$request, 'action'=>'create']);
                // if($validationError) {
                //     return \Response::json($validationError);
                // }

                // // insert post
                // $postDatas = [
                //     'author_id'     => $this->data->auth_id,
                //     'image'         => $request['image'],
                //     'status'        => $request['status']
                // ];

                // $post = $this->post->create($postDatas);
                // // End

                // // insert post description
                // $post_descriptionDatas = [
                //     'post_id'       => $post->id,
                //     'post_description_datas'    => ((isset($request['post_description']))? $request['post_description']:[])
                // ];

                // $post_description = $this->post->insertPostDescription($post_descriptionDatas);
                // // End

                // // insert post to layout
                // $post_to_layoutDatas['post_to_layout_datas'][] = [
                //     'post_id'       => $post->id,
                //     'website_id'    => '1',
                //     'layout_id'     => '0'
                // ];

                // $post_to_layout = $this->post->insertPostToLayout($post_to_layoutDatas);
                // // End

                // // insert post to categories
                // $post_to_categoryDatas = [
                //     'post_id'       => $post->id,
                //     'post_category_datas'   => ((isset($request['post_category']))? $request['post_category']:[])
                // ];

                // $post_category = $this->post->insertPostCategory($post_to_categoryDatas);
                // // End

                // // insert post image
                // $post_imageDatas = [
                //     'post_id'       => $post->id,
                //     'post_images'   => ((isset($request['post_image']))? $request['post_image']:[])
                // ];

                // $post_category = $this->post->insertPostImage($post_imageDatas);
                // // End

                // // insert post image
                // $post_relatedDatas = [
                //     'post_id'       => $post->id,
                //     'posts_related' => ((isset($request['post_related']))? $request['post_related']:[])
                // ];

                // $post_category = $this->post->insertPostRelated($post_relatedDatas);
                // // End

                DB::commit();
                $return = ['error'=>'0','success'=>'1','action'=>'create','msg'=>'Success : save post successfully!', 'load_form'=>$this->data->action_form];
                return \Response::json($return);
            } catch (Exception $e) {
                DB::rollback();
                echo $e->getMessage();
                exit();
            }
        }
        exit();
    }    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($post_id)
    {
        $this->data->go_back = url('/posts');
        $this->data->action_form = url('/posts/edit-load-form/'.$post_id);
        return view('post.edit', ['data'=>$this->data]);
    }

    public function getEditLoadForm($post_id) {
        $this->data->post = $this->post->getPost($post_id);
        $this->data->post_descriptions = $this->post->getPostDescriptions($post_id);

        $post_to_categories = $this->post->getPostCategories($post_id);
        $data['post_categories'] = [];

        foreach ($post_to_categories as $post_to_category) {
            $category_info = $this->category->getCategory($post_to_category->category_id);

            if ($category_info) {
                $data['post_categories'][] = [
                    'category_id' => $category_info->category_id,
                    'name' => ($category_info->path) ? $category_info->path . ' &gt; ' . $category_info->name : $category_info->name
                ];
            }
        }

        $post_relateds = $this->post->getPostRelated($post_id);
        $data['post_relateds'] = [];
        foreach ($post_relateds as $value_post_id) {
            $related_info = $this->post->getPost($value_post_id);

            if ($related_info) {
                $data['post_relateds'][] = [
                    'post_id' => $related_info->post_id,
                    'title'       => $related_info->title
                ];
            }
        }

        $post_images = $this->post->getPostImages($post_id);
        $data['post_images'] = [];

        foreach ($post_images as $post_image) {
            if (is_file($this->data->dir_image . $post_image->image)) {
                $image = $post_image->image;
                $thumb = $post_image->image;
            } else {
                $image = '';
                $thumb = 'no_image.png';
            }

            $data['post_images'][] = [
                'image'      => $image,
                'thumb'      => $this->filemanager->resize($thumb, 120, 80),
                'sort_order' => $post_image->sort_order
            ];
        }

        $datas = [
            'icon' => 'icon_edit',
            'action' => url('/posts/update/'.$post_id),
            'titlelist' => 'Edit Post',
            'post' => $this->data->post,
            'post_descriptions' => $this->data->post_descriptions,
            'post_to_categories' => $data['post_categories'],
            'post_relateds' => $data['post_relateds'],
            'post_images'    => $data['post_images']
        ];

        echo $this->getPostForm($datas);
        exit();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postUpdate($post_id)
    {
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                $request = \Request::all();

                $validationError = $this->post->validationForm(['request'=>$request, 'action'=>'edit']);
                if($validationError) {
                    return \Response::json($validationError);
                }

                // update post
                $postDatas = [
                    'updated_by_author_id'  => $this->data->auth_id,
                    'image'         => $request['image'],
                    'status'        => $request['status']
                ];
                $post = $this->post->where('post_id', '=', $post_id)->update($postDatas);
                // End

                // update post description
                $clear_post_description = $this->post->deletedPostDescription($post_id);
                $post_descriptionDatas = [
                    'post_id'       => $post_id,
                    'post_description_datas'    => ((isset($request['post_description']))? $request['post_description']:[])
                ];

                $post_description = $this->post->insertPostDescription($post_descriptionDatas);
                // End

                // update post to layout
                $clear_post_to_layout = $this->post->deletedPostToLayout($post_id);
                $post_to_layoutDatas['post_to_layout_datas'][] = [
                    'post_id'       => $post_id,
                    'website_id'    => '1',
                    'layout_id'     => '0'
                ];

                $post_to_layout = $this->post->insertPostToLayout($post_to_layoutDatas);
                // End

                // update post to categories
                $clear_post_to_category = $this->post->deletedPostToCategory($post_id);
                $post_to_categoryDatas = [
                    'post_id'       => $post_id,
                    'post_category_datas'   => ((isset($request['post_category']))? $request['post_category']:[])
                ];

                $post_category = $this->post->insertPostCategory($post_to_categoryDatas);
                // End

                // update post image
                $clear_post_image = $this->post->deletedPostImage($post_id);
                $post_imageDatas = [
                    'post_id'       => $post_id,
                    'post_images'   => ((isset($request['post_image']))? $request['post_image']:[])
                ];

                $post_category = $this->post->insertPostImage($post_imageDatas);
                // End

                // update post related
                $clear_post_related = $this->post->deletedPostRelated($post_id);
                $post_relatedDatas = [
                    'post_id'       => $post_id,
                    'posts_related' => ((isset($request['post_related']))? $request['post_related']:[])
                ];

                $post_category = $this->post->insertPostRelated($post_relatedDatas);
                // End

                DB::commit();
                $return = ['error'=>'0','success'=>'1','action'=>'edit','msg'=>'Success : save change post successfully!', 'load_form'=>'none'];
                return \Response::json($return);
            } catch (Exception $e) {
                DB::rollback();
                echo $e->getMessage();
                exit();
            }
        }
        exit();
    }

    public function getPostForm($datas=[]) {
        $this->data->go_category_autocomplete = url('/category/autocomplete');
        $this->data->go_related_autocomplete = url('/posts/autocomplete');
        $this->data->languages = $this->language->getLanguages(['sort'=>'name', 'order'=>'asc'])->get();
        $this->data->layouts = $this->layout->orderBy('name', 'asc')->lists('name', 'layout_id');
        $this->data->status = $this->config->status;

        // define tap
        $this->data->tab_general = 'General';
        $this->data->tab_data = 'Data';
        $this->data->tab_links = 'Links';
        $this->data->tab_design = 'Design';
        $this->data->tab_image = 'Image';

        // define entry
        $this->data->entry_title = 'Post Title';
        $this->data->entry_description = 'Description';
        $this->data->entry_meta_title = 'Meta Tag Title';
        $this->data->entry_meta_description = 'Meta Tag Description';
        $this->data->entry_meta_keyword = 'Meta Tag Keywords';
        $this->data->entry_tag = 'Post Tags';


        $this->data->entry_keyword = 'SEO URL';
        $this->data->entry_image = 'Image';
        $this->data->entry_status = 'Status';
        $this->data->entry_sort_order = 'Sort Order';

        $this->data->entry_category = 'Categories';
        $this->data->entry_related = 'Related Posts';

        $this->data->entry_layout = 'Layout';

        // define input title
        $this->data->title_keyword = 'Do not use spaces, instead replace spaces with - and make sure the keyword is globally unique.';
        $this->data->title_category = '(Autocomplete)';
        $this->data->title_related = '(Autocomplete)';

        $this->data->text_none = '-- None --';

        $this->data->button_remove = 'Remove';
        $this->data->button_image_add = 'Add Image';

        if(isset($datas['post'])) {
            $this->data->image = $datas['post']->image;
            $this->data->sort_order = $datas['post']->sort_order;
            $this->data->post_status = $datas['post']->status;
            $this->data->keyword = $datas['post']->keyword;
        }else {
            $this->data->image = '';
            $this->data->sort_order = '0';
            $this->data->post_status = '1';
            $this->data->keyword = '';
        }

        if(isset($datas['post_descriptions'])) {
            foreach ($datas['post_descriptions'] as $description) {
                $this->data->post_description[$description->language_id]['title'] = $description->title;
                $this->data->post_description[$description->language_id]['description'] = $description->description;
                $this->data->post_description[$description->language_id]['tag'] = $description->tag;
            }
        }else {
            foreach ($this->data->languages as $language) {
                $this->data->post_description[$language->language_id]['title'] = '';
                $this->data->post_description[$language->language_id]['description'] = '';
                $this->data->post_description[$language->language_id]['tag'] = '';
            }
        }

        if(isset($datas['post_to_categories'])) {
            $this->data->post_categories = $datas['post_to_categories'];
        }else {
            $this->data->post_categories = [];
        }

        if(isset($datas['post_relateds'])) {
            $this->data->post_relateds = $datas['post_relateds'];
        }else {
            $this->data->post_relateds = [];
        }

        if(isset($datas['post_images'])) {
            $this->data->post_images = $datas['post_images'];
        }else {
            $this->data->post_images = [];
        }        

        if ($this->data->image && is_file($this->data->dir_image . $this->data->image)) {
            $this->data->thumb = $this->filemanager->resize($this->data->image, 120, 80);
        } else {
            $this->data->thumb = $this->filemanager->resize('no_image.png', 120, 80);
        }

        $this->data->placeholder = $this->filemanager->resize('no_image.png', 120, 80);

        $this->data->action = (($datas['action'])? $datas['action']:'');
        $this->data->titlelist = (($datas['titlelist'])? $datas['titlelist']:'');
        $this->data->icon = (($datas['icon'])? $datas['icon']:'');

        return view('post.form', ['data' => $this->data]);
    }

    public function postComment() {
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                $request = \Request::all();
                $this->data->action_form = url('/post-account/comment-form?post_id='.$request['post_id']);
                if(\Request::has('comment')) {
                    // insert post comment
                    $postCommentDatas = [
                        'user_id'     => $this->data->auth_id,
                        'post_id'     => $request['post_id'],
                        'comment'     => $request['comment'],
                        'parent_id'   => '0'
                    ];

                    $post_comment = $this->post_comment->create($postCommentDatas);
                    // End
                }

                DB::commit();
                $return = ['error'=>'0','success'=>'1','action'=>'create','msg'=>'Success : save post comment successfully!', 'load_form'=>$this->data->action_form];
                return \Response::json($return);
            } catch (Exception $e) {
                DB::rollback();
                echo $e->getMessage();
                exit();
            }
        }
        exit();
    }

    public function getAutocomplete() {
        $request = \Request::all();
        $json = array();

        if (isset($request['filter_title'])) {

            $filter_data = array(
                'filter_title' => $request['filter_title'],
                'sort'        => 'title',
                'order'       => 'ASC',
                'start'       => 0,
                'limit'       => 5
            );

            $results = $this->post->getAutocompletePosts($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'post_id' => $result->post_id,
                    'title'        => strip_tags(html_entity_decode($result->title, ENT_QUOTES, 'UTF-8'))
                );
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['title'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        return json_encode($json);
    }

}

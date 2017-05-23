<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
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
        $this->language = new Language();
        $this->layout = new Layout();
        $this->url_alias = new UrlAlias();
        $this->category = new Category();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->data->web_title = 'Posts';

        $this->data->dir_image = $this->config->dir_image;
    }

    /**
     * Show the application account profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('post.index');
    }

    /**
     * Show the form for creating a new post.
     *
     * @return Response
     */
    public function getCreate()
    {
        $datas = [
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
                $author_id = ((Auth::check())? Auth::user()->id:'0');

                $validationError = $this->post->validationForm(['request'=>$request]);
                if($validationError) {
                    return \Response::json($validationError);
                }

                // insert post
                $postDatas = [
                    'author_id'     => $author_id,
                    'image'         => $request['image'],
                    'status'        => $request['status']
                ];

                $post = $this->post->create($postDatas);
                // End

                // insert post description
                $post_descriptionDatas = [
                    'post_id'       => $post->id,
                    'post_description_datas'    => $request['post_description']
                ];

                $post_description = $this->post->insertPostDescription($post_descriptionDatas);
                // End

                // insert post to layout
                $post_to_layoutDatas['post_to_layout_datas'][] = [
                    'post_id'       => $post->id,
                    'website_id'    => '1',
                    'layout_id'     => '0'
                ];

                $post_to_layout = $this->post->insertPostToLayout($post_to_layoutDatas);
                // End

                // insert post to categories
                $post_to_categoryDatas = [
                    'post_id'       => $post->id,
                    'post_category_datas'   => $request['post_category']
                ];

                $post_category = $this->post->insertPostCategory($post_to_categoryDatas);
                // End

                // insert post image
                $post_imageDatas = [
                    'post_id'       => $post->id,
                    'post_images'   => $request['post_image']
                ];

                $post_category = $this->post->insertPostImage($post_imageDatas);
                // End

                // insert post image
                $post_relatedDatas = [
                    'post_id'       => $post->id,
                    'posts_related'   => $request['post_related']
                ];

                $post_category = $this->post->insertPostRelated($post_relatedDatas);
                // End

                DB::commit();
                $return = ['error'=>'0','success'=>'1','action'=>'create','msg'=>'Success : save post successfully!', 'post'=>$request];
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
     * Show the form for creating a new post.
     *
     * @return Response
     */
    public function getPostsGroups()
    {
        return view('post.posts_groups');
    }

    public function getPostsGroupsCreate() {
        return view('post.posts_groups_form'); 
    }

    public function getPostForm($datas=[]) {
        
        $this->data->go_category_autocomplete = url('/category/autocomplete');
        $this->data->go_related_autocomplete = url('/posts/autocomplete');
        $this->data->go_back = url('/posts');
        $this->data->languages = $this->language->getLanguages(['sort'=>'name', 'order'=>'asc'])->get();
        $this->data->layouts = $this->layout->orderBy('name', 'asc')->lists('name', 'layout_id');
        $this->data->status = $this->config->status;
        $this->data->post_images = [];
        $this->data->post_relateds = [];

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
                $this->data->post_description[$description->language_id]['meta_title'] = $description->meta_title;
                $this->data->post_description[$description->language_id]['meta_description'] = $description->meta_description;
                $this->data->post_description[$description->language_id]['meta_keyword'] = $description->meta_keyword;
                $this->data->post_description[$description->language_id]['tag'] = $description->tag;
            }
        }else {
            foreach ($this->data->languages as $language) {
                $this->data->post_description[$language->language_id]['title'] = '';
                $this->data->post_description[$language->language_id]['description'] = '';
                $this->data->post_description[$language->language_id]['meta_title'] = '';
                $this->data->post_description[$language->language_id]['meta_description'] = '';
                $this->data->post_description[$language->language_id]['meta_keyword'] = '';
                $this->data->post_description[$language->language_id]['tag'] = '';
            }
        }

        if(isset($datas['post_to_layouts'])) {
            $this->data->post_layout = $datas['post_to_layouts'];
        }else {
            $this->data->post_layout = [];
        }

        if(isset($datas['post_to_categories'])) {
            $this->data->post_categories = $datas['post_to_categories'];
        }else {
            $this->data->post_categories = [];
        }

        if ($this->data->image && is_file($this->data->dir_image . $this->data->image)) {
            $this->data->thumb = $this->filemanager->resize($this->data->image, 100, 100);
        } else {
            $this->data->thumb = $this->filemanager->resize('no_image.png', 100, 100);
        }

        $this->data->placeholder = $this->filemanager->resize('no_image.png', 100, 100);

        $this->data->action = (($datas['action'])? $datas['action']:'');
        $this->data->titlelist = (($datas['titlelist'])? $datas['titlelist']:'');

        return view('post.form', ['data' => $this->data]);
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

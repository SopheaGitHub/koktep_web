<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

use App\Http\Requests;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->category = new Category();
    }

    /**
     * Show the application account profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
    	$request = \Request::all();
    	echo $request['category_id'];
    	exit();
        // return view('account.index');
    }

    public function getAutocomplete() {
        $request = \Request::all();
        $json = [];

        if (isset($request['filter_name'])) {

            $filter_data = [
                'filter_name' => $request['filter_name'],
                'sort'        => 'name',
                'order'       => 'ASC',
                'start'       => 0,
                'limit'       => 5
            ];

            $results = $this->category->getAutocompleteCategories($filter_data);

            foreach ($results as $result) {
                $json[] = [
                    'category_id' => $result->category_id,
                    'name'        => strip_tags(html_entity_decode($result->name, ENT_QUOTES, 'UTF-8'))
                ];
            }
        }

        $sort_order = [];

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        return json_encode($json);
    }
}

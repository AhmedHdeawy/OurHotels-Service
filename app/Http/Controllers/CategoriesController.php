<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
	/**
	 * Show the categories page
	 * 
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
    public function index()
    {
    	// Load Categories roots
    	$categories = Category::whereNull('parent_id')->with('childs')->get();

    	return view('categories', compact('categories'));
    }
}

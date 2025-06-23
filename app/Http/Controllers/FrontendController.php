<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CompanyData;

class FrontendController extends Controller
{
    public function index()
    {
        $products = Product::where('show_in_frontend', 1)->with('images')->latest()->get();
        return view('home', compact('products'));
    }

    public function about()
    {
        $company = \App\Models\CompanyData::first();
        return view('about', compact('company'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        // $product = (object)[
        //     'id' => 1,
        //     'name' => 'Royal Gold Necklace',
        //     'price' => 7999,
        //     'description' => 'This royal gold necklace is beautifully handcrafted for special occasions.',
        //     'image' => 'uploads/gold_necklace.jpg' // Image must be in public/uploads/
        // ];

        return view('viewdetail', compact('product'));
    }
}

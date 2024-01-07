<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::query()->with(['category'])->paginate();

        return view(OBJECT_PRODUCTS . DOT . __FUNCTION__, compact('data'));
    }
}

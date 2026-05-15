<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function about()
    {


        return view('about');
    }
}

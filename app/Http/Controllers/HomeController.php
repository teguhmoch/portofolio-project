<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductIn;
use App\Models\ProductOut;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $totalProductIn = ProductIn::query()->sum('qty');
        $totalProductOut = ProductOut::query()->sum('qty');
        $totalStock = Product::query()->sum('stock');
        $productActive = Product::query()->where('status','active')->count();
        
        return view('pages.dashboard',compact('totalProductIn','totalProductOut','totalStock','productActive'));
    }
}

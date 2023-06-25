<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductOut;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ProductOutController extends Controller
{
    public function index(Request $request) {

        $page = $request->has('page') ? $request->get('page') : 1;
        $perPage = $request->has('per_page') ? $request->get('per_page') : $this->total_item_per_loading;
        $offset = ($page - 1) * $perPage;

        $productOuts = ProductOut::query()->limit($perPage)->offset($offset)->latest('id')->get();

        foreach ($productOuts as $productOut) {
            $productOut->create = Carbon::parse($productOut->created_at)->toDateString();
        }

        $session    = $request->session()->get('user') ?? null;
        $isAdmin    = $session->roles()->where('title','admin')->first();
        $isMaster   = $session->roles()->where('title','master')->first();

        return view('pages.product_outs.index',compact('productOuts','isAdmin','isMaster'));
    }

    public function create(Request $request) {
        
        $products = Product::query()->where('status','active')->select('id','name')->get(); 
        return view('pages.product_outs.create',compact('products'));
    }

    public function store(Request $request) {

        $user = $request->session()->get('user') ?? null;
        $body = $request->all();
        $validator = [
            'product_id'    => 'required',
            'qty'           => 'required',
        ];
        $validator = Validator::make($body, $validator);
        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->all() ?? 'Something went wrong');
            
            return redirect()->back();
        }

        //validate stock
        $product = Product::query()->where('id',$request->product_id)->first();

        if($request->qty > $product->stock) {
            session()->flash('error', 'Qty Input Must be lower than stock product ! current stock : '.$product->stock);
            
            return redirect()->back();
        }
        
        $request['added_by'] = $user->id;

        $productOut = ProductOut::create($request->all());

        $dataProduct = [
            "stock"  =>$productOut->product->stock - $productOut->qty,
            "total_product_out"  => $productOut->qty + $productOut->product->total_product_out,
        ];
        Product::findOrfail($productOut->product_id)->update($dataProduct);
        
        return redirect('product-out/create')->withSuccess("Product out has been Created");
    }

    public function show($id) {
        
        $productIn = ProductOut::query()->where('id',$id)->first();
        return view('pages.product_outs.show', compact('productIn'));
    }

    public function get($id) {
        
        $productIn = ProductOut::query()->where('id',$id)->first();
        return view('pages.product_outs.show', compact('productIn'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductIn;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ProductInController extends Controller
{
    public function index(Request $request) {

        $page = $request->has('page') ? $request->get('page') : 1;
        $perPage = $request->has('per_page') ? $request->get('per_page') : $this->total_item_per_loading;
        $offset = ($page - 1) * $perPage;

        $productIns = ProductIn::query()->limit($perPage)->offset($offset)->latest('id')->get();

        foreach ($productIns as $productIn) {
            $productIn->create = Carbon::parse($productIn->created_at)->toDateString();
        }

        $session    = $request->session()->get('user') ?? null;
        $isAdmin    = $session->roles()->where('title','admin')->first();
        $isMaster   = $session->roles()->where('title','master')->first();

        return view('pages.product_ins.index',compact('productIns','isAdmin','isMaster'));
    }

    public function create(Request $request) {
        
        $products = Product::query()->where('status','active')->select('id','name')->get(); 
        return view('pages.product_ins.create',compact('products'));
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
        
        $request['added_by'] = $user->id;

        $productIn = ProductIn::create($request->all());

        $dataProduct = [
            "total_product_in"  => $productIn->qty + $productIn->product->total_product_in,
            "stock"  =>$productIn->qty + $productIn->product->stock,
        ];
        Product::findOrfail($productIn->product_id)->update($dataProduct);
        
        return redirect('product-in/create')->withSuccess("Product in has been Created");
    }

    // public function edit($id) {
        
    //     $productIn = ProductIn::query()->where('id',$id)->first();
    //     $products = Product::query()->where('status','active')->select('id','name')->get(); 

    //     return view('pages.product_in.edit', compact('productIn','products'));
    // }

    // public function update(Request $request, $id) {
        
    //     $user = $request->session()->get('user') ?? null;
    //     $body = $request->all();
    //     $validator = [
    //         'product_id'    => 'required',
    //         'qty'           => 'required',
    //     ];
    //     $validator = Validator::make($body, $validator);
    //     if ($validator->fails()) {
    //         session()->flash('error', $validator->errors()->all() ?? 'Something went wrong');
            
    //         return redirect()->back();
    //     }
        
    //     $request['added_by'] = $user->id;

    //     $productIn = ProductIn::where('id',$id)->first();

    //     $productInUpdate = $productIn->update($request->all());

    //     return redirect()->back()->withSuccess("Product In has been Updated");
    // }

    public function show($id) {
        
        $productIn = ProductIn::query()->where('id',$id)->first();
        return view('pages.product_ins.show', compact('productIn'));
    }

    public function destroy($id) {
        
        $productIn = ProductIn::query()->where('id',$id)->first();

        $destroy = $productIn->delete();
        
        return back()->withSuccess("Product In has been deleted successfully!");
    
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductOut;
use App\Models\ProductCategory;
use App\Models\Supplier;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request) {

        $page = $request->has('page') ? $request->get('page') : 1;
        $perPage = $request->has('per_page') ? $request->get('per_page') : $this->total_item_per_loading;
        $offset = ($page - 1) * $perPage;

        $products = Product::query()->limit($perPage)->offset($offset)->latest('id')->get();

        foreach ($products as $product) {
            $product->create = Carbon::parse($product->created_at)->toDateString();
        }
        $this->syncStock();

        $session    = $request->session()->get('user') ?? null;
        $isAdmin    = $session->roles()->where('title','admin')->first();
        $isMaster   = $session->roles()->where('title','master')->first();

        return view('pages.products.index',compact('products','isAdmin','isMaster'));
    }

    public function create(Request $request) {
        
        $suppliers  = Supplier::where('status','active')->select('id','name')->get();
        $categories = ProductCategory::where('status','active')->select('id','name')->get();
        return view('pages.products.create',compact('suppliers','categories'));
    }

    public function store(Request $request) {

        $user = $request->session()->get('user') ?? null;
        $body = $request->all();
        $validator = [
            'name' => 'required',
            'description' => 'required',
            'product_category_id' => 'required',
            'supplier_id' => 'required',
            'price' => 'required',
        ];
        $validator = Validator::make($body, $validator);
        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->all() ?? 'Something went wrong');
            
            return redirect()->back();
        }
        
        $request['added_by'] = $user->id;

        $product = Product::create($request->all());
        
        return redirect('products/create')->withSuccess("Product Has Been Created");
    }

    public function edit($id) {
        
        $product = Product::query()->where('id',$id)->first();
        $suppliers  = Supplier::where('status','active')->select('id','name')->get();
        $categories = ProductCategory::where('status','active')->select('id','name')->get();

        return view('pages.products.edit', compact('product','suppliers','categories'));
    }

    public function update(Request $request, $id) {
        
        $user = $request->session()->get('user') ?? null;
        $body = $request->all();
        $validator = [
            'name' => 'required',
            'description' => 'required',
            'product_category_id' => 'required',
            'supplier_id' => 'required',
            'price' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($body, $validator);
        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->all() ?? 'Something went wrong');
            
            return redirect()->back();
        }
        
        $request['added_by'] = $user->id;

        $product = Product::where('id',$id)->first();

        $productUpdate = $product->update($request->all());

        return redirect()->back()->withSuccess("Product Has Been Updated");
    }

    public function show($id) {
        
        $product = Product::query()->where('id',$id)->first();
        return view('pages.products.show', compact('product'));
    }

    public function destroy($id) {
        
        $product = Product::query()->where('id',$id)->first();

        $destroy = $product->delete();
        
        return back()->withSuccess("Product has been deleted successfully!");
        
        return view('pages.products.show', compact('product'));
    }



    public function syncStock() {
        $products = Product::query()->where('status','active')->get();
        foreach ( $products as $product ) {
            if (!empty($product)) {
                $totalProductIn = ProductIn::query()->where('product_id',$product->id)->sum('qty');
                $totalProductOut = ProductOut::query()->where('product_id',$product->id)->sum('qty');
            }

            $matchThese = [ 
                'id' => $product->id,
            ];
            $productUpdate = Product::query()->where($matchThese)->first();
            $productUpdate->update([
                'total_product_in' => $totalProductIn,
                'total_product_out' => $totalProductOut,
                'stock' => ($totalProductIn - $totalProductOut)
            ]);
        }
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    public function index(Request $request) {

        $page = $request->has('page') ? $request->get('page') : 1;
        $perPage = $request->has('per_page') ? $request->get('per_page') : $this->total_item_per_loading;
        $offset = ($page - 1) * $perPage;

        $categories = ProductCategory::query()->limit($perPage)->offset($offset)->latest('id')->get();

        foreach ($categories as $category) {
            $category->create = Carbon::parse($category->created_at)->toDateString();
        }

        $session    = $request->session()->get('user') ?? null;
        $isAdmin    = $session->roles()->where('title','admin')->first();
        $isMaster   = $session->roles()->where('title','master')->first();

        return view('pages.categories.index',compact('categories','isAdmin','isMaster'));
    }

    public function create(Request $request) {
        
        return view('pages.categories.create');
    }

    public function store(Request $request) {

        $user = $request->session()->get('user') ?? null;
        $body = $request->all();
        $validator = [
            'name' => 'required',
            'description' => 'required',
        ];
        $validator = Validator::make($body, $validator);
        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->all() ?? 'Something went wrong');
            
            return redirect()->back();
        }
        
        $request['added_by'] = $user->id;

        $category = ProductCategory::create($request->all());
        
        return redirect('categories/create')->withSuccess("Category has been Created");
    }

    public function edit($id) {
        
        $category = ProductCategory::query()->where('id',$id)->first();

        return view('pages.categories.edit', compact('category'));
    }

    public function update(Request $request, $id) {
        
        $user = $request->session()->get('user') ?? null;
        $body = $request->all();
        $validator = [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($body, $validator);
        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->all() ?? 'Something went wrong');
            
            return redirect()->back();
        }
        
        $request['added_by'] = $user->id;

        $category = ProductCategory::where('id',$id)->first();

        $categoryUpdate = $category->update($request->all());

        return redirect()->back()->withSuccess("Category has been Updated");
    }

    public function show($id) {
        
        $category = ProductCategory::query()->where('id',$id)->first();
        return view('pages.categories.show', compact('category'));
    }

    public function destroy($id) {
        
        $category = ProductCategory::query()->where('id',$id)->first();

        $destroy = $category->delete();
        
        return back()->withSuccess("Category has been deleted successfully!");
    
    }
}

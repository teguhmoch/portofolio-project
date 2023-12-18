<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(Request $request) {

        $page = $request->has('page') ? $request->get('page') : 1;
        $perPage = $request->has('per_page') ? $request->get('per_page') : $this->total_item_per_loading;
        $offset = ($page - 1) * $perPage;

        $customers =  Customer::query()->limit($perPage)->offset($offset)->latest('id')->get();

        $session    = $request->session()->get('user') ?? null;
        $isAdmin    = $session->roles()->where('title','admin')->first();
        $isMaster   = $session->roles()->where('title','master')->first();

        return view('pages.customers.index',compact('customers','session','isAdmin','isMaster'));
    }

    public function create(Request $request) {
        
        return view('pages.customers.create');
    }

    public function store(Request $request) {

        $user = $request->session()->get('user') ?? null;
        $body = $request->all();
        $validator = [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ];
        $validator = Validator::make($body, $validator);
        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->all() ?? 'Something went wrong');
            
            return redirect()->back();
        }

        $customer = Customer::create($request->all());
        
        return redirect('customer/create')->withSuccess("Customer has been Created");
    }

    public function edit($id) {
        
        $customer = Customer::query()->where('id',$id)->first();

        return view('pages.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id) {
        
        $user = $request->session()->get('user') ?? null;
        $body = $request->all();
        $validator = [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ];
        $validator = Validator::make($body, $validator);
        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->all() ?? 'Something went wrong');
            
            return redirect()->back();
        }

        $customer = Customer::where('id',$id)->first();

        $customerUpdate = $customer->update($request->all());

        return redirect()->back()->withSuccess("Customer has been Updated");
    }

    public function show($id) {
        
        $customer = Customer::query()->where('id',$id)->first();
        return view('pages.customers.show', compact('customer'));
    }

    // public function destroy($id) {
        
    //     $category = ProductCategory::query()->where('id',$id)->first();

    //     $destroy = $category->delete();
        
    //     return back()->withSuccess("Category has been deleted successfully!");
    
    // }
}

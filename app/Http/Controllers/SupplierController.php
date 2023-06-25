<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index(Request $request) {

        $page = $request->has('page') ? $request->get('page') : 1;
        $perPage = $request->has('per_page') ? $request->get('per_page') : $this->total_item_per_loading;
        $offset = ($page - 1) * $perPage;

        $suppliers = Supplier::query()->limit($perPage)->offset($offset)->latest('id')->get();

        foreach ($suppliers as $supplier) {
            $supplier->create = Carbon::parse($supplier->created_at)->toDateString();
        }

        $session    = $request->session()->get('user') ?? null;
        $isAdmin    = $session->roles()->where('title','admin')->first();
        $isMaster   = $session->roles()->where('title','master')->first();

        return view('pages.suppliers.index',compact('suppliers','isMaster','isAdmin'));
    }

    public function create(Request $request) {
        
        return view('pages.suppliers.create');
    }

    public function store(Request $request) {

        $user = $request->session()->get('user') ?? null;
        $body = $request->all();
        $validator = [
            'name' => 'required',
            'contact' => 'required',
            'address' => 'required',
        ];
        $validator = Validator::make($body, $validator);
        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->all() ?? 'Something went wrong');
            
            return redirect()->back();
        }
        
        $request['added_by'] = $user->id;

        $supplier = Supplier::create($request->all());
        
        return redirect()->back()->withSuccess("Supplier has been created");
    }

    public function edit($id) {
        
        $supplier = Supplier::query()->where('id',$id)->first();

        return view('pages.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id) {
        
        $user = $request->session()->get('user') ?? null;
        $body = $request->all();
        $validator = [
            'name' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($body, $validator);
        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->all() ?? 'Something went wrong');
            
            return redirect()->back();
        }
        
        $request['added_by'] = $user->id;

        $supplier = Supplier::where('id',$id)->first();

        $supplierUpdate = $supplier->update($request->all());

        return redirect()->back()->withSuccess("Supplier has been updated");
    }

    public function show($id) {
        
        $supplier = Supplier::query()->where('id',$id)->first();

        $contact = $supplier->contact;
        $subs = substr($contact, 0, 1);

        if ($subs != 0) {
            $len = strlen($supplier->contact) + 1;
            $contact = str_pad($supplier->contact,$len,'0', STR_PAD_LEFT);    
        }

        $split = chunk_split($contact,3,'-');
        
        $supplier->contact = substr_replace($split ,"",-1);
        
        return view('pages.suppliers.show', compact('supplier'));
    }

    public function destroy($id) {
        
        $supplier = Supplier::query()->where('id',$id)->first();

        $destroy = $supplier->delete();
        
        return back()->withSuccess("Supplier has been deleted successfully!");
    
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request) {

        $session = $request->session()->get('user') ?? null;

        $page = $request->has('page') ? $request->get('page') : 1;
        $perPage = $request->has('per_page') ? $request->get('per_page') : $this->total_item_per_loading;
        $offset = ($page - 1) * $perPage;

        $isMaster = $session->roles()->where('title','master')->first();

        if ($isMaster) {
            $users = User::whereDoesntHave('roles', function ($query) {
                $query->where('title', 'master');
            })->get();
        } else {
            $users = User::whereDoesntHave('roles', function ($query) {
                $query->where('title', 'master')->orWhere('title','admin');
            })->get();
        }

        foreach ($users as $user) {
            if ($user->approved_at) {
                $user->approved_at = Carbon::parse($user->approve_at)->toDateString();
            }
        }

        $session    = $request->session()->get('user') ?? null;
        $isAdmin    = $session->roles()->where('title','admin')->first();
        $isMaster   = $session->roles()->where('title','master')->first();

        return view('pages.users.index',compact('users','isAdmin','isMaster'));
    }

    public function create(Request $request) {
        
        return view('pages.users.create');
    }

    public function store(Request $request) {

        $user = $request->session()->get('user') ?? null;
        $body = $request->all();
        $validator = [
            'name'      => 'required',
            'email'     => 'required|email',
            'password'  => 'required',
            'nik'       => 'required',
        ];
        $validator = Validator::make($body, $validator);
        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->all() ?? 'Something went wrong');
            
            return redirect()->back();
        }    

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'nik'       => $request->nik,
            'status'    => 'inactive'
        ]);

        User::findOrFail($user->id)->roles()->sync(3);
        
        return redirect()->back()->withSuccess("User has been created");
    }

    public function edit($id) {
        
        $user = User::query()->where('id',$id)->first();

        return view('pages.users.edit', compact('user'));
    }

    public function update(Request $request, $id) {
        
        $session = $request->session()->get('user') ?? null;
        $body = $request->all();
        $validator = [
            'name'      => 'required',
            'email'     => 'required|email',
            'nik'       => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($body, $validator);
        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->all() ?? 'Something went wrong');
            
            return redirect()->back();
        }

        
        
        $user = User::where('id',$id)->first();

        $userUpdate = $user->update($request->all());

        if ($request->status == 'active') {
            $user->approved_by = $session->id;
            $user->approved_at = now();
            $user->save();            
        }

        return redirect()->back()->withSuccess("User has been updated");
    }

    public function show($id) {
        
        $user = User::query()->where('id',$id)->first();        
        return view('pages.users.show', compact('user'));
    }

    public function destroy($id) {
        
        $user = User::query()->where('id',$id)->first();

        $destroy = $user->delete();
        
        return back()->withSuccess("User has been deleted successfully!");
    
    }
}

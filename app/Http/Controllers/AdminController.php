<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Review;

class AdminController extends Controller
{
    function __construct() {
        $this->middleware('adminMiddleware');
    }
    
    public function create() {
        $types = [
                'user' => 'User',
                'admin' => 'Administrator'
            ];
        return view('admin.create', ['types' => $types]);
    }
    
    public function destroy(User $user) {
        $message = 'User ' . $user->name . ' has not been removed.';
        if($user->email == Auth::user()->email) {
            return back()->withErrors(['message' => $message]);
        }

        $name = $user->name;
        if($user->deleteUser()){
           $message = 'User ' . $name . ' has been removed.';
           return back()->with('message', $message);
        }
    }
    
    public function edit(User $user) {
        $types = [
                'user' => 'User',
                'admin' => 'Administrator'
            ];
                  
        return view('admin.edit', ['user' => $user, 'types' => $types]);
    }
    
    public function reviews(Request $request) {
        $field = '';
        switch ($request->input('order-by')) {
            case '1': $field = 'id';
                break;
            case '2': $field = 'type';
                break;
            case '3': $field = 'rate';
                break;
            case '4': $field = 'title';
                break;
            case '5': $field = 'excerpt';
                break;
            case '6': $field = 'created_at';
                break;
            case '7': $field = 'idUser';
                break;
        }
        
        $orderType = 'desc';
        if ($request->input('order-type') == 'asc') {
            $orderType = 'asc';
        }
        
        $reviews = Review::all();
        if ($field != null) {
            $reviews = Review::orderBy($field, $orderType)->get();
        }
        
        return view('admin.reviews', ['reviews' => $reviews]);
    }

    public function store(Request $request) {
        $user = new User($request->all());
        $user->password = Hash::make($user->password);
        $user->email_verified_at = Carbon::parse(Carbon::now());
        
        if ($user->storeUser()) {
            $message = 'User has been created';
        } else {
            return back()
                ->withInput()
                ->withErrors(['message' => 'An unexpected error occurred while creating.']);
        }

        return back()->with('message', $message);
    }

    public function show(User $user) {
        return view('admin.show');
    }

    public function update(Request $request, User $user) {
        $validatedData = $request->validate([
                'type' => 'required|in:admin,user',
                'name' => 'required|min:2|max:12',
                'email' => 'required|email|max:80',
                'password' => 'nullable|min:8'
            ]);
        $message = 'User has been updated';
        
        $user->password = Hash::make($request->input('password'));
        
        $user->type = $request->type;
        $user->name = $request->name;
        $user->email = $request->email;
        
        if(!$user->updateUser()){
            return back()
                ->withInput()
                ->withErrors(['message' => 'An unexpected error occurred while updating.']);
        } else {
            return redirect('admin/users')->with('message', $message);
        }
    }
    
    public function users(Request $request) {
        $field = '';
        switch ($request->input('order-by')) {
            case '1': $field = 'id';
                break;
            case '2': $field = 'type';
                break;
            case '3': $field = 'name';
                break;
            case '4': $field = 'email';
                break;
            case '5': $field = 'created_at';
                break;
            case '6': $field = 'email_verified_at';
                break;
        }
        
        $orderType = 'desc';
        if ($request->input('order-type') == 'asc') {
            $orderType = 'asc';
        }
        
        $users = User::all();
        if ($field != null) {
            $users = User::orderBy($field, $orderType)->get();
        }
        
        return view('admin.users', ['users' => $users]);
    }
}
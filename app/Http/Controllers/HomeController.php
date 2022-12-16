<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Review;

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
    public function config() {
        return view('user.config');
    }
    
    public function destroy() {
        $user = Auth::user();
        $name = $user->name;
        $message = 'User ' . $name . ' has not been removed.';

        if ($user->deleteUser()) {
            $message = 'User ' . $name . ' has been removed.';
            return redirect('/')->with('message', $message);
        } else {
            return back()->withErrors(['message' => $message]);
        }
    }
     
    public function index() {
        $user = Auth::user();
        $reviews = $user->reviews;
        $reviews = Review::where('idUser', $user->id)->orderBy('updated_at', 'desc')->get();
        return view('home', ['user' => $user, 'reviews' => $reviews]);
    }
    
    public function picture(Request $request, User $user) {
        $data = $request->all();
        if ($request->hasFile('picture')) {
            $destPath = "public/assets/img/picturesProfile";
            $image = $request->file('picture');
            $imageName = $image->getClientOriginalName();
            $path = $request->file('picture')->storeAs($destPath, $imageName);
            $data['picture'] = $imageName;
            $user->update($data);
            return back()->with('works', 'User picture changed!');
        } else {
            return back()->withErrors(['message' => 'You have to choose an image...']);
        }
    }
    
    public function show(User $user) {
        if ($user != Auth::user()) {
            return view('user.show', ['user' => $user]);
        } else {
            return redirect('home');
        }
    }
    
    public function update(Request $request) {
        $validatedData = $request->validate([
                'name' => 'required|min:2|max:12',
                'email' => 'required|email|max:80',
                'oldPassword' => 'nullable|min:8',
                'newPassword' => 'nullable|min:8|same:password_confirm'
            ]);
        $message = 'User data has been updated.';
            
        $user = Auth::user();
        
        // NAME
        $user->name = $request->name;
            
        // PASSWORD
        if ($request->newPassword != null && Hash::check($request->oldPassword, $user->password)) {
            $user->password = Hash::make($request->input('newPassword'));
        } else if ($request->newPassword != null) {
            return back()->withInput()->withErrors(
                ['oldPassword' => 'Old password does not match password']
            );
        }
        
        // EMAIL
        $sendEmail = false;
        if ($request->email != $user->email) {
            $user->email = $request->email;
            $user->email_verified_at = null;
            $sendEmail = true;
        }
        
        if (!$user->updateUser($sendEmail)) {
            return back()
                ->withInput()
                ->withErrors(['message' => 'An unexpected error occurred while updating.']);
        }
        
        if ($sendEmail) {
            $user->sendEmailVerificationNotification();
        }
        
        return redirect('home')->with('message', $message);
    }
}

@extends('layouts.app')

@section('navContent')
    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
    <li class="nav-item"><a class="nav-link" aria-current="page" href="{{ url('review') }}">Reviews</a></li>
    @if (Auth::user())
        <li class="nav-item"><a class="nav-link" href="{{ url('home') }}">Account</a></li>
    @endif
    @guest
        @if (Route::has('login'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
        @endif
    @endguest
    @if(Auth::user() && Auth::user()->type == 'admin')
        <li class="nav-item">
            <a class="nav-link text-danger active" href="{{ url('admin/users') }}">Control</a>
        </li>
    @endif
@endsection

@section('content')
    @error('message')
        <div class="alert alert-danger container">{{ $message }}</div>
    @enderror

    @if(session('message'))
        <div class="alert alert-success container">{{ session('message') }}</div>
    @endif

    <div class="container w-50" style="margin: 3em auto 7em auto;">
	    <div>
    		<h1 style="margin-bottom: 0.7em; font-size: 2.5rem; font-weight: bold">Edit user <span class="text-success">{{ $user->name }}</span></h1>
    		<form action="{{ url('admin/' . $user->id) }}" method="POST">
    		    @csrf
    		    @method('put')
    		    
                <div class="input-group mb-3">
                    <label id="types" class="input-group-text" for="type">Type</label>
                    <select class="custom-select" style="width: 10em; padding-left: 0.3em; border: 1px solid rgba(0, 0, 0, .2)" name="type" required>
                        @foreach ($types as $key => $type)
                            <option value="{{ $key }}" @if($user->type == $key) selected @endif>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <div class="alert alert-danger container">{{ $message }}</div>
    		        @enderror
                </div>
                
    		    <div class="form-group mb-3">
                    <label for="name" class="mb-2">Username</label>
                    <input value="{{ old('name', $user->name) }}" class="form-control" type="text" id="nombre" name="name" minlength="2" maxlength="12" placeholder="User name" required/>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mb-3">
                    <label for="email" class="mb-2">User email</label>
                    <input value="{{ old('email', $user->email) }}" type="email" id="email" name="email" minlength="2" maxlength="80" class="form-control" placeholder="User email" required/>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mt-3">
                    <label for="password" class="mb-2">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"/>
                    @error('password')
                        <div class="alert alert-danger container" style="margin-top: 0.5em">{{ $message }}</div>
                    @enderror
                </div>
    		    
    		    <div class="form-group d-flex flex-direction-column mt-4">
    		        <a href="{{ url('admin') }}" class="btn btn-secondary" style="margin-right: 0.6em">Cancel</a>
    		        <button type="submit" class="btn btn-primary" style="flex: 1">Edit</button>
    		    </div>
    		</form>
		</div>
    </div>
@endsection
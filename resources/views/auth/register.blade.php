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
                <a class="nav-link active" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
        @endif
    @endguest
    @if(Auth::user() && Auth::user()->type == 'admin')
        <li class="nav-item">
            <a class="nav-link text-danger" href="{{ url('admin/users') }}">Control</a>
        </li>
    @endif
@endsection

@section('content')
    <div class="px-4 py-4 px-md-5 text-center text-lg-start" style="margin-bottom: 8.2em">
        <div class="container mt-5" style="margin-bottom: 2.85em">
            <div class="row gx-lg-5 align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <h1 class="mb-4 display-3 fw-bold ls-tight">
                        <i class="bi bi-chat-left-quote"></i>&nbsp;
                        Find out all the <span class="text-primary">reviews</span>
                    </h1>
                    <p style="color: hsl(217, 10%, 50.8%)">
                        Register to be able to send reviews to other 
                        people and share great moments together. 
                        Everything you will see on this page is 
                        publicly accessible and free.
                    </p>
                </div>
    
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="card">
                        <div class="card-body py-5 px-md-5">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                
                                <!-- Username input -->
                                <div class="form-outline mb-4">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" minlength="2" maxlength="12" required autocomplete="name" autofocus>
                                    <label class="form-label mt-2" for="name">{{ __('Name') }}</label>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                                <!-- Email input -->
                                <div class="form-outline mb-4">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" minlength="2" maxlength="80" required autocomplete="email">
                                    <label class="form-label mt-2" for="email">{{ __('Email Address') }}</label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <!-- Password input -->
                                <div class="form-outline mb-4">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    <label class="form-label mt-2" for="password">{{ __('Password') }}</label>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <!-- Repeat password input -->
                                <div class="form-outline mb-4">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    <label class="form-label mt-2" for="password-confirm">{{ __('Confirm Password') }}</label>
                                </div>
                                
    
                                <!-- Checkbox -->
                                <div class="form-check mb-4">
                                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example33"
                                        checked />
                                    <label class="form-check-label" for="form2Example33">
                                        Subscribe to our newsletter
                                    </label>
                                </div>
                                
                                <!-- Buttons -->
                                <div class="d-flex flex-wrap align-items-center align-content-center">
                                    <!-- Back button -->
                                    <a href="{{ route('login') }}" class="btn btn-secondary" style="margin-right: 1em">Back</a>
        
                                    <!-- Submit button -->
                                    <button type="submit" class="btn btn-primary" style="flex: 1">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
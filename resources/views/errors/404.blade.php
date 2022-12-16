@extends('layouts.app')

@section('navContent')
    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
    <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ url('review') }}">Reviews</a></li>
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
            <a class="nav-link text-danger" href="{{ url('admin/users') }}">Control</a>
        </li>
    @endif
@endsection

@section('content')
    <main>
        <section class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-auto text-center">
                        <img loading="lazy" decoding="async" src="{{ url('/assets/img/404.png') }}" alt="404" class="img-fluid mb-4" width="500" height="350">
                        <h1 class="mb-4">Page Not Found!</h1>
                        <a href="{{ url('/') }}" class="btn btn-outline-primary">Back To Home</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
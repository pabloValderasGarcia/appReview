@extends('layouts.app')

@section('navContent')
    <li class="nav-item"><a class="nav-link active" href="{{ url('/') }}">Home</a></li>
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
            <a class="nav-link text-danger" href="{{ url('admin/users') }}">Control</a>
        </li>
    @endif
@endsection

@section('content')
    <!-- Header-->
    <header class="bg-dark" style="min-height: 28.5em">
        @if(session('login_success'))
            <div class="alert alert-success container">{{ session('login_success') }}</div>
        @endif
        <div class="container px-5 pt-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center my-5">
                        <h1 class="display-5 fw-bolder text-white mb-3">Reviews about Movies, Books and Discs!</h1>
                        <p class="lead text-white-50 mb-5">Share your opinions about movies, books and records with everyone and profit from new ideas and behaviors</p>
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                            <a class="btn btn-primary btn-lg px-4 me-sm-3" href="{{ url('review/create') }}">Create Review</a>
                            <a class="btn btn-outline-light btn-lg px-4" href="{{ url('review') }}">View Reviews</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Features section-->
    <section class="py-5 border-bottom" id="features">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="mb-3"><i class="bi bi-film"></i></div>
                    <h2 class="h4 fw-bolder">Movies</h2>
                    <p>Do you like scary movies, adventure, romance, drama? See right now what people think.</p>
                    <a class="text-decoration-none" href="{{ url('review' . '?type=movie') }}">
                        Movie Reviews
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="mb-3"><i class="bi bi-book"></i></div>
                    <h2 class="h4 fw-bolder">Books</h2>
                    <p>Perhaps you spent hours and hours inside a book thanks to its absorption when reading it.</p>
                    <a class="text-decoration-none" href="{{ url('review' . '?type=book') }}">
                        Book reviews
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3"><i class="bi bi-disc"></i></div>
                    <h2 class="h4 fw-bolder">Discs</h2>
                    <p>Have you been all day or even more listening to that catchy song? See what people think!</p>
                    <a class="text-decoration-none" href="{{ url('review' . '?type=disc') }}">
                        Disc reviews
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
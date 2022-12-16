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
    @if(session('message'))
        <div class="alert alert-success container">{{ session('message') }}</div>
    @endif
    
    @php
        use App\Models\User;
    @endphp
    
    <!-- Page header with logo and tagline-->
    <header class="py-1 bg-light border-bottom mb-4">
        <div class="container">
            <div class="text-center my-5">
                <h1 class="fw-bolder"> {{ ucfirst($type) }} Reviews</h1>
                <p class="lead mb-0">See all reviews of our customers</p>
            </div>
        </div>
    </header>
    <!-- Page content-->
    <div class="container" style="margin-bottom: 6em; min-height: 32em">
        <div class="row d-flex">
            <a href="{{ url('review/create') }}" class="btn btn-primary mb-3" style="width: 53.95%; height: 2.8em; margin-right: 2em; margin-left: 0.8em">Create new review</a>
            <div class="col-lg-7 d-flex flex-wrap justify-content-between">
                @if($reviews->isEmpty())
                    <p>No reviews yet...</p>
                @endif
                @foreach($reviews as $review)
                    <div class="card mb-4 w-100" style="margin-right: 2em; min-width: 340px">
                        <a href="{{ url('review/' . $review->id) }}">
                            <div class="thumbnail-reviews card-img-top" style="width: 100%; height: 18em; background-size: cover; 
                                background-repeat: no-repeat; background-position: center; 
                                background-image: url(data:image/jpeg;base64,{{ $review->thumbnail }})">
                            </div>
                        </a>
                        <div class="card-body">
                            <div class="small text-muted d-flex justify-content-between align-items-center mb-1">
                                <ul class="post-meta mb-0">
                                    <li class="d-flex align-items-center">
                                        <a href="{{ url('review' . '?type=' . $review->type) }}" style="margin: 0 1.2em 0 0">{{ $review->type }}</a>
                                        <p class="my-0">{{ $review->updated_at }}</p>
                                    </li>
                                </ul>
                                <a href="{{ url('home/' . $review->user->id) }}" class="nav-link p-0 text-black">
                                    @if($review->user->picture != 'https://i.stack.imgur.com/l60Hf.png')
                                        <img id="output" class="review-user rounded-circle img-fluid" alt="picture" src="{{ asset('storage/assets/img/picturesProfile/' . $review->user->picture) }}" style="width: 40px; height: 40px; object-fit: cover; box-shadow: var(--shadow); border-radius: 60%;"/>
                                    @else
                                        <img id="output" class="review-user rounded-circle img-fluid" alt="picture" src="{{ $review->user->picture }}" style="width: 40px; height: 40px; object-fit: cover; box-shadow: var(--shadow); border-radius: 60%;"/>
                                    @endif
                                </a>
                            </div>
                            <h2 class="card-title h4">{{ $review->title }}</h2>
                            <p class="card-text">{{ $review->excerpt }}</p>
                            <a class="btn btn-primary" href="{{ url('review/' . $review->id) }}">Read more →</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-4" style="margin-left: 2em">
                <div class="card mb-4">
                    <div class="card-header">Total consumers: <b>{{ User::count() }}</b><b></b></div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">Types</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <ul class="list-unstyled mb-0 mx-0">
                                    <li class="d-flex"><a href="{{ url('review') }}" class="nav-link p-0"><i class="bi bi-globe text-black" style="margin-right: 0.5em"></i><b>All</b></a></li>
                                    <li class="d-flex"><a href="{{ url('review' . '?type=movie') }}" class="nav-link p-0"><i class="bi bi-film text-black" style="margin-right: 0.5em"></i><b>Movies</b></a></li>
                                    <li class="d-flex"><a href="{{ url('review' . '?type=book') }}" class="nav-link p-0"><i class="bi bi-book text-black" style="margin-right: 0.5em"></i><b>Books</b></a></li>
                                    <li class="d-flex"><a href="{{ url('review' . '?type=disc') }}" class="nav-link p-0"><i class="bi bi-disc text-black" style="margin-right: 0.5em"></i><b>Discs</b></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">Latests reviews</div>
                    <ul class="container" id="basic-example" style="padding: 0; margin: 0;">
                        @if(!$reviews->isEmpty())
                            @foreach($reviews->slice(0, 3) as $review)
                                <div class="card w-100 mt-4" style="margin-right: 2em; min-width: 340px">
                                    <a href="{{ url('review/' . $review->id) }}">
                                        <div class="thumbnail-reviews card-img-top" style="width: 100%; height: 8em; background-size: cover; 
                                            background-repeat: no-repeat; background-position: center; 
                                            background-image: url(data:image/jpeg;base64,{{ $review->thumbnail }})">
                                        </div>
                                    </a>
                                    <div class="card-body">
                                        <div class="small text-muted mb-3">
                                            <ul class="post-meta mb-0">
                                                <li class="d-flex align-items-center justify-content-between w-100">
                                                    <a href="{{ url('review' . '?type=' . $review->type) }}" style="margin: 0 1.2em 0 0">{{ $review->type }}</a>
                                                    <p class="my-0">{{ $review->updated_at }}</p>
                                                    <div class="d-flex align-items-start justify-content-end" style="flex: 1">
                                                        <a href="" class="deleteLinkElement m-0" data-bs-toggle="modal" 
                                                        data-bs-target="#deleteElement" data-type="review"
                                                        data-name="{{ $review->id }}" data-url="{{ url('review/' . $review->id) }}" style="background-color: unset; padding-right: 0.2em">
                                                            <i class="bi bi-trash" style="font-size: 1.05em; color: red"></i>
                                                        </a>
                                                        <a class="action-review mb-0" href="{{ url('review/' . $review->id . '/edit') }}" style="background-color: unset; padding-right: 0; margin-right: 0"><i class="bi bi-box-arrow-up-right" style="color: green; margin-right: 0.4em"></i></a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <h2 class="card-title h4">{{ $review->title }}</h2>
                                        <p class="card-text">{{ $review->excerpt }}</p>
                                        <a class="btn btn-primary py-1" href="{{ url('review/' . $review->id) }}" style="width: 100%; text-align: center">Read more</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <li class="list-group-item d-flex align-items-center">Not reviews yet</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
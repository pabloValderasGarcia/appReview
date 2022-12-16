@extends('layouts.app')

@section('navContent')
    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
    <li class="nav-item"><a class="nav-link" aria-current="page" href="{{ url('review') }}">Reviews</a></li>
    @if (Auth::user())
        <li class="nav-item"><a class="nav-link active" href="{{ url('home') }}">Account</a></li>
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
    @if(session('works'))
        <div class="alert alert-success container">{{ session('works') }}</div>
    @endif
    @error('message')
        <div class="alert alert-danger container">{{ $message }}</div>
    @enderror
    
    <div class="container rounded bg-white mt-1">
        <div class="row">
            <div class="d-flex col-md-3" style="flex-direction: column">
                <div class="border-right mt-4">
                    <div class="card-body text-center" style="position: relative; height: 17em">
                        @if(Auth::user())
                            <label class="labelPicture" for="file" style="width: 9.5em; height: 9.5em; color: transparent; position: absolute; top: 8%; left: 27.7%; cursor: pointer; height: $circleSize; width: $circleSize; z-index: 9999">
                                <span class="glyphicon glyphicon-camera" style="display: inline-flex; padding: .2em; height: 2em;"></span>
                            </label>
                        @endif
                        <form action="{{ url('home/picture/' . $user->id) }}" enctype="multipart/form-data" method="post">
                            @csrf
                            @method('put')
                            
                            @if(Auth::user())
                                <input id="file" type="file" accept="image/png, image/jpg, image/jpeg" name="picture" onchange="loadFile(event)" style="display: none"/>
                            @endif
                            
                            @if($user->picture != 'https://i.stack.imgur.com/l60Hf.png')
                                <img id="output" class="rounded-circle img-fluid" alt="picture" src="{{ asset('storage/assets/img/picturesProfile/' . $user->picture) }}" style="width: 9.5em; height: 9.5em; position: absolute; top:8%; left:27.7%; object-fit: cover; box-shadow: var(--shadow); z-index: 0"/>
                            @else
                                <img id="output" class="rounded-circle img-fluid" alt="picture" src="{{ $user->picture }}" style="width: 9.5em; height: 9.5em; position: absolute; top:8%; left:27.7%; object-fit: cover; box-shadow: var(--shadow); z-index: 0"/>
                            @endif
                            
                            @if(Auth::user())
                                <button type="submit" class="changeImage btn btn-primary" style="position: absolute; padding: 0"/>Change</button>
                            @endif
                        </form>
                    </div>
                </div>
                @if(Auth::user())
                    <div>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Account config <a href="{{ url('home/config') }}">Configuration</a></li>
                    </div>
                @endif
            </div>
            <div class="col-md-5 border-right mb-5">
                <form action="{{ url('home/update') }}" method="post">
                    @method('put')
                    @csrf
                    
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="name" class="labels mb-2">Username</label>
                                <input type="text" id="name" name="name" minlength="2" maxlength="12" class="form-control" value="{{ old('name', $user->name) }}" placeholder="User name" required/>
                            </div>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="email" class="labels mb-2">Email</label>
                                <input type="email" id="email" name="email" minlength="2" maxlength="80" class="form-control" value="{{ old('email', $user->email) }}" placeholder="User email" required/>
                            </div>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="oldPassword" class="labels mb-2">Old password</label>
                                <input type="password" id="oldPassword" name="oldPassword" class="form-control" placeholder="Old password"/>
                            </div>
                            @error('oldPassword')
                                <div class="alert alert-danger container" style="margin-top: 0.5em">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="newPassword" class="labels mb-2">New password</label>
                                <input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="New password"/>
                            </div>
                            @error('newPassword')
                                <div class="alert alert-danger container" style="margin-top: 0.5em">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="password_confirm" class="labels mb-2">Repeat password</label>
                                <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="Repeat password"/>
                            </div>
                            @error('password_confirm')
                                <div class="alert alert-danger container" style="margin-top: 0.5em">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-5 mb-5 text-center" style="width: 100%">
                            <button class="btn btn-primary profile-button" type="submit" style="width: 100%">Save Profile</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <div class="p-3 py-5" style="height: 46.5em">
                    <div class="col-md-12 h-100">
                        <p><b>Your reviews</b></p>
                        <div class="infinite-scroll h-100" data-mdb-infinite-direction="y" data-mdb-infinite-container="infinite-scroll-basic">
                            <ul class="container list-group infinite-scroll infinite-scroll-basic h-100" id="basic-example" style="overflow-y: scroll; overflow-x: hidden">
                                @if(!$user->reviews->isEmpty())
                                    @foreach($reviews as $review)
                                        <div class="card mb-4 w-100" style="margin-right: 2em; min-width: 340px">
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
        </div>
    </div>
@endsection
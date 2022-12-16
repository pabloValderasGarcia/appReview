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
    <div class="container w-50" style="margin: 3em auto 15em auto;">
	    <div>
    		<h1 style="margin-bottom: 0.7em; font-size: 2.5rem; font-weight: bold">Create review</h1>
    		<form action="{{ url('review') }}" method="POST" enctype="multipart/form-data">
    		    @csrf
    		    
    		    <div class="d-flex justify-content-between">
    		        <div class="input-group mb-3">
                        <label class="input-group-text" for="type">Type</label>
                        <select class="custom-select" style="width: 10em; padding-left: 0.3em; border: 1px solid rgba(0, 0, 0, .2)" name="type" required>
                            <option value="movie">Movie</option>
                            <option value="book">Book</option>
                            <option value="disc">Disc</option>
                        </select>
                        @error('type')
                            <div class="alert alert-danger container">{{ $message }}</div>
        		        @enderror
                    </div>
                    <div class="rate d-flex" style="font-size: 1.3em">
                        <input type="radio" id="star5" name="rate" value="5"/>
                        <label for="star5">5 stars</label>
                        
                        <input type="radio" id="star4" name="rate" value="4"/>
                        <label for="star4">4 stars</label>
                        
                        <input type="radio" id="star3" name="rate" value="3"/>
                        <label for="star3">3 stars</label>
                        
                        <input type="radio" id="star2" name="rate" value="2"/>
                        <label for="star2">2 stars</label>
                        
                        <input type="radio" id="star1" name="rate" value="1"/>
                        <label for="star1">1 star</label>
                    </div>
    		    </div>
    		    
    		    <div class="form-group mb-3">
    		        <label for="title" class="mb-2">Title</label>
    		        <input type="text" class="form-control" name="title" minlength="2" maxlength="40" value="{{ old('title') }}" required/>
    		        @error('title')
                        <div class="alert alert-danger container">{{ $message }}</div>
    		        @enderror
    		    </div>
    		    
    		    <div class="form-group mb-3">
    		        <label for="excerpt" class="mb-2">Excerpt</label>
    		        <textarea class="form-control" style="height: 6em" name="excerpt" minlength="5" maxlength="250" required>{{ old('excerpt') }}</textarea>
    		        @error('excerpt')
                        <div class="alert alert-danger container">{{ $message }}</div>
    		        @enderror
    		    </div>
    		    
    		    <div class="form-group mb-3">
    		        <label for="message" class="mb-2">Message</label>
    		        <input type="text" id="hidden_message" name="hidden_msg" class="form-control" required style="width: 48.8%; height: 23em; position: absolute"/>
    		        <textarea id="messageReview" name="message" class="form-control" style="height: 23em">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="alert alert-danger container">{{ $message }}</div>
                    @enderror
    		    </div>
    		    
    		    <div class="form-group mb-3">
    		        <label class="form-label" for="thumbnail">Thumbnail</label>
    		        <div class="upload__box">
                        <div class="upload__btn-box" style="position: relative">
                            <label id="thumbnail_label" class="upload__btn" style="position: relative; z-index: 1">
                                <i class="bi bi-cloud" style="font-size: 3em"></i>
                                <p class="mb-0">Choose thumbnail</p>
                            </label>
                            <input type="file" id="thumbnail_input" name="thumbnail" data-type="thumbnail" class="upload__thumbnail" required style="color: transparent; background-color: transparent; position: absolute; bottom: 0; left: 35%; z-index: 0">
                        </div>
                        <div id="thumbnail_wrap" class="upload__img-wrap w-100"></div>
                    </div>
                    @error('thumbnail')
                        <div class="alert alert-danger container">{{ $message }}</div>
    		        @enderror
    		    </div>
    		    
    		    <div class="form-group mb-3">
    		        <label class="form-label" for="image">Upload images</label>
    		        <div class="upload__box">
                        <div class="upload__btn-box">
                            <label class="upload__btn">
                                <i class="bi bi-cloud" style="font-size: 3em"></i>
                                <p class="mb-0">Choose images</p>
                                <input type="file" id="images_input" name="image[]" multiple="" data-type="images" class="upload__inputfile">
                            </label>
                        </div>
                        <div id="images_wrap" class="upload__img-wrap upload_images_wrap"></div>
                    </div>
                    @error('image')
                        <div class="alert alert-danger container">{{ $message }}</div>
    		        @enderror
    		    </div>
    		    
    		    <div class="form-group d-flex flex-direction-column">
    		        <a href="{{ url('/') }}" class="btn btn-secondary" style="margin-right: 0.6em">Cancel</a>
    		        <input type="submit" id="createForm" class="btn btn-primary" style="flex: 1" value="Create"/>
    		    </div>
    		</form>
		</div>
    </div>
@endsection
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
    
    <div class="container-xl">
        <div class="table-responsive">
            <a href="{{ url('admin/users') }}" class="btn btn-secondary">Control Users</a>
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>Reviews <b>Management</b></h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="d-flex">
                                <a href="?order-by=1&order-type=asc" style="color: red">&#x25b4;</a>
                                #
                                <a href="?order-by=1&order-type=desc">&#x25be;</a>
                            </th>
                            <th>
                                <a href="?order-by=2&order-type=asc" style="color: red">&#x25b4;</a>
                                Type
                                <a href="?order-by=2&order-type=desc">&#x25be;</a>
                            </th>
                            <th>
                                <a href="?order-by=3&order-type=asc" style="color: red">&#x25b4;</a>
                                Rate
                                <a href="?order-by=3&order-type=desc">&#x25be;</a>
                            </th>						
                            <th>
                                <a href="?order-by=4&order-type=asc" style="color: red">&#x25b4;</a>
                                Title
                                <a href="?order-by=4&order-type=desc">&#x25be;</a>
                            </th>						
                            <th>
                                <a href="?order-by=5&order-type=asc" style="color: red">&#x25b4;</a>
                                Excerpt
                                <a href="?order-by=5&order-type=desc">&#x25be;</a>
                            </th>
                            <th>
                                <a href="?order-by=6&order-type=asc" style="color: red">&#x25b4;</a>
                                Date Created
                                <a href="?order-by=6&order-type=desc">&#x25be;</a>
                            </th>
                            <th>
                                <a href="?order-by=7&order-type=asc" style="color: red">&#x25b4;</a>
                                idUser
                                <a href="?order-by=7&order-type=desc">&#x25be;</a>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                            <tr>
                                <td>
                                    <a href="{{ url('review/' . $review->id) }}">{{ $review->id }}</a>
                                </td>
                                <td>{{ $review->type }}</td>
                                <td>
                                    @if($review->rate == null)
                                        0
                                    @else
                                        {{ $review->rate }}
                                    @endif
                                </td>
                                <td>{{ $review->title }}</td>
                                <td>{{ $review->excerpt }}</td>                       
                                <td>{{ $review->created_at }}</td>
                                <td>{{ $review->idUser }}</td>                       
                                <td class="d-flex">
                                    <a href="" class="deleteLinkElement" data-bs-toggle="modal" 
                                    data-bs-target="#deleteElement" data-type="review"
                                    data-name="{{ $review->id }}" data-url="{{ url('review/' . $review->id) }}">
                                        <i class="bi bi-trash" style="color: red; margin-right: 0.4em"></i>
                                    </a>
                                    <a href="{{ url('review/' . $review->id . '/edit') }}" class="d-flex align-items-center">
                                        <i class="bi bi-box-arrow-up-right" style="color: green; margin-right: 0.4em"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
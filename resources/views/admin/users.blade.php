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
            <a href="{{ url('admin/reviews') }}" class="btn btn-secondary">Control Reviews</a>
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>User <b>Management</b></h2>
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
                                Role
                                <a href="?order-by=2&order-type=desc">&#x25be;</a>
                            </th>
                            <th>
                                <a href="?order-by=3&order-type=asc" style="color: red">&#x25b4;</a>
                                Name
                                <a href="?order-by=3&order-type=desc">&#x25be;</a>
                            </th>						
                            <th>
                                <a href="?order-by=4&order-type=asc" style="color: red">&#x25b4;</a>
                                Email
                                <a href="?order-by=4&order-type=desc">&#x25be;</a>
                            </th>						
                            <th>
                                <a href="?order-by=5&order-type=asc" style="color: red">&#x25b4;</a>
                                Date Created
                                <a href="?order-by=5&order-type=desc">&#x25be;</a>
                            </th>
                            <th>
                                <a href="?order-by=6&order-type=asc" style="color: red">&#x25b4;</a>
                                Verified
                                <a href="?order-by=6&order-type=desc">&#x25be;</a>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->type }}</td>
                                <td>
                                    <a href="{{ url('home/' . $user->id) }}">
                                        @if($user->picture != 'https://i.stack.imgur.com/l60Hf.png')
                                            <img src="{{ asset('storage/assets/img/picturesProfile/' . $user->picture) }}" class="avatar" alt="Avatar"/>
                                        @else
                                            <img src="{{ $user->picture }}" class="avatar" alt="Avatar"/>
                                        @endif
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td>{{ $user->email }}</td>                        
                                <td>{{ $user->created_at }}</td>                        
                                <td>
                                    @if($user->email_verified_at != null)
                                        yes
                                    @else
                                        no
                                    @endif
                                </td>
                                <td class="d-flex">
                                    @if($user->email != Auth::user()->email)
                                        <a href="" class="deleteLinkElement" data-bs-toggle="modal" 
                                        data-bs-target="#deleteElement" data-type="user" 
                                        data-name="{{ $user->name }}" data-url="{{ url('admin/' . $user->id) }}">
                                            <i class="bi bi-trash" style="color: red; margin-right: 0.4em"></i>
                                        </a>
                                    @endif
                                    @if($user == Auth::user())
                                        <a href="{{ url('home') }}">
                                    @else
                                        <a href="{{ url('admin/' . $user->id . '/edit') }}">  
                                    @endif
                                        <i class="bi bi-box-arrow-up-right" style="color: green; margin-right: 0.4em"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ url('admin/create') }}" class="btn btn-primary">Add User</a>
        </div>
    </div>
@endsection
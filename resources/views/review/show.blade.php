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
    <main style="margin: 3em 0 6em 0">
        <section class="section">
            <div class="container" style="max-width: 77.64%">
                <div class="row justify-content-center">
                    <div class="col-lg-8 mb-5 mb-lg-0" style="margin-right: 1em">
                        <article>
                            <div style="width: 100%; height: 25em; background-size: cover; 
                                background-repeat: no-repeat; background-position: center; 
                                background-image: url(data:image/jpeg;base64,{{ $review->thumbnail }})">
                            </div>
                            <ul class="post-meta mb-3 mt-2 d-flex align-items-center" style="height: 45px">
                                <li class="d-flex align-items-center w-100">
                                    <a href="{{ url('review' . '?type=' . $review->type) }}" style="margin: 0; margin-right: 1em">{{ $review->type }}</a>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        style="margin-right:0.6em" class="text-dark" viewBox="0 0 16 16">
                                        <path d="M5.5 10.5A.5.5 0 0 1 6 10h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z" />
                                        <path
                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z" />
                                        <path
                                            d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z" />
                                    </svg> <span>{{ $review->updated_at }}</span>
                                    <div class="show-rate rate d-flex" style="transform: rotateY(0deg); margin-left: auto; font-size: 1.3em">
                                        @for($i = 1; $i <= $review->rate; $i++)
                                            <input type="radio" id="star{{$i}}" name="rate" value="{{$i}}"/>
                                            <label for="star{{$i}}" class="starMarked">{{$i}} stars</label>
                                        @endfor
                                        @for($i = $review->rate; $i <= 5; $i++)
                                            @if($i != 5)
                                                <input type="radio" id="star{{$i}}" name="rate" value="{{$i}}"/>
                                                <label for="star{{$i}}">{{$i}} stars</label>
                                            @endif
                                        @endfor
                                    </div>
                                </li>
                            </ul>
                            <h1><b>{{ ucfirst(trans($review->title)) }}</b></h1>
                            <p>{{ ucfirst(trans($review->excerpt)) }}</p>
                            <div class="mb-3 content text-left" style="border-bottom: 10px solid rgba(0,0,0,.04); padding-left: 1%; padding-right: 1%"></div>
                            <div class="content text-left">{!! $review->message !!}</div>
                            @if(!$images->isEmpty())
                                <div class="content text-left mb-2" style="border-bottom: 10px solid rgba(0,0,0,.04); padding-left: 1%; padding-right: 1%"></div>
                                <div class="content text-left py-3" style="border-bottom: 10px solid rgba(0,0,0,.04); padding-left: 1%">
                                    <div class="d-flex flex-wrap">
                                        @foreach($images as $image)
                                            <a href="{{ url('review/displayImages/'. $image->path) }}" class="other-image-review" style="width: 19%; height: 8em; margin-right: 1%; margin-bottom: 1%">
                                                <div style="width: 100%; height: 100%; background-size: cover; 
                                                    background-repeat: no-repeat; background-position: center; 
                                                    background-image: url({{ url('review/displayImages/'. $image->path) }})">
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="content text-left" style="border-bottom: 10px solid rgba(0,0,0,.04); padding-left: 1%; padding-right: 1%"></div>
                            @endif
                        </article>
                        <div class="mt-5">
                            <div id="disqus_thread"></div>
                            <script type="application/javascript">
                                var disqus_config = function () {};
                                (function () {
                                    if (["localhost", "127.0.0.1"].indexOf(window.location.hostname) != -1) {
                                        document.getElementById('disqus_thread').innerHTML = 'Disqus comments not available by default when the website is previewed locally.';
                                        return;
                                    }
                                    var d = document, s = d.createElement('script'); s.async = true;
                                    s.src = '//' + "themefisher-template" + '.disqus.com/embed.js';
                                    s.setAttribute('data-timestamp', +new Date());
                                    (d.head || d.body).appendChild(s);
                                })();
                            </script>
                            <noscript>Please enable JavaScript to view the <a
                                    href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a>
                            </noscript>
                            <a href="https://disqus.com" class="dsq-brlink">comments powered by <span
                                    class="logo-disqus">Disqus</span></a>
                        </div>
                    </div>
                    <div class="col-lg-4" style="width: 21.5%">
                        <div class="widget-blocks">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="widget">
                                        <div class="widget-body">
                                            <a href="{{ url('home/' . $review->user->id) }}" class="review_user_picture">
                                                @if($review->user->picture != 'https://i.stack.imgur.com/l60Hf.png')
                                                    <img loading="lazy" decoding="async" style="object-fit:cover; width: 65px; height: 65px; border-radius: 50%" src="{{ asset('storage/assets/img/picturesProfile/' . $review->user->picture) }}" alt="About Me" class="author-thumb-sm d-block">
                                                @else
                                                    <img loading="lazy" decoding="async" style="object-fit:cover; width: 65px; height: 65px; border-radius: 50%" src="{{ $review->user->picture }}" alt="About Me" class="author-thumb-sm d-block"/>
                                                @endif
                                            </a>
                                            <h2 class="widget-title my-3"><b>Author </b>{{ $review->user->name }}</h2>
                                            <p>
                                                <b>Email </b>{{ $review->user->email }}
                                            </p>
                                            <a href="{{ url('home/' . $review->user->id) }}" class="btn btn-sm btn-outline-primary px-3 py-1 mb-4">Know More</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3 col-md-6 w-100">
                                    <div class="widget">
                                        <h2 class="section-title mb-3">Review information</h2>
                                        <div class="widget-body">
                                            <ul class="info-review">
                                                <li><b>Type</b> {{ ucfirst($review->type) }}</li>
                                                <li><b>Created at</b> {{ $review->created_at }}</li>
                                                <li><b>Updated at</b> {{ $review->updated_at }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @if($review->idUser == Auth::user()->id)
                                    <div class="col-lg-12 col-md-6 w-100">
                                        <div class="widget">
                                            <h2 class="section-title mb-3">Review control</h2>
                                            <div class="widget-body">
                                                <ul class="info-review">
                                                    <li class="action-review" style="font-size: 1.2em;">
                                                        <a href="" class="deleteLinkElement" data-bs-toggle="modal" 
                                                        data-bs-target="#deleteElement" data-type="review"
                                                        data-name="{{ $review->id }}" data-url="{{ url('review/' . $review->id) }}">
                                                            <i class="bi bi-trash" style="color: red; margin-right: 0.4em"></i>Delete
                                                        </a>
                                                    </li>
                                                    <li class="action-review" style="font-size: 1.2em;">
                                                        <a href="{{ url('review/' . $review->id . '/edit') }}" class="d-flex align-items-center">
                                                            <i class="bi bi-box-arrow-up-right" style="color: green; margin-right: 0.4em"></i>Edit
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
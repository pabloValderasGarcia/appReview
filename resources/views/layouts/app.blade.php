<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <title>OpenReviews - Reviews 2022</title>
        <!-- Font Awesome -->
        <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{ url('/assets/img/icon.ico') }}"/>
        <!-- Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet"/>
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ url('/assets/css/styles.css') }}" rel="stylesheet"/>
        <!-- My Style -->
        <link href="{{ url('/assets/css/myStyles.css') }}" rel="stylesheet"/>
        
        <x-head.tinymce-config/>
    </head>
    <body>
        <!-- LOADER -->
        <div class="loader"></div>
        
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="logoReviews navbar-brand" href="{{ url('/') }}"><b>OpenReviews App - 2022</b></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @yield('navContent')
                        @if(Auth::user())
                            <li class="nav-item d-flex align-items-center" style="margin-left: 1em; padding: 0">
                                <form action="{{ url('logout') }}" method="post">
                                    @csrf
                                    <button class="btn btn-danger py-1 px-3" type="submit">Logout</button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- DELETE MODAL -->
        <div class="modal fade" id="deleteElement" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action method="post" id="deleteFormElement">
                        @csrf
                        @method('delete')
                        <div class="px-3 d-flex justify-content-between align-items-center text-white bg-secondary" style="margin: 0">
                            <h6 class="modal-title mb-0" id="threadModalLabel">Delete <b id="deleteElementType"></b></h6>
                            <button type="button" class="close text-white" style="background-color: transparent; border: none; font-size: 1.5em" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <div class="modal-body pb-0">
                            <label for="name">Are you sure to delete <b id="deleteElementName"></b>?</label>
                            <div class="modal-footer d-flex mx-0 px-0">
                                <button type="button" class="btn btn-secondary m-0" data-bs-dismiss="modal" style="border: 0;">Cancel</button>
                                <input id="deleteElementTypeInput" type="submit" class="btn btn-primary" style="border: 0; flex: 1"></input>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        @yield('content')
        <!-- Footer-->
        <footer class="bg-dark" style="z-index: 9999999999; padding: 1em 0; position: fixed; bottom: 0; width: 100%">
            <div class="container"><p class="m-1 text-center text-white">Copyright &copy; OpenReviews 2022</p></div>
        </footer>
        <!-- Upload Images -->
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
        <!-- Me -->
        <script src="{{ url('/assets/js/scripts.js') }}"></script>
    </body>
</html>
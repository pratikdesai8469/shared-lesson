<!-- navigation -->
<header>
    <!-- top header -->
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-inline text-lg-right text-center">
                        <li class="list-inline-item">
                            <a href="mailto:admin@shared-lessons.org">info@shared-lessons.org</a>
                        </li>
                        {{-- <li class="list-inline-item">
                            <a href="callto:1234565523">Call Us Now:
                                <span class="ml-2"> 123 456 5523</span>
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- nav bar -->
    <div class="navigation">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="navbar-brand">
                    <a class="nav-logo" href="{{url('/')}}">
                        <img src="{{ asset('public/website/images/logo1.png') }}" height="75" width="60" alt="logo">
                    </a>
                    <div class="nav-logo-text font-italic font-weight-bold"><a class="logo-title" href="{{url('/')}}">SharedLessons</a></div>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            @if(Auth::user() && Auth::user()->role == 2)
                                @guest
                                <li class="nav-item">
                                    <a class="nav-link btn btn-primary btn-sm" href="{{url('/web-login')}}">Login</a>
                                </li>
                                @endguest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('seo-meta')}}">SEO</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-primary btn-sm" href="{{url('/logout')}}">Logout</a>
                                </li>
                            @else
                                <li class="nav-item dropdown {{request()->is('units-and-skills') || request()->is('create-database') ? 'active' : '' }}">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Plans
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{url('/units-and-skills')}}">Add Plan</a>
                                        <a class="dropdown-item" href="{{url('/create-database')}}">Create Your Database</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown {{request()->is('plan') ? 'active' : '' }}">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Teacher Plans
                                    </a>
                                    <div class="dropdown-menu" >
                                        <a class="dropdown-item" href="{{url('/plan')}}">Saved Lesson Plan</a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('/how-to-use')}}">How To use</a>
                                </li>
                                @guest
                                <li class="nav-item">
                                    <a class="nav-link btn btn-primary btn-sm" href="{{url('/web-login')}}">Login</a>
                                </li>
                                @endguest
                                @auth
                                <li class="nav-item {{request()->is('profile') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{url('/profile')}}">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-primary btn-sm" href="{{url('/logout')}}">Logout</a>
                                </li>
                                @endauth
                            @endif
                        </ul>
                    </div>
            </nav>
        </div>
    </div>
</header>

<!-- Search Form -->
<div class="search-form">
    <a href="#" class="close" id="searchClose">
        <i class="ti-close"></i>
    </a>
    <div class="container">
        <form action="#" class="row">
            <div class="col-lg-10 mx-auto">
                <h3>Search Here</h3>
                <div class="input-wrapper">
                    <input type="text" class="form-control" name="search" id="search" placeholder="Enter Keywords..." required>
                    <button>
                        <i class="ti-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
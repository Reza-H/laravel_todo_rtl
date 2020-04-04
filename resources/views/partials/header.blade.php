<nav class="navbar navbar-expand-lg navbar-dark bg-dark main-nav">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt px-1 " style="vertical-align: middle;"></i></a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus px-1"></i></a>
{{--                        {{ __('عضویت') }}--}}
                    </li>
                @endif
            @else
                <li class="nav-item active">
                    <!-- <span class="nav-link" href="#"><i class="fa fa-user" aria-hidden="true"></i><span class="sr-only">(current)</span></a> -->
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user px-1" aria-hidden="true"></i>
                    </a>
                    <div class="dropdown-menu nav-dropdown-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-address-card px-1"></i>پروفایل</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">

                            <i class="fas fa-sign-out-alt px-1"></i> {{ __('خروج') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>


            @endguest
                @if(Auth::check())
                    <li class="nav-item">
                        <a class="nav-link " href="#"><i class="fas fa-bell px-1"></i></a>
                    </li>
                @endif
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}"><i class="fas fa-home px-1"></i></a>
            </li>
            @if(Auth::check())
            <li class="nav-item">
            <a class="nav-link" href="{{ url('/todos') }}"><i class="fas fa-list  px-1"></i></a>
            </li>
            @endif
        </ul>

    </div>
    <a class="navbar-brand" href="{{ url('/') }}" style="position: fixed;top: 0.4rem;left: 0.4rem;">زمتان</a>
</nav>

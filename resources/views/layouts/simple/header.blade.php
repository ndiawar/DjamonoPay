<div class="page-header">
    <div class="header-wrapper row m-0">
        <div class="header-logo-wrapper col-auto p-0">
            <div class="logo-wrapper">
                <a href="{{ route('index') }}">
                    <img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt="" style="width: 40px; height: auto;">
                </a>
            </div>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
            </div>
        </div>
        <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
            <ul class="nav-menus">
                <li class="onhover-dropdown">
                    <div class="notification-box">
                        <svg>
                            <use href="{{ asset('assets/svg/icon-sprite.svg#notification') }}"></use>
                        </svg>
                        <span class="badge rounded-pill badge-secondary">4</span>
                    </div>
                    <div class="onhover-show-div notification-dropdown">
                        <h6 class="f-18 mb-0 dropdown-title">Notifications</h6>
                        <ul>
                            <li class="b-l-primary border-4">
                                <p>Delivery processing <span class="font-danger">10 min.</span></p>
                            </li>
                            <li class="b-l-success border-4">
                                <p>Order Complete<span class="font-success">1 hr</span></p>
                            </li>
                            <li class="b-l-secondary border-4">
                                <p>Tickets Generated<span class="font-secondary">3 hr</span></p>
                            </li>
                            <li class="b-l-warning border-4">
                                <p>Delivery Complete<span class="font-warning">6 hr</span></p>
                            </li>
                            <li><a class="f-w-700" href="#">Check all</a></li>
                        </ul>
                    </div>
                </li>
                <li class="profile-nav onhover-dropdown pe-0 py-0">
                    
                <div class="media profile-media">
                    @if(Auth::check())
                        @if(Auth::user()->photo)
                            <img class="b-r-10" 
                                src="{{ asset('storage/' . Auth::user()->photo) }}" 
                                alt="Photo de profil" 
                                style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <img class="b-r-10" 
                                src="{{ asset('assets/images/user.jpg') }}" 
                                alt="Image par défaut" 
                                style="width: 40px; height: 40px; object-fit: cover;">
                        @endif
                        <div class="media-body">
                            <span>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                            <p class="mb-0 font-roboto">{{ Auth::user()->role }} <i class="middle fa fa-angle-down"></i></p>
                        </div>
                    @else
                        <img class="b-r-10" 
                            src="{{ asset('assets/images/dashboard/profile.png') }}" 
                            alt="Invité" 
                            style="width: 40px; height: 40px; object-fit: cover;">
                        <div class="media-body">
                            <span>Invité</span>
                            <p class="mb-0 font-roboto">Visiteur <i class="middle fa fa-angle-down"></i></p>
                        </div>
                    @endif
                </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li><a href="{{ route('profile') }}"><i data-feather="user"></i><span>Compte</span></a></li>
                        <li>
                            <a href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i data-feather="log-out"></i><span>Déconnexion</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

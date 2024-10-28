<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper"><a href="{{ route('index') }}">
            <img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo.png') }}" alt="">
            <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo_dark.png') }}" alt="">
        </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>

        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">

                    <!-- Lien visible uniquement pour l'agent -->
                    @if(Auth::check() && Auth::user()->role === 'agent')
                     <!-- Lien visible pour tous les utilisateurs -->
                     <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="{{ route('index') }}">
                            <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg>
                            <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use></svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Lien Transactions visible pour tous -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('dashboard-transactions') }}">
                            <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-starter-kit') }}"></use></svg>
                            <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-starter-kit') }}"></use></svg>
                            <span>Transactions</span>
                        </a>
                    </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('dashboard-approvisionner') }}">
                                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-charts') }}"></use></svg>
                                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-charts') }}"></use></svg>
                                <span>Approvisionner</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('dashboard-activites') }}">
                                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#24-hour') }}"></use></svg>
                                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#24-hour') }}"></use></svg>
                                <span>Activitées</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('dashboard-utilisateurs') }}">
                                <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#user-visitor') }}"></use></svg>
                                <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#user-visitor') }}"></use></svg>
                                <span>Utilisateurs</span>
                            </a>
                        </li>
                    @endif

                    <!-- Lien visible uniquement pour le distributeur -->
                    @if(Auth::check() && Auth::user()->role === 'distributeur')
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title link-nav" href="{{ route('distributeurs.afficher_Historique') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                                </svg><span> Distributeur</span></a>
                        </li>
                    @endif

                    <!-- Lien visible uniquement pour le client -->
                    @if(Auth::check() && Auth::user()->role === 'client')
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title link-nav" href="{{ route('clients.afficher_Historiques_clients') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#user-visitor') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#user-visitor') }}"></use>
                                </svg><span> Client</span></a>
                        </li> 
                    @endif
                    
                    
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DjamonoPay est une application de gestion financière flexible, puissante, et moderne, conçue avec une interface utilisateur réactive et intuitive.">
    <meta name="keywords" content="Elle offre des possibilités illimitées pour la gestion sécurisée des transactions, adaptée à divers besoins des utilisateurs dans un environnement professionnel et communautaire.">
    <meta name="author" content="Adefnipa-P3/Groupe1">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <title>DjamonoPay - 2024</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @include('layouts.simple.css')
    @yield('style')
</head>
<body>

  <body @if(Route::current()->getName() == 'index') onload="startTime()" @elseif (Route::current()->getName() == 'button-builder') class="button-builder" @endif>
    <div class="loader-wrapper">
      <div class="loader-index"><span></span></div>
      <svg>
        <defs></defs>
        <filter id="goo">
          <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
          <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
        </filter>
      </svg>
    </div>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      @include('layouts.simple.header')
      <!-- Page Header Ends  -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        @include('layouts.simple.sidebar')
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <div class="container-fluid">        
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  @yield('breadcrumb-title')
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('/')}}">                                       
                      <svg class="stroke-icon">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                      </svg></a></li></li>
                    @yield('breadcrumb-items')
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          @yield('content')
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        @include('layouts.simple.footer') 
        
      </div>
    </div>
    <!-- latest jquery-->
    @include('layouts.simple.script')  
    <!-- Plugin used-->

 <!-- Bootstrap JS Bundle (inclut Popper) -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
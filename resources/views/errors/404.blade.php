@extends('layouts.errors.master')
@section('title', 'Error 404')

@section('css')
@endsection

@section('style')
@endsection


@section('content')
<div class="page-wrapper compact-wrapper" id="pageWrapper">
  <!-- error-404 start-->
  <div class="error-wrapper">
    <div class="container"><img class="img-100" src="{{asset('assets/images/other-images/sad.png')}}" alt="">
      <div class="error-heading">
        <h2 class="headline font-info">404</h2>
      </div>
      <div class="col-md-8 offset-md-2">
                  <p class="sub-content">La page que vous tentez d'atteindre n'est pas disponible actuellement. Cela peut être dû au fait que la page n'existe pas ou qu'elle a été déplacée.</p>
               </div>
               <div><a class="btn btn-info-gradien btn-lg" href="{{ route('index')}}">Retour Page Acceuil</a></div>
    </div>
  </div>
  <!-- error-404 end      -->
</div>
@endsection

@section('script')

@endsection
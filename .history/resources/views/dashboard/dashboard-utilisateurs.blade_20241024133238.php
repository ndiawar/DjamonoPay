@extends('layouts.simple.master')
@section('title', 'Client')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
@endsection

@section('breadcrumb-title')
<h3>Utilisateurs</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Dashboard</li>
 <li class="breadcrumb-item active">Utilisateurs</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <h1>Dashboard Utilisateurs</h1>
    </div>
  </div>
   
@endsection

@section('script')
<script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
<script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/dashboard_5.js') }}"></script>
@endsection

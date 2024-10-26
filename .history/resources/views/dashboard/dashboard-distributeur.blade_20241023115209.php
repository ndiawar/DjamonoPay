@extends('layouts.simple.master')
@section('title', 'Distributeur')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Distributeur</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Distributeur</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row size-column">
            <h1>Dashboard Distributeur</h1>
        </div>
    </div>
@endsection

@section('script')
    <!-- <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"></script>
    <script src="{{ asset('assets/js/counter/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter/counter-custom.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/dashboard_2.js') }}"></script>
    <script src="{{ asset('assets/js/animation/wow/wow.min.js') }}"></script> -->
@endsection

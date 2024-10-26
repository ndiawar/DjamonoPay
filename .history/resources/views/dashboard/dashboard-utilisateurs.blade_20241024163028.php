@extends('layouts.simple.master')
@section('title', 'Client')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
<h3>Utilisateurs</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Dashboard</li>
 <li class="breadcrumb-item active">Utilisateurs</li>
@endsection

@section('content')
        <div class="container-fluid ">
                <!-- Table Utilisateurs-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <h3 class="mb-3">Listes des utilisateurs</h3>
                        <div class="row w-75 mt-5 justify-content-center">
                            <div class="col-md-4">
                                <div class="w-75 border-start border-5  card small-widget">
                                    <div class="bg-gradient">
                                        <svg class="stroke-icon svg-fill">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#pending-order') }}"></use>
                                        </svg>
                                        <span class="font-success">
                                            <i class="icon-arrow-up"></i>
                                            <span class="pe-3">+30%</span>
                                        </span>
                                    </div>
                                    <div class="card-body primary">
                                        <span class="f-light pt-2 fs-4">Nombre de Clients</span>
                                        <div class="d-flex align-items-end gap-1 pt-4">
                                            <h6 class="fs-2">1.258</h6>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="w-75 border-start border-5  card small-widget">
                                    <div class="bg-gradient">
                                        <svg class="stroke-icon svg-fill">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#pending-order') }}"></use>
                                        </svg>
                                        <span class="font-success">
                                            <i class="icon-arrow-up"></i>
                                            <span class="pe-3">+30%</span>
                                        </span>
                                    </div>
                                    <div class="card-body primary">
                                        <span class="f-light pt-2 fs-4">Nombre de Distributeurs</span>
                                        <div class="d-flex align-items-end gap-1 pt-4">
                                            <h6 class="fs-2">1.258</h6>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="w-75 border-start border-5  card small-widget">
                                    <div class="bg-gradient">
                                        <svg class="stroke-icon svg-fill">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#pending-order') }}"></use>
                                        </svg>
                                        <span class="font-success">
                                            <i class="icon-arrow-up"></i>
                                            <span class="pe-3">+30%</span>
                                        </span>
                                    </div>
                                    <div class="card-body primary">
                                        <span class="f-light pt-2 fs-4">Nombre de Agents</span>
                                        <div class="d-flex align-items-end gap-1 pt-4">
                                            <h6 class="fs-2">1.258</h6>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive user-datatable">
                            <table class="display" id="datatable-range">
                                <thead>
                                    <tr>
                                        <th>Utilisateurs</th>
                                        <th>Adresse</th>
                                        <th>Carte Identité</th>
                                        <th>Rôle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Mon Prenom</td>
                                        <td>Dakar</td>
                                        <td>2024 1997 00981</td>
                                        <td>admin</td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Mon Prenom</td>
                                        <td>Dakar</td>
                                        <td>2024 1997 00981</td>
                                        <td>admin</td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Mon Prenom</td>
                                        <td>Dakar</td>
                                        <td>2024 1997 00981</td>
                                        <td>admin</td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Mon Prenom</td>
                                        <td>Dakar</td>
                                        <td>2024 1997 00981</td>
                                        <td>admin</td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Mon Prenom</td>
                                        <td>Dakar</td>
                                        <td>2024 1997 00981</td>
                                        <td>admin</td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Mon Prenom</td>
                                        <td>Dakar</td>
                                        <td>2024 1997 00981</td>
                                        <td>admin</td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Mon Prenom</td>
                                        <td>Dakar</td>
                                        <td>2024 1997 00981</td>
                                        <td>admin</td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Mon Prenom</td>
                                        <td>Dakar</td>
                                        <td>2024 1997 00981</td>
                                        <td>admin</td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Mon Prenom</td>
                                        <td>Dakar</td>
                                        <td>2024 1997 00981</td>
                                        <td>admin</td>
                                    </tr>                              
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tale Utilisateurs-->
        </div>        
    @endsection

@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/dashboard_5.js') }}"></script>


<script src="{{asset('assets/js/chart/apex-chart/apex-chart.js')}}"></script>
<!-- <script src="{{ asset('assets/js/clock.js') }}"></script> -->
<script src="{{ asset('assets/js/chart/apex-chart/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
<!-- <script src="{{ asset('assets/js/dashboard/default.js') }}"></script> -->
<script src="{{ asset('assets/js/notify/index.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/typeahead.bundle.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/typeahead.custom.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/typeahead-custom.js') }}"></script>
<script src="{{ asset('assets/js/height-equal.js') }}"></script>
<script src="{{ asset('assets/js/animation/wow/wow.min.js') }}"></script>
<script src="{{asset('assets/js/chart/apex-chart/stock-prices.js')}}"></script>
<script src="{{asset('assets/js/chart/apex-chart/chart-custom.js')}}"></script>
@endsection

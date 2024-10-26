@extends('layouts.simple.master')
@section('title', 'Distributeur')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection


@section('breadcrumb-title')
    <h3>Distributeur</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Distributeur</li>
@endsection

    @section('content')
        <h1>Dashboard Distributeur</h1>
        <div class="container-fluid">
            <div class="row mt-5">
                <div class="col-md-4 m-auto  ">
                    <div class="border-start border-5 border-info card small-widget">
                        <div class="card-body primary">
                            <span class="f-light pt-2">Solde</span>
                            <div class="d-flex align-items-end gap-1 pt-4">
                                <h6>1.258.000 Fcfa</h6>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 m-auto ">
                    <div class="border-start border-5 border-success card small-widget">
                        <div class="card-body primary">
                            <span class="f-light pt-2">Envoie</span>
                            <div class="d-flex align-items-end gap-1 pt-4">
                            <h6>1.258.000 Fcfa</h6>
                                
                            </div>
                            <div class="bg-gradient">
                                <svg class="stroke-icon svg-fill">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#pending-order') }}"></use>
                                </svg>
                                <span class="font-success">
                                    <i class="icon-arrow-up"></i>
                                    <span class="pe-3">+30%</span>
                                </span>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4 m-auto ">
                    <div class="border-start border-5 border-warning card small-widget">
                        <div class="card-body primary">
                            <span class="f-light pt-2">Retrait</span>
                            <div class="d-flex align-items-end gap-1 pt-4">
                            <h6>1.258.000 Fcfa</h6>
                                
                            </div>
                            <div class="bg-gradient">
                                <svg class="stroke-icon svg-fill">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#pending-order') }}"></use>
                                </svg>
                                <span class="font-success">
                                    <i class="icon-arrow-up"></i>
                                    <span class="pe-3">+30%</span>
                                </span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection

@extends('layouts.simple.master')
@section('title', 'Distributeur')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
@endsection

@section('style')
<style>
        .card-balance {
            border-radius: 10px;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .card-balance h2 {
            font-size: 2rem;
            font-weight: bold;
        }

        .card-balance .balance-amount {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 0;
        }

        .card-actions {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .card-actions .action {
            text-align: center;
        }

        .card-actions .action i {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .percentage {
            background-color: #e6ffed;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9rem;
            color: #34c759;
            font-weight: bold;
        }
    </style>
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
        <div class="row mt-5 position-absolute top-50 start-50">
             <!-- Solde Card -->
            <div class="card card-balance mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted mb-2">Solde</p>
                        <h2 class="balance-amount">$128,320</h2>
                    </div>
                    <div class="col-md-6">
                        <div class="card-actions">
                            <div class="action">
                                <i class="bi bi-send-fill"></i>
                                <p>Envoyer</p>
                            </div>
                            <div class="action">
                                <i class="bi bi-arrow-down-circle"></i>
                                <p>Retrait</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cards for Envoie and Retrait -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card p-3 text-center">
                        <p class="text-muted">Envoie</p>
                        <h4>$128,320</h4>
                        <span class="percentage">↑ 11.09%</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3 text-center">
                        <p class="text-muted">Retrait</p>
                        <h4>$128,320</h4>
                        <span class="percentage">↑ 11.09%</span>
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

@extends('layouts.simple.master')
@section('title', 'Distributeur')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('style')
<style>
.icon-button {
    width: 60px;
    height: 60px;
    background-color: #003f77;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: none;
}

.icon-button:hover {
    background-color: #002c59;
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
        <div class="row mt-5 position-absolute top-5 start-50">
             <!-- Solde Card -->
            <div class="row">
                <div class="col-md-8  ">
                    <div class="border-start border-5 border-dark card small-widget d-flex">
                        <div class="card-body primary">
                            <span class="f-light pt-2">Solde</span>
                            <div class="d-flex align-items-end gap-1 pt-4">
                                <h6>1.258.000 Fcfa</h6>
                                
                            </div>
                        </div>
                        <div class="d-flex flex-row-reverse bd-highlight">
                            <!-- Button Envoyer -->
                            <button class="icon-button rounded-circle btn btn-primary mb-2">
                                <i class="bi bi-send-fill"></i>
                            </button>

                            <!-- Button Retrait -->
                            <button class="icon-button rounded-circle btn btn-primary">
                                <i class="bi bi-arrow-down-circle-fill"></i>
                            </button>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
@endsection

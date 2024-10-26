@extends('layouts.simple.master')
@section('title', 'Distributeur')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* Styles des cards */
    .card-solde, .card-mini {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        position: relative;
    }

    /* Bande colorée à gauche */
    .card-solde::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 8px;
        height: 100%;
        background-color: #003F6B;
    }

    .card-mini::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 8px;
        height: 100%;
        background-color: #B0DEFF;
    }

    .card-solde {
        display: flex;
        align-items: center;
        padding: 20px;
    }

    .card-solde h2 {
        font-size: 2.5rem;
        font-weight: bold;
    }

    .solde-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .icon-circle {
        background-color: #003F6B;
        color: white;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .indicator {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border-radius: 10px;
        padding: 2px 8px;
        font-weight: bold;
        font-size: 0.9rem;
        margin-top: 5px;
        display: inline-block;
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
        <div class="container-fluid ">
                <!-- Table Distributeurs-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <h3 class="mb-3">Historique des transactions</h3>
                        <div class="row">
                            
                            <div class="col-md-6 offset-md-3">
                                <div class="card-solde">
                                        <div class=" bg-white">
                                            <div class="flex-grow-1">
                                                <h6 class="text-muted">Solde</h6>
                                                <h2>$128,320</h2>
                                            </div>
                                            <div class="d-block solde-actions">
                                                <div class="text-center">
                                                    <div class="icon-circle mb-1">
                                                    <i class="bi bi-send-fill"></i>
                                                    </div>
                                                    <small>Envoyer</small>
                                                </div>
                                                <div class="text-center">
                                                    <div class="icon-circle mb-1">
                                                    <i class="bi bi-arrow-down-circle-fill"></i>
                                                    </div>
                                                    <small>Retrait</small>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row w-75 mt-5 justify-content-center">
                            <div class="col-md-4">
                    
                            </div>
                            <div class="col-md-4">
                                <div class="w-75 border-start border-5 border-success card small-widget">
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
                            <div class="col-md-4">
                                <div class="w-75 border-start border-5 border-warning card small-widget">
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
                    <div class="card-body">
                        <div class="table-responsive user-datatable">
                            <table class="display" id="datatable-range">
                                <thead>
                                    <tr>
                                        <th>Distributeur</th>
                                        <th>Adresse</th>
                                        <th>Numéro Compte</th>
                                        <th>Transaction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td class="d-flex rounded" style="background-color: #d4edda;">
                                            <p class="me-2">325.452 Fcfa</p> 
                                            <p class="">Retrait</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td class="d-flex rounded" style="background-color: #d4edda;">
                                            <p class="me-2">325.452 Fcfa</p> 
                                            <p class="">Retrait</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td class="d-flex rounded" style="background-color: #d4edda;">
                                            <p class="me-2">325.452 Fcfa</p> 
                                            <p class="">Retrait</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td class="d-flex rounded" style="background-color: #d4edda;">
                                            <p class="me-2">325.452 Fcfa</p> 
                                            <p class="">Retrait</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td class="d-flex rounded" style="background-color: #d4edda;">
                                            <p class="me-2">325.452 Fcfa</p> 
                                            <p class="">Retrait</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td class="d-flex rounded" style="background-color: #cce5ff;">
                                        <p class="me-2">325.452 Fcfa</p> 
                                        <p class="">Dépôt</p>
                                    </td>

                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td class="d-flex rounded" style="background-color: #cce5ff;">
                                        <p class="me-2">325.452 Fcfa</p> 
                                        <p class="">Dépôt</p>
                                    </td>

                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td class="d-flex rounded" style="background-color: #cce5ff;">
                                        <p class="me-2">325.452 Fcfa</p> 
                                        <p class="">Dépôt</p>
                                    </td>

                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td class="d-flex rounded" style="background-color: #f8d7da;">
                                            <p class="me-5">325.452 Fcfa</p> 
                                            <p class="">annulé</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td class="d-flex rounded" style="background-color: #f8d7da;">
                                            <p class="me-5">325.452 Fcfa</p> 
                                            <p class="">annulé</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td class="d-flex rounded" style="background-color: #f8d7da;">
                                            <p class="me-5">325.452 Fcfa</p> 
                                            <p class="">annulé</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td class="d-flex rounded" style="background-color: #f8d7da;">
                                            <p class="me-5">325.452 Fcfa</p> 
                                            <p class="">annulé</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tale Distributeurs-->
        </div>        
    @endsection


@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/dashboard_5.js') }}"></script>

@endsection

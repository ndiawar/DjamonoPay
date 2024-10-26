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
                                <div class="card p-3 shadow-sm rounded-lg"> <!-- Card with padding, shadow, and rounded corners -->
                                    <div class="d-flex justify-content-between align-items-center"> <!-- Center alignment -->
                                        <div>
                                            <h6 class="text-muted">Solde</h6>
                                            <h2>$128,320</h2>
                                        </div>
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="mb-2">
                                                <div class="icon-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width: 50px; height: 50px; border-radius: 50%;">
                                                    <i class="fs-4 bi bi-send-fill"></i> <!-- Bootstrap Icon for "Envoyer" -->
                                                </div>
                                                <span class="d-block mt-1 text-center">Envoyer</span>
                                            </div>
                                            <div>
                                                <div class="icon-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width: 50px; height: 50px; border-radius: 50%;">
                                                    <i class="fs-4 bi bi-arrow-down-circle-fill"></i> <!-- Bootstrap Icon for "Retrait" -->
                                                </div>
                                                <span class="d-block mt-1 text-center">Retrait</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Envoie et Retrait summary section -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="card p-2 shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span>Envoie</span>
                                            <h4>$128,320</h4>
                                        </div>
                                        <div class="text-success">
                                            <i class="bi bi-arrow-up-right-circle-fill"></i> <!-- Bootstrap Icon for increase -->
                                            <span>11.09%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card p-2 shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span>Retrait</span>
                                            <h4>$128,320</h4>
                                        </div>
                                        <div class="text-success">
                                            <i class="bi bi-arrow-up-right-circle-fill"></i>
                                            <span>11.09%</span>
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

@extends('layouts.simple.master')
@section('title', 'Distributeur')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<!-- Custom CSS -->
<style>
    .icon-circle {
        background-color: #003f6b; /* Couleur de fond des icônes */
        color: white; /* Couleur des icônes */
    }

    .card-hover {
        background-color: #6c757d; /* Couleur par défaut (gris) */
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        background-color: rgba(52, 58, 64, 0.8); /* Gris foncé avec opacité au hover */
        transform: translateY(-5px); /* Légère élévation au hover */
        transition: all 0.3s ease; /* Effet de transition fluide */
    }

    /* Bordure gauche bleue personnalisée pour la carte principale */
    .card-solde {
        border-left: 5px solid #003f6b;
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
                        <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="card p-3 shadow-sm rounded-lg mb-3 position-relative" style="border-left: 5px solid #003f6b;"> <!-- Bordure gauche bleue -->
                                <div class="d-flex justify-content-between align-items-center text-center">
                                    <div>
                                        <h6 class="text-muted">Solde</h6>
                                        <h2>$128,320</h2>
                                    </div>
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="mb-2">
                                            <div class="icon-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; border-radius: 50%; background-color: #003f6b;"> <!-- Couleur de fond du bouton -->
                                                <i class="fs-5 bi bi-send-fill text-white"></i> <!-- Icône blanche -->
                                            </div>
                                            <span class="d-block mt-1 text-center text-muted">Envoyer</span>
                                        </div>
                                        <div>
                                            <div class="icon-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; border-radius: 50%; background-color: #003f6b;"> <!-- Couleur de fond du bouton -->
                                                <i class="fs-5 bi bi-arrow-down-circle-fill text-white"></i> <!-- Icône blanche -->
                                            </div>
                                            <span class="d-block mt-1 text-center text-muted">Retrait</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Envoie et Retrait summary section -->
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-3 mb-3">
                            <div class="card p-2 shadow-sm card-hover bg-ligth text-dark"> <!-- Background sombre et hover -->
                                <div class="d-flex justify-content-between align-items-center text-center">
                                    <div>
                                        <span>Envoie</span>
                                        <h4>$128,320</h4>
                                    </div>
                                    <div class="text-success">
                                        <i class="bi bi-arrow-up-right-circle-fill"></i> <!-- Icône de montée -->
                                        <span>11.09%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card p-2 shadow-sm card-hover bg-ligth text-dark"> <!-- Background sombre et hover -->
                                <div class="d-flex justify-content-between align-items-center text-center">
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

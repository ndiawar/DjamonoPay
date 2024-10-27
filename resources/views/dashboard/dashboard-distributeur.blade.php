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

    .card-hover:hover {
        background-color: rgba(52, 58, 64, 0.1); /* Gris foncé avec opacité au hover */
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
                                            <div class="icon-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; border-radius: 50%; background-color: #003f6b;"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#transfertModal"> <!-- Bouton qui ouvre le modal -->
                                                <i class="fs-5 bi bi-send-fill text-white"></i> <!-- Icône blanche -->
                                            </div>
                                            <span class="d-block mt-1 text-center text-muted">Envoyer</span>
                                        </div>
                                        <!-- Modal pour le transfert -->
                                        <div class="modal fade" id="transfertModal" tabindex="-1" aria-labelledby="transfertModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="transfertModalLabel">Effectuer un Transfert</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('distributeurs.transfert_clients') }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="recipient" class="form-label">Numero Client Expediteur </label>
                                                            <input type="text" class="form-control" id="recipient" name="numero_compte_source" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="recipient" class="form-label">Numero Client Destinataire</label>
                                                            <input type="text" class="form-control" id="recipient" name="numero_compte_destination" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="amount" class="form-label">Montant</label>
                                                            <input type="number" class="form-control" id="amount" name="montant" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-secondary btn-custom me-2">Envoyer</button>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Modal transfert-->
                                        <div>
                                            <div class="icon-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; border-radius: 50%; background-color: #003f6b;"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#retraitModal"> <!-- Bouton qui ouvre le modal -->
                                                <i class="fs-5 bi bi-arrow-down-circle-fill text-white"></i> <!-- Icône blanche -->
                                            </div>
                                            <span class="d-block mt-1 text-center text-muted">Retrait</span>
                                        </div>
                                        <!-- Modal pour le REtrait -->
                                        <div class="modal fade" id="retraitModal" tabindex="-1" aria-labelledby="retraitModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="retraitModalLabel">Effectuer un Retrait</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('distributeurs.effectuer_retrait') }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="recipient" class="form-label">Numero Client</label>
                                                            <input type="text" class="form-control" id="recipient" name="numero_compte" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="amount" class="form-label">Montant</label>
                                                            <input type="number" class="form-control" id="amount" name="montant" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-secondary btn-custom me-2">Envoyer</button>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Modal retrait -->
                                        <div>
                                            <div class="icon-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; border-radius: 50%; background-color: #003f6b;"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#depotModal"> <!-- Bouton qui ouvre le modal -->
                                            <i class="fs-5 bi bi-arrow-down-left-circle text-white"></i> <!-- Icône blanche -->
                                            </div>
                                            <span class="d-block mt-1 text-center text-muted">Depôt</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <!-- Modal pour le transfert -->
                    <div class="modal fade" id="depotModal" tabindex="-1" aria-labelledby="depotModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="depotModalLabel">Effectuer un Depôt</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            <div class="modal-body">
                                <form action="{{ route('distributeurs.crediter_compte_client') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="recipient" class="form-label">Numero Client</label>
                                        <input type="text" class="form-control" id="recipient" name="numero_compte" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Montant</label>
                                        <input type="number" class="form-control" id="amount" name="montant" required>
                                    </div>
                                    <button type="submit" class="btn btn-secondary btn-custom me-2">Envoyer</button>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fin Modal Depot -->
                    <!-- Envoie et Retrait summary section -->
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-3 mb-3">
                            <div class="border-start border-5 border-info card p-2 shadow-sm card-hover bg-ligth text-dark"> <!-- Background sombre et hover -->
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
                            <div class="border-start border-5 border-info card p-2 shadow-sm card-hover bg-ligth text-dark"> <!-- Background sombre et hover -->
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
                                        <th>Photo</th>
                                        <th>Clients</th>
                                        <th>Numéro Compte</th>
                                        <th>Montant</th>
                                        <th>Type_Transaction</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tbody>

                                </tbody>
                               </table>
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

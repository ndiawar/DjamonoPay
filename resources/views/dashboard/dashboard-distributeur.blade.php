@extends('layouts.simple.master')
@section('title', 'Distributeur')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
                                        <h2>{{ number_format($solde, 0, ',', ' ') }} FCFA</h2>
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
                    
                    </div>
                    <div class="card-body">
                        
                         <div class="table-responsive user-datatable">
                                        <table class="display" id="datatable-range">
                                            <thead>
                                        <tr>
                                             <th class="align-middle">Photo</th>
                                            <th class="align-middle">Clients</th>
                                            <th class="align-middle">Numéro Compte</th>
                                            <th class="align-middle">Montant</th>
                                            <th class="align-middle">Type_Transaction</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                            </thead>
                                    <tbody>
                                        @if(isset($transactions) && count($transactions) > 0)
                                            @foreach($transactions as $transaction)
                                                <tr>
                                                    <td class="align-middle">
                                                        @if($transaction->photo)
                                                            <img src="{{ asset('storage/' . $transaction->photo) }}" 
                                                                alt="Photo" 
                                                                class="rounded-circle"
                                                                style="width: 50px; height: 50px; object-fit: cover;">
                                                        @else
                                                            <img src="{{ asset('assets/images/user.jpg') }}" 
                                                                alt="Default" 
                                                                class="rounded-circle"
                                                                style="width: 50px; height: 50px; object-fit: cover;">
                                                        @endif
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="d-flex flex-column">
                                                            <span class="fw-bold">{{ $transaction->nom }} {{ $transaction->prenom }}</span>
                                                            <!-- <span class="text-muted small">{{ $transaction->prenom }}</span> -->
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="d-none d-md-inline">{{ $transaction->numero_compte }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="fw-bold {{ 
                                                            $transaction->type_transaction == 'depot' ? 'text-success' : 
                                                            ($transaction->type_transaction == 'annulee' ? 'text-warning' : 'text-danger') 
                                                        }}">
                                                            {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA
                                                        </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="badge {{ 
                                                            $transaction->type_transaction == 'depot' ? 'bg-success' : 
                                                            ($transaction->type_transaction == 'annulee' ? 'bg-warning' : 'bg-danger') 
                                                        }}">
                                                            {{ ucfirst($transaction->type_transaction) }}
                                                        </span>
                                                    </td>
                                                    
                                                    <td class="align-middle">
                                                    <div class="d-flex gap-2">
    <!-- Bouton détails -->
    <button type="button" 
            class="btn btn-info btn-sm"
            data-bs-toggle="modal" 
            data-bs-target="#detailsModal{{ $transaction->id }}"
            title="Voir détails">
        <i class="bi bi-eye"></i> <!-- Icône de l'œil pour voir les détails -->
    </button>

    <!-- Bouton annuler -->
    <button type="button text-white" 
            class="btn btn-danger btn-sm"
            data-bs-toggle="modal" 
            data-bs-target="#annulerModal{{ $transaction->id }}"
            title="Annuler">
        <i class="bi bi-x-lg"></i> <!-- Icône X pour annuler -->
    </button>
</div>


                                                        <!-- Modal Détails -->
                                                        <div class="modal fade" id="detailsModal{{ $transaction->id }}" tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Détails de la transaction</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p><strong>Distributeur :</strong> {{ $transaction->nom }} {{ $transaction->prenom }}</p>
                                                                        <p><strong>Numéro de compte :</strong> {{ $transaction->numero_compte }}</p>
                                                                        <p><strong>Type :</strong> {{ ucfirst($transaction->type_transaction) }}</p>
                                                                        <p><strong>Montant :</strong> {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Modal Annulation -->
                                                        <div class="modal fade" id="annulerModal{{ $transaction->id }}" tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Confirmation d'annulation</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="alert alert-warning">
                                                                            <p><strong>Êtes-vous sûr de vouloir annuler cette transaction ?</strong></p>
                                                                            <p><strong>Distributeur :</strong> {{ $transaction->nom }} {{ $transaction->prenom }}</p>
                                                                            <p><strong>Montant :</strong> {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA</p>
                                                                            <p><strong>Type :</strong> {{ ucfirst($transaction->type_transaction) }}</p>
                                                                            <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i') }}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                                        <form action="{{ route('distributeurs.annuler_transaction', $transaction->id) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('POST')
                                                                            <button type="submit" class="btn btn-danger">Confirmer</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">Aucune transaction trouvée</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
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
<script src="{{ asset('assets/js/dashboard/dashboard_5.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection

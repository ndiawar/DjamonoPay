@extends('layouts.simple.master')
@section('title', 'Approvissionement')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
        .custom-input-group {
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
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
    <h3>Approvissionement</h3>
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Approvissionement</li>
@endsection

@section('content')
    <div class="container-fluid ">
        <h2 class="mb-4">Créditer un distributeur</h2>

        <!-- Affichage des messages de succès ou d'erreur -->
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row justify-content-center mt-3">
            <div class="col-md-3 mb-3">
                <!-- Card with Dollar Icon and Percentage Change -->
                <div class="border-start card p-2 shadow-sm card-hover bg-light text-dark">
                    <div class="d-flex justify-content-between align-items-center text-center">
                        <div>
                            <span>Crédits Envoyées</span>
                            <h4><i class="bi bi-currency-dollar"></i>{{ number_format($totalCredits, 0, ',', ' ') }} Fcfa</h4> <!-- Dollar Icon before the amount -->
                        </div>
                        <!-- <div class="text-success">
                            <i class="bi bi-arrow-up-right-circle-fill"></i> Upward trend icon 
                            <span>11.09%</span>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-6">
            <!-- Form Section -->
            <form id="credit-form" method="POST" action="{{ route('agents.crediter_compte_distributeur') }}">
                @csrf
                <div class="col mt-5">
                    <div class="mb-4">
                        <label for="distributeur" class="form-label">Sélectionnez un Distributeur</label>
                        <div class="input-group custom-input-group">
                            <select class="form-control" id="distributeur" onchange="updateDistributeurDetails()">
                                <option value="">Choisissez un distributeur</option>
                                @foreach ($distributeurs as $distributeur)
                                    @foreach($distributeur->comptes as $compte)
                                    <option value="{{ $compte->id }}"
                                            data-nom="{{ $distributeur->nom }}"
                                            data-prenom="{{ $distributeur->prenom }}"
                                            data-numero="{{ $compte->numero_compte }}"
                                            data-solde="{{ $compte->solde }}">
                                        {{ $distributeur->nom }} {{ $distributeur->prenom }}
                                    </option>
                                    @endforeach
                                @endforeach
                            </select>
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="card-number" class="form-label">Numéro de Compte</label>
                        <div class="input-group custom-input-group">
                            <input type="text" class="form-control" id="card-number" name="numero_compte" placeholder="Numéro de compte" readonly>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="credit" class="form-label">Montant à Créditer</label>
                        <div class="input-group custom-input-group">
                            <input type="number" class="form-control" id="montant" name="montant" placeholder="Montant" required>
                            <span class="input-group-text">F/ FCFA</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-secondary btn-custom me-2">Envoyer</button>
                    <button class="btn btn-secondary btn-custom">Annuler</button>
                </div>
            </form>
            <!-- Table Section -->
        </div>

        <div class="col-sm-6">
          <div class="card">
            <div class="card-header pb-0 card-no-border">
            </div>
            <div class="card-body">
                <div class="table-responsive user-datatable">
                    <table class="display" id="datatable-range">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Numero Compte</th>
                                <th>Solde</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($distributeurs as $distributeur)
                                @foreach($distributeur->comptes as $compte)
                            <tr>
                                <td>{{ $distributeur->nom }}</td>
                                <td>{{ $distributeur->prenom }}</td>
                                <td>{{ $compte->numero_compte }}</td>
                                <td>{{ $compte->solde }}</td>
                            </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
   function updateDistributeurDetails() {
    const select = document.getElementById('distributeur');
    const selectedOption = select.options[select.selectedIndex];

    // Vérifiez si une option a été sélectionnée
    if (selectedOption) {
        const numeroCompte = selectedOption.getAttribute('data-numero');
        const nom = selectedOption.getAttribute('data-nom');
        const prenom = selectedOption.getAttribute('data-prenom');

        // Mettre à jour les champs correspondants
        document.getElementById('card-number').value = numeroCompte ? numeroCompte : '';
        
        // Le champ pour le crédit est à remplir manuellement par l'utilisateur
        document.getElementById('montant').value = ''; // Réinitialise le montant
    }
}
</script>


@endsection
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

    <div class="row justify-content-center mt-3">
        <div class="col-md-3 mb-3">
            <!-- Card with Dollar Icon and Percentage Change -->
            <div class="border-start card p-2 shadow-sm card-hover bg-light text-dark">
                <div class="d-flex justify-content-between align-items-center text-center">
                    <div>
                        <span>Crédits Envoyées</span>
                        <h4><i class="bi bi-currency-dollar"></i>128,320 Fcfa/XOF</h4> <!-- Dollar Icon before the amount -->
                    </div>
                    <div class="text-success">
                        <i class="bi bi-arrow-up-right-circle-fill"></i> <!-- Upward trend icon -->
                        <span>11.09%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="row mt-5">
        <!-- Form Section -->
        <div class="col-md-6">
            <div class="mb-4">
                <label for="distributeur" class="form-label">Distributeur</label>
                <div class="input-group custom-input-group">
                    <input type="text" class="form-control" id="distributeur" value="Jan Nowak" placeholder="Nom du distributeur" readonly>
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                </div>
            </div>

            <div class="mb-4">
                <label for="card-number" class="form-label">Numéro de Carte</label>
                <div class="input-group custom-input-group">
                    <input type="text" class="form-control" id="card-number" value="44 5858 6585 5558 3333 8564 2485" readonly>
                </div>
            </div>

            <div class="mb-4">
                <label for="credit" class="form-label">Crédit</label>
                <div class="input-group custom-input-group">
                    <input type="text" class="form-control" id="credit" value="6.000.000 FCFA" readonly>
                    <span class="input-group-text">F/ XOF</span>
                </div>
            </div>

            <button class="btn btn-primary btn-custom me-2">Envoyer</button>
            <button class="btn btn-secondary btn-custom">Annuler</button>
        </div>

        <!-- Table Section -->
        <div class="col-sm-6">
          <div class="card">
            <div class="card-header pb-0 card-no-border">
            </div>
            <div class="card-body">
                <div class="table-responsive user-datatable">
                    <table class="display" id="datatable-range">
                        <thead>
                            <tr>
                                <th>Distributeur</th>
                                <th>Numero Carte</th>
                                <th>Crédit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Jan Nowak</td>
                                <td class="card-number">44 5858 6585 5558 3333 8564 2485</td>
                                <td>6.000.000 FCFA</td>
                            </tr>
                            <tr>
                                <td>Jan Nowak</td>
                                <td class="card-number">44 5858 6585 5558 3333 8564 2485</td>
                                <td>6.000.000 FCFA</td>
                            </tr>
                            <tr>
                                <td>Jan Nowak</td>
                                <td class="card-number">44 5858 6585 5558 3333 8564 2485</td>
                                <td>6.000.000 FCFA</td>
                            </tr>
                            <tr>
                                <td>Jan Nowak</td>
                                <td class="card-number">44 5858 6585 5558 3333 8564 2485</td>
                                <td>6.000.000 FCFA</td>
                            </tr>
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


@endsection

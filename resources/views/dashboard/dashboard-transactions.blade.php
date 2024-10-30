@extends('layouts.simple.master')
@section('title', 'Distributeur')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Distributeur</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Transactions</li>
@endsection

@section('content')
    <div class="container-fluid ">
        <!-- Table Transactions-->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0 card-no-border">
                    <h3 class="mb-3">Historique des transactions</h3>
                    <div class="row w-75 mt-5 justify-content-center">
                        <!-- Widget du Solde -->
                        <div class="col-md-4">
                            <div class="w-75 border-start border-5 border-info card small-widget">
                                <div class="card-body primary">
                                    <span class="f-light pt-2">Solde</span>
                                    <div class="d-flex align-items-end gap-1 pt-4">
                                        <h6 class="fs-2">{{ number_format($solde, 0, ',', ' ') }} Fcfa</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <!-- Widget des Envois -->
                        <div class="col-md-4">
                            <div class="w-75 border-start border-5 border-success card small-widget">
                                <div class="card-body primary">
                                    <span class="f-light pt-2">Envoie</span>
                                    <div class="d-flex align-items-end gap-1 pt-4">
                                        <h6 class="fs-2">{{ number_format($totalTransfert, 0, ',', ' ') }} Fcfa</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <!-- Widget des Retraits -->
                        <div class="col-md-4">
                            <div class="w-75 border-start border-5 border-warning card small-widget">
                                <div class="card-body primary">
                                    <span class="f-light pt-2">Retrait</span>
                                    <div class="d-flex align-items-end gap-1 pt-4">
                                        <h6 class="fs-2">{{ number_format($totalRetrait, 0, ',', ' ') }} Fcfa</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Formulaire de filtre -->
                    <div class="mb-3">
                        <form method="GET" action="{{ route('dashboard-transactions') }}">
                            <label for="type_transaction">Filtrer par type de transaction :</label>
                            <select name="type_transaction" id="type_transaction" class="form-select" onchange="this.form.submit()">
                                <option value="">Tous</option>
                                <option value="depot" {{ request('type_transaction') == 'depot' ? 'selected' : '' }}>Dépôt</option>
                                <option value="retrait" {{ request('type_transaction') == 'retrait' ? 'selected' : '' }}>Retrait</option>
                                <option value="transfert" {{ request('type_transaction') == 'transfert' ? 'selected' : '' }}>Transfert</option>
                            </select>
                        </form>
                    </div>

                    <div class="table-responsive user-datatable">
                        <table class="display" id="datatable-range">
                            <thead>
                                <tr>
                                    <th>AGENT</th>
                                    <th>Adresse</th>
                                    <th>Carte Identité</th>
                                    <th>Solde</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($transactions) && count($transactions) > 0)
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td>
                                                @if($transaction->photo)
                                                    <img class="img-fluid table-avtar" 
                                                         src="{{ asset('storage/' . $transaction->photo) }}" 
                                                         alt="Photo" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <img class="img-fluid table-avtar" 
                                                         src="{{ asset('assets/images/user.jpg') }}" 
                                                         alt="Default" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @endif
                                                {{ $transaction->prenom }} {{ $transaction->nom }}
                                            </td>
                                            <td>{{ $transaction->adresse }}</td>
                                            <td>{{ $transaction->numero_identite }}</td>
                                            <td>{{ number_format($transaction->montant, 0, ',', ' ') }} FCFA</td>
                                            <td>
                                                <span class="badge {{ 
                                                    $transaction->type_transaction == 'depot' ? 'bg-success' : 
                                                    ($transaction->type_transaction == 'retrait' ? 'bg-danger' : 'bg-warning') 
                                                }}">
                                                    {{ ucfirst($transaction->type_transaction) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">Aucune transaction trouvée</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Table Transactions-->
    </div>        
@endsection

@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/dashboard_5.js') }}"></script>
@endsection

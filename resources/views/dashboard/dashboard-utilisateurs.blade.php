@extends('layouts.simple.master')
@section('title', 'Client')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
<h3>Utilisateurs</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Dashboard</li>
 <li class="breadcrumb-item active">Utilisateurs</li>
@endsection

@section('content')
        <div class="container-fluid ">
                <!-- Table Utilisateurs-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <h3 class="mb-3">Listes des utilisateurs</h3>
                        <div class="row w-75 mt-5 justify-content-center">
                            <div class="col-md-4">
                                <div class="w-75 border-start border-5 card small-widget">
                                    <div class="bg-gradient">
                                        <svg class="stroke-icon svg-fill">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#pending-order') }}"></use>
                                        </svg>
                                        <span class="font-success">
                                            <i class="icon-arrow-up"></i>
                                            <span class="pe-3">+30%</span>
                                        </span>
                                    </div>
                                    <div class="card-body primary">
                                        <span class="f-light pt-2 fs-6">Nombre de Clients</span>
                                        <div class="d-flex align-items-end gap-1 pt-4">
                                            <h6 class="fs-2">{{ $nombreClients }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-4">
                                <div class="w-75 border-start border-5 card small-widget">
                                    <div class="bg-gradient">
                                        <svg class="stroke-icon svg-fill">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#pending-order') }}"></use>
                                        </svg>
                                        <span class="font-success">
                                            <i class="icon-arrow-up"></i>
                                            <span class="pe-3">+30%</span>
                                        </span>
                                    </div>
                                    <div class="card-body primary">
                                        <span class="f-light pt-2 fs-6">Nombre de Distributeurs</span>
                                        <div class="d-flex align-items-end gap-1 pt-4">
                                            <h6 class="fs-2">{{ $nombreDistributeurs }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-4">
                                <div class="w-75 border-start border-5 card small-widget">
                                    <div class="bg-gradient">
                                        <svg class="stroke-icon svg-fill">
                                            <use href="{{ asset('assets/svg/icon-sprite.svg#pending-order') }}"></use>
                                        </svg>
                                        <span class="font-success">
                                            <i class="icon-arrow-up"></i>
                                            <span class="pe-3">+30%</span>
                                        </span>
                                    </div>
                                    <div class="card-body primary">
                                        <span class="f-light pt-2 fs-6">Nombre d'Agents</span>
                                        <div class="d-flex align-items-end gap-1 pt-4">
                                            <h6 class="fs-2">{{ $nombreAgents }}</h6>
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
                                    <th>Nom</th>
                                    <th>Numero_Compte</th>
                                    <th>Role</th>
                                    <th>État compte</th>
                                    <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    @foreach($user->comptes as $compte) <!-- Itère sur les comptes de chaque utilisateur -->
                                        <tr>
                                            <td>
                                                @if($user->photo)
                                                    <img class="img-fluid table-avtar rounded-circle" 
                                                        src="{{ asset('storage/' . $user->photo) }}" 
                                                        alt="Photo"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <img class="img-fluid table-avtar rounded-circle" 
                                                        src="{{ asset('assets/images/user.jpg') }}" 
                                                        alt="Default"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @endif
                                            </td>
                                            <td>{{ $user->nom }} {{ $user->prenom }}</td>
                                            <td>{{ $compte->numero_compte }}</td> <!-- Utilise le numéro de compte du compte associé -->
                                            <td>{{ $user->role }}</td> 
                                           
                                            <td>{{ $user->etat_compte }}</td>
                                           
                                            <td>
                                                <span class="badge {{ $user->etat_compte == 'actif' ? 'bg-success' : 'bg-warning' }}">
                                                    {{ ucfirst($user->etat_compte) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    @if($user->etat_compte == 'actif')
                                                        <form action="{{ route('agents.bloquer_utilisateur', $user->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir bloquer cet utilisateur ?');">
                                                                Bloquer
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('agents.bloquer_utilisateur', $user->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir débloquer cet utilisateur ?');">
                                                                Débloquer
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <button class="btn btn-primary btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#detailsModal{{ $user->id }}">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tale Utilisateurs-->
        </div>        
    @endsection

@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/dashboard_5.js') }}"></script>


<script src="{{asset('assets/js/chart/apex-chart/apex-chart.js')}}"></script>
<!-- <script src="{{ asset('assets/js/clock.js') }}"></script> -->
<script src="{{ asset('assets/js/chart/apex-chart/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
<!-- <script src="{{ asset('assets/js/dashboard/default.js') }}"></script> -->
<script src="{{ asset('assets/js/notify/index.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/typeahead.bundle.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/typeahead.custom.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/typeahead-custom.js') }}"></script>
<script src="{{ asset('assets/js/height-equal.js') }}"></script>
<script src="{{ asset('assets/js/animation/wow/wow.min.js') }}"></script>
<script src="{{asset('assets/js/chart/apex-chart/stock-prices.js')}}"></script>
<script src="{{asset('assets/js/chart/apex-chart/chart-custom.js')}}"></script>
@endsection

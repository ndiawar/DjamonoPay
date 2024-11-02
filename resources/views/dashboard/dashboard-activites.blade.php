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
    <li class="breadcrumb-item active">Distributeur</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Multiple table control elements Starts-->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0 card-no-border">
                    <h3 class="mb-3">Historique des activités</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive user-datatable">
                        <table class="display" id="datatable-range">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Date</th>
                                    <th>Adresse Identité</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($logs->isEmpty())
                                    <tr>
                                        <td colspan="4">Aucun enregistrement trouvé.</td>
                                    </tr>
                                @else
                                    @foreach ($logs as $log)
                                        <tr>
                                            <td>{{ $log->user->prenom ?? 'Inconnu' }} {{ $log->user->nom ?? 'Inconnu' }}</td> <!-- Affiche le nom de l'utilisateur -->
                                            <td>{{ $log->timestamp }}</td>
                                            <td>{{ $log->description }}</td>
                                            <td>{{ $log->action }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Multiple table control elements Ends-->
    </div>
@endsection

@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/dashboard_5.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#datatable-range').DataTable({
            // Configuration de DataTables si nécessaire
        });
    });
</script>
@endsection

@extends('layouts.simple.master')
@section('title', 'Distributeur')

@section('css')
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
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0 card-no-border">
                <h3 class="mb-3">Statistiques</h3>
                <div class="row w-75 mt-5 justify-content-center">
                    <div class="col-md-4">
                        <div class="w-75 border-start border-5 border-info card small-widget">
                            <div class="card-body primary">
                                <span class="f-light pt-2">Solde Total</span>
                                <div class="d-flex align-items-end gap-1 pt-4">
                                    <h6>{{ number_format($statistics['total_solde'], 0, ',', ' ') }} FCFA</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="w-75 border-start border-5 border-success card small-widget">
                            <div class="card-body primary">
                                <span class="f-light pt-2">Nombre de Distributeurs</span>
                                <div class="d-flex align-items-end gap-1 pt-4">
                                    <h6>{{ $statistics['total_distributeurs'] }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="w-75 border-start border-5 border-warning card small-widget">
                            <div class="card-body primary">
                                <span class="f-light pt-2">Distributeurs Actifs</span>
                                <div class="d-flex align-items-end gap-1 pt-4">
                                    <h6>{{ $statistics['total_distributeurs_actifs'] }}</h6>
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
                                <th>Prenom</th>
                                <th>Numero_identité</th>
                                <th>Solde</th>
                                <th>État compte</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($distributeurs as $distributeur)
                            <tr>
                                <td>
                                    @if($distributeur->photo)
                                        <img class="img-fluid table-avtar rounded-circle" 
                                             src="{{ asset('storage/' . $distributeur->photo) }}" 
                                             alt="Photo"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <img class="img-fluid table-avtar rounded-circle" 
                                             src="{{ asset('assets/images/user.jpg') }}" 
                                             alt="Default"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    @endif
                                </td>
                                <td>{{ $distributeur->nom }}</td>
                                <td>{{ $distributeur->prenom }}</td>
                                <td>{{ $distributeur->numero_identite }}</td>
                                <td>{{ number_format($distributeur->distributeur->solde ?? 0, 0, ',', ' ') }} FCFA</td>
                                <td>
                                    <span class="badge {{ $distributeur->etat_compte == 'actif' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($distributeur->etat_compte) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detailsModal{{ $distributeur->id }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Détails pour chaque distributeur -->
@foreach($distributeurs as $distributeur)
<div class="modal fade" id="detailsModal{{ $distributeur->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails du Distributeur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    @if($distributeur->photo)
                        <img src="{{ asset('storage/' . $distributeur->photo) }}" 
                             alt="Photo" 
                             class="rounded-circle"
                             style="width: 100px; height: 100px; object-fit: cover;">
                    @else
                        <img src="{{ asset('assets/images/user.jpg') }}" 
                             alt="Default" 
                             class="rounded-circle"
                             style="width: 100px; height: 100px; object-fit: cover;">
                    @endif
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <p><strong>Nom:</strong> {{ $distributeur->nom }}</p>
                        <p><strong>Prénom:</strong> {{ $distributeur->prenom }}</p>
                        <p><strong>Email:</strong> {{ $distributeur->email }}</p>
                        <p><strong>Téléphone:</strong> {{ $distributeur->telephone ?? 'Non renseigné' }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p><strong>Numéro identité:</strong> {{ $distributeur->numero_identite }}</p>
                        <p><strong>Solde:</strong> {{ number_format($distributeur->distributeur->solde ?? 0, 0, ',', ' ') }} FCFA</p>
                        <p><strong>Date inscription:</strong> {{ $distributeur->created_at->format('d/m/Y') }}</p>
                        <p><strong>État compte:</strong> 
                            <span class="badge {{ $distributeur->etat_compte == 'actif' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($distributeur->etat_compte) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
</form>

        </div>
    </div>
</div>
@endforeach

@endsection

@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script>
$(document).ready(function() {
    $('#datatable-range').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json'
        },
        order: [[4, 'desc']], // Trie par la colonne solde par défaut
        pageLength: 10
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Écoute l'événement de soumission du formulaire
        $('#updateSoldeForm').on('submit', function(e) {
            e.preventDefault(); // Empêche le comportement par défaut du formulaire

            // Récupère les données du formulaire
            const montant = $('input[name="montant"]').val();
            const distributeurId = '{{ $distributeur->id }}'; // Remplace par l'ID du distributeur

            // Effectue l'appel AJAX
            $.ajax({
                url: '/distributeur/' + distributeurId + '/update-solde',
                method: 'PATCH', // Utilise PATCH ici
                data: {
                    montant: montant,
                    _token: '{{ csrf_token() }}' // Ajoute le token CSRF
                },
                success: function(response) {
                    // Gérer la réponse ici, par exemple :
                    alert(response.message);
                    // Peut-être actualiser la page ou mettre à jour l'interface
                },
                error: function(xhr) {
                    // Gérer les erreurs
                    alert('Erreur : ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>

@endsection
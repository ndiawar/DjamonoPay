@extends('layouts.simple.master')
@section('title', 'Profile')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('breadcrumb-title')
<h3>Profile</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Comptes</li>
<li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        @if(Auth::check())
            <!-- My Profile Section -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="card text-center w-100 p-4 mt-5">
                    <div class="profile-media">
                        @if(Auth::user()->photo)
                            <img class="rounded-circle mb-3"
                                 src="{{ asset('storage/' . Auth::user()->photo) }}"
                                 alt="Photo de profil"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <img class="rounded-circle mb-3"
                                 src="{{ asset('assets/images/user.jpg') }}"
                                 alt="Image par défaut"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @endif
                    </div>
                    <div class="card-body">
                        <p class="text-muted">{{ Auth::user()->role }}</p>
                        <h5>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h5>
                        <p class="text-muted mb-4">{{ Auth::user()->role }}</p>
                        <button class="btn btn-primary w-100">Save</button>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Section -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Profile</h5>
                        <form action="{{ route('profile.update', ['id' => Auth::user()->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nom" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom" value="{{ Auth::user()->nom }}" placeholder="Nom" 
                                           required pattern="[A-Za-zÀ-ÿ '-]+" title="Le nom ne doit contenir que des lettres, des apostrophes ou des traits d'union.">
                                </div>
                                <div class="col-md-6">
                                    <label for="prenom" class="form-label">Prénom</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" value="{{ Auth::user()->prenom }}" placeholder="Prénom" 
                                           required pattern="[A-Za-zÀ-ÿ '-]+" title="Le prénom ne doit contenir que des lettres, des apostrophes ou des traits d'union.">
                                </div>
                            </div>
                        
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" placeholder="Email Address" required>
                            </div>
                        
                            <div class="mb-3">
                                <label for="photo" class="form-label">Profile Photo</label>
                                <input type="file" class="form-control" id="photo" name="photo">
                            </div>
                        
                            <div class="mb-3">
                                <label for="old_password" class="form-label">Ancien mot de passe</label>
                                <input type="password" class="form-control" id="old_password" name="old_password" placeholder="••••••••">
                            </div>
                        
                            <div class="mb-3">
                                <label for="password" class="form-label">Nouveau mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" 
                                    pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}" 
                                    title="Le mot de passe doit contenir au moins 8 caractères, dont au moins une majuscule, une minuscule, un chiffre et un caractère spécial.">
                            </div>
                        
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="text" class="form-control" id="telephone" name="telephone" value="{{ Auth::user()->telephone }}" placeholder="Téléphone" 
                                           pattern="^(77|70|75|76|78)[0-9]{7}$" title="Le numéro doit contenir 9 chiffres et commencer par 77, 70, 75, 76 ou 78.">
                                </div>
                                <div class="col-md-6">
                                    <label for="date_naissance" class="form-label">Date de Naissance</label>
                                    <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="{{ Auth::user()->date_naissance }}" 
                                           min="1000-01-01" max="2012-12-31" title="La date doit être entre 01-01-1000 et 31-12-2012.">
                                </div>
                            </div>
                        
                            <div class="mb-3">
                                <label for="adresse" class="form-label">Adresse</label>
                                <input type="text" class="form-control" id="adresse" name="adresse" value="{{ Auth::user()->adresse }}" placeholder="Adresse">
                            </div>
                        
                            <button type="submit" class="btn btn-dark">Mettre à jour</button>
                            <a href="#" class="btn btn-secondary" id="cancelButton">Annuler</a>
                        </form>
                        
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning text-center">
                Vous devez être connecté pour accéder à votre profil.
            </div>
        @endif
    </div>
</div>

<!-- Modal de succès -->
<div class="modal fade" id="updateSuccessModal" tabindex="-1" aria-labelledby="updateSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateSuccessModalLabel">Mise à jour réussie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Votre profil a été mis à jour avec succès. Vous serez redirigé vers le tableau de bord approprié.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@if(session('success'))
<script>
    // Afficher le modal après une mise à jour réussie
    var myModal = new bootstrap.Modal(document.getElementById('updateSuccessModal'));
    myModal.show();
</script>
@endif

<script>
document.getElementById('cancelButton').addEventListener('click', function(e) {
    e.preventDefault(); // Empêche le comportement par défaut du lien
    var role = '{{ Auth::user()->role }}'; // Récupère le rôle de l'utilisateur
    if (role === 'distributeur') {
        window.location.href = '{{ route('distributeurs.afficher_Historique') }}'; // Redirection pour distributeur
    } else if (role === 'client') {
        window.location.href = '{{ route('clients.afficher_Historiques_clients') }}'; // Redirection pour client
    } else if (role === 'agent') {
        window.location.href = '{{ route('index') }}'; // Redirection pour agent
    } else {
        window.location.href = '{{ route('profile') }}'; // Redirection par défaut, si le rôle est inconnu
    }
});
</script>
@endsection

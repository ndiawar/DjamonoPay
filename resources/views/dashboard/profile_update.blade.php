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
                    <div class="card d-flex flex-column align-items-center justify-content-center text-center w-100 p-4 mt-5">
                        <div class="media profile-media d-flex flex-column align-items-center">
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
                            <p class="text-muted mb-1">{{ Auth::user()->role }}</p>
                            <h5 class="card-title">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h5>
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
                        <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nom" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom" value="{{ Auth::user()->nom }}" placeholder="Nom">
                                </div>
                                <div class="col-md-6">
                                    <label for="prenom" class="form-label">Prénom</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" value="{{ Auth::user()->prenom }}" placeholder="Prénom">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" placeholder="Email Address">
                            </div>

                            <div class="mb-3">
                                <label for="photo" class="form-label">Profile Photo</label>
                                <input type="file" class="form-control" id="photo" name="photo">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="••••••••">
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="text" class="form-control" id="telephone" name="telephone" value="{{ Auth::user()->telephone }}" placeholder="Téléphone">
                                </div>
                                <div class="col-md-6">
                                    <label for="date_naissance" class="form-label">Date de Naissance</label>
                                    <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="{{ Auth::user()->date_naissance }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="adresse" class="form-label">Adresse</label>
                                <input type="text" class="form-control" id="adresse" name="adresse" value="{{ Auth::user()->adresse }}" placeholder="Adresse">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <!-- Message d'erreur si l'utilisateur n'est pas authentifié -->
            <div class="alert alert-warning text-center">
                Vous devez être connecté pour accéder à votre profil.
            </div>
        @endif
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection

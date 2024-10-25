@extends('layouts.simple.master')
@section('title', 'Edit Profil')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection

@section('breadcrumb-title')
    <h3>Edit Profil</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Edit Profil</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <!-- Colonne gauche - Information du profil -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card border">
                    <div class="card-header bg-white " style="color: #0d47a1;">
                         <h5 class="card-title mb-0">Mon Profil </h5>
                    </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/images/user.jpg') }}" class="rounded-circle mb-3" width="100" height="100" alt="Profile">
                                <h5 class="mb-0">Ahmad Lamine</h5>
                                <p class="text-muted">Agent</p>
                            </div>
                            <div class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <small class="text-muted d-block">Numéro de Compte</small>
                                    <span>AetvnyZER89</span>
                                </div>
                                <div class="list-group-item">
                                    <small class="text-muted d-block">Adresse</small>
                                    <span>Keur Massar</span>
                                </div>
                                <div class="list-group-item">
                                    <small class="text-muted d-block">E-mail</small>
                                    <span>ahmad.lamine@gmail.com</span>
                                </div>
                                <div class="list-group-item">
                                    <small class="text-muted d-block">Mot de Passe</small>
                                    <span>********</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne droite - Formulaire -->
                <div class="col-md-8">
                    <form action="" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" name="nom" placeholder="Niassy">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Prénom</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" name="prenom" placeholder="Lamine">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" name="email" placeholder="lamine@gmail.com">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Téléphone</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="tel" class="form-control" name="telephone" placeholder="Telephone">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Date de naissance</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    <input type="date" class="form-control" name="date_naissance" value="1999-03-19">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="********">
                                    <button class="btn btn-outline-dark" type="button" id="togglePassword">
                                        <i class="bi bi-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Numéro de compte</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                                    <input type="text" class="form-control" name="numero_compte" placeholder="1870 1999 02491">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Rôle</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" class="form-control" value="Agent" readonly>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Avatar</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-image"></i></span>
                                    <input type="text" class="form-control" name="avatar" placeholder="agent.png">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                            <button type="button" class="btn btn-secondary">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/dashboard_5.js') }}"></script>
<script>
     document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if(togglePassword) {
            togglePassword.addEventListener('click', function() {
                // Bascule le type de l'input
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Bascule l'icône
                if(type === 'password') {
                    eyeIcon.classList.remove('bi-eye-slash');
                    eyeIcon.classList.add('bi-eye');
                } else {
                    eyeIcon.classList.remove('bi-eye');
                    eyeIcon.classList.add('bi-eye-slash');
                }
            });
        }
    });
</script>
@endsection
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - DjomanoPay</title>
    @vite(['resources/css/register.css', 'resources/js/register.js'])
    <script defer src="{{ asset('js/form.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>

    <div class="background-blur"></div>
    
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            <div class="buttons">
                <a href="{{ route('login') }}" class="btn-secondary">Se connecter</a>
                <button class="btn-primary">S'inscrire</button>
            </div>
        </div>

        <h1>S’inscrire à DjomanoPay</h1>
        <p>Rejoignez DjomanoPay et profitez de paiements rapides et sécurisés !</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registrationForm">
            @csrf

            <div class="input-group">
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" name="nom" placeholder="Nom" value="{{ old('nom') }}" required>
                    <div class="error-message" id="nomError"></div>
                </div>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" name="prenom" placeholder="Prénom" value="{{ old('prenom') }}" required>
                    <div class="error-message" id="prenomError"></div>
                </div>
            </div>

            <div class="input-group">
                <div class="input-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Adresse E-mail" value="{{ old('email') }}" required>
                    <div class="error-message" id="emailError"></div>
                </div>
                <div class="input-icon">
                    <i class="fas fa-phone"></i>
                    <input type="tel" name="telephone" placeholder="Téléphone" value="{{ old('telephone') }}" required>
                    <div class="error-message" id="telephoneError"></div>
                </div>
            </div>

            <div class="input-group">
                <div class="input-icon">
                    <i class="fas fa-home"></i>
                    <input type="text" name="adresse" placeholder="Adresse" value="{{ old('adresse') }}" required>
                    <div class="error-message" id="adresseError"></div>
                </div>
                <div class="input-icon">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" required 
                           min="1000-01-01" max="2012-12-31">
                    <div class="error-message" id="dateNaissanceError"></div>
                </div>
                
                <div class="input-icon password-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Mot de passe" id="password" required>
                    <div class="error-message" id="passwordError"></div>
                    <i class="fas fa-eye" id="togglePassword" style="cursor: pointer; position: absolute; right: -200px; top: 50%; transform: translateY(-50%);"></i>
                </div>
            </div>

            <div class="input-group">
                <div class="input-icon">
                    <i class="fas fa-id-card"></i>
                    <input type="text" name="numero_identite" placeholder="Numéro carte d'identité" value="{{ old('numero_identite') }}" required>
                    <div class="error-message" id="numeroIdentiteError"></div>
                </div>
            </div>

            <div class="input-group center">
                <div class="input-icon">
                    <i class="fas fa-file-image"></i>
                    <input type="file" name="photo" accept=".png, .jpeg" required>
                    <div class="error-message" id="photoError"></div>
                </div>
            </div>

            <button type="submit" class="btn-submit">S'inscrire</button>

            <p class="login-link">
                Vous avez déjà un compte ? <a href="{{ route('login') }}">Connectez-vous ici</a>
            </p>
        </form>

        <footer>
            © 2024 DjomanoPay. Tous droits réservés.
        </footer>
    </div>

</body>
</html>

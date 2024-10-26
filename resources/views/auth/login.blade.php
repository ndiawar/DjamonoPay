<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - DjamonoPay</title>
    @vite(['resources/css/login.css', 'resources/js/login.js'])
    <!-- Intégration de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>

<body>
    <div class="background-blur"></div>

    <div class="container">
        <!-- Section gauche : Texte + Image -->
        <div class="left-section">
            <div class="text-content">
                <h1>Se connecter à DjamonoPay</h1>
                <p>Si vous n'avez pas de compte, <a href="{{ route('register') }}">inscrivez-vous ici !</a></p>
            </div>
            <img id="handal-image" src="{{ asset('images/paie-removebg-preview.png') }}" alt="Illustration échange" />
        </div>

        <!-- Section droite : Formulaire de connexion -->
        <div class="right-section">
            <div class="top-nav">
                <a href="{{ route('login') }}" class="nav-link active">Connexion</a>
                <a href="{{ route('register') }}" class="nav-link">Inscription</a>
            </div>

            <!-- Message d'erreur -->
            @if ($errors->any())
            <div class="error-message">
                <strong>{{ $errors->first() }}</strong>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group">
                    <i class="bi bi-person-circle icon"></i>
                    <input type="text" name="email" placeholder="Adresse e-mail" required autofocus>
                </div>
                <div class="input-group">
                    <i class="bi bi-lock icon"></i>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <i class="bi bi-eye toggle-password" onclick="togglePasswordVisibility()"></i>
                </div>
                <div class="forgot-password">
                    <a href="#">Mot de passe oublié ?</a>
                </div>
                <button type="submit" class="btn-connect">Se connecter</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.querySelector('input[name="password"]');
            const passwordIcon = document.querySelector('.toggle-password');
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = "password";
                passwordIcon.classList.remove('bi-eye-slash');
                passwordIcon.classList.add('bi-eye');
            }
        }
    </script>
</body>

</html>
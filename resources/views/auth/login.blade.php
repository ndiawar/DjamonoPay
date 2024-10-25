<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - DjamonoPay</title>
    @vite(['resources/css/style.css', 'resources/js/login.js'])
    <!-- Intégration de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles pour les messages d'erreur */
        .error-message {
            color: red; /* Couleur du texte en rouge */
            font-weight: bold; /* Mettre en gras */
            margin-bottom: 10px; /* Espacement en bas */
        }
    </style>
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
                <a href="#" class="nav-link active">Se connecter</a>
                <a href="{{ route('register') }}" class="nav-link">S'inscrire</a>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group">
                    <i class="fas fa-user icon"></i>
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="Entrer Email" 
                        required 
                        autofocus 
                    >
                </div>
                <div class="message email-message"></div> <!-- Message pour l'email -->

                <div class="input-group">
                    <i class="fas fa-lock icon"></i>
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Mot de passe" 
                        id="password" 
                        required 
                    >
                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                </div>
                <div class="message password-message"></div> <!-- Message pour le mot de passe -->

                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn-connect">Se connecter</button>

                @if ($errors->any())
                    <div class="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

    <div class="container">
        <h1>Réinitialiser le mot de passe</h1>

        {{-- Afficher les messages d'erreur --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Afficher un message de succès --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulaire pour saisir l'email --}}
        @if (!isset($email))
            <form method="POST" action="{{ route('password.checkEmail') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Saisissez votre email :</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Vérifier l'email</button>
            </form>
        @endif

        {{-- Si l'email est validé, afficher le formulaire pour le mot de passe --}}
        @if (isset($email))
            <form method="POST" action="{{ route('password.updatePassword') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-group">
                    <label for="password">Nouveau mot de passe :</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmer le nouveau mot de passe :</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Mettre à jour le mot de passe</button>
            </form>
        @endif
    </div>

</body>
</html>

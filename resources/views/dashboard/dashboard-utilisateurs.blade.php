<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Distributeurs</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <div class="container">
        <h1>Tableau de Bord des Distributeurs</h1>

        <div class="statistiques">
            <p>Total des Distributeurs : {{ $statistics['total_distributeurs'] }}</p>
            <p>Total des Distributeurs Actifs : {{ $statistics['total_distributeurs_actifs'] }}</p>
            <p>Solde Total : {{ number_format($statistics['total_solde'], 2, ',', ' ') }} CFA</p>
        </div>

        <table class="table-distributeurs">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Solde</th>
                    <th>État du Compte</th>
                </tr>
            </thead>
            <tbody>
                @foreach($distributeurs as $distributeur)
                    <tr>
                        <td>{{ $distributeur->nom }}</td>
                        <td>{{ $distributeur->prenom }}</td>
                        <td>{{ $distributeur->email }}</td>
                        <td>{{ number_format($distributeur->solde, 2, ',', ' ') }} CFA</td>
                        <td>{{ ucfirst($distributeur->etat_compte) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>

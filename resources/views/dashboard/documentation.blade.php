@extends('layouts.simple.master')
@section('title', 'Documentation')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* public/css/documentation.css */

section {
    padding: 2em;
    border-bottom: 1px solid #ddd;
    max-width: 800px;
    margin: 0 auto;
    background: #fff;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #333;
    font-size: 1.8em;
    margin-bottom: 0.5em;
}

p {
    color: #555;
    font-size: 1em;
    line-height: 1.6;
}

.imgDoc {
    width: 100%;
    max-width: 600px;
    border-radius: 8px;
    margin-top: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

</style>
@endsection

@section('breadcrumb-title')
<h3>Documentation</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Client</li>
<li class="breadcrumb-item active">Documentation</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
    <section id="inscription">
        <h2>Inscription</h2>
        <p>Étapes pour créer un compte utilisateur.</p>
        <img class="imgDoc" src="{{ asset('images/inscription_screenshot.png') }}" alt="Capture d'écran de l'inscription">
    </section>

    <section id="connexion">
        <h2>Connexion</h2>
        <p>Guide pour se connecter à votre compte.</p>
        <img class="imgDoc" src="{{ asset('images/connexion_screenshot.png') }}" alt="Capture d'écran de la connexion">
    </section>

    <section id="transfert">
        <h2>Transfert</h2>
        <p>Comment effectuer un transfert d'argent.</p>
        <img class="imgDoc" src="{{ asset('images/transfert_screenshot.png') }}" alt="Capture d'écran du transfert">
    </section>

    <section id="solde">
        <h2>Vérifier Solde</h2>
        <p>Comment afficher le solde disponible.</p>
        <img class="imgDoc" src="{{ asset('images/transfert_screenshot.png') }}" alt="Capture d'écran du transfert">
    </section>

    <section id="transactions">
        <h2>Transactions</h2>
        <p>Liste des transactions effectuées et comment voir les détails.</p>
        <img class="imgDoc" src="{{ asset('images/transfert_screenshot.png') }}" alt="Capture d'écran du transfert">
    </section>

    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection

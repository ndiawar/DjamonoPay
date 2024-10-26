@extends('layouts.simple.master')
@section('title', 'Dashboard Agent')

@section('title', 'Agent')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
@endsection



@section('style')
<style>

    .transaction-stats {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .transaction-stats div {
        text-align: center;
    }
    .amount {
        font-weight: 700;
        font-size: 18px;
        color: #132d64;
    }
    .circle {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    .circle.envoie {
        background-color: #00a9ff;
    }
    .circle.crediter {
        background-color: #d1d5db;
    }
    .circle.retrait2 {
        background-color: #83d1d4;
    }
	.transaction-form {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: transparent;
        border-radius: 8px;
    }

    .transaction-form h4 {
        text-align: start;
        margin-bottom: 20px;
		color: #132d64;
    }

    .form-group label {
        font-weight: lighter;
		font-size: 20px;
		padding: 5px;
		color: gray;
    }
	.form-group input {
		height: 60px;
	}

    .submit-btn {
        background-color: #007bff;
        color: white;
        width: 100%;
        border: none;
		align-content: center;
        padding: 10px;
        border-radius: 5px;
        font-size: 16px;
        margin-top: 15px;
    }
	.btnAjout {
		background-color: #f5f6fa;
        color: black;
        width: 100%;
        border: none;
		border-radius: 25%;
		align-content: center;
        padding: 10px;
        border-radius: 5px;
        font-size: 16px;
        margin-top: 15px;
	}

    .submit-btn:hover {
        background-color: #0056b3;
    }
</style>
@endsection


@section('breadcrumb-title')
    <h3>Agent</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Agent</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row widget-grid">
			<div class="col-md-3">
				<div class="ms-3 card profile-box" >
					<div class="card-body">
						<div class="media">
							<div class="media-body"> 
								<div class="greeting-user">
									<div class="d-flex justify-content-between align-items-center mt-4">
										<h4 class="f-w-600">DjamonoPay</h4>
									</div>
									<div class="card-info d-flex justify-content-end mt-5">
										<div class="me-5 mt-5">NUMERO CARTE</div>
										<div class="ms-5 mt-5">06/24</div>
									</div>
									<div class="card-number mb-4">1234 1234 1234 1234</div>
								</div>
							</div>
						</div>
						<div class="cartoon me-5 mb-5">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="200" height="200">
								<!-- Created with https://api.qrserver.com (QR Code API, see goQR.me/api for information) -->
								<title>QR Code</title>
								<desc>http://127.0.0.1:8000/dashboard/index</desc>
								<rect style="fill:rgb(255, 255, 255);fill-opacity:1" x="15" y="15" width="180" height="180" />
								<g id="elements">
									<path style="fill:rgb(0, 63, 107)" d="M 8,8 l 8,0 0,8 -8,0 z M 16,8 l 8,0 0,8 -8,0 z M 24,8 l 8,0 0,8 -8,0 z M 32,8 l 8,0 0,8 -8,0 z M 40,8 l 8,0 0,8 -8,0 z M 48,8 l 8,0 0,8 -8,0 z M 56,8 l 8,0 0,8 -8,0 z M 80,8 l 8,0 0,8 -8,0 z M 128,8 l 8,0 0,8 -8,0 z M 136,8 l 8,0 0,8 -8,0 z M 160,8 l 8,0 0,8 -8,0 z M 184,8 l 8,0 0,8 -8,0 z M 192,8 l 8,0 0,8 -8,0 z M 200,8 l 8,0 0,8 -8,0 z M 208,8 l 8,0 0,8 -8,0 z M 216,8 l 8,0 0,8 -8,0 z M 224,8 l 8,0 0,8 -8,0 z M 232,8 l 8,0 0,8 -8,0 z M 8,16 l 8,0 0,8 -8,0 z M 56,16 l 8,0 0,8 -8,0 z M 72,16 l 8,0 0,8 -8,0 z M 80,16 l 8,0 0,8 -8,0 z M 96,16 l 8,0 0,8 -8,0 z M 104,16 l 8,0 0,8 -8,0 z M 144,16 l 8,0 0,8 -8,0 z M 168,16 l 8,0 0,8 -8,0 z M 184,16 l 8,0 0,8 -8,0 z M 232,16 l 8,0 0,8 -8,0 z M 8,24 l 8,0 0,8 -8,0 z M 24,24 l 8,0 0,8 -8,0 z M 32,24 l 8,0 0,8 -8,0 z M 40,24 l 8,0 0,8 -8,0 z M 56,24 l 8,0 0,8 -8,0 z M 80,24 l 8,0 0,8 -8,0 z M 88,24 l 8,0 0,8 -8,0 z M 96,24 l 8,0 0,8 -8,0 z M 120,24 l 8,0 0,8 -8,0 z M 136,24 l 8,0 0,8 -8,0 z M 144,24 l 8,0 0,8 -8,0 z M 152,24 l 8,0 0,8 -8,0 z M 160,24 l 8,0 0,8 -8,0 z M 168,24 l 8,0 0,8 -8,0 z M 184,24 l 8,0 0,8 -8,0 z M 200,24 l 8,0 0,8 -8,0 z M 208,24 l 8,0 0,8 -8,0 z M 216,24 l 8,0 0,8 -8,0 z M 232,24 l 8,0 0,8 -8,0 z M 8,32 l 8,0 0,8 -8,0 z M 24,32 l 8,0 0,8 -8,0 z M 32,32 l 8,0 0,8 -8,0 z M 40,32 l 8,0 0,8 -8,0 z M 56,32 l 8,0 0,8 -8,0 z M 72,32 l 8,0 0,8 -8,0 z M 80,32 l 8,0 0,8 -8,0 z M 96,32 l 8,0 0,8 -8,0 z M 152,32 l 8,0 0,8 -8,0 z M 168,32 l 8,0 0,8 -8,0 z M 184,32 l 8,0 0,8 -8,0 z M 200,32 l 8,0 0,8 -8,0 z M 208,32 l 8,0 0,8 -8,0 z M 216,32 l 8,0 0,8 -8,0 z M 232,32 l 8,0 0,8 -8,0 z M 8,40 l 8,0 0,8 -8,0 z M 24,40 l 8,0 0,8 -8,0 z M 32,40 l 8,0 0,8 -8,0 z M 40,40 l 8,0 0,8 -8,0 z M 56,40 l 8,0 0,8 -8,0 z M 88,40 l 8,0 0,8 -8,0 z M 104,40 l 8,0 0,8 -8,0 z M 112,40 l 8,0 0,8 -8,0 z M 120,40 l 8,0 0,8 -8,0 z M 128,40 l 8,0 0,8 -8,0 z M 152,40 l 8,0 0,8 -8,0 z M 184,40 l 8,0 0,8 -8,0 z M 200,40 l 8,0 0,8 -8,0 z M 208,40 l 8,0 0,8 -8,0 z M 216,40 l 8,0 0,8 -8,0 z M 232,40 l 8,0 0,8 -8,0 z M 8,48 l 8,0 0,8 -8,0 z M 56,48 l 8,0 0,8 -8,0 z M 72,48 l 8,0 0,8 -8,0 z M 88,48 l 8,0 0,8 -8,0 z M 112,48 l 8,0 0,8 -8,0 z M 120,48 l 8,0 0,8 -8,0 z M 128,48 l 8,0 0,8 -8,0 z M 144,48 l 8,0 0,8 -8,0 z M 184,48 l 8,0 0,8 -8,0 z M 232,48 l 8,0 0,8 -8,0 z M 8,56 l 8,0 0,8 -8,0 z M 16,56 l 8,0 0,8 -8,0 z M 24,56 l 8,0 0,8 -8,0 z M 32,56 l 8,0 0,8 -8,0 z M 40,56 l 8,0 0,8 -8,0 z M 48,56 l 8,0 0,8 -8,0 z M 56,56 l 8,0 0,8 -8,0 z M 72,56 l 8,0 0,8 -8,0 z M 88,56 l 8,0 0,8 -8,0 z M 104,56 l 8,0 0,8 -8,0 z M 120,56 l 8,0 0,8 -8,0 z M 136,56 l 8,0 0,8 -8,0 z M 152,56 l 8,0 0,8 -8,0 z M 168,56 l 8,0 0,8 -8,0 z M 184,56 l 8,0 0,8 -8,0 z M 192,56 l 8,0 0,8 -8,0 z M 200,56 l 8,0 0,8 -8,0 z M 208,56 l 8,0 0,8 -8,0 z M 216,56 l 8,0 0,8 -8,0 z M 224,56 l 8,0 0,8 -8,0 z M 232,56 l 8,0 0,8 -8,0 z M 104,64 l 8,0 0,8 -8,0 z M 112,64 l 8,0 0,8 -8,0 z M 128,64 l 8,0 0,8 -8,0 z M 152,64 l 8,0 0,8 -8,0 z M 160,64 l 8,0 0,8 -8,0 z M 168,64 l 8,0 0,8 -8,0 z M 8,72 l 8,0 0,8 -8,0 z M 16,72 l 8,0 0,8 -8,0 z M 24,72 l 8,0 0,8 -8,0 z M 32,72 l 8,0 0,8 -8,0 z M 40,72 l 8,0 0,8 -8,0 z M 56,72 l 8,0 0,8 -8,0 z M 64,72 l 8,0 0,8 -8,0 z M 72,72 l 8,0 0,8 -8,0 z M 80,72 l 8,0 0,8 -8,0 z M 88,72 l 8,0 0,8 -8,0 z M 104,72 l 8,0 0,8 -8,0 z M 120,72 l 8,0 0,8 -8,0 z M 128,72 l 8,0 0,8 -8,0 z M 144,72 l 8,0 0,8 -8,0 z M 152,72 l 8,0 0,8 -8,0 z M 176,72 l 8,0 0,8 -8,0 z M 192,72 l 8,0 0,8 -8,0 z M 208,72 l 8,0 0,8 -8,0 z M 224,72 l 8,0 0,8 -8,0 z M 8,80 l 8,0 0,8 -8,0 z M 24,80 l 8,0 0,8 -8,0 z M 32,80 l 8,0 0,8 -8,0 z M 48,80 l 8,0 0,8 -8,0 z M 64,80 l 8,0 0,8 -8,0 z M 72,80 l 8,0 0,8 -8,0 z M 80,80 l 8,0 0,8 -8,0 z M 128,80 l 8,0 0,8 -8,0 z M 152,80 l 8,0 0,8 -8,0 z M 168,80 l 8,0 0,8 -8,0 z M 176,80 l 8,0 0,8 -8,0 z M 184,80 l 8,0 0,8 -8,0 z M 200,80 l 8,0 0,8 -8,0 z M 232,80 l 8,0 0,8 -8,0 z M 32,88 l 8,0 0,8 -8,0 z M 56,88 l 8,0 0,8 -8,0 z M 64,88 l 8,0 0,8 -8,0 z M 80,88 l 8,0 0,8 -8,0 z M 96,88 l 8,0 0,8 -8,0 z M 104,88 l 8,0 0,8 -8,0 z M 136,88 l 8,0 0,8 -8,0 z M 144,88 l 8,0 0,8 -8,0 z M 184,88 l 8,0 0,8 -8,0 z M 40,96 l 8,0 0,8 -8,0 z M 48,96 l 8,0 0,8 -8,0 z M 80,96 l 8,0 0,8 -8,0 z M 88,96 l 8,0 0,8 -8,0 z M 96,96 l 8,0 0,8 -8,0 z M 120,96 l 8,0 0,8 -8,0 z M 136,96 l 8,0 0,8 -8,0 z M 144,96 l 8,0 0,8 -8,0 z M 152,96 l 8,0 0,8 -8,0 z M 160,96 l 8,0 0,8 -8,0 z M 168,96 l 8,0 0,8 -8,0 z M 176,96 l 8,0 0,8 -8,0 z M 184,96 l 8,0 0,8 -8,0 z M 192,96 l 8,0 0,8 -8,0 z M 200,96 l 8,0 0,8 -8,0 z M 224,96 l 8,0 0,8 -8,0 z M 8,104 l 8,0 0,8 -8,0 z M 16,104 l 8,0 0,8 -8,0 z M 40,104 l 8,0 0,8 -8,0 z M 48,104 l 8,0 0,8 -8,0 z M 56,104 l 8,0 0,8 -8,0 z M 64,104 l 8,0 0,8 -8,0 z M 80,104 l 8,0 0,8 -8,0 z M 96,104 l 8,0 0,8 -8,0 z M 128,104 l 8,0 0,8 -8,0 z M 136,104 l 8,0 0,8 -8,0 z M 144,104 l 8,0 0,8 -8,0 z M 168,104 l 8,0 0,8 -8,0 z M 184,104 l 8,0 0,8 -8,0 z M 192,104 l 8,0 0,8 -8,0 z M 216,104 l 8,0 0,8 -8,0 z M 16,112 l 8,0 0,8 -8,0 z M 32,112 l 8,0 0,8 -8,0 z M 72,112 l 8,0 0,8 -8,0 z M 88,112 l 8,0 0,8 -8,0 z M 104,112 l 8,0 0,8 -8,0 z M 112,112 l 8,0 0,8 -8,0 z M 120,112 l 8,0 0,8 -8,0 z M 128,112 l 8,0 0,8 -8,0 z M 136,112 l 8,0 0,8 -8,0 z M 160,112 l 8,0 0,8 -8,0 z M 168,112 l 8,0 0,8 -8,0 z M 176,112 l 8,0 0,8 -8,0 z M 192,112 l 8,0 0,8 -8,0 z M 200,112 l 8,0 0,8 -8,0 z M 232,112 l 8,0 0,8 -8,0 z M 8,120 l 8,0 0,8 -8,0 z M 32,120 l 8,0 0,8 -8,0 z M 40,120 l 8,0 0,8 -8,0 z M 56,120 l 8,0 0,8 -8,0 z M 64,120 l 8,0 0,8 -8,0 z M 80,120 l 8,0 0,8 -8,0 z M 88,120 l 8,0 0,8 -8,0 z M 112,120 l 8,0 0,8 -8,0 z M 120,120 l 8,0 0,8 -8,0 z M 128,120 l 8,0 0,8 -8,0 z M 144,120 l 8,0 0,8 -8,0 z M 160,120 l 8,0 0,8 -8,0 z M 192,120 l 8,0 0,8 -8,0 z M 200,120 l 8,0 0,8 -8,0 z M 24,128 l 8,0 0,8 -8,0 z M 32,128 l 8,0 0,8 -8,0 z M 48,128 l 8,0 0,8 -8,0 z M 72,128 l 8,0 0,8 -8,0 z M 104,128 l 8,0 0,8 -8,0 z M 112,128 l 8,0 0,8 -8,0 z M 136,128 l 8,0 0,8 -8,0 z M 152,128 l 8,0 0,8 -8,0 z M 184,128 l 8,0 0,8 -8,0 z M 200,128 l 8,0 0,8 -8,0 z M 216,128 l 8,0 0,8 -8,0 z M 224,128 l 8,0 0,8 -8,0 z M 40,136 l 8,0 0,8 -8,0 z M 48,136 l 8,0 0,8 -8,0 z M 56,136 l 8,0 0,8 -8,0 z M 104,136 l 8,0 0,8 -8,0 z M 120,136 l 8,0 0,8 -8,0 z M 128,136 l 8,0 0,8 -8,0 z M 152,136 l 8,0 0,8 -8,0 z M 184,136 l 8,0 0,8 -8,0 z M 192,136 l 8,0 0,8 -8,0 z M 208,136 l 8,0 0,8 -8,0 z M 8,144 l 8,0 0,8 -8,0 z M 24,144 l 8,0 0,8 -8,0 z M 48,144 l 8,0 0,8 -8,0 z M 72,144 l 8,0 0,8 -8,0 z M 80,144 l 8,0 0,8 -8,0 z M 88,144 l 8,0 0,8 -8,0 z M 128,144 l 8,0 0,8 -8,0 z M 136,144 l 8,0 0,8 -8,0 z M 168,144 l 8,0 0,8 -8,0 z M 184,144 l 8,0 0,8 -8,0 z M 208,144 l 8,0 0,8 -8,0 z M 232,144 l 8,0 0,8 -8,0 z M 8,152 l 8,0 0,8 -8,0 z M 24,152 l 8,0 0,8 -8,0 z M 32,152 l 8,0 0,8 -8,0 z M 40,152 l 8,0 0,8 -8,0 z M 48,152 l 8,0 0,8 -8,0 z M 56,152 l 8,0 0,8 -8,0 z M 72,152 l 8,0 0,8 -8,0 z M 88,152 l 8,0 0,8 -8,0 z M 96,152 l 8,0 0,8 -8,0 z M 104,152 l 8,0 0,8 -8,0 z M 128,152 l 8,0 0,8 -8,0 z M 144,152 l 8,0 0,8 -8,0 z M 168,152 l 8,0 0,8 -8,0 z M 176,152 l 8,0 0,8 -8,0 z M 192,152 l 8,0 0,8 -8,0 z M 208,152 l 8,0 0,8 -8,0 z M 216,152 l 8,0 0,8 -8,0 z M 8,160 l 8,0 0,8 -8,0 z M 24,160 l 8,0 0,8 -8,0 z M 32,160 l 8,0 0,8 -8,0 z M 48,160 l 8,0 0,8 -8,0 z M 64,160 l 8,0 0,8 -8,0 z M 72,160 l 8,0 0,8 -8,0 z M 80,160 l 8,0 0,8 -8,0 z M 88,160 l 8,0 0,8 -8,0 z M 96,160 l 8,0 0,8 -8,0 z M 120,160 l 8,0 0,8 -8,0 z M 136,160 l 8,0 0,8 -8,0 z M 160,160 l 8,0 0,8 -8,0 z M 192,160 l 8,0 0,8 -8,0 z M 200,160 l 8,0 0,8 -8,0 z M 208,160 l 8,0 0,8 -8,0 z M 216,160 l 8,0 0,8 -8,0 z M 224,160 l 8,0 0,8 -8,0 z M 8,168 l 8,0 0,8 -8,0 z M 56,168 l 8,0 0,8 -8,0 z M 64,168 l 8,0 0,8 -8,0 z M 88,168 l 8,0 0,8 -8,0 z M 96,168 l 8,0 0,8 -8,0 z M 128,168 l 8,0 0,8 -8,0 z M 144,168 l 8,0 0,8 -8,0 z M 152,168 l 8,0 0,8 -8,0 z M 160,168 l 8,0 0,8 -8,0 z M 168,168 l 8,0 0,8 -8,0 z M 176,168 l 8,0 0,8 -8,0 z M 184,168 l 8,0 0,8 -8,0 z M 192,168 l 8,0 0,8 -8,0 z M 200,168 l 8,0 0,8 -8,0 z M 216,168 l 8,0 0,8 -8,0 z M 224,168 l 8,0 0,8 -8,0 z M 232,168 l 8,0 0,8 -8,0 z M 72,176 l 8,0 0,8 -8,0 z M 104,176 l 8,0 0,8 -8,0 z M 112,176 l 8,0 0,8 -8,0 z M 120,176 l 8,0 0,8 -8,0 z M 136,176 l 8,0 0,8 -8,0 z M 152,176 l 8,0 0,8 -8,0 z M 168,176 l 8,0 0,8 -8,0 z M 200,176 l 8,0 0,8 -8,0 z M 208,176 l 8,0 0,8 -8,0 z M 224,176 l 8,0 0,8 -8,0 z M 232,176 l 8,0 0,8 -8,0 z M 8,184 l 8,0 0,8 -8,0 z M 16,184 l 8,0 0,8 -8,0 z M 24,184 l 8,0 0,8 -8,0 z M 32,184 l 8,0 0,8 -8,0 z M 40,184 l 8,0 0,8 -8,0 z M 48,184 l 8,0 0,8 -8,0 z M 56,184 l 8,0 0,8 -8,0 z M 72,184 l 8,0 0,8 -8,0 z M 112,184 l 8,0 0,8 -8,0 z M 120,184 l 8,0 0,8 -8,0 z M 144,184 l 8,0 0,8 -8,0 z M 160,184 l 8,0 0,8 -8,0 z M 168,184 l 8,0 0,8 -8,0 z M 184,184 l 8,0 0,8 -8,0 z M 200,184 l 8,0 0,8 -8,0 z M 208,184 l 8,0 0,8 -8,0 z M 216,184 l 8,0 0,8 -8,0 z M 8,192 l 8,0 0,8 -8,0 z M 56,192 l 8,0 0,8 -8,0 z M 88,192 l 8,0 0,8 -8,0 z M 104,192 l 8,0 0,8 -8,0 z M 112,192 l 8,0 0,8 -8,0 z M 136,192 l 8,0 0,8 -8,0 z M 152,192 l 8,0 0,8 -8,0 z M 168,192 l 8,0 0,8 -8,0 z M 200,192 l 8,0 0,8 -8,0 z M 208,192 l 8,0 0,8 -8,0 z M 216,192 l 8,0 0,8 -8,0 z M 224,192 l 8,0 0,8 -8,0 z M 8,200 l 8,0 0,8 -8,0 z M 24,200 l 8,0 0,8 -8,0 z M 32,200 l 8,0 0,8 -8,0 z M 40,200 l 8,0 0,8 -8,0 z M 56,200 l 8,0 0,8 -8,0 z M 72,200 l 8,0 0,8 -8,0 z M 80,200 l 8,0 0,8 -8,0 z M 88,200 l 8,0 0,8 -8,0 z M 104,200 l 8,0 0,8 -8,0 z M 120,200 l 8,0 0,8 -8,0 z M 128,200 l 8,0 0,8 -8,0 z M 136,200 l 8,0 0,8 -8,0 z M 168,200 l 8,0 0,8 -8,0 z M 176,200 l 8,0 0,8 -8,0 z M 184,200 l 8,0 0,8 -8,0 z M 192,200 l 8,0 0,8 -8,0 z M 200,200 l 8,0 0,8 -8,0 z M 208,200 l 8,0 0,8 -8,0 z M 216,200 l 8,0 0,8 -8,0 z M 8,208 l 8,0 0,8 -8,0 z M 24,208 l 8,0 0,8 -8,0 z M 32,208 l 8,0 0,8 -8,0 z M 40,208 l 8,0 0,8 -8,0 z M 56,208 l 8,0 0,8 -8,0 z M 72,208 l 8,0 0,8 -8,0 z M 128,208 l 8,0 0,8 -8,0 z M 152,208 l 8,0 0,8 -8,0 z M 176,208 l 8,0 0,8 -8,0 z M 200,208 l 8,0 0,8 -8,0 z M 224,208 l 8,0 0,8 -8,0 z M 8,216 l 8,0 0,8 -8,0 z M 24,216 l 8,0 0,8 -8,0 z M 32,216 l 8,0 0,8 -8,0 z M 40,216 l 8,0 0,8 -8,0 z M 56,216 l 8,0 0,8 -8,0 z M 72,216 l 8,0 0,8 -8,0 z M 80,216 l 8,0 0,8 -8,0 z M 88,216 l 8,0 0,8 -8,0 z M 96,216 l 8,0 0,8 -8,0 z M 104,216 l 8,0 0,8 -8,0 z M 144,216 l 8,0 0,8 -8,0 z M 152,216 l 8,0 0,8 -8,0 z M 176,216 l 8,0 0,8 -8,0 z M 216,216 l 8,0 0,8 -8,0 z M 224,216 l 8,0 0,8 -8,0 z M 8,224 l 8,0 0,8 -8,0 z M 56,224 l 8,0 0,8 -8,0 z M 72,224 l 8,0 0,8 -8,0 z M 96,224 l 8,0 0,8 -8,0 z M 120,224 l 8,0 0,8 -8,0 z M 136,224 l 8,0 0,8 -8,0 z M 144,224 l 8,0 0,8 -8,0 z M 152,224 l 8,0 0,8 -8,0 z M 176,224 l 8,0 0,8 -8,0 z M 192,224 l 8,0 0,8 -8,0 z M 200,224 l 8,0 0,8 -8,0 z M 224,224 l 8,0 0,8 -8,0 z M 8,232 l 8,0 0,8 -8,0 z M 16,232 l 8,0 0,8 -8,0 z M 24,232 l 8,0 0,8 -8,0 z M 32,232 l 8,0 0,8 -8,0 z M 40,232 l 8,0 0,8 -8,0 z M 48,232 l 8,0 0,8 -8,0 z M 56,232 l 8,0 0,8 -8,0 z M 72,232 l 8,0 0,8 -8,0 z M 96,232 l 8,0 0,8 -8,0 z M 128,232 l 8,0 0,8 -8,0 z M 136,232 l 8,0 0,8 -8,0 z M 144,232 l 8,0 0,8 -8,0 z M 176,232 l 8,0 0,8 -8,0 z M 200,232 l 8,0 0,8 -8,0 z " />
								</g>
							</svg>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xxl-4 col-md-6 box-col-6 ms-3">
				<div class="card bg-transparent shadow-sm p-3 borderborder-secondary rounded">
					<div class="card-body">
						<!-- Bilan Global -->
						<h6 class="text-muted mt-2">Bilan Global</h6>
						<h4 class="font-weight-bold">1.258.796 Fcfa</h4>
						<div class="d-flex justify-content-end align-items-center ms-5 mb-3 ps-5">
							<!-- Augmentation -->
							<span class="text-success d-flex align-items-center">
							<i class="bi bi-arrow-up me-1"></i> 23.12%
							</span>
							<!-- Diminution -->
							<span class="ps-5 text-danger d-flex align-items-center">
							<i class="bi bi-arrow-down me-1"></i> 23.12%
							</span>
						</div>

						<hr class="my-3">

						<!-- Monnaie -->
						<div class="d-flex justify-content-between">
							<div>
							<h6 class="text-muted">Monnaie</h6>
							<h5 class="font-weight-bold">FCFA/ XOF</h5>
							</div>
							<!-- Statut -->
							<div class="text-end">
							<h6 class="text-muted">Statut</h6>
							<h5 class="font-weight-bold text-dark">Active</h5>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 mt-5">
				<div class="row mt-5">
					<div class="col-md-4 m-auto  ">
						<div class="border-start border-5 border-info card small-widget">
							<div class="card-body primary">
								<span class="f-light pt-2">Solde</span>
								<div class="d-flex align-items-end gap-1 pt-4">
									<h6>1.258.000 Fcfa</h6>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 m-auto ">
						<div class="border-start border-5 border-success card small-widget">
							<div class="card-body primary">
								<span class="f-light pt-2">Pending Orders</span>
								<div class="d-flex align-items-end gap-1 pt-4">
								<h6>1.258.000 Fcfa</h6>
									
								</div>
								<div class="bg-gradient">
									<svg class="stroke-icon svg-fill">
										<use href="{{ asset('assets/svg/icon-sprite.svg#pending-order') }}"></use>
									</svg>
									<span class="font-success">
										<i class="icon-arrow-up"></i>
										<span class="pe-3">+30%</span>
									</span>
								</div>

							</div>
						</div>
					</div>
					<div class="col-md-4 m-auto ">
						<div class="border-start border-5 border-warning card small-widget">
							<div class="card-body primary">
								<span class="f-light pt-2">Pending Orders</span>
								<div class="d-flex align-items-end gap-1 pt-4">
								<h6>1.258.000 Fcfa</h6>
									
								</div>
								<div class="bg-gradient">
									<svg class="stroke-icon svg-fill">
										<use href="{{ asset('assets/svg/icon-sprite.svg#pending-order') }}"></use>
									</svg>
									<span class="font-success">
										<i class="icon-arrow-up"></i>
										<span class="pe-3">+30%</span>
									</span>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xxl-6 col-md-6 appointment-sec box-col-6 mt-5">
				<div class="appointment">
					<div class="card">
						<div class="card-header card-no-border">
							<div class="header-top">
								<h5 class="m-0">Recent Sales</h5>
								<div class="card-header-right-icon">
									<div class="dropdown">
										<button class="btn dropdown-toggle" id="recentButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">Today</button>
										<div class="dropdown-menu dropdown-menu-end" aria-labelledby="recentButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday</a></div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body pt-0">
						<div class="appointment-table table-responsive">
							<table class="table table-bordernone">
							<tbody>
								<tr>
								<td><img class="img-fluid img-40 rounded-circle" src="{{ asset('assets/images/dashboard/user/1.jpg') }}" alt="user"></td>
								<td class="img-content-box"><a class="d-block f-w-500">Jane Cooper</a><span class="f-light">10 minutes ago</span></td>
								<td class="text-end">
									<p class="m-0 font-success">$200.00</p>
								</td>
								</tr>
								<tr>
								<td><img class="img-fluid img-40 rounded-circle" src="{{ asset('assets/images/dashboard/user/2.jpg') }}" alt="user"></td>
								<td class="img-content-box"><a class="d-block f-w-500">Brooklyn Simmons</a><span class="f-light">19 minutes ago</span></td>
								<td class="text-end">
									<p class="m-0 font-success">$970.00</p>
								</td>
								</tr>
								<tr>
								<td><img class="img-fluid img-40 rounded-circle" src="{{ asset('assets/images/dashboard/user/3.jpg') }}" alt="user"></td>
								<td class="img-content-box"><a class="d-block f-w-500">Leslie Alexander</a><span class="f-light">2 hours ago</span></td>
								<td class="text-end">
									<p class="m-0 font-success">$300.00</p>
								</td>
								</tr>
								<tr>
								<td><img class="img-fluid img-40 rounded-circle" src="{{ asset('assets/images/dashboard/user/4.jpg') }}" alt="user"></td>
								<td class="img-content-box"><a class="d-block f-w-500">Travis Wright</a><span class="f-light">8 hours ago</span></td>
								<td class="text-end">
									<p class="m-0 font-success">$450.00</p>
								</td>
								</tr>
								<tr>
								<td><img class="img-fluid img-40 rounded-circle" src="{{ asset('assets/images/dashboard/user/5.jpg') }}" alt="user"></td>
								<td class="img-content-box"><a class="d-block f-w-500">Mark Green</a><span class="f-light">1 day ago</span></td>
								<td class="text-end">
									<p class="m-0 font-success">$768.00</p>
								</td>
								</tr>
							</tbody>
							</table>
						</div>
						</div>
					</div>
				</div>
	  		</div>
			<div class="col-xxl-6 col-md-6 box-col-6">
				<div class="card transCard">
					<div class="card-header card-no-border">
						<h5>Transactions</h5>
					</div>
					<div class="card-body">
						<div class="transaction-stats">
							<div>
								<p>Journalier</p>
								<p class="amount">475.000 Fcfa</p>
							</div>
							<div>
								<p>hebdomadaire</p>
								<p class="amount">7.000.000 Fcfa</p>
							</div>
							<div>
								<p>Mensuelle</p>
								<p class="amount">22.542.356 Fcfa</p>
							</div>
						</div>
						<div class="chart-container">
							<canvas id="donutChart"></canvas>
						</div>
					</div>
				</div>
        	</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xxl-4 col-md-6 box-col-6">
				<div class="transaction-form bg-transparent">
					<h4>Transaction Rapide vers un distributeur</h4>
					
					<form action="" method="POST">
						@csrf
						<div class="form-group">
							<label for="card-number text-ligth">Numéro Carte Djamono Pay</label>
							<input type="text" class="form-control border border-primary rounded-5 bg-transparent" id="card-number" name="card_number" placeholder="1234 2345 7379 90" required>
						</div>
						
						<div class="form-group">
							<label for="amount">Montant à transférer</label>
							<input type="text" class="form-control border border-primary rounded-5 bg-transparent "  id="amount" name="amount" placeholder="4.500.000" required>
						</div>
						
						<button type="submit" class="submit-btn border border-radius p-3 text-center badge fw-bold w-50">Envoie D'argent</button>
					</form>
				</div>
			</div>
			<div class="col-xxl-4 col-md-6 box-col-6">
				<div class="card">

					<div class="card-body">
						<div id="basic-apex"></div>
					</div>
				</div>
			</div>
			<div class="col-xxl-4 col-md-6 box-col-6 mt-5">
				<div class="bg-transparent ms-5 mt-5">					
					<form action="" method="POST">
						@csrf
						
						<button type="submit" class="btn btn-light text-dark w-75 d-flex align-items-center border border-radius m-5 shadow p-3 mb-5 bg-body rounded rounded-5 fw-bold">
							<span class="bg-info text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 25px; height: 25px; margin-right: 10px;">+</span>
							Un Distributeur / Agent
						</button>

						<button type="submit" class="btn btn-light text-dark w-75  d-flex align-items-center border border-radius m-5 shadow p-3 mb-5 bg-body rounded rounded-5 fw-bold">
							<span class="bg-info text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 25px; height: 25px; margin-right: 10px;">+</span>
							Un Client
						</button>

					</form>
				</div>
			</div>
		</div>
	</div>
    <script type="text/javascript">
		var session_layout = '{{ session()->get("layout") }}';
	</script>
@endsection

@section('script')
<script src="{{asset('assets/js/chart/apex-chart/apex-chart.js')}}"></script>
<!-- <script src="{{ asset('assets/js/clock.js') }}"></script> -->
<script src="{{ asset('assets/js/chart/apex-chart/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
<!-- <script src="{{ asset('assets/js/dashboard/default.js') }}"></script> -->
<script src="{{ asset('assets/js/notify/index.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/typeahead.bundle.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/typeahead.custom.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/typeahead-custom.js') }}"></script>
<script src="{{ asset('assets/js/height-equal.js') }}"></script>
<script src="{{ asset('assets/js/animation/wow/wow.min.js') }}"></script>
<script src="{{asset('assets/js/chart/apex-chart/stock-prices.js')}}"></script>
<script src="{{asset('assets/js/chart/apex-chart/chart-custom.js')}}"></script>

<!-- Include necessary scripts for the charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('donutChart').getContext('2d');
    var donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Envoie', 'Créditer', 'Retrait 2'],
            datasets: [{
                data: [40, 30, 30], // Adjust these values for the chart
                backgroundColor: ['#00a9ff', '#d1d5db', '#83d1d4'],
                borderWidth: 1
            }]
        },
        options: {
            cutoutPercentage: 70, // Creates a donut shape
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false // Hides default legend as we have our custom one
            }
        }
    });
</script>
@endsection

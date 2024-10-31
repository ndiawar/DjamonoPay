@extends('layouts.simple.master')
@section('title', 'Client')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('breadcrumb-title')
    <h3>Client</h3>
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Client</li>
@endsection

    @section('content')
      <div class="container-fluid ">
              <!-- Table Clients-->
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header pb-0 card-no-border ">
              <h3 class="mb-3">Historique des transactions</h3>
                    <!-- Solde masqué/affiché -->
                <div class="card p-3" style="width: 35rem; margin: auto;">
                    <!-- Solde masqué/affiché -->
                    <h3 id="balance" class="text-center">
                        <span id="balanceValue">{{ number_format($solde, 0, ',', ' ') }} F</span>

                    <i class="text-dark bi bi-eye-slash" id="toggleBalance" onclick="toggleBalance()" style="cursor:pointer;"></i>
                    </h3>


                    <!-- QR Code -->
                    <div class="d-flex justify-content-center mb-3">
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

                    <!-- Bouton pour transférer (ouvre le modal) -->
                   
                </div>
                <!-- Modal pour le transfert -->
               <div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
             <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transferModalLabel">Effectuer un transfert</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('clients.transfert_clients') }}" method="POST" id="transferForm">
                            @csrf

                            <div class="mb-3">
                                <label for="numero_compte_destination" class="form-label">Numéro du client destinataire</label>
                                <input type="text" class="form-control" id="numero_compte_destination" name="numero_compte_destination" required>
                                <div class="invalid-feedback" id="numero_compte_destination-error"></div>
                            </div>

                            <div class="mb-3">
                                <label for="montant_envoye" class="form-label">Montant à envoyer (incluant les frais de 2%)</label>
                                <input type="number" class="form-control" id="montant_envoye" name="montant" required step="0.01" min="0">
                                <div class="invalid-feedback" id="montant_envoye-error"></div>
                            </div>

                            <div class="mb-3">
                                <label for="montant_recu" class="form-label">Montant à recevoir (hors frais)</label>
                                <input type="number" class="form-control" id="montant_recu" required step="0.01" min="0">
                            </div>

                            <div class="alert alert-info mt-2" id="frais-info" style="display: none;">
                                Frais de transfert (2%): <span id="frais-montant">0</span> FCFA
                            </div>

                            <button type="submit" class="btn btn-secondary btn-custom me-2" id="submitTransfer">Envoyer</button>
                        </form>
                    </div>
                </div>
    </div>
</div>

                
                

                
            </div>
            <div class="card-body">
                <div class="table-responsive user-datatable">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th class="align-middle">Photo</th>
                                <th class="align-middle">Clients</th>
                                <th class="align-middle">Numéro Compte</th>
                                <th class="align-middle">Montant</th>
                                <th class="align-middle">Type_Transaction</th>
                                <th class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($transactions) && count($transactions) > 0)
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td class="align-middle">
                                            @if($transaction->photo)
                                                <img src="{{ asset('storage/' . $transaction->photo) }}" 
                                                    alt="Photo" 
                                                    class="rounded-circle"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('assets/images/user.jpg') }}" 
                                                    alt="Default" 
                                                    class="rounded-circle"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ $transaction->nom }} {{ $transaction->prenom }}</td>
                                        <td class="align-middle">{{ $transaction->numero_compte }}</td>
                                        <td class="align-middle">
                                            <span class="fw-bold {{ $transaction->type_transaction == 'depot' ? 'text-success' : 'text-primary' }}">
                                                {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge {{ $transaction->type_transaction == 'depot' ? 'bg-success' : 'bg-primary' }}">
                                                {{ ucfirst($transaction->type_transaction) }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <button type="button" 
                                                    class="btn btn-info btn-sm"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#detailsModal{{ $transaction->id }}"
                                                    title="Voir détails">
                                                <i class="bi bi-eye"></i>
                                            </button>
                    
                                            <div class="modal fade" id="detailsModal{{ $transaction->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Détails de la transaction</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Distributeur :</strong> {{ $transaction->nom }} {{ $transaction->prenom }}</p>
                                                            <p><strong>Numéro de compte :</strong> {{ $transaction->numero_compte }}</p>
                                                            <p><strong>Type :</strong> {{ ucfirst($transaction->type_transaction) }}</p>
                                                            <p><strong>Montant :</strong> {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">Aucune transaction trouvée</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    
                </div>
            </div>
          </div>
        </div>
          <!-- Tale Clients-->
      </div>        
    @endsection


@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/dashboard_5.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Supposons que vous ayez une variable pour le solde dynamique
const soldeDynamique = '{{ number_format($solde, 0, ',', ' ') }} F'; // Valeur récupérée du backend

function toggleBalance() {
    const balance = document.getElementById('balanceValue');
    const icon = document.getElementById('toggleBalance');

    // Vérifier si le solde est actuellement affiché ou non
    if (balance.style.display === 'none') {
        // Afficher le solde
        balance.style.display = 'inline'; 
        balance.textContent = soldeDynamique; // Remplacez par la valeur dynamique
        icon.className = 'text-dark bi bi-eye-slash'; // Icône œil fermé

        // Supprimer les points si affichés
        const hiddenBalance = document.getElementById('hiddenBalance');
        if (hiddenBalance) {
            hiddenBalance.remove();
        }
    } else {
        // Masquer le solde
        balance.style.display = 'none'; 
        icon.className = 'text-dark bi bi-eye'; // Icône œil ouvert

        // Ajouter des points pour masquer le solde
        if (!document.getElementById('hiddenBalance')) {
            balance.insertAdjacentHTML('afterend', '<span id="hiddenBalance" style="color: #003f6b;">••••••</span>');
        }
    }
    
}



    document.addEventListener('DOMContentLoaded', function () {
        const montantEnvoyeInput = document.getElementById('montant_envoye');
        const montantRecuInput = document.getElementById('montant_recu');
        const fraisInfo = document.getElementById('frais-info');
        const fraisMontant = document.getElementById('frais-montant');

        montantEnvoyeInput.addEventListener('input', function () {
            const montantEnvoye = parseFloat(montantEnvoyeInput.value) || 0;
            const frais = montantEnvoye * 0.02; // 2% de frais
            const montantRecu = montantEnvoye - frais;

            fraisMontant.textContent = frais.toFixed(2); // Mettre à jour le montant des frais
            montantRecuInput.value = montantRecu.toFixed(2); // Mettre à jour le montant reçu

            // Afficher la section des frais si le montant est supérieur à 0
            fraisInfo.style.display = montantEnvoye > 0 ? 'block' : 'none';
        });
    });




//controle de saisies transfert client client

document.addEventListener('DOMContentLoaded', function() {
    const COMMISSION_RATE = 0.02; // 2%
    let isCalculatingFromReceived = false;

    // Fonction pour calculer le montant reçu après déduction des frais
    function calculateReceivedAmount(sentAmount) {
        if (!sentAmount) return '';
        return (parseFloat(sentAmount) * (1 - COMMISSION_RATE)).toFixed(2);
    }

    // Fonction pour calculer le montant à envoyer en fonction du montant reçu souhaité
    function calculateSentAmount(receivedAmount) {
        if (!receivedAmount) return '';
        return (parseFloat(receivedAmount) / (1 - COMMISSION_RATE)).toFixed(2);
    }

    // Fonction pour mettre à jour l'affichage des frais
    function updateFraisDisplay(montant) {
        const fraisElement = document.getElementById('frais-montant');
        const fraisInfoElement = document.getElementById('frais-info');
        
        if (fraisElement && fraisInfoElement) {
            const frais = (parseFloat(montant || 0) * COMMISSION_RATE).toFixed(2);
            fraisElement.textContent = frais;
            fraisInfoElement.style.display = montant ? 'block' : 'none';
        }
    }

    // Fonction de validation des champs de formulaire
    function validateField(field) {
        const value = field.value;
        const errorDiv = document.getElementById(`${field.id}-error`);
        let isValid = true;

        if (errorDiv) {
            switch (field.id) {
                case 'numero_compte_source':
                case 'numero_compte_destination':
                    if (!value) {
                        errorDiv.textContent = 'Ce champ est requis';
                        isValid = false;
                    } else if (value.length < 5) {
                        errorDiv.textContent = 'Le numéro de compte doit contenir au moins 5 caractères';
                        isValid = false;
                    } else {
                        errorDiv.textContent = '';
                    }
                    break;

                case 'montant_envoye':
                    if (!value) {
                        errorDiv.textContent = 'Le montant est requis';
                        isValid = false;
                    } else if (parseFloat(value) <= 0) {
                        errorDiv.textContent = 'Le montant doit être supérieur à 0';
                        isValid = false;
                    } else {
                        errorDiv.textContent = '';
                    }
                    break;
            }
        }

        field.classList.toggle('is-invalid', !isValid);
        return isValid;
    }

    // Écouteur pour le champ montant envoyé
    const montantEnvoyeElement = document.getElementById('montant_envoye');
    if (montantEnvoyeElement) {
        montantEnvoyeElement.addEventListener('input', function(e) {
            if (isCalculatingFromReceived) return;
            const montant = e.target.value;
            
            if (validateField(this)) {
                const montantRecuElement = document.getElementById('montant_recu');
                if (montantRecuElement) {
                    montantRecuElement.value = calculateReceivedAmount(montant);
                }
                updateFraisDisplay(montant);
            }
        });
    }

    // Écouteur pour le champ montant reçu
    const montantRecuElement = document.getElementById('montant_recu');
    if (montantRecuElement) {
        montantRecuElement.addEventListener('input', function(e) {
            isCalculatingFromReceived = true;
            const montantRecu = e.target.value;
            const montantEnvoye = calculateSentAmount(montantRecu);
            
            if (montantEnvoyeElement) {
                montantEnvoyeElement.value = montantEnvoye;
                updateFraisDisplay(montantEnvoye);
                validateField(montantEnvoyeElement);
            }
            
            isCalculatingFromReceived = false;
        });
    }

    // Validation des numéros de compte source et destination
    ['numero_compte_source', 'numero_compte_destination'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('input', function() {
                validateField(this);
            });
        }
    });

    // Validation du formulaire avant soumission
    const transferForm = document.getElementById('transferForm');
    if (transferForm) {
        transferForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const fields = ['numero_compte_source', 'numero_compte_destination', 'montant_envoye'];
            let isValid = true;

            fields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field && !validateField(field)) {
                    isValid = false;
                }
            });

            if (isValid) {
                this.submit();
            }
        });
    }
});


</script>


@endsection


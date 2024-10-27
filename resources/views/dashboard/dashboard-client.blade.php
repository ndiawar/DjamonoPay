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
                        <span id="balanceValue">1542789 F</span>
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
                    <div class="mb-2 text-center">
                        <div class="icon-circle d-flex justify-content-center align-items-center mx-auto" data-bs-toggle="modal" data-bs-target="#transferModal" style="width: 40px; height: 40px; border-radius: 50%; background-color: #003f6b;">
                            <i class="fs-5 bi bi-send-fill text-white"></i>
                        </div>
                        <span class="d-block mt-1 text-muted">Envoyer</span>
                    </div>
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
                      <form action="{{ route('clients.transfert_clients') }}" method="POST">
                          @csrf
                          <div class="mb-3">
                              <label for="recipient" class="form-label">Source</label>
                              <input type="text" class="form-control" id="recipient" name="numero_compte_source" required>
                          </div>
                          <div class="mb-3">
                              <label for="recipient" class="form-label">Destinataire</label>
                              <input type="text" class="form-control" id="recipient" name="numero_compte_destination" required>
                          </div>
                          <div class="mb-3">
                              <label for="amount" class="form-label">Montant</label>
                              <input type="number" class="form-control" id="amount" name="montant" required>
                          </div>
                          <button type="submit" class="btn btn-secondary btn-custom me-2">Envoyer</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive user-datatable">
                    <table class="display" id="datatable-range">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Adresse</th>
                                <th>Numéro Compte</th>
                                <th>Transaction</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                        alt="">Nom Client</td>
                                <td>Dakar</td>
                                <td>6145 7854 7485 9654 0012</td>
                                <td class="d-flex rounded" style="background-color: #d4edda;">
                                    <p class="me-2">325.452 Fcfa</p> 
                                    <p class="">Retrait</p>
                                </td>
                            </tr>
                            <tr>
                                <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                        alt="">Nom Client</td>
                                <td>Dakar</td>
                                <td>6145 7854 7485 9654 0012</td>
                                <td class="d-flex rounded" style="background-color: #d4edda;">
                                    <p class="me-2">325.452 Fcfa</p> 
                                    <p class="">Retrait</p>
                                </td>
                            </tr>
                            <tr>
                                <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                        alt="">Nom Client</td>
                                <td>Dakar</td>
                                <td>6145 7854 7485 9654 0012</td>
                                <td class="d-flex rounded" style="background-color: #d4edda;">
                                    <p class="me-2">325.452 Fcfa</p> 
                                    <p class="">Retrait</p>
                                </td>
                            </tr>
                            <tr>
                                <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                        alt="">Nom Client</td>
                                <td>Dakar</td>
                                <td>6145 7854 7485 9654 0012</td>
                                <td class="d-flex rounded" style="background-color: #d4edda;">
                                    <p class="me-2">325.452 Fcfa</p> 
                                    <p class="">Retrait</p>
                                </td>
                            </tr>
                            <tr>
                                <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                        alt="">Nom Client</td>
                                <td>Dakar</td>
                                <td>6145 7854 7485 9654 0012</td>
                                <td class="d-flex rounded" style="background-color: #d4edda;">
                                    <p class="me-2">325.452 Fcfa</p> 
                                    <p class="">Retrait</p>
                                </td>
                            </tr>
                            <tr>
                                <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                        alt="">Nom Client</td>
                                <td>Dakar</td>
                                <td>6145 7854 7485 9654 0012</td>
                                <td class="d-flex rounded" style="background-color: #cce5ff;">
                                <p class="me-2">325.452 Fcfa</p> 
                                <p class="">transfert</p>
                            </td>

                            </tr>
                            <tr>
                                <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                        alt="">Nom Client</td>
                                <td>Dakar</td>
                                <td>6145 7854 7485 9654 0012</td>
                                <td class="d-flex rounded" style="background-color: #cce5ff;">
                                <p class="me-2">325.452 Fcfa</p> 
                                <p class="">transfert</p>
                            </td>

                            </tr>
                            <tr>
                                <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                        alt="">Nom Client</td>
                                <td>Dakar</td>
                                <td>6145 7854 7485 9654 0012</td>
                                <td class="d-flex rounded" style="background-color: #cce5ff;">
                                <p class="me-2">325.452 Fcfa</p> 
                                <p class="">transfert</p>
                            </td>

                            </tr>
                            <tr>
                                <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                        alt="">Nom Client</td>
                                <td>Dakar</td>
                                <td>6145 7854 7485 9654 0012</td>
                                <td class="d-flex rounded" style="background-color: #f8d7da;">
                                    <p class="me-5">325.452 Fcfa</p> 
                                    <p class="">annulé</p>
                                </td>
                            </tr>
                            <tr>
                                <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                        alt="">Nom Client</td>
                                <td>Dakar</td>
                                <td>6145 7854 7485 9654 0012</td>
                                <td class="d-flex rounded" style="background-color: #f8d7da;">
                                    <p class="me-5">325.452 Fcfa</p> 
                                    <p class="">annulé</p>
                                </td>
                            </tr>
                            <tr>
                                <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                        alt="">Nom Client</td>
                                <td>Dakar</td>
                                <td>6145 7854 7485 9654 0012</td>
                                <td class="d-flex rounded" style="background-color: #f8d7da;">
                                    <p class="me-5">325.452 Fcfa</p> 
                                    <p class="">annulé</p>
                                </td>
                            </tr>
                            <tr>
                                <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                        alt="">Nom Client</td>
                                <td>Dakar</td>
                                <td>6145 7854 7485 9654 0012</td>
                                <td class="d-flex rounded" style="background-color: #f8d7da;">
                                    <p class="me-5">325.452 Fcfa</p> 
                                    <p class="">annulé</p>
                                </td>
                            </tr>
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
function toggleBalance() {
    const balance = document.getElementById('balanceValue');
    const icon = document.getElementById('toggleBalance');

    if (balance.style.display === 'none') {
        balance.style.display = 'inline';
        balance.textContent = '1542789 F'; // Rétablir la valeur
        icon.className = 'text-dark bi bi-eye-slash'; // Icône œil fermé

        // Supprimer les points si affichés
        const hiddenBalance = document.getElementById('hiddenBalance');
        if (hiddenBalance) {
            hiddenBalance.remove();
        }
    } else {
        balance.style.display = 'none';
        icon.className = 'text-dark bi bi-eye'; // Icône œil ouvert

        // Vérifier si les points sont déjà affichés
        if (!document.getElementById('hiddenBalance')) {
            balance.insertAdjacentHTML('afterend', '<span id="hiddenBalance" style="color: #003f6b;">••••••</span>'); // Ajouter les points
        }
    }
}
</script>


@endsection

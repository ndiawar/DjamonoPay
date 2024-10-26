@extends('layouts.simple.master')
@section('title', 'Distributeur')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
@endsection

@section('style')
@endsection

@section('style')

@endsection

@section('breadcrumb-title')
    <h3>Distributeur</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Distributeur</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mt-5 position-absolute top-5 start-50">
             <!-- Solde Card -->
            <div class="">
                <div class="row">
                <div class="col-md-8  ">
						<div class="border-start border-5 border-dark card small-widget">
							<div class="card-body primary">
								<span class="f-light pt-2">Solde</span>
								<div class="d-flex align-items-end gap-1 pt-4">
									<h6>1.258.000 Fcfa</h6>
									
								</div>
							</div>
                            <div class="container text-center mt-5">
    <!-- Button Envoyer -->
    <button class="icon-button">
        <i class="bi bi-send-fill"></i>
    </button>

    <!-- Button Retrait (add a margin for spacing) -->
    <button class="icon-button ms-3">
        <i class="bi bi-arrow-down-circle-fill"></i>
    </button>
</div>
						</div>
					</div>
                </div>
            </div>

            <!-- Cards for Envoie and Retrait -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card p-3 text-center">
                        <p class="text-muted">Envoie</p>
                        <h4>$128,320</h4>
                        <span class="percentage">↑ 11.09%</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3 text-center">
                        <p class="text-muted">Retrait</p>
                        <h4>$128,320</h4>
                        <span class="percentage">↑ 11.09%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection

@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection

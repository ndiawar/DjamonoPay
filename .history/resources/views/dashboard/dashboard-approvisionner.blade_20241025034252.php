@extends('layouts.simple.master')
@section('title', 'Approvissionement')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .custom-input-group {
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .credit-total {
            font-size: 20px;
            font-weight: bold;
            padding: 15px;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .credit-total i {
            margin-right: 10px;
        }
        .custom-table th, .custom-table td {
            font-size: 16px;
        }
        .custom-table td {
            font-weight: bold;
        }
        .custom-table td .card-number {
            font-weight: normal;
        }
        .btn-custom {
            border-radius: 10px;
        }
    </style>
@endsection

@section('breadcrumb-title')
    <h3>Approvissionement</h3>
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Approvissionement</li>
@endsection

@section('content')
    <div class="container-fluid ">

    </div>        
@endsection


@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/dashboard_5.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@endsection

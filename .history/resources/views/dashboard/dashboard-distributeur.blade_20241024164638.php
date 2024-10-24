@extends('layouts.simple.master')
@section('title', 'Distributeur')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Distributeur</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Distributeur</li>
@endsection

    @section('content')
        <div class="container-fluid ">
                <!-- Table Distributeurs-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <h3 class="mb-3">Historique des transactions</h3>
                        <div class="row w-75 mt-5 justify-content-center">
                            <div class="col-md-4">
                                <div class="w-75 border-start border-5 border-info card small-widget">
                                    <div class="card-body primary">
                                        <span class="f-light pt-2">Solde</span>
                                        <div class="d-flex align-items-end gap-1 pt-4">
                                            <h6>1.258.000 Fcfa</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="w-75 border-start border-5 border-success card small-widget">
                                    <div class="card-body primary">
                                        <span class="f-light pt-2">Envoie</span>
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
                            <div class="col-md-4">
                                <div class="w-75 border-start border-5 border-warning card small-widget">
                                    <div class="card-body primary">
                                        <span class="f-light pt-2">Retrait</span>
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
                    <div class="card-body">
                        <div class="table-responsive user-datatable">
                            <table class="display" id="datatable-range">
                                <thead>
                                    <tr>
                                        <th>Distributeur</th>
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
                                        <td><p>325.452 Fcfa</p> <p>retrait</p> </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td><p>325.452 Fcfa</p> <p>retrait</p> </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td><p>325.452 Fcfa</p> <p>retrait</p> </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td><p>325.452 Fcfa</p> <p>retrait</p> </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td><p>325.452 Fcfa</p> <p>retrait</p> </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td><p>325.452 Fcfa</p> <p>depôt</p> </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td><p>325.452 Fcfa</p> <p>depôt</p> </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td><p>325.452 Fcfa</p> <p>depôt</p> </td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Nom Client</td>
                                        <td>Dakar</td>
                                        <td>6145 7854 7485 9654 0012</td>
                                        <td class=" d-flex"><p>325.452 Fcfa</p> <p class="bg-danger">annulé</p> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tale Distributeurs-->
        </div>        
    @endsection


@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/dashboard_5.js') }}"></script>

@endsection

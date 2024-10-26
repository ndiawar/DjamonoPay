@extends('layouts.simple.master')
@section('title', 'Client')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
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
            <div class="card-header pb-0 card-no-border">
              <h3 class="mb-3">Historique des transactions</h3>
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

@endsection

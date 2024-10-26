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
                <!-- Multiple table control elements  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <h3 class="mb-3">Historique des activitées</h3>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive user-datatable">
                            <table class="display" id="datatable-range">
                                <thead>
                                    <tr>
                                        <th>Utilisateur</th>
                                        <th>Date</th>
                                        <th>Adresse Identité</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>$320,800</td>
                                    </tr>
                                    <tr>
                                        <td> Garrett Winters</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>$170,750</td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/11.png') }}"
                                                alt="">Ashton Cox</td>
                                        <td>Junior Technical Author</td>
                                        <td>San Francisco</td>
                                        <td>$86,000</td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/11.png') }}
                                                alt="">Cedric Kelly</td>
                                        <td>Senior Javascript Developer</td>
                                        <td>Edinburgh</td>
                                        <td>$433,060</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Airi Satou</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>$162,700</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Brielle Williamson</td>
                                        <td>Integration Specialist</td>
                                        <td>New York</td>
                                        <td>$372,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Herrod Chandler</td>
                                        <td>Sales Assistant</td>
                                        <td>San Francisco</td>
                                        <td>$137,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Rhona Davidson</td>
                                        <td>Integration Specialist</td>
                                        <td>Tokyo</td>
                                        <td>$327,900</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Colleen Hurst</td>
                                        <td>Javascript Developer</td>
                                        <td>San Francisco</td>
                                        <td>$205,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Sonya Frost</td>
                                        <td>Software Engineer</td>
                                        <td>Edinburgh</td>
                                        <td>$103,600</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Multiple table control elements Ends-->
            </div>
        </div>
    @endsection

    @section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/dashboard_5.js') }}"></script>


<script src="{{asset('assets/js/chart/apex-chart/apex-chart.js')}}"></script>
<!-- <script src="{{ asset('assets/js/clock.js') }}"></script> -->
<script src="{{ asset('assets/js/chart/apex-chart/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
<!-- <script src="{{ asset('assets/js/dashboard/default.js') }}"></script> -->
@endsection

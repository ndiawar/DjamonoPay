@extends('layouts.simple.master')
@section('title', 'Distributeur')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('style')
<style>
.icon-button {
    width: 60px;
    height: 60px;
    background-color: #003f77;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: none;
}

.icon-button:hover {
    background-color: #002c59;
}

    </style>
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
            <div class="row">
                <div class="col-md-8  ">
                    <div class="border-start border-5 border-dark card small-widget d-flex">
                        <div class="card-body primary">
                            <span class="f-light pt-2">Solde</span>
                            <div class="d-flex align-items-end gap-1 pt-4">
                                <h6>1.258.000 Fcfa</h6>
                                
                            </div>
                        </div>
                        <div class="d-flex align-items-end flex-column bd-highlight">
                            <!-- Button Envoyer -->
                            <button class="icon-button rounded-circle btn btn-primary mb-2">
                                <i class="bi bi-send-fill"></i>
                            </button>

                            <!-- Button Retrait -->
                            <button class="icon-button rounded-circle btn btn-primary">
                                <i class="bi bi-arrow-down-circle-fill"></i>
                            </button>
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
    <div class="container-fluid">
        <div class="row size-column">
        <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <h3 class="mb-3">Custom filtering - range search</h3><span>This example shows a search being
                            performed on the age column in the data, based upon two inputs.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive user-datatable">
                            <table class="display" id="datatable-range">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/2.jpg') }}"
                                                alt="">Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Garrett Winters</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>63</td>
                                        <td>2011/07/25</td>
                                        <td>$170,750</td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/11.png') }}"
                                                alt="">Ashton Cox</td>
                                        <td>Junior Technical Author</td>
                                        <td>San Francisco</td>
                                        <td>66</td>
                                        <td>2009/01/12</td>
                                        <td>$86,000</td>
                                    </tr>
                                    <tr>
                                        <td> <img class="img-fluid table-avtar" src="{{ asset('assets/images/user/3.png') }}"
                                                alt="">Cedric Kelly</td>
                                        <td>Senior Javascript Developer</td>
                                        <td>Edinburgh</td>
                                        <td>22</td>
                                        <td>2012/03/29</td>
                                        <td>$433,060</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Airi Satou</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>33</td>
                                        <td>2008/11/28</td>
                                        <td>$162,700</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Brielle Williamson</td>
                                        <td>Integration Specialist</td>
                                        <td>New York</td>
                                        <td>61</td>
                                        <td>2012/12/02</td>
                                        <td>$372,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Herrod Chandler</td>
                                        <td>Sales Assistant</td>
                                        <td>San Francisco</td>
                                        <td>59</td>
                                        <td>2012/08/06</td>
                                        <td>$137,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Rhona Davidson</td>
                                        <td>Integration Specialist</td>
                                        <td>Tokyo</td>
                                        <td>55</td>
                                        <td>2010/10/14</td>
                                        <td>$327,900</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Colleen Hurst</td>
                                        <td>Javascript Developer</td>
                                        <td>San Francisco</td>
                                        <td>39</td>
                                        <td>2009/09/15</td>
                                        <td>$205,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Sonya Frost</td>
                                        <td>Software Engineer</td>
                                        <td>Edinburgh</td>
                                        <td>23</td>
                                        <td>2008/12/13</td>
                                        <td>$103,600</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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

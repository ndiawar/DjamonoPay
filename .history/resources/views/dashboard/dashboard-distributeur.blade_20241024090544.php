@extends('layouts.simple.master')
@section('title', 'Distributeur')

@section('css')
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
        <div class="container-fluid">
            <div class="row w-75 mt-5">
                <div class="col-md-4 m-auto  ">
                    <div class=" w-75 border-start border-5 border-info card small-widget">
                        <div class="card-body primary">
                            <span class="f-light pt-2">Solde</span>
                            <div class="d-flex align-items-end gap-1 pt-4">
                                <h6>1.258.000 Fcfa</h6>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 m-auto ">
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
                <div class="col-md-4 m-auto ">
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
            <div class="row mt-5">
                <!-- Multiple table control elements  Starts-->
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
                                        <th>Distributeur</th>
                                        <th>Adresse</th>
                                        <th>Carte Identité</th>
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
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Jena Gaines</td>
                                        <td>Office Manager</td>
                                        <td>London</td>
                                        <td>30</td>
                                        <td>2008/12/19</td>
                                        <td>$90,560</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Quinn Flynn</td>
                                        <td>Support Lead</td>
                                        <td>Edinburgh</td>
                                        <td>22</td>
                                        <td>2013/03/03</td>
                                        <td>$342,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Charde Marshall</td>
                                        <td>Regional Director</td>
                                        <td>San Francisco</td>
                                        <td>36</td>
                                        <td>2008/10/16</td>
                                        <td>$470,600</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Haley Kennedy</td>
                                        <td>Senior Marketing Designer</td>
                                        <td>London</td>
                                        <td>43</td>
                                        <td>2012/12/18</td>
                                        <td>$313,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Tatyana Fitzpatrick</td>
                                        <td>Regional Director</td>
                                        <td>London</td>
                                        <td>19</td>
                                        <td>2010/03/17</td>
                                        <td>$385,750</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Michael Silva</td>
                                        <td>Marketing Designer</td>
                                        <td>London</td>
                                        <td>66</td>
                                        <td>2012/11/27</td>
                                        <td>$198,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Paul Byrd</td>
                                        <td>Chief Financial Officer (CFO)</td>
                                        <td>New York</td>
                                        <td>64</td>
                                        <td>2010/06/09</td>
                                        <td>$725,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Gloria Little</td>
                                        <td>Systems Administrator</td>
                                        <td>New York</td>
                                        <td>59</td>
                                        <td>2009/04/10</td>
                                        <td>$237,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Bradley Greer</td>
                                        <td>Software Engineer</td>
                                        <td>London</td>
                                        <td>41</td>
                                        <td>2012/10/13</td>
                                        <td>$132,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Dai Rios</td>
                                        <td>Personnel Lead</td>
                                        <td>Edinburgh</td>
                                        <td>35</td>
                                        <td>2012/09/26</td>
                                        <td>$217,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Jenette Caldwell</td>
                                        <td>Development Lead</td>
                                        <td>New York</td>
                                        <td>30</td>
                                        <td>2011/09/03</td>
                                        <td>$345,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Yuri Berry</td>
                                        <td>Chief Marketing Officer (CMO)</td>
                                        <td>New York</td>
                                        <td>40</td>
                                        <td>2009/06/25</td>
                                        <td>$675,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Caesar Vance</td>
                                        <td>Pre-Sales Support</td>
                                        <td>New York</td>
                                        <td>21</td>
                                        <td>2011/12/12</td>
                                        <td>$106,450</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Doris Wilder</td>
                                        <td>Sales Assistant</td>
                                        <td>Sidney</td>
                                        <td>23</td>
                                        <td>2010/09/20</td>
                                        <td>$85,600</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Angelica Ramos</td>
                                        <td>Chief Executive Officer (CEO)</td>
                                        <td>London</td>
                                        <td>47</td>
                                        <td>2009/10/09</td>
                                        <td>$1,200,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Gavin Joyce</td>
                                        <td>Developer</td>
                                        <td>Edinburgh</td>
                                        <td>42</td>
                                        <td>2010/12/22</td>
                                        <td>$92,575</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Jennifer Chang</td>
                                        <td>Regional Director</td>
                                        <td>Singapore</td>
                                        <td>28</td>
                                        <td>2010/11/14</td>
                                        <td>$357,650</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Brenden Wagner</td>
                                        <td>Software Engineer</td>
                                        <td>San Francisco</td>
                                        <td>28</td>
                                        <td>2011/06/07</td>
                                        <td>$206,850</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Fiona Green</td>
                                        <td>Chief Operating Officer (COO)</td>
                                        <td>San Francisco</td>
                                        <td>48</td>
                                        <td>2010/03/11</td>
                                        <td>$850,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Shou Itou</td>
                                        <td>Regional Marketing</td>
                                        <td>Tokyo</td>
                                        <td>20</td>
                                        <td>2011/08/14</td>
                                        <td>$163,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Michelle House</td>
                                        <td>Integration Specialist</td>
                                        <td>Sidney</td>
                                        <td>37</td>
                                        <td>2011/06/02</td>
                                        <td>$95,400</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Suki Burks</td>
                                        <td>Developer</td>
                                        <td>London</td>
                                        <td>53</td>
                                        <td>2009/10/22</td>
                                        <td>$114,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Prescott Bartlett</td>
                                        <td>Technical Author</td>
                                        <td>London</td>
                                        <td>27</td>
                                        <td>2011/05/07</td>
                                        <td>$145,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Gavin Cortez</td>
                                        <td>Team Leader</td>
                                        <td>San Francisco</td>
                                        <td>22</td>
                                        <td>2008/10/26</td>
                                        <td>$235,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Martena Mccray</td>
                                        <td>Post-Sales support</td>
                                        <td>Edinburgh</td>
                                        <td>46</td>
                                        <td>2011/03/09</td>
                                        <td>$324,050</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Unity Butler</td>
                                        <td>Marketing Designer</td>
                                        <td>San Francisco</td>
                                        <td>47</td>
                                        <td>2009/12/09</td>
                                        <td>$85,675</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Howard Hatfield</td>
                                        <td>Office Manager</td>
                                        <td>San Francisco</td>
                                        <td>51</td>
                                        <td>2008/12/16</td>
                                        <td>$164,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Hope Fuentes</td>
                                        <td>Secretary</td>
                                        <td>San Francisco</td>
                                        <td>41</td>
                                        <td>2010/02/12</td>
                                        <td>$109,850</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Vivian Harrell</td>
                                        <td>Financial Controller</td>
                                        <td>San Francisco</td>
                                        <td>62</td>
                                        <td>2009/02/14</td>
                                        <td>$452,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Timothy Mooney</td>
                                        <td>Office Manager</td>
                                        <td>London</td>
                                        <td>37</td>
                                        <td>2008/12/11</td>
                                        <td>$136,200</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Jackson Bradshaw</td>
                                        <td>Director</td>
                                        <td>New York</td>
                                        <td>65</td>
                                        <td>2008/09/26</td>
                                        <td>$645,750</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Olivia Liang</td>
                                        <td>Support Engineer</td>
                                        <td>Singapore</td>
                                        <td>64</td>
                                        <td>2011/02/03</td>
                                        <td>$234,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Bruno Nash</td>
                                        <td>Software Engineer</td>
                                        <td>London</td>
                                        <td>38</td>
                                        <td>2011/05/03</td>
                                        <td>$163,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Sakura Yamamoto</td>
                                        <td>Support Engineer</td>
                                        <td>Tokyo</td>
                                        <td>37</td>
                                        <td>2009/08/19</td>
                                        <td>$139,575</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Thor Walton</td>
                                        <td>Developer</td>
                                        <td>New York</td>
                                        <td>61</td>
                                        <td>2013/08/11</td>
                                        <td>$98,540</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Finn Camacho</td>
                                        <td>Support Engineer</td>
                                        <td>San Francisco</td>
                                        <td>47</td>
                                        <td>2009/07/07</td>
                                        <td>$87,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Serge Baldwin</td>
                                        <td>Data Coordinator</td>
                                        <td>Singapore</td>
                                        <td>64</td>
                                        <td>2012/04/09</td>
                                        <td>$138,575</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Zenaida Frank</td>
                                        <td>Software Engineer</td>
                                        <td>New York</td>
                                        <td>63</td>
                                        <td>2010/01/04</td>
                                        <td>$125,250</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Zorita Serrano</td>
                                        <td>Software Engineer</td>
                                        <td>San Francisco</td>
                                        <td>56</td>
                                        <td>2012/06/01</td>
                                        <td>$115,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Jennifer Acosta</td>
                                        <td>Junior Javascript Developer</td>
                                        <td>Edinburgh</td>
                                        <td>43</td>
                                        <td>2013/02/01</td>
                                        <td>$75,650</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Cara Stevens</td>
                                        <td>Sales Assistant</td>
                                        <td>New York</td>
                                        <td>46</td>
                                        <td>2011/12/06</td>
                                        <td>$145,600</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Hermione Butler</td>
                                        <td>Regional Director</td>
                                        <td>London</td>
                                        <td>47</td>
                                        <td>2011/03/21</td>
                                        <td>$356,250</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Lael Greer</td>
                                        <td>Systems Administrator</td>
                                        <td>London</td>
                                        <td>21</td>
                                        <td>2009/02/27</td>
                                        <td>$103,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Jonas Alexander</td>
                                        <td>Developer</td>
                                        <td>San Francisco</td>
                                        <td>30</td>
                                        <td>2010/07/14</td>
                                        <td>$86,500</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Shad Decker</td>
                                        <td>Regional Director</td>
                                        <td>Edinburgh</td>
                                        <td>51</td>
                                        <td>2008/11/13</td>
                                        <td>$183,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Michael Bruce</td>
                                        <td>Javascript Developer</td>
                                        <td>Singapore</td>
                                        <td>29</td>
                                        <td>2011/06/27</td>
                                        <td>$183,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="img-fluid table-avtar" src="{{ asset('assets/images/user/7.jpg') }}"
                                                alt="">Donna Snider</td>
                                        <td>Customer Support</td>
                                        <td>New York</td>
                                        <td>27</td>
                                        <td>2011/01/25</td>
                                        <td>$112,000</td>
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

        <!-- Tableau -->
        
    @endsection

@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection

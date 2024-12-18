@extends('layouts.simple.master')
@section('title', 'Distributeur')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

<!-- @section('style')
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
@endsection -->

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
        <div class="row mt-5 ">
 <!-- State saving Starts-->
 <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <h3>State saving</h3><span>
                            DataTables has the option of being able to save the state of a table (its paging position,
                            ordering state etc) so that is can be restored when the user
                            reloads a page, or comes back to the page after visiting a sub-page. This state saving ability
                            is enabled by the <code class="option"
                                title="DataTables initialisation option">stateSave</code> option.</span><span>The built in
                            state saving method uses the HTML5 <code>localStorage</code> and <code>sessionStorage</code>
                            APIs for efficient storage of the data. Please
                            note that this means that the built in state saving option <strong>will not work with
                                IE6/7</strong> as these browsers do not support these APIs. Alternative
                            options of using cookies or saving the state on the server through Ajax can be used through the
                            <code class="option" title="DataTables initialisation option">stateSaveCallback</code> and <a
                                href="//datatables.net/reference/option/stateLoadCallback"><code class="option"
                                    title="DataTables initialisation option">stateLoadCallback</code></a>
                            options.</span><span>The duration for which the saved state is valid and can be used to restore
                            the table state can be set using the <code class="option"
                                title="DataTables initialisation option">stateDuration</code> initialisation
                            parameter (2 hours by default). This parameter also controls if <code>localStorage</code> (0 or
                            greater) or <code>sessionStorage</code> (-1) is used to store
                            the data.</span><span>The example below simply shows state saving enabled in DataTables with the
                            <code class="option" title="DataTables initialisation option">stateSave</code> option.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="basic-9">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td><span class="badge rounded-pill badge-light-primary">System Architect</span>
                                        </td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Garrett Winters</td>
                                        <td><span class="badge rounded-pill badge-light-secondary">Accountant</span></td>
                                        <td>Tokyo</td>
                                        <td>63</td>
                                        <td>2011/07/25</td>
                                        <td>$170,750</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ashton Cox</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Junior Technical
                                                Author</span></td>
                                        <td>San Francisco</td>
                                        <td>66</td>
                                        <td>2009/01/12</td>
                                        <td>$86,000</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cedric Kelly</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Senior Javascript
                                                Developer</span></td>
                                        <td>Edinburgh</td>
                                        <td>22</td>
                                        <td>2012/03/29</td>
                                        <td>$433,060</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Airi Satou</td>
                                        <td><span class="badge rounded-pill badge-light-secondary">Accountant</span></td>
                                        <td>Tokyo</td>
                                        <td>33</td>
                                        <td>2008/11/28</td>
                                        <td>$162,700</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Brielle Williamson</td>
                                        <td><span class="badge rounded-pill badge-light-info">Integration Specialist</span>
                                        </td>
                                        <td>New York</td>
                                        <td>61</td>
                                        <td>2012/12/02</td>
                                        <td>$372,000</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Herrod Chandler</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Sales Assistant</span>
                                        </td>
                                        <td>San Francisco</td>
                                        <td>59</td>
                                        <td>2012/08/06</td>
                                        <td>$137,500</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Rhona Davidson</td>
                                        <td><span class="badge rounded-pill badge-light-info">Integration Specialist</span>
                                        </td>
                                        <td>Tokyo</td>
                                        <td>55</td>
                                        <td>2010/10/14</td>
                                        <td>$327,900</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Colleen Hurst</td>
                                        <td><span class="badge rounded-pill badge-light-danger">Javascript Developer</span>
                                        </td>
                                        <td>San Francisco</td>
                                        <td>39</td>
                                        <td>2009/09/15</td>
                                        <td>$205,500</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sonya Frost</td>
                                        <td><span class="badge rounded-pill badge-light-success">Software Engineer</span>
                                        </td>
                                        <td>Edinburgh</td>
                                        <td>23</td>
                                        <td>2008/12/13</td>
                                        <td>$103,600</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jena Gaines</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Office Manager</span></td>
                                        <td>London</td>
                                        <td>30</td>
                                        <td>2008/12/19</td>
                                        <td>$90,560</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Quinn Flynn</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Support Lead</span></td>
                                        <td>Edinburgh</td>
                                        <td>22</td>
                                        <td>2013/03/03</td>
                                        <td>$342,000</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Charde Marshall</td>
                                        <td><span class="badge rounded-pill badge-light-info">Regional Director</span></td>
                                        <td>San Francisco</td>
                                        <td>36</td>
                                        <td>2008/10/16</td>
                                        <td>$470,600</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Haley Kennedy</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Senior Marketing
                                                Designer</span></td>
                                        <td>London</td>
                                        <td>43</td>
                                        <td>2012/12/18</td>
                                        <td>$313,500</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tatyana Fitzpatrick</td>
                                        <td><span class="badge rounded-pill badge-light-info">Regional Director</span></td>
                                        <td>London</td>
                                        <td>19</td>
                                        <td>2010/03/17</td>
                                        <td>$385,750</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michael Silva</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Marketing Designer</span>
                                        </td>
                                        <td>London</td>
                                        <td>66</td>
                                        <td>2012/11/27</td>
                                        <td>$198,500</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Paul Byrd</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Chief Financial Officer
                                                (CFO)</span></td>
                                        <td>New York</td>
                                        <td>64</td>
                                        <td>2010/06/09</td>
                                        <td>$725,000</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gloria Little</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Systems
                                                Administrator</span></td>
                                        <td>New York</td>
                                        <td>59</td>
                                        <td>2009/04/10</td>
                                        <td>$237,500</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bradley Greer</td>
                                        <td><span class="badge rounded-pill badge-light-success">Software Engineer</span>
                                        </td>
                                        <td>London</td>
                                        <td>41</td>
                                        <td>2012/10/13</td>
                                        <td>$132,000</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dai Rios</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Personnel Lead</span>
                                        </td>
                                        <td>Edinburgh</td>
                                        <td>35</td>
                                        <td>2012/09/26</td>
                                        <td>$217,500</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jenette Caldwell</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Development Lead</span>
                                        </td>
                                        <td>New York</td>
                                        <td>30</td>
                                        <td>2011/09/03</td>
                                        <td>$345,000</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Yuri Berry</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Chief Marketing Officer
                                                (CMO)</span></td>
                                        <td>New York</td>
                                        <td>40</td>
                                        <td>2009/06/25</td>
                                        <td>$675,000</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Caesar Vance</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Pre-Sales Support</span>
                                        </td>
                                        <td>New York</td>
                                        <td>21</td>
                                        <td>2011/12/12</td>
                                        <td>$106,450</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Doris Wilder</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Sales Assistant</span>
                                        </td>
                                        <td>Sidney</td>
                                        <td>23</td>
                                        <td>2010/09/20</td>
                                        <td>$85,600</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Angelica Ramos</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Chief Executive Officer
                                                (CEO)</span></td>
                                        <td>London</td>
                                        <td>47</td>
                                        <td>2009/10/09</td>
                                        <td>$1,200,000</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gavin Joyce</td>
                                        <td><span class="badge rounded-pill badge-light-success">Developer</span></td>
                                        <td>Edinburgh</td>
                                        <td>42</td>
                                        <td>2010/12/22</td>
                                        <td>$92,575</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jennifer Chang</td>
                                        <td><span class="badge rounded-pill badge-light-info">Regional Director</span>
                                        </td>
                                        <td>Singapore</td>
                                        <td>28</td>
                                        <td>2010/11/14</td>
                                        <td>$357,650</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Brenden Wagner</td>
                                        <td><span class="badge rounded-pill badge-light-success">Software Engineer</span>
                                        </td>
                                        <td>San Francisco</td>
                                        <td>28</td>
                                        <td>2011/06/07</td>
                                        <td>$206,850</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fiona Green</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Chief Operating Officer
                                                (COO)</span></td>
                                        <td>San Francisco</td>
                                        <td>48</td>
                                        <td>2010/03/11</td>
                                        <td>$850,000</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shou Itou</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Regional Marketing</span>
                                        </td>
                                        <td>Tokyo</td>
                                        <td>20</td>
                                        <td>2011/08/14</td>
                                        <td>$163,000</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michelle House</td>
                                        <td><span class="badge rounded-pill badge-light-info">Integration
                                                Specialist</span></td>
                                        <td>Sidney</td>
                                        <td>37</td>
                                        <td>2011/06/02</td>
                                        <td>$95,400</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Suki Burks</td>
                                        <td><span class="badge rounded-pill badge-light-success">Developer</span></td>
                                        <td>London</td>
                                        <td>53</td>
                                        <td>2009/10/22</td>
                                        <td>$114,500</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Prescott Bartlett</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Technical Author</span>
                                        </td>
                                        <td>London</td>
                                        <td>27</td>
                                        <td>2011/05/07</td>
                                        <td>$145,000</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gavin Cortez</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Team Leader</span></td>
                                        <td>San Francisco</td>
                                        <td>22</td>
                                        <td>2008/10/26</td>
                                        <td>$235,500</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Martena Mccray</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Post-Sales support</span>
                                        </td>
                                        <td>Edinburgh</td>
                                        <td>46</td>
                                        <td>2011/03/09</td>
                                        <td>$324,050</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Unity Butler</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Marketing Designer</span>
                                        </td>
                                        <td>San Francisco</td>
                                        <td>47</td>
                                        <td>2009/12/09</td>
                                        <td>$85,675</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Howard Hatfield</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Office Manager</span>
                                        </td>
                                        <td>San Francisco</td>
                                        <td>51</td>
                                        <td>2008/12/16</td>
                                        <td>$164,500</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hope Fuentes</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Secretary</span></td>
                                        <td>San Francisco</td>
                                        <td>41</td>
                                        <td>2010/02/12</td>
                                        <td>$109,850</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Vivian Harrell</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Financial
                                                Controller</span></td>
                                        <td>San Francisco</td>
                                        <td>62</td>
                                        <td>2009/02/14</td>
                                        <td>$452,500</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Timothy Mooney</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Office Manager</span>
                                        </td>
                                        <td>London</td>
                                        <td>37</td>
                                        <td>2008/12/11</td>
                                        <td>$136,200</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jackson Bradshaw</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Director</span></td>
                                        <td>New York</td>
                                        <td>65</td>
                                        <td>2008/09/26</td>
                                        <td>$645,750</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Olivia Liang</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Support Engineer</span>
                                        </td>
                                        <td>Singapore</td>
                                        <td>64</td>
                                        <td>2011/02/03</td>
                                        <td>$234,500</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bruno Nash</td>
                                        <td><span class="badge rounded-pill badge-light-success">Software Engineer</span>
                                        </td>
                                        <td>London</td>
                                        <td>38</td>
                                        <td>2011/05/03</td>
                                        <td>$163,500</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sakura Yamamoto</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Support Engineer</span>
                                        </td>
                                        <td>Tokyo</td>
                                        <td>37</td>
                                        <td>2009/08/19</td>
                                        <td>$139,575</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Thor Walton</td>
                                        <td><span class="badge rounded-pill badge-light-success">Developer</span></td>
                                        <td>New York</td>
                                        <td>61</td>
                                        <td>2013/08/11</td>
                                        <td>$98,540</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Finn Camacho</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Support Engineer</span>
                                        </td>
                                        <td>San Francisco</td>
                                        <td>47</td>
                                        <td>2009/07/07</td>
                                        <td>$87,500</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Serge Baldwin</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Data Coordinator</span>
                                        </td>
                                        <td>Singapore</td>
                                        <td>64</td>
                                        <td>2012/04/09</td>
                                        <td>$138,575</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Zenaida Frank</td>
                                        <td><span class="badge rounded-pill badge-light-success">Software Engineer</span>
                                        </td>
                                        <td>New York</td>
                                        <td>63</td>
                                        <td>2010/01/04</td>
                                        <td>$125,250</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Zorita Serrano</td>
                                        <td><span class="badge rounded-pill badge-light-success">Software Engineer</span>
                                        </td>
                                        <td>San Francisco</td>
                                        <td>56</td>
                                        <td>2012/06/01</td>
                                        <td>$115,000</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jennifer Acosta</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Junior Javascript
                                                Developer</span></td>
                                        <td>Edinburgh</td>
                                        <td>43</td>
                                        <td>2013/02/01</td>
                                        <td>$75,650</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cara Stevens</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Sales Assistant</span>
                                        </td>
                                        <td>New York</td>
                                        <td>46</td>
                                        <td>2011/12/06</td>
                                        <td>$145,600</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hermione Butler</td>
                                        <td><span class="badge rounded-pill badge-light-info">Regional Director</span>
                                        </td>
                                        <td>London</td>
                                        <td>47</td>
                                        <td>2011/03/21</td>
                                        <td>$356,250</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lael Greer</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Systems
                                                Administrator</span></td>
                                        <td>London</td>
                                        <td>21</td>
                                        <td>2009/02/27</td>
                                        <td>$103,500</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jonas Alexander</td>
                                        <td><span class="badge rounded-pill badge-light-success">Developer</span></td>
                                        <td>San Francisco</td>
                                        <td>30</td>
                                        <td>2010/07/14</td>
                                        <td>$86,500</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shad Decker</td>
                                        <td><span class="badge rounded-pill badge-light-info">Regional Director</span>
                                        </td>
                                        <td>Edinburgh</td>
                                        <td>51</td>
                                        <td>2008/11/13</td>
                                        <td>$183,000</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michael Bruce</td>
                                        <td><span class="badge rounded-pill badge-light-danger">Javascript
                                                Developer</span></td>
                                        <td>Singapore</td>
                                        <td>29</td>
                                        <td>2011/06/27</td>
                                        <td>$183,000</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Donna Snider</td>
                                        <td><span class="badge rounded-pill badge-light-primary">Customer Support</span>
                                        </td>
                                        <td>New York</td>
                                        <td>27</td>
                                        <td>2011/01/25</td>
                                        <td>$112,000</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                        <td>Action </td>
                                    </tr>
                                </tfoot>
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

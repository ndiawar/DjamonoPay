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
              <div class="card p-3" style="width: 18rem;">
                <!-- Solde masqué/affiché -->
                <h3 id="balance" class="text-center">
                    <span id="balanceValue">1542789 F</span>
                    <i class="bi bi-eye-slash" id="toggleBalance" onclick="toggleBalance()" style="cursor:pointer;"></i>
                </h3>

                <!-- QR Code -->
                <div class="text-center">
                    <img src="data:image/png;base64, {{ $qrCodeBase64 }}" alt="QR Code">
                </div>

                <!-- Bouton pour transférer (ouvre le modal) -->
                <div class="text-center mt-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#transferModal">
                        <i class="bi bi-send"></i> Transférez
                    </button>
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
                      <form action="/transfer" method="POST">
                          @csrf
                          <div class="mb-3">
                              <label for="recipient" class="form-label">Destinataire</label>
                              <input type="text" class="form-control" id="recipient" name="recipient" required>
                          </div>
                          <div class="mb-3">
                              <label for="amount" class="form-label">Montant</label>
                              <input type="number" class="form-control" id="amount" name="amount" required>
                          </div>
                          <button type="submit" class="btn btn-primary">Envoyer</button>
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
<script>
function toggleBalance() {
    const balance = document.getElementById('balanceValue');
    const icon = document.getElementById('toggleBalance');
    if (balance.style.display === 'none') {
        balance.style.display = 'inline';
        icon.className = 'bi bi-eye-slash';
    } else {
        balance.style.display = 'none';
        icon.className = 'bi bi-eye';
    }
}
</script>

@endsection

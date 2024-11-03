<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - DjomanoPay</title>
    @vite(['resources/css/register.css', 'resources/js/register.js'])
    <script defer src="{{ asset('js/form.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>

    <div class="background-blur"></div>
    
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
        </div>

        <h1>S’inscrire à DjomanoPay</h1>
        <p>Rejoignez DjomanoPay et profitez de paiements rapides et sécurisés !</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registrationForm">
            @csrf

            <div class="input-group">
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" name="nom" placeholder="Nom" value="{{ old('nom') }}" required pattern="[A-Za-z]+" title="Veuillez entrer uniquement des lettres sans espaces ni chiffres.">
                    <div class="error-message" id="nomError"></div>
                </div>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" 
                           name="prenom" 
                           placeholder="Prénom" 
                           value="{{ old('prenom') }}" 
                           required 
                           pattern="^([A-Za-zÀ-ÿ]+(?: [A-Za-zÀ-ÿ]+){0,2})$" 
                           title="Le prénom peut contenir jusqu'à trois mots avec des lettres uniquement, séparés par des espaces.">
                    <div class="error-message" id="prenomError"></div>
                </div>
                
            </div>

            <div class="input-group">
                <div class="input-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Adresse E-mail" value="{{ old('email') }}" required>
                    <div class="error-message" id="emailError"></div>
                </div>
                <div class="input-icon">
                    <i class="fas fa-phone"></i>
                    <input type="tel" 
                           name="telephone" 
                           placeholder="Téléphone" 
                           value="{{ old('telephone') }}" 
                           required 
                           pattern="^(70|75|76|77|78)[0-9]{7}$" 
                           title="Le numéro doit commencer par 70, 75, 76, 77 ou 78 et contenir exactement 9 chiffres.">
                    <div class="error-message" id="telephoneError"></div>
                </div>
                
            </div>

            <div class="input-group">
                <div class="input-icon">
                    <i class="fas fa-home"></i>
                    <input type="text" name="adresse" placeholder="Adresse" value="{{ old('adresse') }}" required>
                    <div class="error-message" id="adresseError"></div>
                </div>
                <div class="input-icon">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" required 
                           min="1000-01-01" max="2012-12-31">
                    <div class="error-message" id="dateNaissanceError"></div>
                </div>
                
                <div class="input-icon password-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Mot de passe" id="password" required pattern="^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$" title="Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.">
                    <div class="error-message" id="passwordError"></div>
                    <i class="fas fa-eye" id="togglePassword" style="cursor: pointer; position: absolute; right: -200px; top: 50%; transform: translateY(-50%);"></i>
                </div>
            </div>

            <div class="input-group">
                <div class="input-icon">
                    <i class="fas fa-id-card"></i>
                    <input type="text" name="numero_identite" placeholder="Numéro carte d'identité" value="{{ old('numero_identite') }}" required pattern="^[0-9]{14}$" title="Veuillez entrer un numéro d'identité valide (14 chiffres sans espaces).">
                    <div class="error-message" id="numeroIdentiteError"></div>
                </div>
                <div class="input-icon">
                    <i class="fas fa-users"></i>
                    <select name="role" required>
                        <option value="">Choisissez un rôle</option>
                        <option value="distributeur">Distributeur</option>
                        <option value="agent">Agent</option>
                    </select>
                    <div class="error-message" id="roleError"></div>
                </div>
            </div>

            <div class="input-group center">
                <div class="input-icon">
                    <i class="fas fa-file-image"></i>
                    <input type="file" name="photo" accept=".png, .jpeg" required>
                    <div class="error-message" id="photoError"></div>
                </div>
            </div>

            <button type="submit" class="btn-submit">S'inscrire</button>
            <button type="buutton" class="btn-submit"> <a href="{{ route('index') }}">Retour</a></button>
        </form>

        <footer>
            © 2024 DjomanoPay. Tous droits réservés.
        </footer>
    </div>

  <!-- Modal d'inscription réussie -->
  @if(session('success'))
  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="successModalLabel">Inscription réussie !</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  {{ session('success') }}
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>
              </div>
          </div>
      </div>
  </div>
  @endif

  <!-- JavaScript Bootstrap et jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
      // Afficher le modal d'inscription réussie automatiquement si session success est définie
      $(document).ready(function(){
          @if(session('success'))
              $('#successModal').modal('show');
          @endif
      });
  </script>

</div>


</body>
</html>
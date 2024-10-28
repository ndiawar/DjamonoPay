<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use App\Http\Controllers\ClientController;


class TransactionComponent extends Component

{

    public $recipient;
    public $amount;
    public $balance;

    protected $rules = [
        'recipient' => 'required|exists:clients,account_number',
        'amount' => 'required|numeric|min:1',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
// Logique pour effectuer le transfert
public function transfer()
{
    $this->validate();

    try {
        // Créer une instance du contrôleur
        $controller = new ClientController();

        // Appeler la méthode de transfert en passant les données
        $request = new Request([
            'numero_compte_source' => $this->recipient, // Assurez-vous d'ajouter une propriété pour le compte source
            'numero_compte_destination' => $this->recipientDestination, // Assurez-vous d'ajouter une propriété pour le compte destination
            'montant' => $this->amount,
        ]);

        // Appeler la méthode de transfert
        $response = $controller->transfertEntreClients($request);

        // Gérer le message de succès ou d'erreur
        if ($response instanceof \Illuminate\Http\RedirectResponse) {
            // Si c'est une redirection, on peut ajouter un message flash à Livewire
            session()->flash('message', 'Transfert réussi !');
            $this->reset(['recipient', 'amount']); // Réinitialiser les champs
            $this->dispatchBrowserEvent('close-modal'); // Fermer le modal
        }

    } catch (\Exception $e) {
        session()->flash('error', 'Erreur lors du transfert : ' . $e->getMessage());
    }
}

    public function render()
    {
        return view('livewire.transaction-component');
    }
}

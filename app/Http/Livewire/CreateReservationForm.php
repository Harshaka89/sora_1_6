<?php

namespace App\Http\Livewire;

use App\Models\Reservation;
use App\Models\Table;
use Livewire\Component;

class CreateReservationForm extends Component
{
    public $customer_name;
    public $customer_email;
    public $customer_phone;
    public $table_id;
    public $party_size;
    public $reservation_time;
    public $status = 'Confirmed'; // Default to Confirmed for manual entries

    public $tables = [];

    protected $rules = [
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'required|email|max:255',
        'customer_phone' => 'required|string|max:20',
        'table_id' => 'required|exists:tables,id',
        'party_size' => 'required|integer|min:1',
        'reservation_time' => 'required|date',
        'status' => 'required|in:Pending,Confirmed,Canceled,Seated',
    ];

    public function mount()
    {
        $this->tables = Table::orderBy('name')->get();
    }

    public function store()
    {
        $this->validate();

        Reservation::create([
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_phone' => $this->customer_phone,
            'table_id' => $this->table_id,
            'party_size' => $this->party_size,
            'reservation_time' => $this->reservation_time,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Reservation successfully created.');

        return redirect()->route('reservations.index');
    }

    public function render()
    {
        return view('livewire.create-reservation-form');
    }
}

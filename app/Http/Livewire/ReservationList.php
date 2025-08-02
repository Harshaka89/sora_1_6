<?php

namespace App\Http\Livewire;

use App\Models\Reservation;
use Livewire\Component;
use Livewire\WithPagination;

class ReservationList extends Component
{
    use WithPagination;

    public $status = '';
    public $sortBy = 'reservation_time';
    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortBy = $field;
    }

    public function updateStatus($reservationId, $newStatus)
    {
        $reservation = Reservation::findOrFail($reservationId);
        $reservation->status = $newStatus;
        $reservation->save();

        session()->flash('message', 'Reservation status for ' . $reservation->customer_name . ' updated to ' . $newStatus . '.');
    }

    public function render()
    {
        $reservations = Reservation::query()
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.reservation-list', [
            'reservations' => $reservations
        ]);
    }
}

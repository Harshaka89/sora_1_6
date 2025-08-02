<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ReservationList;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\Table; // Add Table model

class ReservationListTest extends TestCase
{
    use RefreshDatabase;

     /** @test */
    public function it_can_update_a_reservation_status()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // We need a table for the reservation factory to work
        Table::factory()->create(); 
        $reservation = Reservation::factory()->create(['status' => 'Pending']);

        Livewire::test(ReservationList::class)
            ->call('updateStatus', $reservation->id, 'Confirmed');

        $this->assertEquals('Confirmed', $reservation->fresh()->status);
    }
    
    /** @test */
    public function the_reservations_page_contains_the_livewire_component()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/reservations')
            ->assertSeeLivewire('reservation-list');
    }

    /** @test */
    public function it_displays_a_list_of_reservations()
    {
        Reservation::factory()->create(['customer_name' => 'John Doe']);
        Reservation::factory()->create(['customer_name' => 'Jane Smith']);

        Livewire::test(ReservationList::class)
            ->assertSee('John Doe')
            ->assertSee('Jane Smith');
    }

    /** @test */
    public function it_can_filter_reservations_by_status()
    {
        Reservation::factory()->create(['customer_name' => 'Confirmed Booking', 'status' => 'Confirmed']);
        Reservation::factory()->create(['customer_name' => 'Pending Booking', 'status' => 'Pending']);

        Livewire::test(ReservationList::class)
            ->set('status', 'Confirmed')
            ->assertSee('Confirmed Booking')
            ->assertDontSee('Pending Booking');
    }

    /** @test */
    public function it_can_sort_reservations_by_date()
    {
        Reservation::factory()->create(['customer_name' => 'Future Booking', 'reservation_time' => now()->addDay()]);
        Reservation::factory()->create(['customer_name' => 'Past Booking', 'reservation_time' => now()->subDay()]);

        Livewire::test(ReservationList::class)
            ->call('sortBy', 'reservation_time', 'asc')
            ->assertSeeInOrder(['Past Booking', 'Future Booking']);

        Livewire::test(ReservationList::class)
            ->call('sortBy', 'reservation_time', 'desc')
            ->assertSeeInOrder(['Future Booking', 'Past Booking']);
    }
}

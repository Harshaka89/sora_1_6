<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\CreateReservationForm;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateReservationFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_create_reservation_page_is_accessible()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/reservations/create')
            ->assertStatus(200)
            ->assertSeeLivewire('create-reservation-form');
    }

    /** @test */
    public function it_can_create_a_new_reservation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $table = Table::factory()->create(['capacity' => 4]);

        Livewire::test(CreateReservationForm::class)
            ->set('customer_name', 'John Doe')
            ->set('customer_email', 'john.doe@example.com')
            ->set('customer_phone', '1234567890')
            ->set('table_id', $table->id)
            ->set('party_size', 4)
            ->set('reservation_time', now()->addDay()->format('Y-m-d\TH:i'))
            ->call('store');

        $this->assertTrue(Reservation::where('customer_name', 'John Doe')->exists());
    }

    /** @test */
    public function customer_name_is_required()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(CreateReservationForm::class)
            ->set('customer_name', '')
            ->call('store')
            ->assertHasErrors(['customer_name' => 'required']);
    }

    /** @test */
    public function customer_email_is_required_and_must_be_a_valid_email()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(CreateReservationForm::class)
            ->set('customer_email', '')
            ->call('store')
            ->assertHasErrors(['customer_email' => 'required']);

        Livewire::test(CreateReservationForm::class)
            ->set('customer_email', 'not-an-email')
            ->call('store')
            ->assertHasErrors(['customer_email' => 'email']);
    }
}

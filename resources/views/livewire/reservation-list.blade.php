<div>
    <div class="flex justify-between items-center mb-4">
        <!-- Filter Dropdown -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Filter by Status:</label>
            <select wire:model="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">All Statuses</option>
                <option value="Pending">Pending</option>
                <option value="Confirmed">Confirmed</option>
                <option value="Seated">Seated</option>
                <option value="Canceled">Canceled</option>
            </select>
        </div>
        <!-- Create New Reservation Button -->
        <div>
            <a href="{{ route('reservations.create') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Create New Reservation
            </a>
        </div>
    </div>
    
    <!-- Session Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><a href="#" wire:click.prevent="sortBy('customer_name')">Customer Name</a></th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><a href="#" wire:click.prevent="sortBy('party_size')">Party Size</a></th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><a href="#" wire:click.prevent="sortBy('reservation_time')">Date & Time</a></th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><a href="#" wire:click.prevent="sortBy('status')">Status</a></th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($reservations as $reservation)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->customer_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->party_size }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('M d, Y @ h:i A') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @switch($reservation->status)
                                    @case('Pending') bg-yellow-100 text-yellow-800 @break
                                    @case('Confirmed') bg-green-100 text-green-800 @break
                                    @case('Seated') bg-blue-100 text-blue-800 @break
                                    @case('Canceled') bg-red-100 text-red-800 @break
                                @endswitch
                            ">{{ $reservation->status }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div x-data="{ open: false }" @click.away="open = false" class="relative inline-block text-left">
                                <div>
                                    <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                                        Actions
                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </button>
                                </div>
                                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                    <div class="py-1">
                                        @if($reservation->status !== 'Confirmed')<a href="#" wire:click.prevent="updateStatus({{ $reservation->id }}, 'Confirmed')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Mark as Confirmed</a>@endif
                                        @if($reservation->status !== 'Seated')<a href="#" wire:click.prevent="updateStatus({{ $reservation->id }}, 'Seated')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Mark as Seated</a>@endif
                                        @if($reservation->status !== 'Canceled')<a href="#" wire:click.prevent="updateStatus({{ $reservation->id }}, 'Canceled')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Mark as Canceled</a>@endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">No reservations found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $reservations->links() }}
    </div>
</div>

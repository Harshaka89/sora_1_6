<form wire:submit.prevent="store">
    <div class="space-y-6">
        <!-- Customer Name -->
        <div>
            <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
            <input type="text" wire:model.defer="customer_name" id="customer_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('customer_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Customer Email -->
        <div>
            <label for="customer_email" class="block text-sm font-medium text-gray-700">Customer Email</label>
            <input type="email" wire:model.defer="customer_email" id="customer_email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('customer_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Customer Phone -->
        <div>
            <label for="customer_phone" class="block text-sm font-medium text-gray-700">Customer Phone</label>
            <input type="tel" wire:model.defer="customer_phone" id="customer_phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('customer_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Table -->
        <div>
            <label for="table_id" class="block text-sm font-medium text-gray-700">Table</label>
            <select wire:model.defer="table_id" id="table_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">Select a Table</option>
                @foreach($tables as $table)
                    <option value="{{ $table->id }}">{{ $table->name }} (Capacity: {{ $table->capacity }})</option>
                @endforeach
            </select>
            @error('table_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Party Size -->
        <div>
            <label for="party_size" class="block text-sm font-medium text-gray-700">Party Size</label>
            <input type="number" wire:model.defer="party_size" id="party_size" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('party_size') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Reservation Time -->
        <div>
            <label for="reservation_time" class="block text-sm font-medium text-gray-700">Date and Time</label>
            <input type="datetime-local" wire:model.defer="reservation_time" id="reservation_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('reservation_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        
        <div>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Create Reservation
            </button>
        </div>
    </div>
</form>

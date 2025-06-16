<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Confirm Campaign Join</h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 p-6 border rounded bg-white shadow">
        <h3 class="text-lg font-bold mb-2">{{ $campaign->name }}</h3>
        <p class="text-gray-700 mb-2">{{ $campaign->description }}</p>
        <p class="text-sm text-gray-500 mb-4">Dungeon Master: {{ $campaign->owner->name }}</p>

        <form method="POST" action="{{ route('campaigns.join') }}">
            @csrf
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Confirm Join
            </button>

            <a href="{{ route('dashboard') }}" class="ml-4 text-sm text-gray-600 hover:underline">
                Cancel
            </a>
        </form>
    </div>
</x-app-layout>

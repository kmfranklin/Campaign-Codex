<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (session('success'))
    <div class="mb-4 text-green-600 font-semibold">
        {{ session('success') }}
    </div>
@endif

<h2 class="text-lg font-semibold mb-4">Your Campaigns</h2>

@if ($campaigns->isEmpty())
    <p class="text-gray-600">You are not a member of any campaigns yet.</p>
@else
    <ul class="space-y-4">
        @foreach ($campaigns as $campaign)
            <li class="p-4 border rounded shadow-sm bg-white">
                <h3 class="text-xl font-bold">{{ $campaign->name }}</h3>
                <p class="text-gray-700">{{ $campaign->description }}</p>
                <p class="text-sm text-gray-500 mt-1">Role: <strong>{{ $campaign->pivot->role }}</strong></p>
                <p class="text-sm text-gray-500">DM: {{ $campaign->owner->name }}</p>
            </li>
        @endforeach
    </ul>
@endif

</x-app-layout>

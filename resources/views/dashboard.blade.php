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

<a href="{{ route('campaigns.join.form') }}"
   class="inline-block mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
   + Join Campaign
</a>

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

                @if ($campaign->pivot->role === 'dm')
                    <p class="text-sm text-blue-600 mt-1">Slug: <code>{{ $campaign->slug }}</code></p>
                @endif
            </li>
        @endforeach
    </ul>
@endif

</x-app-layout>

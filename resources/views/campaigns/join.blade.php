<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Join a Campaign</h2>
    </x-slot>

    <div class="mt-4 max-w-xl mx-auto">
        <form method="POST" action="{{ route('campaigns.join.lookup') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Campaign Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="w-full mt-1 p-2 border rounded" required>

                @if ($errors->has('slug'))
                    <p class="text-sm text-red-600 mt-1">{{ $errors->first('slug') }}</p>
                @endif

                <p class="text-sm text-gray-500 mt-1">Ask your DM for the campaign slug.</p>
            </div>

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Join Campaign
            </button>
        </form>
    </div>
</x-app-layout>

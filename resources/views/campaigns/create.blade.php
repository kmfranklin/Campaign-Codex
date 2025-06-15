<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Create a Campaign</h2>
    </x-slot>

    <div class="mt-4 max-w-xl mx-auto">
        <form method="POST" action="{{ route('campaigns.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Campaign Name</label>
                <input type="text" name="name" class="w-full mt-1 p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" class="w-full mt-1 p-2 border rounded"></textarea>
            </div>

            <button
    type="submit"
    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow"
>
    Create Campaign
</button>
        </form>
    </div>
</x-app-layout>

@extends('layouts.public')

@section('title', 'Items')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Items</h1>

    @if ($items->count())
        <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($items as $item)
                <li class="bg-white shadow rounded p-4 hover:shadow-md transition">
                    <a href="{{ route('items.show', ['key' => $item->key]) }}" class="block font-semibold text-blue-600 hover:underline">
                      {{ $item->name }}
                    </a>
                    <p class="text-sm text-gray-500">
                      {{ ucwords(str_replace('-', ' ', $item->category ?? 'Misc')) }}
                    </p>
                </li>
            @endforeach
        </ul>

        <div class="mt-6">
            {{ $items->links() }}
        </div>
    @else
        <p>No items found.</p>
    @endif
@endsection

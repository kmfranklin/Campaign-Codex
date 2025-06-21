@extends('layouts.public')

@section('title', $item->name)

@section('content')
    <a href="{{ route('items.index') }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">&larr; Back to Items</a>

    <h1 class="text-3xl font-bold mb-2">{{ $item->name }}</h1>
    <p class="text-gray-600 italic mb-4">{{ ucfirst($item->category ?? 'Miscellaneous') }}</p>

    <div class="prose max-w-none">
        {!! nl2br(e($item->desc ?? 'No description available.')) !!}
    </div>
@endsection

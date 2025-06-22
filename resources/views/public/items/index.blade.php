@extends('layouts.public')

@section('title', 'Items')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
    <h1 class="text-2xl font-bold">Items</h1>

    <form method="GET" action="{{ route('items.index') }}" class="w-full md:w-auto">
        <div class="flex flex-wrap md:flex-nowrap items-end gap-4">

            {{-- Search --}}
            <div class="flex flex-col w-full sm:w-auto">
                <label for="search" class="text-sm font-semibold text-gray-600">Search</label>
                <input
                    type="text"
                    name="search"
                    id="search"
                    value="{{ request('search') }}"
                    placeholder="Search item names..."
                    class="rounded-md border-gray-300 focus:ring-0 focus:border-green-700 text-sm"
                />
            </div>

            {{-- Type Filter --}}
            <div class="flex flex-col w-full sm:w-auto">
                <label for="type" class="text-sm font-semibold text-gray-600">Type</label>
                <select
                    name="type"
                    id="type"
                    class="rounded-md border-gray-300 focus:ring-0 focus:border-green-700 text-sm"
                >
                    <option value="">All Types</option>
                    <option value="Armor" {{ request('type') === 'Armor' ? 'selected' : '' }}>Armor</option>
                    <option value="Weapon" {{ request('type') === 'Weapon' ? 'selected' : '' }}>Weapon</option>
                    <option value="Ammunition" {{ request('type') === 'Ammunition' ? 'selected' : '' }}>Ammunition</option>
                    <option value="Wondrous Item" {{ request('type') === 'Wondrous Item' ? 'selected' : '' }}>Wondrous Item</option>
                    <option value="Adventuring Gear" {{ request('type') === 'Adventuring Gear' ? 'selected' : '' }}>Adventuring Gear</option>
                    <option value="Tools" {{ request('type') === 'Tools' ? 'selected' : '' }}>Tools</option>
                    <option value="Poison" {{ request('type') === 'Poison' ? 'selected' : '' }}>Poison</option>
                </select>
            </div>

            {{-- Rarity Filter --}}
            <div class="flex flex-col w-full sm:w-auto">
                <label for="rarity" class="text-sm font-semibold text-gray-600">Rarity</label>
                <select
                    name="rarity"
                    id="rarity"
                    class="rounded-md border-gray-300 focus:ring-0 focus:border-green-700 text-sm"
                >
                    <option value="">All Rarities</option>
                    <option value="Common" {{ request('rarity') === 'Common' ? 'selected' : '' }}>Common</option>
                    <option value="Uncommon" {{ request('rarity') === 'Uncommon' ? 'selected' : '' }}>Uncommon</option>
                    <option value="Rare" {{ request('rarity') === 'Rare' ? 'selected' : '' }}>Rare</option>
                    <option value="Very Rare" {{ request('rarity') === 'Very Rare' ? 'selected' : '' }}>Very Rare</option>
                    <option value="Legendary" {{ request('rarity') === 'Legendary' ? 'selected' : '' }}>Legendary</option>
                    <option value="Artifact" {{ request('rarity') === 'Artifact' ? 'selected' : '' }}>Artifact</option>
                </select>
            </div>

            {{-- Attunement Filter --}}
            <div class="flex flex-col w-full sm:w-auto">
                <label for="attunement" class="text-sm font-semibold text-gray-600">Attunement</label>
                <select
                    name="attunement"
                    id="attunement"
                    class="rounded-md border-gray-300 focus:ring-0 focus:border-green-700 text-sm"
                >
                    <option value="">All</option>
                    <option value="1" {{ request('attunement') === '1' ? 'selected' : '' }}>Requires Attunement</option>
                    <option value="0" {{ request('attunement') === '0' ? 'selected' : '' }}>No Attunement</option>
                </select>
            </div>

            {{-- Filter / Reset --}}
            <div class="flex gap-2 mt-1 w-full sm:w-auto">
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-green-800 rounded-md hover:bg-green-900"
                >
                    Filter
                </button>

                <a
                    href="{{ route('items.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300"
                >
                    Reset
                </a>
            </div>
        </div>
    </form>
  </div>
</div>

{{-- Results --}}
    <div id="item-grid-wrapper">
        @if ($items->count())
        @include('public.items.partials.item-grid', ['items' => $items])
        @endif
    </div>

@endsection

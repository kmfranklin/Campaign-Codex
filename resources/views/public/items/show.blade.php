@php
    use League\CommonMark\CommonMarkConverter;
@endphp

@extends('layouts.public')

@section('title', $item->name)

@section('content')
    <a href="{{ route('items.index') }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">&larr; Back to Items</a>

    <h1 class="text-3xl font-bold mb-1">{{ $item->name }}</h1>
    <p class="text-sm text-gray-500 mb-6">
        {{ ucwords(str_replace('-', ' ', $item->category ?? 'Miscellaneous')) }}
        @if ($item->rarity)
            · <span class="capitalize">{{ str_replace('-', ' ', $item->rarity) }}</span>
        @endif
        @if ($item->requires_attunement)
            · <span class="text-orange-600">Requires Attunement</span>
        @endif
    </p>

    @if ($item->description)
        <x-markdown :content="$item->description" />
    @endif

    @if ($item->armor_stats)
        @php $stats = json_decode($item->armor_stats, true); @endphp

        <h2 class="text-xl font-semibold mt-6 mb-2">Armor Properties</h2>
        <ul class="list-disc pl-5 text-sm text-gray-700">
            <li>Base AC: {{ $stats['ac_base'] ?? '?' }}</li>
            <li>Add Dex Modifier: {{ $stats['ac_add_dexmod'] ? 'Yes' : 'No' }}</li>
            <li>Dex Cap: {{ $stats['ac_cap_dexmod'] ?? 'None' }}</li>
            <li>Stealth Disadvantage: {{ $stats['grants_stealth_disadvantage'] ? 'Yes' : 'No' }}</li>
            <li>STR Requirement: {{ $stats['strength_score_required'] ?? 'None' }}</li>
        </ul>
    @endif

    @php
        $hasDetails = $item->cost || $item->weight || $item->hit_dice || $item->hit_points || $item->nonmagical_attack_resistance || $item->nonmagical_attack_immunity;
    @endphp

    @if ($hasDetails)
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-2">Item Details</h2>
            <ul class="list-disc pl-5 text-sm text-gray-700 space-y-1">
                @if ($item->cost)
                    <li><strong>Cost:</strong> {{ number_format($item->cost, 2) }} gp</li>
                @endif

                @if ($item->weight)
                    <li><strong>Weight:</strong> {{ number_format($item->weight, 2) }} lb</li>
                @endif

                @if ($item->hit_dice || $item->hit_points)
                    <li><strong>Durability:</strong>
                        @if ($item->hit_dice)
                            {{ $item->hit_dice }}
                        @endif
                        @if ($item->hit_dice && $item->hit_points)
                            ({{ $item->hit_points }} HP)
                        @elseif ($item->hit_points)
                            {{ $item->hit_points }} HP
                        @endif
                    </li>
                @endif

                @if ($item->nonmagical_attack_resistance)
                    <li>Resistant to nonmagical attacks</li>
                @endif

                @if ($item->nonmagical_attack_immunity)
                    <li>Immune to nonmagical attacks</li>
                @endif
            </ul>
        </div>
    @endif

    @php
        $vuln = json_decode($item->damage_vulnerabilities, true);
        $res = json_decode($item->damage_resistances, true);
        $imm = json_decode($item->damage_immunities, true);
    @endphp

    @if (!empty($vuln) || !empty($res) || !empty($imm))
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-2">Damage Traits</h2>
            <ul class="list-disc pl-5 text-sm text-gray-700 space-y-1">
                @if (!empty($vuln))
                    <li><strong>Vulnerabilities:</strong> {{ implode(', ', $vuln) }}</li>
                @endif
                @if (!empty($res))
                    <li><strong>Resistances:</strong> {{ implode(', ', $res) }}</li>
                @endif
                @if (!empty($imm))
                    <li><strong>Immunities:</strong> {{ implode(', ', $imm) }}</li>
                @endif
            </ul>
        </div>
    @endif

@endsection

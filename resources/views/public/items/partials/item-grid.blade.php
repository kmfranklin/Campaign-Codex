<ul id="item-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
  @foreach ($items as $item)
    <li class="h-full">
      <a href="{{ route('items.show', ['key' => $item->key]) }}"
         class="h-full bg-white border border-gray-200 rounded-xl p-8 shadow-sm hover:shadow-lg transition duration-200 flex flex-col justify-between">

        @php
            $icon = match($item->category) {
                'armor', 'shield' => 'icon-shield',
                'ammunition' => 'icon-bow-arrow',
                'weapon' => 'icon-sword',
                'wondrous-item' => 'heroicon-o-sparkles',
                'adventuring-gear' => 'icon-backpack',
                'tools' => 'heroicon-o-wrench-screwdriver',
                'poison' => 'icon-potion',
                default => 'heroicon-o-cube',
            };
        @endphp

        <div class="flex items-start justify-between mb-2">
            <span class="text-lg font-semibold text-green-900 hover:no-underline font-title">
                {{ $item->name }}
            </span>
            <x-dynamic-component :component="$icon" class="w-5 h-5 text-green-700" />
        </div>

        @php
            $metaParts = [];
            if ($item->category) $metaParts[] = ucwords(str_replace('-', ' ', $item->category));
            if ($item->rarity) $metaParts[] = ucwords(str_replace('-', ' ', $item->rarity));
            if ($item->requires_attunement) $metaParts[] = '<span class="text-orange-600">Requires Attunement</span>';
        @endphp

        @if (!empty($metaParts))
            <p class="mt-auto text-sm text-gray-600 font-body">{!! implode(' · ', $metaParts) !!}</p>
        @endif
      </a>
    </li>
  @endforeach
</ul>

@if ($items->hasPages())
  <div class="mt-8 pagination-wrapper">
    {{ $items->links() }}
  </div>
@endif


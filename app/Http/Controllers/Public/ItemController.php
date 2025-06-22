<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
  /**
   * Display a list of public items.
   */
  public function index(Request $request)
  {
    $query = Item::query();

    // Search by name
    if ($request->filled('search')) {
      $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Filter by category/type
    if ($request->filled('type')) {
      $query->where('category', strtolower(str_replace(' ', '-', $request->type)));
    }

    // Filter by rarity
    if ($request->filled('rarity')) {
      $query->where('rarity', strtolower(str_replace(' ', '-', $request->rarity)));
    }

    // Filter by attunement
    if ($request->filled('attunement')) {
      if ($request->attunement === '1') {
        $query->where('requires_attunement', true);
      } elseif ($request->attunement === '0') {
        $query->where(function ($q) {
          $q->whereNull('requires_attunement')
            ->orWhere('requires_attunement', false);
        });
      }
    }

    $items = $query->orderBy('name')->paginate(20)->withQueryString();

    if ($request->ajax()) {
      return view('public.items.partials.item-grid', compact('items'))->render();
    }

    return view('public.items.index', compact('items'));
  }
}

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
    $items = Item::orderBy('name')->paginate(20);

    return view('public.items.index', compact('items'));
  }

  /**
   * Display a single item by slug.
   */
  public function show(string $key)
  {
    $item = Item::where('key', $key)->firstOrFail();

    return view('public.items.show', compact('item'));
  }
}

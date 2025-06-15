<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('campaigns.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
    ]);

    $campaign = Campaign::create([
      'name' => $request->name,
      'description' => $request->description,
      'slug' => Str::slug($request->name) . '-' . uniqid(),
      'owner_id' => auth()->id(),
    ]);

    $campaign->members()->attach(auth()->id(), [
      'role' => 'dm',
      'joined_at' => now(),
    ]);

    return redirect()->route('dashboard')->with('success', 'Campaign created!');
  }

  /**
   * Display the specified resource.
   */
  public function show(Campaign $campaign)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Campaign $campaign)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Campaign $campaign)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Campaign $campaign)
  {
    //
  }
}

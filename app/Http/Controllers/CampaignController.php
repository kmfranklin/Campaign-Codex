<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

  public function showJoinForm()
  {
    return view('campaigns.join');
  }

  public function lookup(Request $request)
  {
    $request->validate([
      'slug' => 'required|string|exists:campaigns,slug',
    ]);

    $campaign = Campaign::where('slug', $request->slug)->with('owner')->first();

    // Don't allow joining if you're already in
    if ($campaign->members()->where('user_id', auth()->id())->exists()) {
      return redirect()->route('dashboard')->with('success', 'You are already a member of that campaign.');
    }

    // Store the campaign ID temporarily in the session for confirmation
    session()->put('join_campaign_id', $campaign->id);

    return redirect()->route('campaigns.join.confirm');
  }

  public function confirm()
  {
    $campaignId = session('join_campaign_id');

    if (!$campaignId) {
      return redirect()->route('campaigns.join.form')->withErrors([
        'slug' => 'No campaign selected. Please enter a valid slug.',
      ]);
    }

    $campaign = Campaign::with('owner')->find($campaignId);

    if (!$campaign) {
      return redirect()->route('campaigns.join.form')->withErrors([
        'slug' => 'Campaign no longer exists.',
      ]);
    }

    return view('campaigns.confirm_join', compact('campaign'));
  }

  public function join()
  {
    $campaignId = session('join_campaign_id');

    if (!$campaignId) {
      return redirect()->route('campaigns.join.form')->withErrors([
        'slug' => 'No campaign selected. Please enter a valid slug.',
      ]);
    }

    $campaign = \App\Models\Campaign::find($campaignId);

    if (!$campaign) {
      return redirect()->route('campaigns.join.form')->withErrors([
        'slug' => 'Campaign no longer exists.',
      ]);
    }

    // Prevent duplicate joins
    if ($campaign->members()->where('user_id', auth()->id())->exists()) {
      return redirect()->route('dashboard')->with('success', 'You are already a member of this campaign.');
    }

    $campaign->members()->attach(auth()->id(), [
      'role' => 'player',
      'joined_at' => now(),
    ]);

    session()->forget('join_campaign_id');

    return redirect()->route('dashboard')->with('success', 'You joined the campaign successfully!');
  }
}

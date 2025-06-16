<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Document;

class DocumentSeeder extends Seeder
{
  public function run(): void
  {
    $response = Http::get('https://api.open5e.com/documents/');

    if ($response->ok()) {
      foreach ($response->json('results') as $doc) {
        Document::updateOrCreate(
          ['slug' => $doc['slug']],
          [
            'title' => $doc['title'],
            'url' => $doc['url'],
            'license' => $doc['license'],
            'description' => $doc['desc'],
            'author' => $doc['author'] ?? null,
            'organization' => $doc['organization'] ?? null,
            'version' => $doc['version'] ?? null,
            'copyright' => $doc['copyright'] ?? null,
            'license_url' => $doc['license_url'] ?? null,
            'v2_related_key' => $doc['v2_related_key'] ?? null,
          ]
        );
      }
    } else {
      $this->command->error('Failed to fetch documents from Open5e.');
    }
  }
}

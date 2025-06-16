<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Document;

class SpellSeeder extends Seeder
{
  public function run(): void
  {
    $allowedDocuments = ['wotc-srd', 'a5e'];
    $url = 'https://api.open5e.com/spells/';
    $next = $url;

    while ($next) {
      $response = Http::get($next);

      if (!$response->ok()) {
        $this->command->error("Failed to fetch spells from Open5e.");
        return;
      }

      $results = $response->json('results');

      foreach ($results as $spell) {
        // Only allow spells from specific documents
        if (!in_array($spell['document__slug'], $allowedDocuments)) {
          continue;
        }

        // Resolve document_id
        $document = Document::where('slug', $spell['document__slug'])->first();
        if (!$document) {
          $this->command->warn("Skipping '{$spell['name']}' — unknown document slug '{$spell['document__slug']}'");
          continue;
        }

        DB::table('spells')->updateOrInsert(
          ['slug' => $spell['slug']],
          [
            'document_id' => $document->id,
            'name' => $spell['name'],
            'slug' => $spell['slug'],
            'description' => $spell['desc'],
            'higher_level' => $spell['higher_level'],
            'page' => $spell['page'],
            'range' => $spell['range'],
            'target_range_sort' => $spell['target_range_sort'],
            'components' => $spell['components'],
            'requires_verbal_components' => $spell['requires_verbal_components'],
            'requires_somatic_components' => $spell['requires_somatic_components'],
            'requires_material_components' => $spell['requires_material_components'],
            'material' => $spell['material'],
            'can_be_cast_as_ritual' => $spell['can_be_cast_as_ritual'],
            'concentration' => $spell['requires_concentration'],
            'duration' => $spell['duration'],
            'casting_time' => $spell['casting_time'],
            'level' => $spell['level_int'],
            'level_text' => $spell['level'],
            'school' => $spell['school'],
            'classes' => $spell['dnd_class'],
            'spell_lists' => json_encode($spell['spell_lists']),
            'archetype' => $spell['archetype'],
            'circles' => $spell['circles'],
            'created_at' => now(),
            'updated_at' => now(),
          ]
        );
      }

      $next = $response->json('next');
    }

    $this->command->info('Spells imported successfully from allowed documents.');
  }
}

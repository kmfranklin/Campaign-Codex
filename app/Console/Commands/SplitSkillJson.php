<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SplitSkillJson extends Command
{
  protected $signature = 'open5e:split-skills 
                            {--path=storage/data/open5e/srd-2014/Skill.json : Path to original Skill.json}
                            {--output=storage/data/srd-2014/skills : Output directory for split files}';

  protected $description = 'Split Skill.json into individual JSON files';

  public function handle(): void
  {
    $path = base_path($this->option('path'));
    $outputDir = base_path($this->option('output'));

    if (!File::exists($path)) {
      $this->error("File not found: {$path}");
      return;
    }

    if (!File::exists($outputDir)) {
      File::makeDirectory($outputDir, 0755, true);
    }

    $json = json_decode(File::get($path), true);

    if (!is_array($json)) {
      $this->error("Invalid JSON structure.");
      return;
    }

    $count = 0;
    foreach ($json as $entry) {
      if (!isset($entry['pk'])) {
        continue;
      }

      $filename = $outputDir . '/' . $entry['pk'] . '.json';
      File::put($filename, json_encode($entry, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
      $count++;
    }

    $this->info("Split {$count} skill entries into {$outputDir}");
  }
}

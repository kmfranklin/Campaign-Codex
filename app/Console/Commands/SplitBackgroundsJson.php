<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SplitBackgroundsJson extends Command
{
  protected $signature = 'open5e:split-backgrounds
                          {--path=storage/data/open5e/srd-2014/Background.json}
                          {--output=storage/data/srd-2014/backgrounds}';

  protected $description = 'Splits Background.json into individual files';

  public function handle(): void
  {
    $inputPath = base_path($this->option('path'));
    $outputPath = base_path($this->option('output'));

    if (!File::exists($inputPath)) {
      $this->error("File not found: {$inputPath}");
      return;
    }

    if (!File::exists($outputPath)) {
      File::makeDirectory($outputPath, 0755, true);
    }

    $json = json_decode(File::get($inputPath), true);
    $count = 0;

    foreach ($json as $entry) {
      if (!isset($entry['pk'])) continue;

      $filename = "{$outputPath}/{$entry['pk']}.json";
      File::put($filename, json_encode($entry, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
      $count++;
    }

    $this->info("Split complete: {$count} files written to {$outputPath}");
  }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SplitRulesJson extends Command
{
  protected $signature = 'open5e:split-rules 
        {--path=storage/data/open5e/srd-2014/Rule.json : Path to the original Rule.json}
        {--output=storage/data/srd-2014/rules : Output directory for split files}';

  protected $description = 'Splits Open5e Rule.json into individual files';

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

      $slug = $entry['pk'];
      $filename = "{$outputPath}/{$slug}.json";
      File::put($filename, json_encode($entry, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
      $count++;
    }

    $this->info("Split complete: {$count} files written to {$outputPath}");
  }
}

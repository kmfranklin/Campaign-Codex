<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SplitClassFeaturesJson extends Command
{
  protected $signature = 'open5e:split-classfeatures 
                            {--path=storage/data/open5e/srd-2014/ClassFeature.json : Path to source JSON} 
                            {--output=storage/data/srd-2014/class_features : Output directory}';

  protected $description = 'Split ClassFeature.json into individual files';

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

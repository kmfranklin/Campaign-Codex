<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SplitItemJson extends Command
{
  protected $signature = 'open5e:split-items 
                            {--path=storage/data/open5e/srd-2014/Item.json : Path to original Item.json}
                            {--output=storage/data/srd-2014/items : Output directory for split files}';

  protected $description = 'Splits the Open5e Item.json file into one file per item';

  public function handle()
  {
    $path = base_path($this->option('path'));
    $outputDir = base_path($this->option('output'));

    if (!file_exists($path)) {
      return $this->error("File not found: $path");
    }

    $json = json_decode(file_get_contents($path), true);
    if (!is_array($json)) {
      return $this->error("Invalid JSON format in $path");
    }

    if (!is_dir($outputDir)) {
      File::makeDirectory($outputDir, 0755, true);
    }

    $count = 0;
    foreach ($json as $entry) {
      if (!isset($entry['model']) || $entry['model'] !== 'api_v2.item') {
        continue;
      }

      $key = $entry['pk'] ?? uniqid('item_');
      $filename = $outputDir . '/' . $key . '.json';
      file_put_contents($filename, json_encode($entry, JSON_PRETTY_PRINT));
      $count++;
    }

    $this->info("Split $count items into: $outputDir");
  }
}

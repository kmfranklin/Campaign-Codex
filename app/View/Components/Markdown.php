<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use League\CommonMark\CommonMarkConverter;

class Markdown extends Component
{
  public string $html;

  public function __construct(public ?string $content = '')
  {
    $converter = new CommonMarkConverter();
    $this->html = $converter->convert($content ?? '');
  }

  public function render(): View|Closure|string
  {
    return view('components.markdown');
  }
}

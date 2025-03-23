<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DisplayCardsGrid extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $items, public $genres = [], public $isMovie = true)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.display-cards-grid');
    }
}

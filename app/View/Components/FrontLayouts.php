<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontLayouts extends Component
{
    /**
     * Create a new component instance.
     */

    public $title ;

    public function __construct($title=null)
    {
        $this->title=$title ?? config('app.name')?? null;
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layout.front');
    }
}

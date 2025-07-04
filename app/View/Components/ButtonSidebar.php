<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ButtonSidebar extends Component
{
    /**
     * Create a new component instance.
     */

    public $icon;
    public $route;

    public function __construct($route, $icon)
    {
        $this->icon = $icon;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button-sidebar');
    }
}

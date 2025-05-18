<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ShiftButton extends Component
{
    public $type;
    public $id;
    public $disabled;
    /**
     * Create a new component instance.
     */
    public function __construct($type = 'primary', $id = '', $disabled = false)
    {
        $this->type = $type;
        $this->id = $id;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shift-button');
    }
}

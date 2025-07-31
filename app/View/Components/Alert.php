<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Mockery\Matcher\Type;

class Alert extends Component
{
    /**
     * Create a new component instance.
     */

    public $type, $errorr;
    public function __construct($type ='danger', $errorr = null)
    {
        $this->type = $type;
        $this->errorr = $errorr;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}

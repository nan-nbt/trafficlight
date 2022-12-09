<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Test extends Component
{
    public $name;
    public $section;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $section)
    {
        $this->name = $name;
        $this->section = $section;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.test');
    }
}

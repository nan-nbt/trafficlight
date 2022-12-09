<?php

namespace App\View\Components\Content\Report;

use Illuminate\View\Component;

class DataCollectionReport extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.content.report.data-collection-report');
    }
}

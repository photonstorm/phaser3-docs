<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ExamplesLink extends Component
{
    public $searchName;
    public $quantity;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($searchName = "", $quantity = 16)
    {
        //
        $this->searchName = $searchName;
        $this->quantity = $quantity;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.examples-link');
    }
}

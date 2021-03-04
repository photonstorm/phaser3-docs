<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SourceLinks extends Component
{
    public $metaFileRoute;
    public $metalineno;

    // Classes
    public $class;

    public function __construct($metaFileRoute, $metalineno)
    {
        $this->metaFileRoute = $metaFileRoute;
        $this->metalineno = $metalineno;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.docs.source-links');
    }
}

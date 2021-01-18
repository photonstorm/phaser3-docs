<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Aside extends Component
{
    public $title;
    public $namespaces;
    public $classes;
    public $members;
    public $membersConstants;
    public $methods;
    public $typedefs;
    public $events;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $title = '',
        $members = [],
        $membersConstants = [],
        $methods = [],
        $classes = [],
        $namespaces = [],
        $typedefs = [],
        $events = []
    )
    {
        $this->title = $title;
        $this->members = $members;
        $this->membersConstants = $membersConstants;
        $this->methods = $methods;
        $this->classes = $classes;
        $this->namespaces = $namespaces;
        $this->typedefs = $typedefs;
        $this->events = $events;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.aside');
    }
}

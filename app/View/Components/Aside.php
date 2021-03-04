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
    public $test;

    // Local variable
    public $aside_collection;
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
        $this->members = collect($members);
        $this->membersConstants = collect($membersConstants);
        $this->methods = collect($methods);
        $this->classes = collect($classes);
        $this->namespaces = collect($namespaces);
        $this->typedefs = collect($typedefs);
        $this->events = collect($events);

        $this->aside_collection = [];

        if(!$this->namespaces->isEmpty()) {
            array_push($this->aside_collection, [
                "type" => "namespaces",
                "show" => true,
                "data" => $this->namespaces->values()
            ]);
        }

        if(!$this->members->isEmpty()) {
            array_push($this->aside_collection, [
                "type" => "members",
                "show" => true,
                "data" => $this->members->values()
            ]);
        }

        if(!$this->membersConstants->isEmpty() ) {
            array_push($this->aside_collection, [
                "type" => "membersConstants",
                "show" => true,
                "data" => $this->membersConstants->values()
            ]);
        }

        if(!$this->methods->isEmpty()) {
            array_push($this->aside_collection, [
                "type" => "methods",
                "show" => true,
                "data" => $this->methods->values()
                ]);
        }

        if(!$this->classes->isEmpty()) {
            array_push($this->aside_collection, [
                "type" => "classes",
                "show" => true,
                "data" => $this->classes->values()
            ]);
        }

        if(!$this->typedefs->isEmpty()) {
            array_push($this->aside_collection, [
                "type" => "typedefs",
                "show" => true,
                "data" => $this->typedefs->values()
            ]);
        }

        if(!$this->events->isEmpty()) {
            array_push($this->aside_collection, [
                "type" => "events",
                "show" => true,
                "data" => $this->events->values()
            ]);
        }

        // dd($this->aside_collection);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.docs.aside');
    }
}

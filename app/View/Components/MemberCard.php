<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MemberCard extends Component
{
    public $method;
    public $params;
    public $since;
    public $metaFileRoute;
    public $metalineno;
    public $returnsdescription;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($method, Array $params = [], $since, $metaFileRoute, $metalineno, $returnsdescription = "")
    {
        //
        $this->method = $method;
        $this->params = $params;
        $this->since = $since;
        $this->metaFileRoute = $metaFileRoute;
        $this->metalineno = $metalineno;
        $this->returnsdescription = $returnsdescription;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.member-card');
    }
}

<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MemberCard extends Component
{
    public $method;
    public $params;
    public $scope; // If is static or not
    public $description;
    public $type;
    public $since;
    public $metaFileRoute;
    public $metalineno;
    public $defaultValue;
    public $returnsdescription;
    public $returnstype;

    public function __construct($method = "", $description = "", $scope = "", $type = "", Array $params = [], $since, $metaFileRoute, $metalineno, $defaultValue = "", $returnsdescription = "", $returnstype = "")
    {
        //
        $this->method = $method;
        $this->description = $description;
        $this->scope = $scope;
        $this->type = $type;
        $this->params = $params;
        $this->since = $since;
        $this->metaFileRoute = $metaFileRoute;
        $this->metalineno = $metalineno;
        $this->defaultValue = $defaultValue;
        $this->returnsdescription = $returnsdescription;
        $this->returnstype = $returnstype;
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

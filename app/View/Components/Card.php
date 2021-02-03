<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $collection;
    public $focus;
    public $id;
    public $isFocusRoute;

    // Members used by card
    public $table_name;
    public $metaFileRoute = "";

    public function __construct($id = '', $collection, bool $focus = false, bool $isFocusRoute = FALSE)
    {
        $this->collection = $collection;
        $this->focus = $focus;
        $this->id = $id;
        $this->isFocusRoute = $isFocusRoute;

        // Members used by card
        $this->metaFileRoute = "$collection->metapath/$collection->metafilename";
    }

    public function getTableName()
    {
        return $this->collection->getTable() ?? '';
    }

    public function getAccess()
    {
        $scope_out = '';
        if ($this->collection->scope == 'static') {
            $scope_out .= 'static';
        }

        if($this->collection->access == 'private') {
            if (!empty($scope_out)) {
                $scope_out .= ', ';
            }
            $scope_out .= 'private';
        }

        if($this->collection->access == 'protected') {
            if (!empty($scope_out)) {
                $scope_out .= ', ';
            }
            $scope_out .= 'protected';
        }

        if ($this->collection->readOnly == '1') {
            if (!empty($scope_out)) {
                $scope_out .= ', ';
            }
            $scope_out .= 'readonly';
        }

        if ($this->getTableName() == 'constants') {
            if (!empty($scope_out)) {
                $scope_out .= ', ';
            }
            $scope_out .= 'constant';
        }

        if ($this->collection->nullable == "1") {
            if (!empty($scope_out)) {
                $scope_out .= ', ';
            }
            $scope_out .= 'nullable';
        }

        if(!empty($scope_out)) {
            $scope_out = "<$scope_out>";
        }
        return $scope_out;
    }


    public function create_table_params_properties() {
        $table = [
            "name" => FALSE,
            "type" => FALSE,
            "arguments" => FALSE,
            "defaultValue" => FALSE,
            "description" => FALSE
        ];

        $params_or_properties = [];

        if (!empty($this->collection->params)) {
            $params_or_properties = $this->collection->params;
        }

        if (!empty($this->collection->properties)) {
            $params_or_properties = $this->collection->properties;
        }

        foreach($params_or_properties as $key => $param_or_property) {
            foreach($table as $key => $value) {
                if(!$table[$key]) {
                    $table[$key] = !empty($param_or_property[$key]);
                }
            }
            if(!$table['arguments']) {
                $table['arguments'] = ($param_or_property['optional'] == 1);
            }
        }
        return $table;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.card');
    }
}

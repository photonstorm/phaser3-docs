<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MemberCard extends Component
{
    public $id;
    // The kind of card, IE: typedef, constant, member, class, etc..
    public $kind;
    // Name of element
    public $name;
    // the long name is an id
    public $longname;
    // parameters. Is an array [] ? Use: :params
    public $params;
    // Properties. Is an array [] ?. Use: :properties
    public $properties;
    // The scope, IE: If is static, protected, etc..
    public $scope;
    // Description of element
    public $description;
    // Type (some cards like member)
    public  $type;
    // Types is used for create the types IE: number | Array.<Phaser.GameObjects..>. use: :types
    public $types;
    public $since;
    public $metaFileRoute;
    public $metalineno;
    public $defaultValue;
    public $returnsdescription;
    public $returnstype;
    public $overrides;
    public $nullable;
    public $inherits;
    public $fires;
    public $examples;
    // set if the card have focus link
    public $focus;
    public $access;
    public $shortname;

    public function __construct(
        $id = "",
        $kind = "",
        $name = "",
        $description = "",
        $scope = "",
        $type = "",
        $types = "",
        Array $params = [],
        Array $properties = [],
        $since = "3.0.0",
        $metaFileRoute = "",
        $metalineno = 0,
        $defaultValue = "",
        $returnsdescription = "",
        $returnstype = "",
        $overrides = "",
        $nullable = "0",
        $inherits = "",
        $fires = "",
        $longname = "",
        $examples = [],
        $focus = false,
        $access = '',
        $shortname = ''
    )
    {
        $this->id = $id;
        $this->kind = $kind;
        $this->name = $name;
        $this->description = $description;
        $this->scope = $scope;
        $this->type = $type;
        $this->types = $types;
        $this->params = $params;
        $this->properties = $properties;
        $this->since = $since;
        $this->metaFileRoute = $metaFileRoute;
        $this->metalineno = $metalineno;
        $this->defaultValue = $defaultValue;
        $this->returnsdescription = $returnsdescription;
        $this->returnstype = $returnstype;
        $this->overrides = $overrides;
        $this->nullable = $nullable;
        $this->inherits = $inherits;
        $this->fires = $fires;
        $this->longname = $longname;
        $this->examples = $examples;
        $this->focus = $focus;
        $this->access = $access;
        $this->shortname = $shortname;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.docs.member-card');
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

        if (count($this->params) > 0 ) {
            $params_or_properties = $this->params;
        }

        if (count($this->properties) > 0 ) {
            $params_or_properties = $this->properties;
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
}

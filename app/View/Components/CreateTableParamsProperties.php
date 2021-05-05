<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CreateTableParamsProperties extends Component
{
    public $id;
    public $collection;
    public $metaFileRoute = "";
    public $focus = false;

    public function __construct(
        $id = "",
        $collection
    )
    {
        $this->id = $id;
        $this->collection = $collection;

        $this->metaFileRoute = "$collection->metapath/$collection->metafilename";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.docs.create-table-params-properties');
    }

    public function create_table_params_properties()
    {
        $table = [
            "name" => FALSE,
            "type" => FALSE,
            "arguments" => FALSE,
            "defaultValue" => FALSE,
            "description" => FALSE
        ];

        $params_or_properties = [];

        if (!collect($this->collection->params)->isEmpty())
        {
            $params_or_properties = $this->collection->params;
        }

        if (!collect($this->collection->properties)->isEmpty())
        {
            $params_or_properties = $this->collection->properties;
        }

        foreach ($params_or_properties as $key => $param_or_property)
        {
            foreach ($table as $key => $value)
            {
                if (!$table[$key])
                {
                    $table[$key] = !empty($param_or_property[$key]);
                }
            }
            if (!$table['arguments'])
            {
                $table['arguments'] = ($param_or_property['optional'] == 1);
            }
        }
        return $table;
    }
}

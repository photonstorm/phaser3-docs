<div {{ $attributes }}>
    @php
        $param_join = resolve('get_params_format')($params);
    @endphp
    @if (!empty($name))
    <ul class="h4">
        <li>
            <span class="text-danger">
                @if ($scope == "static" || $scope == "protected" || $scope == "readonly" || $kind == "constant" || $nullable == "1" )
                    @php
                        $scope_out = '';
                        if ($scope == 'static') {
                            $scope_out .= 'static';
                        }

                        if ($scope == 'protected') {
                            if (!empty($scope_out)) {
                                $scope_out .= ', ';
                            }
                            $scope_out .= 'protected';
                        }

                        if ($scope == 'readonly') {
                            if (!empty($scope_out)) {
                                $scope_out .= ', ';
                            }
                            $scope_out .= 'readonly';
                        }

                        if ($kind == 'constant') {
                            if (!empty($scope_out)) {
                                $scope_out .= ', ';
                            }
                            $scope_out .= 'constant';
                        }

                        if ($nullable == "1" ) {
                            if (!empty($scope_out)) {
                                $scope_out .= ', ';
                            }
                            $scope_out .= 'nullable';
                        }
                    @endphp
                    {{"<".$scope_out.">"}}
                @endif

                @if ($kind === "typedef")
                    @if (strtolower($type) == 'function')
                        {{($scope == "static") ? "<static>" : "" }} {{ htmlspecialchars_decode($name) }}({{$param_join}})
                    @elseif (strtolower($type) == 'object')
                        {{($scope == "static") ? "<static>" : "" }} {{ htmlspecialchars_decode($name) }}
                    @endif
                @else
                    {{ htmlspecialchars_decode($name) }}
                @endif
                @if ($kind === "constant" || $kind === "member")
                    :{!! resolve('get_types')($types) !!}
                @endif
            </span>
        </li>
    </ul>
    @endif
    @if (!empty($description))
    <div class="pl-3">
        <span class="font-weight-bold">Description:</span> {{$description}}
    </div>
    @endif
    @if (!empty($type))
    <div class="pl-3">
        Type: {{$type}}
    </div>
    @endif
    @if (count($properties) > 0)
    <h5>
        Properties:
    </h5>
    <table class="table border-bottom border-dark">
        <thead class="thead-dark">
            <tr>
                    @foreach ($create_table_params_properties as $key => $value)
                        @if($value)
                            @if($key == 'defaultValue')
                                <th scope="col">Default</th>
                            @else
                                <th scope="col">{{$key}}</th>
                            @endif
                        @endif
                    @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($properties as $property)
            <tr>
                @if ($create_table_params_properties()['name'])
                    {{-- Name --}}
                    <th scope="row">{{ $property->name }}</th>
                @endif
                @if ($create_table_params_properties()['type'])
                {{-- Type --}}
                <td>
                    {!!  resolve('get_types')($property)  !!}
                </td>
                @endif
                @if ($create_table_params_properties()['arguments'])
                {{-- Arguments --}}
                <td>
                    @if ($property->optional == 1)
                    {{"<optional>"}}
                    @endif
                </td>
                @endif
                @if ($create_table_params_properties()['defaultValue'])
                {{-- Default --}}
                <td>{{$property->defaultValue}}</td>
                @endif
                @if ($create_table_params_properties()['description'])
                {{-- Description --}}
                <td>{{$property->description}}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    @if (count($params) > 0)
        <h5>
            Parameters:
        </h5>
        <table class="table border-bottom border-dark">
            <thead class="thead-dark">
                <tr>
                    @foreach ($create_table_params_properties as $key => $value)
                        @if($value)
                            @if($key == 'defaultValue')
                                <th scope="col">Default</th>
                            @else
                                <th scope="col">{{$key}}</th>
                            @endif
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($params as $param)
                <tr>
                    @if ($create_table_params_properties()['name'])
                        {{-- Name --}}
                        <th scope="row">{{ $param->name }}</th>
                    @endif
                    @if ($create_table_params_properties()['type'])
                        {{-- Type --}}
                        <td>
                            {!!  resolve('get_types')($param)  !!}
                        </td>
                    @endif
                    @if ($create_table_params_properties()['arguments'])
                        {{-- Arguments --}}
                        <td>
                            @if ($param->optional == 1)
                            {{"<optional>"}}
                            @endif
                        </td>
                    @endif
                    @if ($create_table_params_properties()['defaultValue'])
                        {{-- Default --}}
                        <td>{{$param->defaultValue}}</td>
                    @endif
                    @if ($create_table_params_properties()['description'])
                        {{-- Description --}}
                        <td>{{$param->description}}</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    @if(!empty($returnsdescription))
    <div class="pl-3">
        <div class="text-info">Returns:</div>
        <div class="pl-4">{{$returnsdescription}}</div>
    </div>
    @endif
    @if(!empty($returnstype))
    <div class="pl-3">
        <div class="text-info">Type:</div>
        <div class="pl-4">{{$returnstype}}</div>
    </div>
    @endif
    @if (!empty($defaultValue))
    <div class="text-info font-weight-bold pl-3">
        <div class="text-info">Default: {{$defaultValue}}</div>
    </div>
    @endif
    @if(!empty($inherits))
    <div>Inherited from: {{$inherits}}</div>
    @endif
    @if(!empty($overrides))
    <div>Overrides: {{$overrides}}</div>
    @endif
    @if(!empty($fires))
    <div>Fires: {{$fires}}</div>
    @endif
    <div class="text-danger">Since: {{$since}}</div>
    <x-source-links metaFileRoute={{$metaFileRoute}} metalineno={{$metalineno}}/>
</div>

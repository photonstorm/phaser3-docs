@if (!collect($collection->properties)->isEmpty())
        <h5>
            Properties:
        </h5>
        <table class="table table-light table-striped table-bordered shadow-sm">
            <thead class="thead-light">
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
                @foreach ($collection->properties as $property)
                <tr>
                    {{-- Name --}}
                    @if ($create_table_params_properties()['name'])
                        <th scope="row">{{ $property->name }}</th>
                    @endif
                    {{-- Type --}}
                    @if ($create_table_params_properties()['type'])
                    <td>
                        {!! resolve('get_types')($property) !!}
                    </td>
                    @endif
                    {{-- Arguments --}}
                    @if ($create_table_params_properties()['arguments'])
                    <td>
                        @if ($property->optional == 1)
                        {{"<optional>"}}
                        @endif
                    </td>
                    @endif
                    {{-- Default --}}
                    @if ($create_table_params_properties()['defaultValue'])
                        <td>{{$property->defaultValue}}</td>
                    @endif
                    @if ($create_table_params_properties()['description'])
                    {{-- Description --}}
                    <td>
@markdown
{!! $property->description !!}
@endmarkdown
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif


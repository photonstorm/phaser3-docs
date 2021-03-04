@if (!collect($collection->params)->isEmpty())
    <h4>
        Parameters:
    </h4>
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
            @foreach ($collection->params as $param)
            <tr>
                {{-- Name --}}
                @if ($create_table_params_properties()['name'])
                    <th scope="row">{{ $param->name }}</th>
                @endif
                {{-- Type --}}
                @if ($create_table_params_properties()['type'])
                    <td>
                        {!! resolve('get_types')($param) !!}
                    </td>
                @endif
                {{-- Arguments --}}
                @if ($create_table_params_properties()['arguments'])
                    <td>
                        @if ($param->optional == 1)
                        {{"<optional>"}}
                        @endif
                    </td>
                @endif
                {{-- Default --}}
                @if ($create_table_params_properties()['defaultValue'])
                    <td>{{$param->defaultValue}}</td>
                @endif
                {{-- Description --}}
                @if ($create_table_params_properties()['description'])
                    <td>
@markdown
{!! $param->description !!}
@endmarkdown
                    </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
@endif

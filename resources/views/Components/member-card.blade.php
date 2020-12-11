<div {{ $attributes }}>
    <ul class="h4">
        <li>
            <span class="text-danger">{{ htmlspecialchars_decode($method) }}</span>
        </li>
    </ul>
    @if (!empty($description))
    <div class="pl-3">
        Description: {{$description}}
    </div>
    @endif
    @if (!empty($type))
    <div class="pl-3">
        Type: {{$type}}
    </div>
    @endif
    @if (count($params))
        <h5>
            Parameters:
        </h5>
        <table class="table border-bottom border-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Arguments</th>
                    <th scope="col">Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($params as $param)
                <tr>
                    <th scope="row">{{ $param->name }}</th>
                    <td>
                        @if (resolve('get_namespace_class_link')($param->type) === 'class')
                            <a class="text-info" href="/namespace/{{$param->type}}">{{$param->type}}</a>
                        @elseif (resolve('get_namespace_class_link')($param->type) === 'namespace')
                            <a class="text-danger" href="/class/{{$param->type}}">{{$param->type}}</a>
                        @else
                            {{$param->type}}
                        @endif
                    </td>
                    <td>
                        @if ($param->optional == 1)
                        {{"<optional>"}}
                        @endif
                    </td>
                    <td>{{$param->description}}</td>
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
    @if (!empty($defaultValue))
    <div class="text-info font-weight-bold pl-3">
        <div class="text-info">Default: {{$defaultValue}}</div>
    </div>
    @endif
    <div class="text-danger">Since: {{$since}}</div>
    <x-source-links metaFileRoute={{$metaFileRoute}} metalineno={{$metalineno}}/>
</div>

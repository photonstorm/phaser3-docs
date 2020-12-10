<div class="border-bottom border-danger mt-4 pt-2 pb-4">
    <ul class="h4">
        <li>
            <span class="text-danger">{{$method}}</span>
        </li>
    </ul>
    @if (count($params))
        <h5>
            Parameters:
        </h5s>
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
                    <td>{{$param->type}}</td>
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
    <div class="p2-3">
        <div class="text-info">Returns:</div>
        <div class="pl-4">{{$returnsdescription}}</div>
    </div>
    @endif
    <div class="text-danger">Since: {{$since}}</div>
    <div class="text-danger">Source:
        <a href="https://github.com/photonstorm/phaser/blob/{{config('app.actual_phaser_version')}}/src/{{$metaFileRoute}}">src/{{$metaFileRoute}}</a>
        <a href="https://github.com/photonstorm/phaser/blob/{{config('app.actual_phaser_version')}}/src/{{$metaFileRoute}}#L{{$metalineno}}">(Line {{$metalineno}})</a>
    </div>
</div>

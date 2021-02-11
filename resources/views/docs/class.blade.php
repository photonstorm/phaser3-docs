@extends('layouts.docs.page')

@section('title', $class->longname)

@section('content')

<h1>
@foreach ($namesplit as $parts)
    <a href="/{{ $version }}/{{ $parts[0] }}">{{ $parts[1] }}</a> {{ $parts[2] }}
@endforeach
</h1>

<pre><code>Source file: {{ $class->metapath }}/{{ $class->metafilename }}</code></pre>
<pre><code>Added in Phaser v{{ $class->since }}</code></pre>

<sl-details summary="Class Description" open>
@markdown
{!! $class->description !!}
@endmarkdown
</sl-details>


<sl-details summary="Constructor" open>

<h3>Constructor:</h3>

@markdown
```javascript
new {{ $class->name }}({{ $classConstructor }})
```
@endmarkdown

</sl-details>





@endsection

@section('aside')
    <x-aside
        class="w-100"
        title="Class: {{$class->name}}"
        :membersConstants="$membersConstants"
        :members="$members"
        :methods="$methods"
        :version="$version"
    />
@endsection

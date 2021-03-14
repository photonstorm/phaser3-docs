@if(!empty($collection->examples))
<div>
    <span class="font-weight-bold">Examples:</span>
    @foreach ($collection->examples->all() as $example)
@markdown
```javascript
{!! $example !!}
```
@endmarkdown
    @endforeach
</div>
@endif

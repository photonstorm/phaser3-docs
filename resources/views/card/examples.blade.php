@if(!empty($examples))
        <div>
            <span class="font-weight-bold">Examples:</span>
            <ul>
                @foreach ($collection->getExamples->all() as $example)
                    <li>

@markdown
```javascript
{{$example->example}}
```
@endmarkdown
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

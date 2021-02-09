@if ($isFocusRoute)
    <div {{ $attributes }}>
@else
    <div {{ $attributes->merge([
        'class' => ( (($collection->access == 'private') ? 'private hide-card' : '' ) .' '. (($collection->access == 'protected') ? 'protected' : '' ) .' '. ((!empty($collection->inherits)) ? 'inherited' : ''))
    ]) }}>
@endif

    @include('card.name')
    @include('card.description')
    @include('card.parameters')
    @include('card.properties')
    @include('card.type')
    @include('card.returns')
    @include('card.default-value')
    @include('card.inherited-from')
    @include('card.overrides')
    @include('card.fires')
    @include('card.listens')
    @include('card.examples')
    @include('card.source')

</div>

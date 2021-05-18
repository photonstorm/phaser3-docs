@if ($isFocusRoute)
<div id="{{ $id }}" {{ $attributes }}>
@else
<div id="{{ $id }}" {{ $attributes->merge([
    'class' => (
        (($collection->access == 'private') ? 'private hide-card' : '' ) .
        (($collection->webgl == '1') ? 'webglonly' : '' ) .
        (($collection->access == 'protected') ? 'protected' : '' ) .
        ((!empty($collection->inherits)) ? 'inherited' : ''))
]) }}>
@endif
    @include('components.docs.card.parts.name')
    @include('components.docs.card.parts.description')
    @include('components.docs.card.parts.parameters')
    @include('components.docs.card.parts.properties')
    @include('components.docs.card.parts.type')
    @include('components.docs.card.parts.returns')
    @include('components.docs.card.parts.default-value')
    @include('components.docs.card.parts.inherited-from')
    @include('components.docs.card.parts.overrides')
    @include('components.docs.card.parts.fires')
    @include('components.docs.card.parts.listens')
    @include('components.docs.card.parts.examples')
    @include('components.docs.card.parts.source')
</div>

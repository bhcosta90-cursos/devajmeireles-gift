<div>
    <x-ts-select.styled
        :label="__('Item')"
        :request="route('api.items')"
        select="label:name|value:id"
        {{ $attributes }}
    />
</div>

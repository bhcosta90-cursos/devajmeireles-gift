<div>
    <x-ts-select.styled
        :label="__('Category')"
        :request="route('api.categories')"
        select="label:name|value:id"
        {{ $attributes }}
    />
</div>

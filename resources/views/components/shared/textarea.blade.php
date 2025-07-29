@props([
    'label' => '',
    'name' => '',
    'rows' => 2,
    'placeholder' => '',
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label fw-semibold">{{ $label }}</label>
    @endif
    <textarea 
        id="{{ $name }}" 
        name="{{ $name }}" 
        rows="{{ $rows }}" 
        {{ $attributes->merge(['class' => 'form-control']) }}
        placeholder="{{ $placeholder ?: 'Ingrese ' . strtolower($label) }}"
    >{{ old($name) }}</textarea>
</div>
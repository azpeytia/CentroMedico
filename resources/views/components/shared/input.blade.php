@props([
    'type' => 'text',
    'label' => '',
    'name' => '',
    'placeholder' => '',
    'step' => null,
    'unit' => null,
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label fw-semibold">{{ $label }}</label>
    @endif

    <div class="input-group">
        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            {{ $attributes->merge(['class' => 'form-control']) }}
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($step) step="{{ $step }}" @endif
            value="{{ old($name) }}"
        >
        @if($unit)
            <span class="input-group-text">{{ $unit }}</span>
        @endif
    </div>
</div>
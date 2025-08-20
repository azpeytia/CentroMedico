@props([
    'type' => 'submit',
    'icon' => 'bi-save',
    'label' => 'Salvar',
])

<button type="{{ $type }}"
    id="saveButton"
    {{ $attributes->merge(['class' => 'btn btn-primary shadow-sm d-inline-flex align-items-center gap-2 me-1']) }}>
    <i class="bi {{ $icon }}"></i>
    {{ trim($slot) ?: $label }}
</button>
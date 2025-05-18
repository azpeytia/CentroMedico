<button 
    type="submit" 
    class="btn btn-{{ $type }} btn-lg w-100" 
    id="{{ $id }}" 
    @if($disabled) disabled @endif
>
    {{ $slot }}
</button>
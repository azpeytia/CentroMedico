@extends('layouts.main')

@section('title', 'Inventarios')

@section('content')
    <div class="container" id="restock-inventory">
        <h1>Reabastecer productos vendidos</h1>
        <form>
            <div>
                <div class="d-flex align-items-start gap-2 flex-wrap mb-2">
                    <input type="text" class="form-control" id="gtinBarCode" name="gtinBarCode" placeholder="Código" style="max-width: 200px;">
                    <input type="text" class="form-control" id="product" name="product" value="" placeholder="Producto" readonly style="flex: 1;">
                    <button type="button" class="btn btn-secondary" id="search">Buscar</button>
                </div>
                <div class="form-text">Captura el código de barras del producto vendido.</div>

                <input type="number" class="form-control mt-2" id="quantity" name="quantity" placeholder="Cantidad">
                <div class="form-text">Ingresa la cantidad de productos a reabastecer</div>
            </div>
            <input type="hidden" id="product_id" value="">
            <button type="submit" class="btn btn-primary" id="restock">Reabastecer</button>
        </form>
    </div>
@endsection

<script>
    window.dashboardUrl = "{{ route('dashboard') }}";
</script>

@push('scripts')
    <script src="{{ asset('js/restock-inventory.js') }}" type="module"></script>
@endpush
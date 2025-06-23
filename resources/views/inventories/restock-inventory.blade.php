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
            <a href="{{ route('dashboard') }}" class="btn btn-danger">Cancelar</a>
        </form>
    </div>
    <!-- Modal para busqueda de productos -->
    <div class="modal fade" id="searchProductModal" tabindex="-1" aria-labelledby="searchProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchProductModalLabel">Buscar producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="searchProductInput" class="form-control mb-3" placeholder="Escribe el nombre del producto">
                    <ul id="searchProductList" class="list-group">
                        <!-- Lista de productos se llenará dinámicamente -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    window.dashboardUrl = "{{ route('dashboard') }}";
</script>

@push('scripts')
    <script src="{{ asset('js/restock-inventory.js') }}" type="module"></script>
@endpush
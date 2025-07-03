@extends('layouts.main')

@section('title', 'Inventario - Requisición')

@section('content')
    <div class="container" id="inventory-requisition">
        <h1 class="mb-4">Requisición de inventario</h1>
        <div class="row mb-3">
            <div class="col-12 d-flex flex-wrap align-items-center">
                <div class="btn-group flex-wrap" role="group" aria-label="Acciones">
                    <button type="submit" class="btn btn-primary mb-2 me-2" id="btnExportExcel">Exportar a Excel</button>
                    <button type="submit" class="btn btn-success mb-2 me-2" id="btnExportPDF">Exportar a PDF</button>
                    <button type="submit" class="btn btn-secondary mb-2 me-2" id="btnSendEmail">Enviar a correo</button>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('dashboard') }}" class="btn btn-danger mb-2">Cancelar</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="productTable" class="table table-bordered table-striped table-sm w-100">
            </table>
        </div>
    </div>
@endsection

<script>
    window.dashboardUrl = "{{ route('dashboard') }}";
</script>
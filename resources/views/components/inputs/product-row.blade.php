<div class="row product-row g-2 align-items-stretch">
    <div class="col-12 col-sm-6 col-md-5">
        <!-- <label for="inputSaleProduct" class="form-label">Producto</label> -->
        <input id="inputSaleProduct" type="text" class="inputSaleProduct form-control" placeholder="Producto">
        <div class="product-suggestions mt-1">
            <!-- Aquí se mostrarán las sugerencias -->
        </div>
    </div>
    <div class="col-6 col-sm-3 col-md-2">
        <!-- <label for="inputSaleQuantity" class="form-label">Cantidad</label> -->
        <input id="inputSaleQuantity" type="text" class="inputSaleQuantity form-control" placeholder="Cantidad">
    </div>
    <div class="col-6 col-sm-3 col-md-2">
        <!-- <label for="inputSaleProductPrice" class="form-label">Precio</label> -->
        <input id="inputSaleProductPrice" type="text" class="inputSaleProductPrice form-control" placeholder="Precio" readonly>
    </div>
    <div class="col-12 col-sm-3 col-md-2">
        <!-- <label for="inputSaleSubtotal" class="form-label">Subtotal</label> -->
        <input id="inputSaleSubtotal" type="text" class="inputSaleSubtotal form-control" placeholder="Subtotal" readonly>
    </div>
    <div class="d-none">
        <input type="hidden" name="product_id" class="inputSaleProductId" value="">
    </div>
    <div class="d-none">
        <input type="hidden" name="minimun_stock" class="inputSaleMinimunStock" value="">
    </div>
    <div class="col-12 col-sm-2 col-md-1 d-flex gap-1">
        <button type="button" class="btn btn-primary add-product-button" aria-label="Agregar producto">+</button>
        <button type="button" class="btn btn-danger remove-product-button" aria-label="Eliminar producto" disabled>&times;</button>
    </div>
</div>
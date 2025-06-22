document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('restock-inventory')) {
        initializePage();
    }
});

function initializePage() {
    setFocusGtinBarCode();
    captureQuantity();
    restockInventory();
}

function setFocusGtinBarCode() {
    gtinBarCode.focus();
}

function captureQuantity() {
    document.getElementById('quantity').addEventListener('click', function(event) {
        event.preventDefault();
        loadProductInformation();
    })
}

async function loadProductInformation() {
    const gtinBarCode = document.getElementById('gtinBarCode').value;

    try {
        const eventResultDTO = await load_product_information(gtinBarCode);

        if (!eventResultDTO.result) {
            document.getElementById('gtinBarCode').value = '';
            setFocusGtinBarCode();
            return handleResponse(eventResultDTO);
        }

        document.getElementById('product').value = eventResultDTO.values.productRecord.name;
        document.getElementById('product_id').value = eventResultDTO.values.productRecord.id;
    } catch (error) {
        setFocusGtinBarCode();
        swalResponse(error);
    }
}

function restockInventory() {
    document.getElementById('restock').addEventListener('click', async function(event) {
        event.preventDefault();

        updateProductStock();
        //updateInventoryStock();
    })
}

async function updateProductStock() {
    const gtinBarCode = document.getElementById('gtinBarCode').value;
    const quantity = document.getElementById('quantity').value;
    const productQuantity = {
        gtinBarCode: gtinBarCode,
        quantity: quantity
    }

    try {
        const eventResultDTO = await update_product_stock(productQuantity);

        if (!eventResultDTO.result) {
            return handleResponse(eventResultDTO);
        }

        updateInventoryStock();
    } catch (error) {
        setFocusGtinBarCode();
        swalResponse(error);
    }
}

async function updateInventoryStock() {
    const productId = document.getElementById('product_id').value;
    const quantity = document.getElementById('quantity').value;
    const productQuantity = {
        productId: productId,
        quantity: quantity
    }

    try {
        const eventResultDTO = await update_inventory_stock(productQuantity);

        if (!eventResultDTO.result) {
            return handleResponse(eventResultDTO);
        }

        document.getElementById('gtinBarCode').value = '';
        document.getElementById('quantity').value = '';
        document.getElementById('product').value = '';
        document.getElementById('product_id').value = '';

        setFocusGtinBarCode();

        swalResponse(eventResultDTO);
    } catch (error) {
        swalResponse(error);
    }
}

function handleResponse(eventResultDTO) {
    swalResponse(eventResultDTO);
}
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('restock-inventory')) {
        initializePage();
    }
});

function initializePage() {
    setFocusGtinBarCode();
    captureQuantity();
    restockInventory();
    searchProduct();
}

function setFocusGtinBarCode() {
    gtinBarCode.focus();
}

function captureQuantity() {
    document.getElementById('quantity').addEventListener('click', function(event) {
        event.preventDefault();

        if (document.getElementById('product').value === '') {
            loadProductInformation();
        }
        //loadProductInformation();
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
    document.getElementById('restock').addEventListener('click', function(event) {
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

function searchProduct() {
    const searchButton = document.getElementById('search');
    const modalElement = document.getElementById('searchProductModal');
    const input = document.getElementById('searchProductInput');
    const resultsList = document.getElementById('searchProductList');

    if (!searchButton || !modalElement || !input || !resultsList) {
        return;
    }

    const modal = new bootstrap.Modal(modalElement, {
        backdrop: 'static',
        keyboard: false
    });

    searchButton.addEventListener('click', function(event) {
        event.preventDefault();
        modal.show();
        input.value = '';
        resultsList.innerHTML = '';
    });

    input.addEventListener('input', async function() {
        const eventRecord = input.value.trim();
        if (eventRecord.length < 3) {
            resultsList.innerHTML = '';
            return;
        }

        try {
            const eventResultDTO = await search_product_information(eventRecord);
            resultsList.innerHTML = '';

            if (!eventResultDTO.result) {
                swalResponse(eventResultDTO);
                return;
            }

            eventResultDTO.values.productRecords.forEach(product => {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item';
                listItem.textContent = product.name;
                listItem.dataset.productId = product.id;
                listItem.addEventListener('click', function() {
                    document.getElementById('product').value = product.name;
                    document.getElementById('product_id').value = product.id;
                    modal.hide();
                    document.getElementById('gtinBarCode').value = product.gtin_code;
                    document.getElementById('quantity').value = '';
                    resultsList.innerHTML = '';
                    setFocusGtinBarCode();
                });
                resultsList.appendChild(listItem);
            });
        } catch (error) {
            swalResponse(error);
        }
    });
    modalElement.addEventListener('hidden.bs.modal', function() {
        input.value = '';
        resultsList.innerHTML = '';
    });
    modalElement.addEventListener('shown.bs.modal', function() {
        input.focus();
    });
}

function handleResponse(eventResultDTO) {
    swalResponse(eventResultDTO);
}
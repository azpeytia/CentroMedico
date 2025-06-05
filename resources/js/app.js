// 1. Dependencias externas
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import ExcelJS from 'exceljs';

// 2. Archivos internos
import './bootstrap';

import './components/sidebar';

import './helpers/dateTimeHelper';
import './helpers/swalHelper';
import {
    swalResponse
} from './helpers/swalHelper';

// Archivos internos de servicios Region inventario
import {
    save_shift_inventory_information,
    update_shift_inventory_information,
    get_inventory_request_information,
    get_inventory_information,
} from './services/inventoryService';
// Endregion inventarios

// Archivos internos de servicios Region pacientes
import {
    search_patient_information,
} from './services/patientService';
// Endregion pacientes

// Archivos internos de servicios Region productos
import {
    get_product_information,
    search_product_information,
} from './services/productService';
// Endregion productos

// Archivos internos de servicios Region ventas
import {
    save_sale_information,
} from './services/saleService';
// Endregion ventas

// Archivos internos de servicios Region turnos
import {
    get_shift_information,
    get_previous_shift_status,
    get_current_shift_status,
    update_shift_status,
    update_previous_status,
} from './services/shiftService';
// Endregion turnos

// Archivos internos de páginas
import './pages/inventory-by-shift';
import './pages/shift-management';
import './pages/sale';

// 3. Configuración global
window.Alpine = Alpine;
window.Swal = Swal;
window.swalResponse = swalResponse;
window.ExcelJS = ExcelJS;

// Configuración global Region inventarios
window.save_shift_inventory_information = save_shift_inventory_information;
window.update_shift_inventory_information = update_shift_inventory_information;
window.get_inventory_request_information = get_inventory_request_information;
window.get_inventory_information = get_inventory_information;
// Endregion inventarios

// Configuración global Region pacientes
window.search_patient_information = search_patient_information;
// Endregion pacientes

// Configuración global Region productos
window.get_product_information = get_product_information;
window.search_product_information = search_product_information;
// Endregion productos

// Configuración global Region ventas
window.save_sale_information = save_sale_information;
// Endregion ventas

// Configuración global Region turnos
window.get_shift_information = get_shift_information;
window.get_previous_shift_status = get_previous_shift_status;
window.get_current_shift_status = get_current_shift_status;
window.update_shift_status = update_shift_status;
window.update_previous_status = update_previous_status;
// Endregion turnos

Alpine.start();

// 4. Eventos y lógica
document.addEventListener('DOMContentLoaded', () => {
    updateDateTime();
    setInterval(updateDateTime, 1000);
});
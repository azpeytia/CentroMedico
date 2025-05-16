// 1. Dependencias externas
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import ExcelJS from 'exceljs';

// 2. Archivos internos
import './bootstrap';
import './components/sidebar';
import './helpers/dateTimeHelper';
import './helpers/swalHelper';
import { swalResponse } from './helpers/swalHelper';
import {
    save_shift_inventory_information,
    update_shift_inventory_information,
    get_inventory_request_information,
} from './services/inventoryService';
import {
    get_product_information,
} from './services/productService';
import {
    get_shift_information,
    get_previous_shift_status,
    get_current_shift_status,
    update_shift_status,
    update_previous_status,
} from './services/shiftService';

// 3. Configuración global
window.Alpine = Alpine;
window.Swal = Swal;
window.swalResponse = swalResponse;
window.ExcelJS = ExcelJS;

// Configuración global Region inventarios
window.save_shift_inventory_information = save_shift_inventory_information;
window.update_shift_inventory_information = update_shift_inventory_information;
window.get_inventory_request_information = get_inventory_request_information;
// Endregion inventarios

// Configuración global Region productos
window.get_product_information = get_product_information;
// Endregion productos

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
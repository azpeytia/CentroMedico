<div class="user-panel">
    <div class="image">
        <img src="{{ asset('images/user.jpg') }}" alt="User Image">
    </div>
    <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline" style="color: #007bff; text-decoration: none;">
                Cerrar sesión
            </button>
        </form>
    </div>
</div>

<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-folder"></i> Catálogos
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-person-badge"></i> Doctores
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-person-vcard"></i> Enfermeras
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-person-wheelchair"></i> Pacientes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-capsule-pill"></i> Medicamentos
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-eyedropper"></i> Crear medicamento
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-card-list"></i> Lista de medicamentos
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-people"></i> Usuarios
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-person-plus"></i> Crear usuario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-card-list"></i> Lista de usuarios
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-box-seam"></i> Inventarios
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('inventories.shift_management') }}">
                    <i class="bi bi-clock"></i> Iniciar/Terminar turno
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('inventories.inventory_by_shift') }}">
                    <i class="bi bi-clipboard-data"></i> Por turno
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-truck"></i> Surtir inventario
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-calculator"></i> Calcular inventario
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-sticky"></i> Crear requisición
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-clipboard-heart"></i> Diagnósticos
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-prescription"></i> Recetas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-cart"></i> Ventas
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('sales.create') }}">
                    <i class="bi bi-receipt"></i> Crear nota de venta
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-search"></i> Ventas realizadas
                </a>
            </li>
        </ul>
    </li>
</ul>
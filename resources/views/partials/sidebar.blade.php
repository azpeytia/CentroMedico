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
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-box-seam"></i> Inventarios
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-clock"></i> Iniciar/Terminar turno
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
            <i class="bi bi-file-earmark-medical"></i> Recetas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-bag-plus"></i> Ventas
        </a>
    </li>
</ul>
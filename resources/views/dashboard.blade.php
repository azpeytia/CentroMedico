@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid main">
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-md-4">
                <div class="card card-custom-bg">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-people-fill card-icon"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">Usuarios</h5>
                            <p class="card-text">150 registrados</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-4">
                <div class="card card-custom-bg">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-heart-fill card-icon"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">Donaciones</h5>
                            <p class="card-text">20 nuevas donaciones</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-md-4">
                <div class="card card-custom-bg">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-calendar-fill card-icon"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">Eventos</h5>
                            <p class="card-text">3 próximos eventos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<?php
// Inicia la sesión
session_start();

// Si se hace clic en el botón de cerrar sesión
if (isset($_POST['cerrar_sesion'])) {
    // Destruir la sesión
    session_destroy();
    // Redirigir a la página de inicio o de login
    header("Location: ../vistas_inicio/inicio.html"); // Cambia 'login.php' a la URL deseada
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Administrador</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vista_administrador.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <img src="../favicon (1).ico" height="100px" id="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="Usuarios">Usuarios</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../vistas_registro/Usuarios/registrar_administradores.html">Registrar</a></li>
                            <li><a class="dropdown-item" href="../../Controlador/controladores_usuario/Consulta_usuario.php">Consultar</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Proveedor</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../vistas_registro/Proveedores/registrar_proveedores.html">Registrar</a></li>
                            <li><a class="dropdown-item" href="../../Controlador/controladores_proveedores/consulta_proveedor.php">Consultar</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="Producto">Producto</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../vistas_registro/Producto/registro_producto.html">Registrar</a></li>
                            <li><a class="dropdown-item" href="../../Controlador/controladores_producto/consulta_producto.php">Consultar</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Pedido</a>
                        <ul class="dropdown-menu"> 
                            <li><a class="dropdown-item" href="../../Controlador/controladores_pedido/consulta_pedidos.php">Consultar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="d-grid gap-2 d-md-block" id="cerrar">
            <form method="post" style="display: inline;">
                <button class="btn btn-primary" type="submit" name="cerrar_sesion">Cerrar Sesión</button>
            </form>
        </div>
    </nav>
    
    <!-- Panel de Control comienza aquí -->
    <div class="container my-4">
        <h1 class="text-center">Panel de Control - Administrador</h1>

        <!-- Fila de tarjetas de estadísticas -->
        <div class="row mt-4">
            <!-- Ventas del día -->
            <div class="col-md-3">
                <div class="card text-center bg-light mb-3">
                    <div class="card-header">Ventas del Día</div>
                    <div class="card-body">
                        <h2 class="card-title">$1000</h2>
                        <p class="card-text">Total de ventas de hoy.</p>
                    </div>
                </div>
            </div>

            <!-- Pedidos pendientes -->
            <div class="col-md-3">
                <div class="card text-center bg-light mb-3">
                    <div class="card-header">Pedidos Pendientes</div>
                    <div class="card-body">
                        <h2 class="card-title">25</h2>
                        <p class="card-text">Pedidos sin procesar.</p>
                    </div>
                </div>
            </div>

            <!-- Inventario bajo -->
            <div class="col-md-3">
                <div class="card text-center bg-light mb-3">
                    <div class="card-header">Inventario Bajo</div>
                    <div class="card-body">
                        <h2 class="card-title">5 Productos</h2>
                        <p class="card-text">Productos críticos en stock.</p>
                    </div>
                </div>
            </div>

            <!-- Clientes registrados -->
            <div class="col-md-3">
                <div class="card text-center bg-light mb-3">
                    <div class="card-header">Clientes Registrados</div>
                    <div class="card-body">
                        <h2 class="card-title">120</h2>
                        <p class="card-text">Clientes totales registrados.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fila de gráficos (opcional) -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Ventas Mensuales</div>
                    <div class="card-body">
                        <canvas id="ventasMes"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Pedidos por Estado</div>
                    <div class="card-body">
                        <canvas id="pedidosEstado"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Ejemplo de gráfico de ventas mensuales
        const ctx = document.getElementById('ventasMes').getContext('2d');
        const ventasMes = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
                datasets: [{
                    label: 'Ventas',
                    data: [1200, 1900, 3000, 5000, 2000],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Ejemplo de gráfico de pedidos por estado
        const ctx2 = document.getElementById('pedidosEstado').getContext('2d');
        const pedidosEstado = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Pendientes', 'Procesados', 'Entregados'],
                datasets: [{
                    label: 'Pedidos',
                    data: [12, 19, 30],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>



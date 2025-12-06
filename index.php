<?php include "templates/header.php"; ?>

<style>
    /* Fondo suave profesional */
    body {
        background: #f5f7fa;
    }

    /* Tarjetas elegantes */
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        border: none;
    }

    /* Contenedor centrado para pantallas grandes */
    .container-custom {
        max-width: 1100px;
        margin: auto;
    }

    /* Título principal */
    .main-title {
        font-size: 2.6rem;
        font-weight: bold;
        color: #0A3D62;
    }

    /* Footer */
    footer {
        background: #0A3D62;
        color: white;
        padding: 12px;
        margin-top: 40px;
        text-align: center;
        border-radius: 8px;
    }
</style>

<div class="container container-custom">

    <!-- Título principal -->
    <div class="text-center mt-4">
        <h1 class="main-title">
            ⛏️ Ferretería Peralta
        </h1>
        <hr style="height:4px; background:#0A3D62; border:none; opacity:0.8; width:80%; margin:auto;">
    </div>

    <!-- Sección Bienvenida -->
    <h2 class="mt-5">Bienvenidos 👋</h2>

    <div class="card p-4 mt-3">
        <p style="font-family: Arial; font-size:16px; font-align:justify;">
            La <u><i><b style="color:#75132A;">Ferretería Peralta </b></i></u>🧰, en Moctezuma, Sonora, busca implementar un sistema
            computarizado para optimizar su control de inventario y mejorar el servicio al cliente.
        </p>

        <p><b>Sus principales objetivos son:</b></p>

        <ul>
            <li>
                <b style="color:#172D61;">⚙️Reducción De Errores:</b> Se busca reducir los errores en un 
                <span style="color:#19264F; font-weight:bold;">40%</span> para mejorar la precisión del inventario.
            </li>

            <li>
                <b style="color:#172D61;">⚙️Aumento De Satisfacción:</b> Incrementar la satisfacción del cliente en un 
                <span style="color:#19264F; font-weight:bold;">30%</span>, promoviendo una experiencia de compra eficiente.
            </li>
        </ul>
    </div>

    <!-- Tarjeta Datos de la Materia -->
    <div class="card p-4 mt-5">
        <h4>📚 Datos de la Materia</h4>
        <p style= "font-family:Arial; font-size: 16px;">M4 - Diseña y Gestiona Bases de Datos Óptimas</small>

        <div class="mt-3 d-flex justify-content-center">
            <img src="img\Logo.png"
                 alt="CBTA Logo" 
                 style="width: 350px; border-radius:12px;">
        </div>
    </div>


   
</div>

<div class="container mt-4">
  <div class="row justify-content-center">

    <!-- RECUADRO 1 -->
    <div class="col-md-4">
      <div class="card shadow-sm text-center p-3">
        <img src="img/imagen1.jpg" class="img-fluid rounded" alt="Alumna Elizabeth">
        <h5 class="mt-3 fw-bold"> Maria Elizabeth Yanez Peralta</h5>
      </div>
    </div>

    <!-- RECUADRO 2 -->
    <div class="col-md-4">
      <div class="card shadow-sm text-center p-3">
        <img src="img/imagen2.jpg" class="img-fluid rounded" alt="Alumna Danna">

        <h5 class="mt-3 fw-bold">Danna Sofia Madrid Montaño</h5>
      </div>
    </div>

  </div>
</div>
<div class="container mt-4">
  <div class="row justify-content-center">


</div>
</div>
<a href="files/E04_FerreteriaPeralta.pdf" 
   target="_blank" 
   class="btn btn-outline-primary mt-3">
   📄 Ver Proyecto Original (PDF)
</a>

<!-- Footer -->
<footer>
     2025 Ferretería Peralta — Sistema de Gestión
</footer>

<?php include "templates/footer.php"; ?>





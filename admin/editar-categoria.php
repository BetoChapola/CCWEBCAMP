<?php
include_once 'funciones/sesiones.php';
// *** NOTA***
// Para que una redirección PHP (ubicada en: include_once 'funciones/sesiones.php') pueda funcionar NO DEBE HABER ningún código antes. En ese archivo existe una validacion para que no se pueda entrar a esta zona si no esta logueado.
// Pero esa validacion tiene una REDIRECCION, por eso se pone hasta el principio para no generar ningun error.
include_once 'funciones/funciones.php';
include_once 'templates/header.php';
include_once 'templates/barra.php';
include_once 'templates/navegacion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        die("error");
    }
}
?>


<div class="content-wrapper">
  <!-- Content Wrapper. Contains page content -->

  <section class="content-header">
    <!-- Content Header (Page header) -->
    <h1>Editar Categoría<small>Llena los campos para editar una categoría</small></h1>
  </section>

  <div class="row">
    <div class="col-md-8">
      <section class="content">
        <!-- Main content -->

        <div class="box">
          <!-- .box -->

          <div class="box-header with-border">
            <h3 class="box-title">Editar Categoría</h3>
          </div>

          <div class="box-body">
            <!-- .box-body -->
            <?php
            $sql = "SELECT * FROM categoria_evento where id_categoria = $id";
            $resultado = $conn->query($sql);
            $categoria = $resultado->fetch_assoc();
            ?>
            <!-- Al momento de presionar el boton "Añadir" (evento "submit") se envian los datos del formulario
              "guardar-registro" al archivo "admin-ajax.js. Donde se creara un array (de objetos) para enviar los datos de
              forma mas segura al archivo "modelo-admin.php". Este archivo php se encarga de hacer las validaciones
              para poder insertar los datos a la BD. Dando como retorno un json que puede ser utilizado por JS
              para crear efectos como las ventanas de SweetAlert2.
             -->
            <form role="form" name="guardar-registro" id="guardar-registro" method="POST" action="modelo-categoria.php"><!-- .form -->

              <div class="box-body"><!--.box-body -->
                <div class="form-group">
                  <label for="usuario">Nombre:</label>
                  <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" placeholder="Nombre de la nueva categoría" value="<?php echo $categoria['cat_evento'] ?>">
                </div>
                <div class="form-group">
                  <label for="">Ícono:</label>
                  <div class="input-group">
                      <div class="input-group-addon">
                          <i class="fa fa-plus-circle"></i>
                      </div>
                      <input type="text" name="icono" id="icono" class="form-control pull-right" placeholder="fa-icon" value="<?php echo $categoria['icono'] ?>">
                  </div>
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="registro" value="actualizar">
                <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                <button type="submit" class="btn btn-primary" id="crear_registro">Actualizar</button>
              </div>

            </form><!-- /.form -->

          </div><!-- /.box-body -->

        </div><!-- /.box -->
      </section><!-- /.content -->
    </div>
  </div>

</div><!-- /.content-wrapper -->

<?php 
include_once 'templates/footer.php';
?>
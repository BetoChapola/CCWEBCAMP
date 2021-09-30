<?php
include_once 'funciones/sesiones.php';
// *** NOTA***
// Para que una redirección PHP (ubicada en: include_once 'funciones/sesiones.php') pueda funcionar NO DEBE HABER ningún código antes. En ese archivo existe una validacion para que no se pueda entrar a esta zona si no esta logueado.
// Pero esa validacion tiene una REDIRECCION, por eso se pone hasta el principio para no generar ningun error.
include_once 'funciones/funciones.php'; //Tiene la conexion a la BD
include_once 'templates/header.php'; // Carga todos los archivos de estilos.
include_once 'templates/barra.php'; // Carga la barra principal que esta en todas las paginas.
include_once 'templates/navegacion.php'; // Carga el panel lateral de navegación del proyecto.
?>

<!-- RECORDAR: que en este nivel ya existen todas las variables de sesion que creamos en el archivo de validacion "login-admin.php": 
  session_start();
  $_SESSION['usuario'] = $usuario_admin;
  $_SESSION['nombre'] = $nombre_admin;
  $_SESSION['nivel'] = $nivel;
  $_SESSION['id'] = $id_admin;

-->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Listado de personas Registradas.
            <small></small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Maneja los Registrados en esta sección.</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="registros" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Fecha de Registro</th>
                                    <th>Artículos</th>
                                    <th>Talleres</th>
                                    <th>Regalo</th>
                                    <th>Compra</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $sql = "SELECT registrados.*, regalos.nombre_regalo FROM registrados ";
                                    $sql .= " JOIN regalos ";
                                    $sql .= " ON registrados.regalo = regalos.ID_regalo ";
                                    $resultado = $conn->query($sql);
                                    // echo $sql;
                                } catch (Exception $e) {
                                    $error = $e->getMessage();
                                    echo $error;
                                }
                                while ($registrados = $resultado->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $registrados['nombre_registrado'] . ' ' . $registrados['apellido_registrado'] ?>
                                        <?php 
                                            $pagado = $registrados['pagado'];
                                            if ($pagado) {
                                                echo '<span class = "badge bg-green">PAGADO</span>';
                                            } else {
                                                echo '<span class = "badge bg-red">NO PAGADO</span>';
                                            }
                                        ?>
                                    </td>
                                        <td><?php echo $registrados['email_registrado'] ?></td>
                                        <td><?php echo $registrados['fecha_registro'] ?></td>
                                        <td>
                                            <?php 
                                                $articulos = json_decode($registrados['pases_articulos'], true);
                                                // var_dump($articulos);
                                                

                                                $arreglo_articulos = array (
                                                    'un dia' => 'Pase 1 día',
                                                    'pase_2dias' => 'Pase 2 días',
                                                    'pase_completo' => 'Pase Completo',
                                                    'camisas' => 'Camisas',
                                                    'etiquetas' => 'Etiquetas'
                                                );

                                                
                                                foreach($articulos as $llave => $articulo) {

                                                    // ! Este era el código original, pero por alguna razón no lo funciona en mi código. Opte por isset() en vez de usar la función array_key_exists().
                                                    // if(array_key_exists('cantidad', $articulo)) {
                                          
                                                    //     echo $articulo['cantidad'] . " " .  $arreglo_articulos[$llave] . "<br>";
                                                    //   } else {
                                                    //    echo $articulo . " " .  $arreglo_articulos[$llave] . "<br>";
                                                    //   }
                                                    // https://es.stackoverflow.com/questions/364174/warning-error-trying-to-access-array-offset-on-value-of-type-null-php-7-4

                                                    if (isset($articulo['cantidad'])) {
                                                        echo $articulo['cantidad'] . " " .  $arreglo_articulos[$llave] . "<br>";
                                                    }else {
                                                        echo $articulo . " " .  $arreglo_articulos[$llave] . "<br>";
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 

                                                $eventos_resultado = $registrados['talleres_registrados'];
                                                $talleres = json_decode($eventos_resultado, true);
                                                $talleres = implode("', '", $talleres['eventos']);

                                                $sql_talleres = "SELECT nombre_evento, fecha_evento, hora_evento FROM eventos WHERE clave IN ('$talleres') OR id_evento IN ('$talleres') ";

                                                $resultado_talleres = $conn->query($sql_talleres);

                                                while ($eventos = $resultado_talleres->fetch_assoc()) {
                                                    echo $eventos['nombre_evento'] . " " . $eventos['fecha_evento'] . " " . $eventos['hora_evento'] . "<br>";
                                                }
                                            
                                            ?>
                                        </td>
                                        <td><?php echo $registrados['regalo'] ?></td>
                                        <td><?php echo (float) $registrados['total_pagado'] ?></td>
                                        <td> 
                                            <a href="editar-registrado.php?id=<?php echo $registrados['ID_Registrado']; ?>" class="btn bg-orange btm-flat margin">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#" data-id="<?php echo $registrados['ID_Registrado']; ?>" data-tipo="registrado" class="btn bg-maroon btm-flat margin borrar_registro">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Fecha de Registro</th>
                                    <th>Artículos</th>
                                    <th>Talleres</th>
                                    <th>Regalo</th>
                                    <th>Compra</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>


</div>
<!-- /.content-wrapper -->

<?php include_once 'templates/footer.php';
?>
<?php
include_once 'funciones/sesiones.php';
// *** NOTA***
// Para que una redirección PHP (ubicada en: include_once 'funciones/sesiones.php') pueda funcionar NO DEBE HABER ningún código antes. En ese archivo existe una validacion para que no se pueda entrar a esta zona si no esta logueado.
// Pero esa validacion tiene una REDIRECCION, por eso se pone hasta el principio para no generar ningun error.
include_once 'funciones/funciones.php';
include_once 'templates/header.php';
include_once 'templates/barra.php';
include_once 'templates/navegacion.php';
?>


<div class="content-wrapper">
  <!-- Content Wrapper. Contains page content -->

  <section class="content-header">
    <!-- Content Header (Page header) -->
    <h1>Crear Registrados a los eventos<small></small></h1>
  </section>

  <div class="row">
    <div class="col-md-8">
      <section class="content">
        <!-- Main content -->

        <div class="box">
          <!-- .box -->

          <div class="box-header with-border">
            <h3 class="box-title">Crear Registrado manualmente</h3>
          </div>

          <div class="box-body">

            <form role="form" name="guardar-registro" id="guardar-registro" method="POST" action="modelo-registrado.php">

              <div class="box-body">


                <div class="form-group">
                  <label for="nombre_registrado">Nombre:</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                </div>

                <div class="form-group">
                  <label for="apellido_registrado">Apellido:</label>
                  <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido">
                </div>

                <div class="form-group">
                  <label for="email">email:</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="email">
                </div>

                <div class="form-group">
                  <div id="paquetes" class="paquetes">
                  <div class="box-header with-border">
                    <h3 class="box-title">Elije el número de boletos</h3>
                  </div>

                    <ul class="lista-precios clearfix row">
                      <li class="col-md-4">
                        <div class="tabla-precio text-center">
                          <h3>Pase por día (Viernes)</h3>
                          <p class="numero">$30</p>
                          <ul class="text-center">
                            <li>bocadillos gratis</li>
                            <li>Todas las conferencias</li>
                            <li>Todos los talleres</li>
                          </ul>
                          <div class="orden">
                            <label for="pase_dia">Boletos deseados</label>
                            <input type="number" class="form-control" min="0" id="pase_dia" size="3" name="boletos[un_dia][cantidad]" placeholder="0">
                            <input type="hidden" value="30" name="boletos[un_dia][precio]">
                          </div>
                        </div>
                      </li><!-- un-dia -->
                      <li class="col-md-4">
                        <div class="tabla-precio text-center">
                          <h3>Pase por dos días(Viernes y sábado)</h3>
                          <p class="numero">$45</p>
                          <ul>
                            <li>bocadillos gratis</li>
                            <li>Todas las conferencias</li>
                            <li>Todos los talleres</li>
                          </ul>
                          <div class="orden">
                            <label for="pase_dos_dias">Boletos deseados</label>
                            <input type="number" class="form-control" min="0" id="pase_dos_dias" size="3" name="boletos[dos_dias][cantidad]" placeholder="0">
                            <input type="hidden" value="45" name="boletos[dos_dias][precio]">
                          </div>
                        </div>
                      </li><!-- dos-dias -->
                      <li class="col-md-4">
                        <div class="tabla-precio text-center">
                          <h3>Todos los días</h3>
                          <p class="numero">$50</p>
                          <ul>
                            <li>bocadillos gratis</li>
                            <li>Todas las conferencias</li>
                            <li>Todos los talleres</li>
                          </ul>
                          <div class="orden">
                            <label for="pase_completo">Boletos deseados</label>
                            <input type="number" class="form-control" min="0" id="pase_completo" size="3" name="boletos[pase_completo][cantidad]" placeholder="0">
                            <input type="hidden" value="50" name="boletos[pase_completo][precio]">
                          </div>
                        </div>
                      </li><!-- todos-los-dias -->
                    </ul><!-- lista-precios -->

                  </div><!-- paquetes -->
                </div> <!-- paquetes -->

                <div class="form-group">
                  <div class="box-header with-border">

                    <div id="eventos" class="eventos clearfix">
                      <h3>Elige tus talleres</h3>
                      <div class="caja">

                        <?php
                        try {

                          $sql = "SELECT eventos.*, categoria_evento.cat_evento, invitados.nombre_invitado, invitados.apellido_invitado";
                          $sql .= " FROM eventos ";
                          $sql .= " JOIN categoria_evento ";
                          $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria";
                          $sql .= " JOIN invitados ";
                          $sql .= " ON eventos.id_inv = invitados.id_invitado ";
                          $sql .= " ORDER BY eventos.fecha_evento, eventos.id_cat_evento, eventos.hora_evento ";

                          // echo $sql;

                          $resultado = $conn->query($sql);
                        } catch (Exception $e) {
                          echo $e->getMessage();
                        }

                        $eventos_dias = array();
                        while ($eventos = $resultado->fetch_assoc()) {

                          // echo "<pre>";
                          // var_dump($eventos);
                          // echo "</pre>";

                          $fecha = $eventos['fecha_evento'];
                          setlocale(LC_ALL, 'es-ES'); // no me funciona la conversion de los dia en español
                          $dia_semana = strftime("%A", strtotime($fecha));
                          $categoria = $eventos['cat_evento'];

                          // echo utf8_encode($dia_semana);

                          $dia = array(
                            'nombre_evento' => $eventos['nombre_evento'],
                            'hora' => $eventos['hora_evento'],
                            'id' => $eventos['id_evento'],
                            'nombre_invitado' => $eventos['nombre_invitado'],
                            'apellido_invitado' => $eventos['apellido_invitado']
                          );
                          $eventos_dias[utf8_encode($dia_semana)]['eventos'][$categoria][] = $dia;
                        }

                        // var_dump($eventos_dias);

                        ?>

                        <?php
                        foreach ($eventos_dias as $dia => $eventos) { ?>

                          <div id="<?php echo str_replace('á', 'a', $dia); ?>" class="contenido-dia clearfix row">
                            <h4 class="text-center nombre-dia"><?php echo $dia; ?></h4>

                            <?php foreach ($eventos['eventos'] as $tipo => $evento_dia) : ?>

                              <div class="col-md-4">
                                <p><?php echo $tipo ?></p>

                                <?php foreach ($evento_dia as $evento) { ?>
                                  <label>
                                    <input type="checkbox" class="minimal" name="registro_evento[]" id="<?php echo $evento['id'] ?>" value="<?php echo $evento['id'] ?>">
                                    <time><?php echo $evento['hora'] ?></time> <?php echo $evento['nombre_evento'] ?><br>
                                    <span class="autor"><?php echo $evento['nombre_invitado'] . " " . $evento['apellido_invitado'] ?></span>
                                  </label>
                                <?php } ?>

                              </div>

                            <?php endforeach; ?>

                          </div>
                          <!--Contenido día-->

                        <?php } ?>
                      </div>
                      <!--.caja-->
                    </div>
                    <!--#eventos-->


                  </div>
                </div> <!-- talleres -->

                <div class="form-group">
                  <div class="box-header with-border">
                    <h3 class="box-title">Elije los regalos</h3>
                  </div>
                    <div id="resumen" class="resumen clearfix">
                      <h3>Pago y extras</h3><br>
                      <div class="caja clearfix row">
                        <div class="extras col-md-6">
                          <div class="orden">
                            <label for="camisa_evento">Camisa del evento $10<small>(promoción 7% dto.)</small></label>
                            <input type="number" class="form-control" min="0" id="camisa_evento" name="pedido_extra[camisas][cantidad]" size="3" placeholder="0">
                            <input type="hidden" value="10" name="pedido_extra[camisas][precio]">
                          </div><!-- orden -->
                          <div class="orden">
                            <label for="etiquetas">Paquete de 10 etiquetas $2 <small>(HTML5, CSS3, JavaScript)</small></label>
                            <input type="number" class="form-control" min="0" id="etiquetas" name="pedido_extra[etiquetas][cantidad]" size="3" placeholder="0">
                            <input type="hidden" value="2" name="pedido_extra[etiquetas][precio]">
                          </div><!-- orden -->
                          <div class="orden">
                            <label for="regalo">Seleccione un regalo</label><br>
                            <select name="regalo" id="regalo" required class="form-control seleccionar">
                              <option value="">-- Seleccione un regalo --</option>
                              <option value="2">Etiquetas</option>
                              <option value="1">Pulseras</option>
                              <option value="3">Plumas</option>
                            </select>
                          </div><!-- orden -->
                          <br>
                          <input type="button" id="calcular" class="button btn-success" value="Calcular">
                        </div><!-- extras -->

                        <div class="total col-md-6">
                          <p>Resumen:</p>
                          <div id="lista_productos">

                          </div>
                          <p>Total:</p>
                          <div id="suma_total">

                          </div>
                          <input type="hidden" name="total_pedido" id="total_pedido">
                        </div><!-- total -->

                      </div><!-- caja -->
                    </div><!-- resumen -->
                  
                </div> <!-- regalos -->


              </div><!-- /.box-body -->


              <div class="box-footer">
                <input type="hidden" name="registro" value="nuevo">
                <button type="submit" class="btn btn-primary" id="btnRegistro">Añadir</button>
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
<?php
    try {
        require_once('includes/funciones/bdconexion.php');
        $sql = " SELECT * FROM invitados ";

        $resultado = $conn->query($sql);
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
    ?>

    <section class="invitados contenedor seccion">
        <h2>Nuestros invitados</h2>
        <ul class="lista-invitados clearfix">
            <?php
            while ($invitados = $resultado->fetch_assoc()) { ?>

                <li>
                    <div class="invitado">
                        <a class="invitado-info" href="#invitado<?php echo $invitados['id_invitado'] ?>">
                            <img src="img/<?php echo $invitados['url_imagen'] ?>">
                            <p><?php echo $invitados['nombre_invitado'] . " " . $invitados['apellido_invitado'] ?></p>
                        </a>
                    </div>
                </li>

                <div style="display:none;">
                    <div class="invitado-info" id="invitado<?php echo $invitados['id_invitado'] ?>">
                        <h2><?php echo $invitados['nombre_invitado'] . " " . $invitados['apellido_invitado'] ?></h2>
                        <p><?php echo $invitados['descripcion'] ?></p>
                        <img src="img/<?php echo $invitados['url_imagen'] ?>">
                    </div>
                </div>

            <?php } //while-fetch_assoc
            ?>
        </ul>
    </section>


    <?php $conn->close(); ?>
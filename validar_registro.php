
    <?php if (isset($_POST['submit'])) : 
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $regalo = $_POST['regalo'];
        $total = $_POST['total_pedido'];
        $fecha = date('Y-m-d H:i:s');
        //pedidos
        $boletos = $_POST['boletos'];
        $camisas = $_POST['pedido_camisas'];
        $etiquetas = $_POST['pedido_etiquetas'];
        include_once 'includes/funciones/funciones.php';
        $pedido = productos_json($boletos, $camisas, $etiquetas);
        //eventos
        $eventos = $_POST['registro'];
        $registro = eventos_json($eventos);
        //Prepared Statements (una forma mas segura de insertar datos en SQL)
        //Previene la inseccionSQL
        try {
            require_once('includes/funciones/bdconexion.php');
            $stmt = $conn->prepare("INSERT INTO registrados 
            (nombre_registrado, apellido_registrado, email_registrado,fecha_registro, 
            pases_articulos, talleres_registrados, regalo, total_pagado) 
            VALUES (?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssis", 
            $nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total);
            $stmt->execute();
            $stmt->close();
            //Para evitar que los datos se queden en memoria y se vualvan a insertar en la tabla con F5
            //Usaremos la redirecion con header(); al final estaremos enviando a la misma pagina pero con
            //un valor diferente al final (?exitoso=1)
            header('Location: validar_registro.php?exitoso=1');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        ?>
    <?php endif ?>
<?php include_once 'includes/templates/header.php'; ?>

<section class="seccion contenedor">
    <h2>Resumen de Registros</h2>

    <?php 
    if(isset($_GET['exitoso'])):
        if($_GET['exitoso'] == 1):
            echo "Tu registo ha sido exitoso";
        endif;
    endif;
    ?>

</section>


<?php include_once 'includes/templates/footer.php'; ?>
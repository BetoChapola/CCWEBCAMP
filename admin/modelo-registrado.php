<?php
include_once 'funciones/funciones.php';

//======================================================================
// C  R  U  D
//======================================================================

if (isset($_POST['registro'])) {

    //NOMBRE
    !isset($_POST['nombre']) ?:
        $nombre = $_POST['nombre'];
    //APELLIDO
    !isset($_POST['apellido']) ?:
        $apellido = $_POST['apellido'];
    //EMAIL
    !isset($_POST['email']) ?:
        $email = $_POST['email'];
    // BOLETOS
    !isset($_POST['boletos']) ?:
        $boletos_adquiridos = $_POST['boletos'];
    //EVENTOS
    !isset($_POST['registro_evento']) ?:
        $eventos = $_POST['registro_evento'];
    !isset($eventos) ?:
        $registro_eventos = eventos_json($eventos);
    //CAMISAS
    !isset($_POST['pedido_extra']['camisas']['cantidad']) ?:
        $camisas = $_POST['pedido_extra']['camisas']['cantidad'];
    //ETIQUETAS
    !isset($_POST['pedido_extra']['etiquetas']['cantidad']) ?:
        $etiquetas = $_POST['pedido_extra']['etiquetas']['cantidad'];
    //REGALO
    !isset($_POST['regalo']) ?:
        $regalo = $_POST['regalo'];
    //TOTAL
    !isset($_POST['total_pedido']) ?:
        $total = $_POST['total_pedido'];

    // * Unimos los arrays para crear uno que se llame pedido.
    !isset($boletos_adquiridos) ?:
        $pedido = productos_json($boletos_adquiridos, $camisas, $etiquetas);

    //registro = nuevo/actualizar
    $registro = $_POST['registro'];

    //======================================================================
    // INSERTAR NUEVO CATEGORIA
    //======================================================================

    if ($registro == 'nuevo') {

        // die(json_encode($_POST));

        $stmt = $conn->prepare('INSERT INTO registrados (nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado, pagado) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, 1)');
        try {
            $stmt->bind_param('sssssis', $nombre, $apellido, $email, $pedido, $registro_eventos, $regalo, $total);
            $stmt->execute();
            $id_insertado = $stmt->insert_id;
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_insertado' => $id_insertado
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $respuesta = array(
                'respuesta' => $e->getMessage()
            );
        }
        die(json_encode($respuesta));
    }


    //======================================================================
    // MODIFICAR CATEGORIA
    //======================================================================

    if ($registro == 'actualizar') {
        // die(json_encode($_POST));

        $id_registro = $_POST['id_registro'];
        $fecha_registro = $_POST['fecha_registro'];

        try {
            //En este bloque si me funciono la función NOW() 👍
            $stmt = $conn->prepare('UPDATE registrados SET nombre_registrado = ?, apellido_registrado = ?, email_registrado = ?, fecha_registro = ?, pases_articulos = ?, talleres_registrados = ?, regalo = ?, total_pagado = ?, pagado = 1 WHERE ID_Registrado = ?');
            $stmt->bind_param("ssssssisi", $nombre, $apellido, $email, $fecha_registro, $pedido, $registro_eventos, $regalo, $total, $id_registro);
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_actualizado' => $id_registro
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        die(json_encode($respuesta));
    }

    //======================================================================
    // ELIMINAR CATEGORIA
    //======================================================================
    // En esta sección, debemos poner especial atención con las relaciones de la tabla;
    // ya que la tabla "categoria_evento" es una tabla de la cual dependen otras tablas (eventos).
    // Su campo "id_categoria" es una llave foranea en otras tablas (eventos). Entonces NO SE PUEDE ELIMINAR sin antes
    // "deshacer" o eliminar sus relaciones con las otras tablas, en las cuales tambien se tendrán
    // que eliminar los registros relacionados.

    // Tambien se debe considerar que 

    if ($registro == 'eliminar') {
        // die(json_encode($_POST));
        $id_borrar = $_POST['id'];

        try {
            $stmt = $conn->prepare('DELETE FROM registrados WHERE ID_Registrado = ?');
            $stmt->bind_param("i", $id_borrar);
            $stmt->execute();


            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_eliminado' => $id_borrar
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }

            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        die(json_encode($respuesta));
    }
}

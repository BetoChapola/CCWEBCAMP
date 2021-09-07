<?php

include_once 'funciones/funciones.php';
// Recibimos en este documento la estructura de datos que se envía desde admin-ajax.js.
// Mediante "die (json_encode($_POST));" podemos detener la ejecución y ver lo que genera:
// Object { usuario: "_dato_", nombre: "_dato_", password: "_dato_", "agregar-admin": "_dato_" }
// die (json_encode($_POST));
// Los 2 formularios tienen los mismos campos y mandan los mismos datos a excepción de uno extra (name="id_registro") que esta en editar-admin.php.

// DATOS ENVIADOS DESDE crear-admin.php/editar-admin.php A admin-ajax.js
// name="nombre"
// name="password"
// name="registro" TIPO de registro = nuevo/actualizar
// name="usuario"

// DATOS ENVIADOS DESDE editar-admin.php A admin-ajax.js
// name="id_registro" ### EXTRA ### solo estará disponible en editar-admin.php

// ##################################################################
// ######################  C R U D  #################################
// ##################################################################
if (isset($_POST['registro'])) {

    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];
    $registro = $_POST['registro']; //TIPO de registro = nuevo/actualizar

    // Hasheamos el password (encriptación):
    $opciones = array(
        // "costo" de iteraciones para crear un hash. Mientras más alto (más seguro) más consumos de recurso en el servidor.
        'cost' => 10
    );
    // $hashed = password_hash($password, tipo_de_encriptado, array_de opciones);
    $password_hashed = password_hash($password, PASSWORD_BCRYPT, $opciones);

    if ($registro == 'nuevo') {
        try {

            $stmt = $conn->prepare("INSERT INTO admins (usuario, nombre, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $usuario, $nombre, $password_hashed);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_admin' => $id_registro
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

    if ($registro == 'actualizar') {
        $id_registro = $_POST['id_registro'];

        try {
            $stmt = $conn->prepare('UPDATE admins SET usuario = ?, nombre = ?, password = ? WHERE id_admin = ?');
            $stmt->bind_param("sssi", $usuario, $nombre, $password_hashed, $id_registro);
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array (
                    'respuesta' => 'exito',
                    'id_actualizado' => $stmt->insert_id
                    // 'id_actualizado' => $id_registro
                );
            }else {
                $respuesta = array (
                    'respuesta' => 'error'
                );
            }
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $respuesta = array (
                'respuesta' => $e->getMessage()
            );
        }
        die(json_encode($respuesta));
    }
    
}


// ##################################################################
// ######################  L O G I N  ###############################
// ##################################################################
if (isset($_POST['login-admin'])) {
    // die(json_encode($_POST));

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    try {
        include_once 'funciones/funciones.php';
        $stmt = $conn->prepare("SELECT * FROM admins WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        // con bind_result() podemos renombrar los campos
        $stmt->bind_result($id_admin, $usuario_admin, $nombre_admin, $password_admin);


        // https://www.php.net/manual/es/function.mysql-affected-rows.php
        if ($stmt->affected_rows) {
            // Si existe el usuario lo guardamos en una variable.
            $existe = $stmt->fetch();

            if ($existe) {
                // Si el usuario existe verificar el password:
                if (password_verify($password, $password_admin)) {

                    // Creamos la sesión
                    session_start();
                    $_SESSION['usuario'] = $usuario_admin;
                    $_SESSION['nombre'] = $nombre_admin;

                    // Respuesta exitosa
                    $respuesta = array(
                        'respuesta' => 'exitoso',
                        'usuario' => $nombre_admin
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error'
                    );
                }
            } else {
                // Mandamos la respuesta.
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
        }


        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    die(json_encode($respuesta));
}


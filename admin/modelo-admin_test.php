<?php
// Desarrollo Web Completo
// Video #753 Sección 80: "Creando una Zona de administración Usando LTE"
include_once 'funciones/funciones.php';

// DATOS ENVIADOS DESDE crear-admin.php/editar-admin.php A admin-ajax.js
// name="usuario"
// name="nombre"
// name="password"
// name="registro" TIPO de registro = nuevo/actualizar

// DATOS ENVIADOS DESDE editar-admin.php A admin-ajax.js
// name="id_registro" ### EXTRA ### solo estará disponible en editar-admin.php

###### 1)
//****** */
    // $usuario = $_POST['usuario'];
    // $nombre = $_POST['nombre'];
    // $password = $_POST['password'];
    // $registro = $_POST['registro']; //registro = nuevo/actualizar
    // $id_registro = $_POST['id_registro'];

    #A)
// $_POST['nombre'];

// echo 'Es de tipo: ' . gettype($_POST['nombre']);
// $revisar = (isset($_POST['nombre'])) ? 'SI esta definida' : 'NO esta definida' ;
// $revisar1 = (empty($_POST['nombre'])) ? 'SI esta vacío' : 'NO esta vacío' ;
// $revisar2 = (is_null($_POST['nombre'])) ? 'SI es null' : 'NO es null' ;

// var_dump($_POST, $_POST['nombre'], $revisar, $revisar1, $revisar2);

###### 2)

#a)
// $registro = $_POST['registro'];

// if ($registro == 'nuevo') {
//     die(json_encode($_POST));
// }

// if ($registro == 'actualizar') {
//     die(json_encode($_POST));
// }

#b)
if (isset($_POST['registro'])) {
    

    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];
    $registro = $_POST['registro']; //registro = nuevo/actualizar
    

    if ($registro == 'nuevo') {

        $respuesta = array(
            'usuario' => $usuario,
            'nombre' => $nombre,
            'password' => $password,
            'registro' => $registro
        );
        die(json_encode($respuesta));
        
        // die(json_encode($_POST));
    }

    if ($registro == 'actualizar') {

        $id_registro = $_POST['id_registro'];

        $respuesta = array(
            'usuario' => $_POST['usuario'],
            'nombre' => $_POST['nombre'],
            'password' => $_POST['password'],
            'id_registro' => $_POST['id_registro'],
            'registro' => $_POST['registro']
        );
        die(json_encode($respuesta));
        
        // die(json_encode($_POST));
    }
}









// ######################  L O G I N  ###############################
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


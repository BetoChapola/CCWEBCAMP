<?php
// En la modificación del video 727 uniremos los archivos pagar.php y validar_pago.php. A partir de este video
// Los 2 archivos estarán en el archivo pagar.php
// ya se esta subiendo al nuevo branch CCWEBCAM_paypal

if (!isset($_POST['submit'])) {
    exit("Hubo un error.");
}

// Hacemos el llamado a las clases (namespace) que usaremos en el proyecto:

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;


require 'includes/paypal.php';

if (isset($_POST['submit'])) :
    // Agregar las variables que usaremos:
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $regalo = $_POST['regalo'];
    $total = $_POST['total_pedido'];
    $fecha = date('Y-m-d H:i:s');
    //pedidos
    $boletos = $_POST['boletos'];
    $numero_boletos = $boletos;
    $camisas = $_POST['pedido_extra']['camisas']['cantidad'];
    $precioCamisa= $_POST['pedido_extra']['camisas']['precio'];
    $etiquetas = $_POST['pedido_extra']['etiquetas']['cantidad'];
    $precioEtiquetas = $_POST['pedido_extra']['etiquetas']['precio'];
    include_once 'includes/funciones/funciones.php';
    // $pedido = productos_json($boletos, $camisas, $etiquetas); 
    // TUVE QUE COMENTAR LA FUNCION EN EL ARCHIVO
    // funciones.php YA QUE CAUSABA UN CONFLICTO. AUNQUE CREO QUE BASTABA CON COMENTAR ESTA LINEA
    // O SEA IMPEDIR EL LLAMADO A LA FUNCION.
    //eventos
    $eventos = $_POST['registro'];
    $registro = eventos_json($eventos);

//     echo "<pre>";
//     var_dump($_POST);
//     echo "</pre>";
// exit;
endif;



    //Prepared Statements (una forma mas segura de insertar datos en SQL)
    //Previene la inyección SQL
    try {
        require_once('includes/funciones/bdconexion.php');
        $stmt = $conn->prepare("INSERT INTO registrados 
        (nombre_registrado, apellido_registrado, email_registrado,fecha_registro, 
        pases_articulos, talleres_registrados, regalo, total_pagado) 
        VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param(
            "ssssssis", $nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total
        );
        $stmt->execute();
        $stmt->close();
        //Para evitar que los datos se queden en memoria y se vualvan a insertar en la tabla con F5
        //Usaremos la redirecion con header(); al final estaremos enviando a la misma pagina pero con
        //un valor diferente al final (?exitoso=1)
        header('Location: validar_registro.php?exitoso=1');
    } catch (\Exception $e) {
        echo $e->getMessage();
    }







// Instanciamos la clase Payer();
$compra = new Payer();
$compra->setPaymentMethod('paypal');



// Item();
$articulo = new Item();
$articulo->setName($producto)
         ->setCurrency('MXN')
         ->setQuantity(1)
         ->setPrice($precio);


/*
// Lista de todos los artículos que le vamos a cobrar al cliente guardados en un array();
$listaArticulos = new ItemList();
$listaArticulos->setItems(array($articulo));

// Agregamos los detalles de la venta
$detalles = new Details();
$detalles->setShipping($envio)
         ->setSubtotal($precio);


$cantidad = new Amount();
$cantidad->setCurrency('MXN')
         ->setTotal($total) // Se deben incluir todos los conceptos de cobro (tax, gasto de envío, comisión etc)
         ->setDetails($detalles);

$transaccion = new Transaction();
$transaccion->setAmount($cantidad)
            ->setItemList($listaArticulos)
            ->setDescription('Pago ')
            ->setInvoiceNumber(uniqid());

$redireccionar = new RedirectUrls();
$redireccionar->setReturnUrl(URL_SITIO."/pago_finalizado.php?exito=true")
              ->setCancelUrl(URL_SITIO."/pago_finalizado.php?exito=false");

$pago = new Payment();
$pago->setIntent("sale")
     ->setPayer($compra)
     ->setRedirectUrls($redireccionar)
     ->setTransactions(array($transaccion));

try {
    $pago->create($apiContext);
} catch (PayPal\Exception\PayPalConnectionException $pce) {
    echo "<pre>";
    print_r(json_decode($pce->getData()));
    exit;
    echo "</pre>";
}

// Enlace de aprobación:
$aprobado = $pago->getApprovalLink();

header("Location: {$aprobado}");
*/
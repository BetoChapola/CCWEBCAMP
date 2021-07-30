<!DOCTYPE html>
<!-- Para este ejercicio 25 julio 2021 usamos las instrucciones del video 718 de la sección 77
link de descarga: http://paypal.github.io/PayPal-PHP-SDK/
https://github.com/paypal/PayPal-PHP-SDK/releases  (version 1.14.0)
-->
<html>

<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/5.0.0/normalize.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <div class="formulario">
        <h2>Pagos con Paypal</h2>

        <?php
        $resultado = $_GET['exito'];
        

        // echo "<pre>";
        // var_dump($resultado);
        // echo "</pre>";

        if ($resultado == "true") {
            $paymentId = $_GET['paymentId'];
            echo "El pago se realizo correctamente. <br>";
            echo "El ID es: {$paymentId}";
        }else {
            echo "El pago no se realizó.";
        }

        ?>

    </div>
</body>


</html>
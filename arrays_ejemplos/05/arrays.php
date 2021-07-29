<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>


    <?php //array asociativo
    
        $persona = array (
            'datos' => array(
                'nombre' => 'Alberto',
                'pais' => 'Mexico',
                'profesion' => 'Desarrollador'
            ),
            
            'lenguajes' => array(
                'front_end' => array('css','javascript','html5','jquery'),
                'back_end' => array('php','mysql','python')
            ),
        );
    ?>
    
    <pre>
        <?php var_dump($persona); ?>
    </pre>
    <hr>
    <pre>
        <?php print_r($persona); ?>
    </pre>
    <hr>
    <pre>
        <?php print_r($persona['lenguajes']['front_end'][1]); ?>
    </pre>
    <hr>
    <pre>
        <?php var_export($persona); ?>
    </pre>

    
</body>

</html>
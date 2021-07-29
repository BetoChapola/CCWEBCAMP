<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>


    <?php //array asociativo 
        $persona = array (
            'nombre' => 'Alberto',
            'pais' => 'Mexico',
            'profesion' => 'Desarrollador'
        );
    ?>
    
    <pre>
        <?php print_r($persona); ?>
    </pre>
    
    <pre>
        <?php var_dump($persona); ?>
        <?php echo $persona['nombre']; ?>
    </pre>
    
    <?php echo $persona['nombre']; ?>
    
    <pre>
        <?php print_r(array_values($persona)); ?>
    </pre>
    
    <pre>
        <?php print_r(array_keys($persona)); ?>
    </pre>
    
    
</body>

</html>
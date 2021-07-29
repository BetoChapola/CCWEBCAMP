<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>

    <?php //Revisar que un elemento existe en un arreglo
    
        $tecnologias = array ('CSS','HTML5','JavaScript','jQuery');
        $existe = in_array('HTML5', $tecnologias); //in_array(); solo funciona en array indexados.
        echo $existe;
    ?>

    <pre>
        <?php print_r($existe); ?>
    </pre>
    <pre>
        <?php var_dump($existe); ?>
    </pre>
    <hr>
    
    
    <?php //array asociativo 
        $persona = array (
            'nombre' => 'Alberto',
            'pais' => 'Mexico',
            'profesion' => 'Desarrollador'
        );
    
    
        $existe2 = array_values($persona);
        $existe3 = in_array('Alberto',array_values($persona));
    ?>
    
    <pre>
        <?php var_dump($existe2); ?>
    </pre>
    <pre>
        <?php var_dump($existe3); ?>
    </pre>

</body>

</html>
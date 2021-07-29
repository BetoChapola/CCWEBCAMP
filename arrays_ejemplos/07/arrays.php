<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>

    <?php //Arreglo numerico indexado
    
        $tecnologias = array ('CSS','HTML5','JavaScript','jQuery');
    ?>

    <h2>Lenguajes que conozco</h2>
    
    <ul>
        <?php foreach($tecnologias as $tecnologia): ?>
            <li><?php echo $tecnologia; ?></li>
        <?php endforeach; ?>
    </ul>
    
    
    
    
    <?php //array asociativo 
        $persona = array (
            'nombre' => 'Alberto',
            'pais' => 'Mexico',
            'profesion' => 'Desarrollador'
        );
    ?>

    <h2>Datos personales</h2>
    <ul>
        <?php foreach($persona as $key => $val): ?> 
            <li><?php echo $key . ': ' . $val; ?></li>
        <?php endforeach ?>
    </ul>
    <ul>
        <?php foreach($persona as $val): //por defaul retorna los valores, no las keys ?> 
            <li><?php echo $val; ?></li>
        <?php endforeach ?>
    </ul>
    

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>

    <?php //array asociativo Y MULTIDIMENSIONAL
    
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
        <?php print_r($persona); ?>
    </pre>
    <hr>



    <h2>Foreach arreglos Multidimensionales</h2>

    <ul>
        <h2>Datos</h2>
        <?php foreach($persona['datos'] as $person): ?>
            <li><?php echo $person; ?></li>
        <?php endforeach; ?>

        <?php foreach($persona as $lenguajes): ?>

            <?php if(array_key_exists('front_end', $lenguajes)): ?>
                <h2>Lenguajes de Front End</h2>
                <?php foreach($lenguajes['front_end'] as $front): ?>
                    <li><?php echo $front ?></li>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if(array_key_exists('back_end', $lenguajes)): ?>
                <h2>Lenguajes de Back End</h2>
                <?php foreach($lenguajes['back_end'] as $back): ?>
                    <li><?php echo $back ?></li>
                <?php endforeach; ?>
            <?php endif; ?>

        <?php endforeach; ?>

    </ul>
    <hr>




    <h2>Foreach arreglos Multidimensionales 2da forma:</h2>

    <ul>
        <h2>Datos</h2>
        <?php foreach($persona['datos'] as $person2): ?>
            <li><?php echo $person2 ?></li>
        <?php endforeach; ?>

        <h2>Lenguajes de Front End</h2>
        <?php foreach($persona['lenguajes']['front_end'] as $leng): ?>
            <li><?php echo $leng ?></li>
        <?php endforeach; ?>

        <h2>Lenguajes de Back End</h2>
        <?php foreach($persona['lenguajes']['back_end'] as $leng): ?>
            <li><?php echo $leng ?></li>
        <?php endforeach; ?>
    </ul>





</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>


    <?php // versiones anteriores
    
        $tecnologias = ['CSS','HTML5','JavaScript','jQuery'];
    ?>

    <pre>
        <?php print_r($tecnologias); ?>
    </pre>


    

    <?php
    
        $tecnologias[] = 'Python'; //agrega un elemento al final de array
        $tecnologias[5] = 'Java'; //agrega un elemento al fina del array, se sabe el numero especifico del ultimo elemento [4], por eso sabemos que el elemento [5] sera el ultimo 
        $tecnologias[2] = 'Ruby'; //cambia el contenido de un elemento ya existente

    ?>

    <pre>
        <?php print_r($tecnologias);  ?>
    </pre>


  
   
    <?php //borrar el ultimo elemento y traerlo en un variable 
            $java = array_pop($tecnologias);
    ?>

    <h1><?php echo $java ?></h1>

    <pre>
        <?php print_r($tecnologias);  ?>
    </pre>
    
    
    
    
    <?php //borrar cualquier posicion del array
          //Borra el index del array numerico.
        unset($tecnologias[3]);
    ?>
    
    <pre>
        <?php print_r($tecnologias);  ?>
    </pre>
    
    
    
    
    <?php //Remover primer elemento y agregarlo a un variable 
         $removido = array_shift($tecnologias);
    ?>
    
    <h1><?php echo $removido ?></h1>
    
    <pre>
        <?php print_r($tecnologias);  ?>
    </pre>
    
    
    
    
    <?php //Remover primer elemento y agregarlo a un variable 
         $array = array_splice($tecnologias, 1, 1, array('AngularJS', 'Jquery'));
    ?>
    
    <pre>
        <?php print_r($array) ?>
    </pre>
    
    <pre>
        <?php print_r($tecnologias);  ?>
    </pre>
    
    
</body>

</html>
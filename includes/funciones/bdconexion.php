<?php

    $conn = new mysqli('localhost','root','','ccwebcamp'); //No tenemos clave

    if($conn->connect_error){
        echo $error->$conn->connect_error;
    }

?>
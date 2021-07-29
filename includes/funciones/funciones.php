<?php

function productos_json(&$boletos, &$camisas = 0, &$etiquetas = 0){
    $dias = array(
        0 => 'un dia',
        1 => 'pase_completo',
        2 => 'pase_2dias'
    );

    /**Combinamos 2 arrays con la funcion array_combine($array1, $array2);
     * la funcion crea un array combinado:
     * $total_boletos = {'llave' => 'valor'.....'llaveN' => 'valorN'}
     * $total_boletos = {'un_dia' => '', 'pase_completo => '', 'pase_2dias' => '')
     * 
     * }
    */
    $total_boletos = array_combine($dias, $boletos);

    //funcion que convierte un array a Json: json_encode();
    //1) Creamos un array vacío.
    $json = array();

    foreach ($total_boletos as $key => $boletos):
        if((int) $boletos > 0): //Convertimos $boletos a int porque originalmente era un string
    //Queremos que se guarde en la llave actual $json[$key] el valor convertido a int = (int) $boletos;
            $json[$key] = (int) $boletos;
        endif;
    endforeach;

    $camisas = (int) $camisas;
    if($camisas > 0){
        $json['camisas'] = $camisas; 
    }
    $etiquetas = (int) $etiquetas;
    if($etiquetas > 0){
        $json['etiquetas'] = $etiquetas; 
    }

    return json_encode($json);

}

function eventos_json(&$eventos){
    $eventos_json = array();

    foreach($eventos as $evento) :
        $eventos_json ['eventos'][] = $evento;
    endforeach;

    return json_encode($eventos_json);
}

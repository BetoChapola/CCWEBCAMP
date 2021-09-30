<?php

function productos_json(&$boletos, &$camisas = 0, &$etiquetas = 0){
    $dias = array(
        0 => 'un dia',
        1 => 'pase_completo',
        2 => 'pase_2dias'
    );

    unset ($boletos['un_dia']['precio']);
    unset ($boletos['dos_dias']['precio']);
    unset ($boletos['pase_completo']['precio']);

    $total_boletos = array_combine($dias, $boletos);


    // Array de extras:
    $camisas = (int) $camisas;
    if($camisas > 0){
        $total_boletos['camisas'] = $camisas; 
    }
    $etiquetas = (int) $etiquetas;
    if($etiquetas > 0){
        $total_boletos['etiquetas'] = $etiquetas; 
    }

    return json_encode($total_boletos);

}

// ! VIDEO 786 cambiamos mucho de esta funcion original:

// function productos_json(&$boletos, &$camisas = 0, &$etiquetas = 0){
//     $dias = array(
//         0 => 'un dia',
//         1 => 'pase_completo',
//         2 => 'pase_2dias'
//     );

//     /**Combinamos 2 arrays con la función array_combine($array1, $array2);
//      * la función crea un array combinado:
//      * $total_boletos = {'llave' => 'valor'.....'llaveN' => 'valorN'}
//      * $total_boletos = {'un_dia' => 'valor', 'pase_completo => 'valor', 'pase_2dias' => 'valor')
//      * 
//      * }
//     */
//     $total_boletos = array_combine($dias, $boletos);

//     //función que convierte un array a Json: json_encode();
//     //1) Creamos un array vacío.
//     $json = array();

//     foreach ($total_boletos as $key => $boletos):
//         if((int) $boletos > 0): //Convertimos $boletos a int porque originalmente era un string
//     //Queremos que se guarde en la llave actual $json[$key] el valor convertido a int = (int) $boletos;
//             $json[$key] = (int) $boletos;
//         endif;
//     endforeach;

//     $camisas = (int) $camisas;
//     if($camisas > 0){
//         $json['camisas'] = $camisas; 
//     }
//     $etiquetas = (int) $etiquetas;
//     if($etiquetas > 0){
//         $json['etiquetas'] = $etiquetas; 
//     }

//     return json_encode($json);

// }

function eventos_json(&$eventos){
    $eventos_json = array();

    foreach($eventos as $evento) :
        $eventos_json ['eventos'][] = $evento;
    endforeach;

    return json_encode($eventos_json);
}

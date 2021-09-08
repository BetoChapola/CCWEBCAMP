$(document).ready(function () {

  /** 
    Esta es la función jQuery para llamar al formulario por su ID. En su evento 'submit' ejecutamos una función
    y atrapamos su evento (e). Prevenimos que se ejecute el 'action' del <form> para que podamos manejar los datos desde
    jQuery.
  */

  //======================================================================
  // INSERTAR NUEVO ADMINISTRADOR
  //======================================================================
  $('#guardar-registro').on('submit', function (e) {
    e.preventDefault();

    // Podemos almacenar los datos en un array de varios objetos, es similar al FormData();
    var datos = $(this).serializeArray();
      /*
          la estructura del array serializeArray() es similar a esto:
          Array(4) [ {…}, {…}, {…}, {…} ]
          0: Object { name: "usuario", value: "_dato_" }
          1: Object { name: "nombre", value: "_dato_" }
          2: Object { name: "password", value: "_dato_" }
          3: Object { name: "agregar-admin", value: "_dato_" }
      */


    $.ajax({
      type: $(this).attr('method'),
      data: datos,
      url: $(this).attr('action'),
      dataType: 'json',
      success: function (data) {
        // Aquí recibímos la respuesta del archivo que esta en la "url: $(this).attr('action')", en este caso es
        // modelo-admin.php.
        console.log(data);

        var resultado = data;
        if (resultado.respuesta == 'exito') {
          Swal.fire(
            'Correcto!',
            'El administrador se creo correctamente!',
            'success'
          )
        } else {
          Swal.fire(
            'Error!',
            'Hubo un error!',
            'error'
          )
        }
      }
    })
  });


  //======================================================================
  // ELIMINAR ADMINISTRADOR
  //======================================================================
  $('.borrar_registro').on('click', function (e) {
      e.preventDefault();

      // Vamos a utilizar nuestros atributos personalizados: data-id y data-tipo
      // Creamos data-tipo para usar menos archivos. Asi solo haremos llegar el "tipo" de elemento que queremos borrar,
      // haciendo mas reutilizable nuestro código.
      var id = $(this).attr('data-id');
      var tipo = $(this).attr('data-tipo');

      Swal.fire({
          title: '¿Quieres eliminar este registro?',
          text: "Un registro eliminado no se puede recuperar!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, Eliminar!',
          cancelButtonText: 'No, Cancelar!'
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                type: 'post',
                data: {
                  'id': id,
                  'registro': 'eliminar'
                },
                url: 'modelo-' + tipo + '.php',
                success: function (data) {
                    var resultado = JSON.parse(data);
                    // console.log(resultado);
                    if (resultado.respuesta == 'exito') {
                        Swal.fire(
                          'Eliminado!',
                          'El registro ha sido eliminado.',
                          'success'
                        )
                        jQuery('[data-id="' + resultado.id_eliminado + '"]').parents('tr').remove();
                    } else {
                      Swal.fire({
                          icon: 'error',
                          title: 'Error...',
                          text: 'No se pudo eliminar!'
                      })
                    }
                }
            })

          }
      })
  });

});

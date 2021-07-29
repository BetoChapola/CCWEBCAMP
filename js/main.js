(function(){
    "use strict";
    
    var regalo = document.getElementById('regalo');
    
    document.addEventListener('DOMContentLoaded', function(){

        
        
        
        //datos usuario
        var nombre = document.getElementById('nombre');
        var apellido = document.getElementById('apellido');
        var email = document.getElementById('email');
        
        
        //campos pasess
        var pase_dia = document.getElementById('pase_dia');
        var pase_dos_dias = document.getElementById('pase_dos_dias');
        var pase_completo = document.getElementById('pase_completo');
        
        //botones y divs
        var calcular = document.getElementById('calcular');
        var errorDiv = document.getElementById('error');
        var botonRegistro = document.getElementById('btnRegistro');
        botonRegistro.disabled = true; //el boton esta desabilitado pero el css lo mantiene con los colores "habilitado". Necesario corregir
        var lista_productos = document.getElementById('lista_productos');
        var suma = document.getElementById('suma_total');

        
        
        //extras
        var camisa = document.getElementById('camisa_evento');
        var etiquetas = document.getElementById('etiquetas');
         
        
        calcular.addEventListener('click', calcularMontos);
        
        pase_dia.addEventListener('blur', mostrarDias);
        pase_dos_dias.addEventListener('blur', mostrarDias);
        pase_completo.addEventListener('blur', mostrarDias);
        
        nombre.addEventListener('blur', validarCampos);
        apellido.addEventListener('blur', validarCampos);
        email.addEventListener('blur', validarCampos);
        email.addEventListener('blur', validarMail);

        
        
        function validarCampos(){
            if(this.value == ''){
                errorDiv.style.display = 'block';
                errorDiv.innerHTML = "Este campo es obligatorio";
                this.style.border = '1px solid red';
                errorDiv.style.border = '1px solid red';
            }else{
                errorDiv.style.display = 'none';
                this.style.border = '1px solid #cccccc';
            }
        }
        
        /*Esta es otra forma de hacer una funcion de validacion para el registro de usuarios.
        
        nombre.addEventListener('blur', function(){
            if(this.value == ''){
                errorDiv.style.display = 'block';
                errorDiv.innerHTML = "Este campo es obligatorio";
                this.style.border = '1px solid red';
                errorDiv.style.border = '1px solid red';
            }else{
                errorDiv.style.display = 'none';
                this.style.border = '1px solid #cccccc';
            }
        })*/
        
        function validarMail() {
            if (this.value.indexOf("@") > -1) {
                errorDiv.style.display = 'none';
                this.style.border = '1px solid #cccccc';
            }else{
                errorDiv.style.display = 'block';
                errorDiv.innerHTML = "Este campo debe contener un mail valido";
                this.style.border = '1px solid red';
                errorDiv.style.border = '1px solid red';
            }
        }
        
        function calcularMontos(event){
            event.preventDefault();
            
            if(regalo.value === ''){
                alert("Debes elegir un regalo");
                regalo.focus();
            }else{
                var boletosDia = parseInt(pase_dia.value, 10) || 0,
                    boletos2Dias = parseInt(pase_dos_dias.value, 10) || 0,
                    boletoCompleto = parseInt(pase_completo.value, 10) || 0,
                    cantidadCamisas = parseInt(camisa.value, 10) || 0,
                    cantidadEtiquetas = parseInt(etiquetas.value, 10) || 0;
                /*
                La función parseInt comprueba el primer argumento, una cadena, e intenta devolver un entero de la base especificada. Por ejemplo, una base de 10 indica una conversión a número decimal, 8 octal, 16 hexadecimal, y así sucesivamente.
                https://developer.mozilla.org/es/docs/Web/JavaScript/Referencia/Objetos_globales/parseInt
                
                || 0
                Convierte un NaN en el valor que asignemos, ejemplos:
                || 0
                || "Hola, no soy un número"
                */
                var totalPagar = (boletosDia * 30) + (boletos2Dias * 45) + (boletoCompleto * 50) + ((cantidadCamisas * 10) * .93) + (cantidadEtiquetas * 2);
                
                var listadoProductos = new Array();
                
                if(boletosDia >= 1){
                   listadoProductos.push(`${boletosDia} Pases por día`);
                   }
                if(boletos2Dias >= 1){
                    listadoProductos.push(`${boletos2Dias} Pases por 2 días`);
                }
                if(boletoCompleto >= 1){
                    listadoProductos.push(`${boletoCompleto} Pases completos`);
                }
                if(cantidadCamisas >= 1){
                    listadoProductos.push(`${cantidadCamisas} Camisas`);
                }
                if(cantidadEtiquetas >= 1){
                    listadoProductos.push(`${cantidadEtiquetas} Etiquetas`);
                }
                
                lista_productos.style.display = "block";
                lista_productos.innerHTML = '';
                for(var i = 0; i<listadoProductos.length; i++){
                    lista_productos.innerHTML += listadoProductos[i] + '<br/>';
                }
                
                suma.innerHTML = "$ " + totalPagar.toFixed(2);

                botonRegistro.disabled = false;
                document.getElementById('total_pedido').value = totalPagar;
            }
            
            
        }
        
        function mostrarDias(){
            var boletosDia = parseInt(pase_dia.value, 10) || 0,
                boletos2Dias = parseInt(pase_dos_dias.value, 10) || 0,
                boletoCompleto = parseInt(pase_completo.value, 10) || 0;
            var diasElegidos = [];
            
            if (boletosDia > 0){
                diasElegidos.push('viernes');
                console.log(diasElegidos);
            }
            if (boletos2Dias > 0){
                diasElegidos.push('viernes','sabado');
                console.log(diasElegidos);
            }else{
                document.getElementById(diasElegidos).style.display = 'none';
            }
            if (boletoCompleto > 0){
                diasElegidos.push('viernes','sabado','domingo');
                console.log(diasElegidos);
            }
            for (var i=0; i < diasElegidos.length; i++){
                document.getElementById(diasElegidos[i]).style.display = 'block';
            }
        }
        
        
        
        
        //mapa(puse este script al final del código porque al principio causa conflictos en la páagina de registro.php)
        var map = L.map('mapa').setView([21.155563, -86.837305], 19);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([21.155563, -86.837305]).addTo(map)
            .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
            .openPopup();




    });//DOM CONTENT LOADED
})();


$(function (){
    
    //LETTERING
    $('.nombre-sitio').lettering();

    //Agregar clase a Menú
    $('body.conferencia .navegacion-principal a:contains("Conferencia")').addClass('activo');
    $('body.calendario .navegacion-principal a:contains("Calendario")').addClass('activo');
    $('body.invitados .navegacion-principal a:contains("Invitados")').addClass('activo');

    
    //MENU FIJO
    var windowHeight = $(window).height();
    var barraAltura = $('.barra').innerHeight();
    
    $(window).scroll(function (){
        var scroll = $(window).scrollTop();
        if (scroll > windowHeight) {
            $('.barra').addClass('fixed');
            $('body').css({'margin-top' : barraAltura + 'px'});
        } else {
            $('.barra').removeClass('fixed');
            $('body').css({'margin-top': '0px'});
        }
    });
    
    //MENU MOVIL (HAMBURGUESA)
    
    //PROGRAMA DE CONFERENCIAS
    /*
    $('div.ocultar').hide();
    
    podemos hacer uso de jQuery para ocultar un div. O podemos de igual forma hacerlo con CSS:
    
    div.ocultar{
    display: none;
    }
    
    En el turotial se hace con CSS.
    */
    $('div.ocultar').hide();
    $('.programa-evento .info-curso:first').show();
    $('.menu-programa a:first').addClass('activo');
    
    
    $('.menu-programa a').on('click', function() {
        $('.menu-programa a').removeClass('activo');
        $(this).addClass('activo');
        $('.ocultar').hide();
        var enlace = $(this).attr('href');
        $(enlace).fadeIn(700);
        return false; //para evitar saltos en la pantalla
    });
    
    
    //ANIMACION PARA NUMEROS
    $('.resumen-evento li:nth-child(1) p').animateNumber({number: 6}, 1200);
    $('.resumen-evento li:nth-child(2) p').animateNumber({number: 15}, 1200);
    $('.resumen-evento li:nth-child(3) p').animateNumber({number: 3}, 600);
    $('.resumen-evento li:nth-child(4) p').animateNumber({number: 9}, 1500);
    
    //ANIMACION CUENTA REGRESIVA
    $('.cuenta-regresiva').countdown('2021/12/10 9:00:00', function(event) {
        $('#dias').html(event.strftime('%D'));
        $('#horas').html(event.strftime('%H'));
        $('#minutos').html(event.strftime('%M'));
        $('#segundos').html(event.strftime('%S'));
    });

    //ColorBox
    $('.invitado-info').colorbox({inline:true, width:"50%"});



});























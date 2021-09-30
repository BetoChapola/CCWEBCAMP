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


    var map = L.map('mapa').setView([21.155563, -86.837305], 19);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([21.155563, -86.837305]).addTo(map)
            .bindPopup('CCWebCamp.<br> Te esperamos.')
            .openPopup();

});























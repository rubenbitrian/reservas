$('.stateSelector').change(function(e) {
    var stateId = $(this).find('option:selected').val();
    var bookingId = $(this).parent().siblings(":first").text();
    $.ajax({
        // En data puedes utilizar un objeto JSON, un array o un query string
        data: {
            "bookingId" : bookingId, 
            "stateId" : stateId
        },
        //Cambiar a type: POST si necesario
        type: "POST",
        // Formato de datos que se espera en la respuesta
        dataType: "json",
        // URL a la que se enviará la solicitud Ajax
        url: Routing.generate('admon_estado_switchState'),
    })
    .done(function( data, textStatus, jqXHR ) {
        if(data) {

        } 
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {

    });
})

$('.endDatepicker').prop( "disabled", true );
$('.startDatepicker').change(function() {
    $('.endDatepicker').prop( "disabled", false );
    $(".endDatepicker").datepicker({
        format: 'dd/mm/yyyy',
        startDate: this.value,
        language: "es",
        datesDisabled: dateArr,
        autoclose: true
    });
});
$('.endDatepicker').change(function() {
    $.ajax({
        // En data puedes utilizar un objeto JSON, un array o un query string
        data: {"startDate" : $('.startDatepicker').val(), "endDate" : $('.endDatepicker').val()},
        //Cambiar a type: POST si necesario
        type: "POST",
        // Formato de datos que se espera en la respuesta
        dataType: "json",
        // URL a la que se enviará la solicitud Ajax
        url: Routing.generate('testDate'),
    })
    .done(function( data, textStatus, jqXHR ) {
        if(data) {
            $('.startDatepicker').removeClass('is-invalid');
            $('.endDatepicker').removeClass('is-invalid');

            $('.startDatepicker').addClass('is-valid');
            $('.endDatepicker').addClass('is-valid');
        } else {
            $('.startDatepicker').removeClass('is-valid');
            $('.endDatepicker').removeClass('is-valid');
            $('.startDatepicker').addClass('is-invalid');
            $('.endDatepicker').addClass('is-invalid');
            $('.startDatepicker').val('');
            $('.endDatepicker').val('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        alert('Ha ocurrido un problema interno, intentelo de nuevo, en el caso de persistir este problema, hable con el administrador de la aplicacion.');

    });
});
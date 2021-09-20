$(document).ready(function() {
    var dateToday = new Date();
    let day = dateToday.getDate();
    let month = dateToday.getMonth() + 1;
    let year = dateToday.getFullYear();
    if(month < 10){
        esDate = `${day}/0${month}/${year}`;
    }else{
        esDate = `${day}/${month}/${year}`;
    }
    // fechasPilladas = {{ fechasPilladas|json_encode() }}

    $(".startDatepicker").datepicker({
        format: 'dd/mm/yyyy',
        startDate: esDate,
        language: "es",
        datesDisabled: dateArr,
        autoclose: true
    });
})
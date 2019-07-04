$(document).ready(function () {
    $('#num_pre').change(function () {
        sumnum();
    });

    $('#num_iqf').change(function () {
        sumnum();
    });
});

function sumnum(){
    var numpre = $('#num_pre').val();
    var numiqf = $('#num_iqf').val();
        var total = parseFloat(numpre) + parseFloat(numiqf);
        $('#num_all').val(total);

}

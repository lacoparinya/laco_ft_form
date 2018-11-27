$(document).ready(function () {
    $('#input_kg').change(function () {
       calpercent()
    });

    $('#output_kg').change(function () {
        calpercent()
    });

    $('#num_pk').change(function () {
        sumclassify();
    });

    $('#num_pf').change(function () {
        sumclassify();
    });

    $('#num_pst').change(function () {
        sumclassify();
    });
});

function calpercent(){
     var inp = $('#input_kg').val();
     var oup = $('#output_kg').val();
     var yeild = 0;
     if (inp > 0 && oup > 0) {
         yeild = (oup * 100 / inp).toFixed(2);
     }
     $('#yeild_percent').val(yeild);
}

function sumclassify(){
    var pk = $('#num_pk').val();
    var pf = $('#num_pf').val();
    var pst = $('#num_pst').val();
    var sum = 0;
    if (pk > 0) {
        sum = parseInt(sum) + parseInt(pk);
    }
    if (pf > 0) {
        sum = parseInt(sum) + parseInt(pf);
    }
    if (pst > 0) {
        sum = parseInt(sum) + parseInt(pst);
    }

    $('#num_classify').val(sum);
}
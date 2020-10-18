$(document).ready(function () {
    $('#mat_pack_id').change(function () {
        getrate()
    });

    $('#stamp_machine_id').change(function () {
        getrate()
    });

});

function getrate(){

    var matpack = $('#mat_pack_id').val();
    var stampmachine = $('#stamp_machine_id').val();
    var _token = $('input[name="_token"]').val();

    $.ajax({
        url: '/ft_form/mat-pack-rates/getrate',
        method: "POST",
        data: {
            matpackid: matpack,
            stampmachineid: stampmachine,
            _token: _token
        },
        success: function (result) {
            var jresult = JSON.parse(result);
            if (jresult.value > 0){
                $('#rateperhr').val(jresult.value);
            }            
        }
    })
}

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

function calLine(){
    var line_a = $('#line_a').val();
    var line_b = $('#line_b').val();
    var line_classify_unit = $('#line_classify_unit').val();
    var totalLine = 0;
    if (line_classify_unit == '1'){
        $('#line_classify').attr('readonly', 'readonly');
        if (line_a > 0) {
            totalLine = parseInt(totalLine) + parseInt(line_a);
        }
        if (line_b > 0) {
            totalLine = parseInt(totalLine) + parseInt(line_b);
        }

        $('#line_classify').val(totalLine);
        
    }else{
        $('#line_classify').removeAttr('readonly');
        $('#line_classify').val('');
    }
}
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

    $('#line_a').change(function () {
        calLine();
    });

    $('#line_b').change(function () {
        calLine();
    });

    $('#line_classify_unit').change(function () {
        calLine();
    });

    $('.dynamic').change(function () {
        if ($(this).val() != '') {
            var select = $(this).attr("id");
            var value = $(this).val();
            var dependent = $(this).data('dependent');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '/ft_form/dynamic-list/shiftfetch',
                method: "POST",
                data: {
                    select: select,
                    value: value,
                    _token: _token,
                    dependent: dependent
                },
                success: function (result) {
                    var jresult = JSON.parse(result);
                    $('#' + dependent).val(jresult.value);
                    $('#' + dependent + '_show').val(jresult.label);
                }
            })
        }
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
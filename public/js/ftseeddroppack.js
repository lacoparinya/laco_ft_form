$(document).ready(function () {
    $('#method_id').change(function () {
        setshowhidedata()
    });

    setshowhidedata();

});

function setshowhidedata(){

    var method = $('#method_id').val();
    var _token = $('input[name="_token"]').val();

    $.ajax({
        url: '/ft_form/seed-drop-packs/getkey',
        method: "POST",
        data: {
            method: method,
            _token: _token
        },
        success: function (result) {
            var jresult = JSON.parse(result);

            $('.allform').hide();

            $.each(jresult,function( key, value ) {
                $('.d'+ value).show();
            });       
        }
    })
}

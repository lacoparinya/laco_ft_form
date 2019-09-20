$(document).ready(function () {
    $('.sumkg').change(function () {
        calpercent();
        calproductivity();
    });

    $('.calpack').change(function () {
        caloutput();
    });

    $('#order_name').autocomplete(
        {
            position: { my: "left top", at: "left bottom" },
            source: function (request, response) {
                $.ajax({
                    url: "/ft_form/dynamic-list/getorder",
                    dataType: "jsonp",
                    data: {
                        q: request.term
                    },
                    success: function (data) {
                        $('#order_id').val('');
                        response($.map(data, function (item) {
                            console.log(item);
                            return {
                                label: item.order_no,
                                value: item.order_no,
                                realv: item.id,
                                reald: item.loading_date
                            }
                        }));
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert("error: " + errorThrown);
                    }
                });
            },
            minLength: 3,
            select: function (event, ui) {
                $('#order_id').val(ui.item.realv);
                $('#order_date').val(ui.item.reald);
            }
        });

});

function calpercent() {
    var inp = $('#input_kg').val();
    var oup = $('#output_kg').val();
    var yeild = 0;
    if (inp > 0 && oup > 0) {
        yeild = (oup * 100 / inp).toFixed(3);
    }
    console.log(inp);
    console.log(oup);
    console.log(yeild);
    $('#yeild_percent').val(yeild);
}

function calproductivity() {
    var oup = $('#output_kg').val();
    var num = $('#num_pack').val();
    var prod = 0;

    if (oup > 0 && num > 0) {
        prod = (oup / num).toFixed(3);
    }

    $('#productivity').val(prod);
}

function caloutput() {
    var oup = $('#output_kg').val();
    var kgperpack = $('#kgsperpack').val();
    var outpack = 0;
    if (kgperpack > 0) {
        outpack = (oup / kgperpack).toFixed(0);
    }

    $('#output_pack').val(outpack);
}

$(document).ready(function () {
    $('.sumkg').change(function () {
        sumalldata();
        var recvRM = $('#recv_RM').val();
        if (parseFloat(recvRM) > 0) {
            addrm();
        }
    });

    $('#recv_RM').change(function () {
        addrm();
    });
});

function sumalldata(){
    var sum = 0;
    var total = 0;
    for (let index = 1; index < 11; index++) {
        str = '#output_custom' + index;
        if($(str).length){
            tmp = parseFloat($(str).val());
            sum = sum + tmp;
        }
    }
    $('#output_sum').val(sum);
    var lastsum = $('#prev_output_all_sum').val();
    total = sum + parseFloat(lastsum);
    $('#output_all_sum').val(total);

    var prevRM = $('#prev_current_RM').val();
    if (parseFloat(prevRM) > 0) {
        var total = parseFloat(prevRM) - parseFloat(sum);

        $('#current_RM').val(total);
    }else{
        $('#current_RM').val(sum);
    }

}

function addrm(){
    var recvRM = $('#recv_RM').val();
    var sumOutput = $('#output_sum').val();

    var total = parseFloat(recvRM) - parseFloat(sumOutput);

    $('#current_RM').val(total);
}

function checkShift(){
    var txtTime = $('#process_time').val()
    var aTime = txtTime.split(":");
    console.log(aTime[0]);
}

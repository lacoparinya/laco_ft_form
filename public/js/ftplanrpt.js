$(document).ready(function () {
    $('#month').change(function () {    
       getprevdata();
    });

    $('#year').change(function () {
        getprevdata();
    });

});

function getprevdata() {
    var month = $("#month").val();
    var year = $("#year").val();

    $.ajax({
      url: "/ft_form/planrpt/getprevdata/" + month + "/" + year,
      type: "GET",
      data: {},
      success: function (response) {
        console.log(response["details"]);
        $.each(response['details'], function (key, value) {
          
          $("#num_delivery_plan-" + value.plan_group_id).val(value.num_delivery_plan);
          $("#num_confirm-" + value.plan_group_id).val(value.num_confirm);
          $("#num_packed-" + value.plan_group_id).val(value.num_packed);
          $("#num_wait-" + value.plan_group_id).val(value.num_wait);
        });
        alert('Get data from Prev');
      },
      error: function (response) {
        alert("Error" + response);
      },
    });

    
}


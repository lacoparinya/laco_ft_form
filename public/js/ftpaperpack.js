$(document).ready(function () {
    $('.calexpdate').change(function(){
        var selectset = $(this).attr('data-ref');
        recalexpdate(selectset);
    });

    $(".calexpdatelot").change(function () {
      var selectset = $(this).attr("data-ref");
      recalexpdatelot(selectset);
    });

    $(".calexpdateall").change(function () {
        $(".calexpdate").each(function(){
            var selectset2 = $(this).attr("data-ref");
            recalexpdate(selectset2);
        });

        $(".calexpdatelot").each(function () {
          var selectset2 = $(this).attr("data-ref");
          recalexpdatelot(selectset2);
        });
      
    });



    $(".calbox").change(function(){
        var selectset3 = $(this).attr("data-ref");
        console.log(selectset3);
        recalbox(selectset3);
    });

    $(".recalweight").change(function () {
      
      var selectset2 = $(this).attr("data-ref");
      recalweight(selectset2);
    });

});

function recalbox(selectset) {
    var frombox = $("#fbox" + selectset).val();
    var tobox = $("#tbox" + selectset).val();
    var numpackperbox = $("#number_per_pack").val();
    var outerweightkg = $("#outer_weight_kg").val();
    var numofbox = 0;
    var numofpack = 0;
    var weightf = 0;
    var weightp = 0;
    console.log(tobox + " " + frombox);
    if (parseInt(tobox) > parseInt(frombox)) {
      numofbox = tobox - frombox + 1;
      console.log(numofbox);
    }
    if(numofbox >0){
        numofpack = numofbox * numpackperbox;
        weightf = numofbox * outerweightkg;
        weightp = weightf / 0.95;
    }

    $("#nbox" + selectset).val(numofbox);
    $("#nbag" + selectset).val(numofpack);
    $("#fweight" + selectset).val(parseFloat(weightf).toFixed(2));
    $("#pweight" + selectset).val(parseFloat(weightp).toFixed(2));
}


function myAddMonths(date, months) {
  var d = date.getDate();
  date.setMonth(date.getMonth() + +months);
  if (date.getDate() != d) {
    date.setDate(0);
  }
  return date;
}

function recalexpdate(selectset){
    var myselectdate = $("#pack_date" + selectset).val();
    var expmonth = $("#exp_month").val();
    var newaddmonth = myAddMonth(myselectdate, expmonth);
    $("#exp_date" + selectset).val(
      newaddmonth.getFullYear() +
        "-" +
        ("0" + (newaddmonth.getMonth() + 1)).slice(-2) +
        "-" +
        ("0" + newaddmonth.getDate()).slice(-2)
    );
}

function recalexpdatelot(selectset) {
  var myselectdate = $("#packdate" + selectset).val();
  var expmonth = $("#exp_month").val();
  var newaddmonth = myAddMonth(myselectdate, expmonth);
  $("#expdate" + selectset).val(
    newaddmonth.getFullYear() +
      "-" +
      ("0" + (newaddmonth.getMonth() + 1)).slice(-2) +
      "-" +
      ("0" + newaddmonth.getDate()).slice(-2)
  );
}

function myAddMonth(txtdate,monthnum){
  var d = new Date(txtdate);

  d.setMonth(parseInt(d.getMonth()) + parseInt(monthnum));
  var newdate = new Date(txtdate);
  newdate.setDate(1);
  newdate.setMonth(parseInt(newdate.getMonth()) + parseInt(monthnum));

  if (newdate.getMonth() == d.getMonth()) {
    return d;
  } else {
    d.setDate(parseInt(d.getDate()) - parseInt(1));
    if (newdate.getMonth() == d.getMonth()) {
      return d;
    } else {
      d.setDate(parseInt(d.getDate()) - parseInt(1));
      if (newdate.getMonth() == d.getMonth()) {
        return d;
      } else {
        d.setDate(parseInt(d.getDate()) - parseInt(1));
        if (newdate.getMonth() == d.getMonth()) {
          return d;
        }
      }
    }
  }

}

function recalweight(selectset){
  var numbox = $("#all_bpack" + selectset).val();
  var outerweightkg = $("#outer_weight_kg").val();
  var totalweight = parseInt(numbox) * outerweightkg;
  $("#all_weight" + selectset).val(parseFloat(totalweight).toFixed(2));
}
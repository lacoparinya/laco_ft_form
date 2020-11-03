$(document).ready(function () {
    $('#process_datetime').change(function () {
        var url = "/ft_form/mains/weight/" + $(this).val();
        $(location).attr('href', url);
    });

});


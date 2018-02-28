$(document).ready(function () {
    $('#is_free').on('change', function () {
        console.log($(this).val());
        if ($(this).val() == 0) {
            $('#delivery_cost').fadeIn();
        } else {
            $('#delivery_cost').fadeOut();
        }
    });
    $(document).ready(function() {
        $('.select2').select2();
    });
});

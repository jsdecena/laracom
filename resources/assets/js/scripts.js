$(document).ready(function () {
    $('#is_free').on('change', function () {
        console.log($(this).val());
        if ($(this).val() == 0) {
            $('#delivery_cost').fadeIn();
        } else {
            $('#delivery_cost').fadeOut();
        }
    });
    $('.select2').select2({
        placeholder: 'Select'
    });
    $('.table').DataTable({
        'info' : false,
        'paging' : false,
        'searching' : false,
        'columnDefs' : [
            {
                'orderable': false, 'targets' : -1
            }
        ],
        'sorting' : []
    });

    $('.btn-radio').click(function(e) {
        $('.btn-radio').not(this).removeClass('active')
            .siblings('input').prop('checked',false)
            .siblings('.img-radio').css('opacity','0.5');
        $(this).addClass('active')
            .siblings('input').prop('checked',true)
            .siblings('.img-radio').css('opacity','1');
    });
});

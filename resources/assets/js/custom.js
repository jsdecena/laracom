$(document).ready(function () {
    $("#brand-logo").owlCarousel({
        autoPlay: 3000, //Set AutoPlay to 3 seconds
        items: 6,
        itemsDesktop: [1199, 6],
        itemsDesktopSmall: [979, 6]
    });

    $('.select2').select2();

    if ($('#thumbnails li img').length > 0) {
        $('#thumbnails li img').on('click', function () {
            $('#main-image')
                .attr('src', $(this).attr('src') +'?w=400')
                .attr('data-zoom', $(this).attr('src') +'?w=1200');
        });
    }

    $("input[name$='eyewear_options']").click(function() {
        var modalToLoad = $(this).val();
        $('#'+modalToLoad).css({'padding-right': '35%'});
        $('#'+modalToLoad).modal({backdrop: 'static', keyboard: false});
        $('#'+modalToLoad).modal('show');
    });

    $("#modal-close").click(function(){
        $("input[name$='eyewear_options']").prop('checked', false);
    });

    $("#modal_close_x").click(function(){
        $("input[name$='eyewear_options']").prop('checked', false);
    });
});
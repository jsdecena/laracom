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

    $(".modal_close").on("click", function(){
        // alert(1);
        $("input[name$='eyewear_options']").prop('checked', false);
        $(".radioToUncheck").prop('checked', false);
    });

    // $('.color-choose input').on('click', function () {
    //     var ravi_color = $(this).attr('data-image');
    //     $('.current').removeClass('current');
    //     $('.left_img img[data-image = ' + ravi_color + ']').addClass('current');
    //     $(this).addClass('current');
    // });
});
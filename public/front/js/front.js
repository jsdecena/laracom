$(document).ready(function () {

    // Payment options
    $('input[name="payment"]').on('change', function () {
        $.ajax({
            type: 'post',
            url: '/set-payment',
            data: { paymentId: $(this).val(), _token: $('input[name="_token"]').val()},
            success: function(data){
                //
            }
        });
    });

    // Addresses
    $('input[name="address"]').on('change', function () {
        $.ajax({
            type: 'post',
            url: '/set-address',
            data: { addressId: $(this).val(), _token: $('input[name="_token"]').val()},
            success: function(data){
                //
            }
        });
    });

    // Couriers
    $('input[name="courier"]').on('change', function () {
        $.ajax({
            type: 'post',
            url: '/set-courier',
            data: { courierId: $(this).val(), _token: $('input[name="_token"]').val()},
            success: function(data){
                console.log(data);
                $(data.courier).each(function (idx, shipping) {
                    $('#shippingFee').html(shipping.cost);
                    if (shipping.cost != 0) {
                        $('#shippingRow').fadeIn();
                    } else {
                        $('#shippingRow').fadeOut();
                    }
                });
                $('#cartTotal').html(data.cartTotal);
            }
        });
    });
});

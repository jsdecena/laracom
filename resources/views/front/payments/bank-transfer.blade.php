<tr>
    <td>
        @if(isset($payment['name']))
            {{ ucwords($payment['name']) }}
        @else
            <p class="alert alert-danger">You need to have <strong>name</strong> key in your config</p>
        @endif
    </td>
    <td>
        @if(isset($payment['description']))
            {{ $payment['description'] }}
        @endif
    </td>
    <td>
        <a id="bankTransferHref" data-href="{{ route('bank-transfer.index') }}" href="#" class="btn btn-warning pull-right">Pay with {{ ucwords($payment['name']) }} <i class="fa fa-bank"></i></a>
    </td>
</tr>
<script type="text/javascript">
    $(document).ready(function () {
        let BTElement = $('#bankTransferHref');
        let btLink = BTElement.data('href');
        let billingAddressId = $('input[name="billing_address"]').val();

        BTElement.attr('href', btLink + '?billing_address=' + billingAddressId)
    });
</script>
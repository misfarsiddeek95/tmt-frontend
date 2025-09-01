<script>
    const BASE_URL = '<?=FRONT_URL?>';
    const CURRENCY = '<?=$cur?>';
    const minPrice = '<?=$minMaxRoomPrices->min_price?>';
    const maxPrice = '<?=$minMaxRoomPrices->max_price?>';
</script>
<script src="<?=base_url()?>assets/js/jquery-3.6.4.min.js"></script>
<script src="<?=base_url()?>assets/js/vendors.js"></script>
<script src="<?=base_url()?>assets/js/main.js"></script>
<script src="<?=base_url()?>assets/js/site.js"></script>
<script>
    $(document).on('submit','form#subscribe-form',function(e){
        e.preventDefault();
        $.ajax({
            url: BASE_URL+'subscribe',
            type: 'POST',
            data: $('#subscribe-form').serialize(),
            success: function(result){
                const resp = $.parseJSON(result);
                if (resp.status == 'success') {
                    $("#subscribe-form")[0].reset();
                    alert(resp.message);
                } else {
                    alert(resp.message);
                }
            },
            error: function(result){}
        })
    });

    const numberWithCommas = (x) => {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // remove already selected dates when select next date range.
    var clickedCount = 0;
    $('div[date]:not(.date-disabled)').on('click', function () {
        clickedCount++;
        if (clickedCount == 1) {
            $('div[date]').removeClass('-is-active -is-in-path');
        }
    });

    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = { weekday: 'short', day: 'numeric', month: 'short' };
        return date.toLocaleDateString('en-GB', options); // Format as "Tue 1 Oct"
    }

</script>
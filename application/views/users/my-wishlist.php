<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('includes/head'); ?>
        <link rel="stylesheet" href="<?=base_url()?>assets/css/toastr.min.css">
        <title>My Wishlist</title>
    </head>

    <body data-barba="wrapper">
        <?php $this->load->view('includes/preloader'); ?>
        <?php $this->load->view('users/includes/topbar'); ?>

        <div class="dashboard" data-x="dashboard" data-x-toggle="-is-sidebar-open">
            <?php $this->load->view('users/includes/sidebar'); ?>

            <div class="dashboard__main">
                <div class="dashboard__content bg-light-2">
                    <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
                        <div class="col-auto">
                            <h1 class="text-30 lh-14 fw-600">Wishlist</h1>
                            <div class="text-15 text-light-1">
                                Find your wished products below.
                            </div>
                        </div>

                        <div class="col-auto"></div>
                    </div>

                    <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                        <div class="tabs -underline-2 js-tabs">
                            <div class="tabs__content pt-30 js-tabs-content">
                                <div class="tabs__pane -tab-item-1 is-tab-el-active">
                                    <div class="row y-gap-20">
                                        <?php 
                                            foreach ($allWishlists as $row) { 
                                                $img = PHOTO_DOMAIN.'default.jpg';
                                                if ($row->photo_path != null && $row->photo_path != '') {
                                                    $img = PHOTO_DOMAIN.'hotels/'.$row->photo_path.'-std.jpg';
                                                }
                                        ?>
                                        <div class="col-12" id="wpid-<?=$row->wp_id?>">
                                            <div class="">
                                                <div class="row x-gap-20 y-gap-30">
                                                    <div class="col-md-auto">
                                                        <div class="cardImage ratio ratio-1:1 w-200 md:w-1/1 rounded-4">
                                                            <div class="cardImage__content">
                                                                <img class="rounded-4 col-12" src="<?=$img?>" alt="image"/>
                                                            </div>

                                                            <div class="cardImage__wishlist">
                                                                <button class="button -red-1 bg-error-2 size-30 rounded-full shadow-2 text-white-50" onclick="deleteWhishlist('<?=$row->wp_id?>');">
                                                                    <i class="icon-trash text-15 fw-700"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <h3 class="text-18 lh-14 fw-500">
                                                            <?=$row->hotel_name?>, <?=$row->hotel_type?>, <?=$row->nicename?>
                                                        </h3>

                                                        <div class="d-flex x-gap-5 items-center pt-10">
                                                            <?=str_repeat('<i class="icon-star text-10 text-yellow-1"></i>',$row->stars)?>
                                                        </div>

                                                        <div class="row x-gap-10 y-gap-10 items-center pt-20">
                                                            <div class="col-auto">
                                                                <p class="text-14">
                                                                    <?=$row->atoll?>, <?=$row->nicename?>
                                                                    <button data-x-click="mapFilter" class="text-blue-1 underline ml-10 mapFilter<?=$row->resort_id?>" onclick="setMapSrc('<?=$row->latitude?>','<?=$row->longitude?>','mapFilter<?=$row->resort_id?>')">
                                                                        Show on map
                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <?php if(!empty($row->hotelFacilities)) { ?>
                                                        <div class="row x-gap-10 y-gap-10 pt-20">
                                                            <?php foreach ($row->hotelFacilities as $fac) {?>
                                                            <div class="col-auto">
                                                                <div class="border-light rounded-100 py-5 px-20 text-14 lh-14">
                                                                <?=$fac->facility_name?>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="col-md-auto text-right md:text-left">
                                                        <div class="d-flex flex-column justify-between h-full">
                                                            <div class="row x-gap-10 y-gap-10 justify-end items-center md:justify-start">
                                                                <div class="col-auto">
                                                                    <div class="text-14 lh-14 fw-500">
                                                                        Exceptional
                                                                    </div>
                                                                    <div class="text-14 lh-14 text-light-1">
                                                                        <?=number_format($row->review_count)?> reviews
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="flex-center text-white fw-600 text-14 size-40 rounded-4 bg-blue-1">
                                                                        <?=number_format($row->stars,1)?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="pt-24">
                                                                <div class="fw-500">Starting from</div>
                                                                <span class="fw-500 text-blue-1"><?=$cur.''.number_format($row->min_price)?></span>
                                                                / night
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php $this->load->view('users/includes/footer'); ?>
                </div>
            </div>
        </div>
        <div class="mapFilter" data-x="mapFilter" data-x-toggle="-is-active">
            <div class="mapFilter__overlay"></div>

            <div class="mapFilter__close">
                <button class="button -blue-1 size-40 bg-white shadow-2" data-x-click="mapFilter">
                <i class="icon-close text-15"></i>
                </button>
            </div>

            <div class="mapFilter__grid" data-x="mapFilter__grid" data-x-toggle="-filters-hidden">
            </div>
        </div>

        <!-- JavaScript -->
        <?php $this->load->view('includes/js'); ?>
        <script src="<?=base_url()?>assets/js/toastr.min.js"></script>
        <script>
            const setMapSrc = (lat,long,targetClass) => {
                const targets = $("."+targetClass);
                if (!targets) return;

                const iframe = `<iframe class="map-bottom-2" src="https://maps.google.com/maps?q=${lat},${long}&hl=en&z=14&amp;output=embed" allowfullscreen="true" loading="lazy" referrerpolicy="no-referrer-when-downgrade" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe>`
                $('.mapFilter__grid').html(iframe);

                const attributes = targets[0].getAttribute("data-x-click");
                const target = document.querySelector(`[data-x=${attributes}]`);
                targets[0].addEventListener("click", () => {
                    const toggleClass = target.getAttribute("data-x-toggle");
                    target.classList.toggle(toggleClass);
                });
            }

            const deleteWhishlist = (wpId) => {
                toastr.warning(
                    "<button type='button' id='confirmBtn' class='bg-red-2 text-white-50 fw-600' style='width:40%;display:inline;margin:3px;'>Yes</button><button type='button' id='closeBtn' class='bg-light-1 text-white-50 fw-600' style='width:40%;display:inline;margin:3px;'>No</button>",
                    'Do you want to remove this item from your wishlist?', {
                    closeButton: true,
                    allowHtml: true,
                    onShown: function (toast) {
                        $("#confirmBtn").click(function () {
                            const isLoggedIn = '<?=$this->session->userdata('logged_in')?>';
                            if (!isLoggedIn) {
                                return toastr.error("You aren't logged in to remove the product from wishlist.");
                            }
                            $.ajax({
                                type:'POST',
                                url:'<?=base_url()?>remove-from-wishlist',
                                data:'wpId='+wpId,
                                success:function(result){
                                    var resp = $.parseJSON(result);
                                    if (resp.status == 'success') {
                                        toastr.success(resp.message);
                                        $(`#wpid-${wpId}`).remove();
                                    } else {
                                        toastr.warning(resp.message);
                                    }
                                },
                                error:function(result){
                                    toastr.error('Something went wrong :(');
                                }
                            });
                        });
                        $("#closeBtn").click(function () {
                            toastr.clear()
                        });
                    }
                });
            }
        </script>
    </body>
</html>
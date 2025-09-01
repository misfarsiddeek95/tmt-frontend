<!DOCTYPE html>
<html lang="en" data-x="html" data-x-toggle="html-overflow-hidden">

    <head>
        <?php $this->load->view('includes/head'); ?>
        <meta content="<?=$pageMain->seo_keywords != '' ? $pageMain->seo_keywords : '' ?>" name="keywords">
        <meta content="<?=$pageMain->seo_description != '' ? $pageMain->seo_description : '' ?>" name="description">
        <title><?=$pageMain->seo_title != '' ? $pageMain->seo_title : 'About' ?></title>
    </head>

    <body>
        <?php $this->load->view('includes/preloader'); ?>
        <main>
            <?php $this->load->view('includes/header'); ?>
            <section class="section-bg layout-pt-lg layout-pb-lg">
                <div class="section-bg__item col-12">
                    <?php
                        $img = base_url().'assets/img/pages/about/1.png';
                        if ($pageBanner->photo_path != null && $pageBanner->photo_path != '') {
                            $img = PHOTO_DOMAIN.'pages/'.$pageBanner->photo_path.'-org.jpg';
                        }
                    ?>
                    <img src="<?=$img?>" alt="image">
                </div>

                <div class="container">
                    <div class="row justify-center text-center">
                        <div class="col-xl-6 col-lg-8 col-md-10">
                            <h1 class="text-40 md:text-25 fw-600 text-white"><?=$pageBanner->headline?></h1>
                            <div class="text-white mt-15"><?=$pageBanner->second_title?></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="layout-pt-lg layout-pb-md" id="whychooseus">
                <div data-anim-wrap="" class="container">
                    <div data-anim-child="slide-up delay-1" class="row justify-center text-center">
                        <div class="col-auto">
                            <div class="sectionTitle -md">
                                <h2 class="sectionTitle__title"><?=$pageWhyChooseUs->headline?></h2>
                                <p class=" sectionTitle__text mt-5 sm:mt-0"><?=$pageWhyChooseUs->second_title?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row y-gap-40 justify-between pt-50">
                        <div data-anim-child="slide-up delay-2" class="col-lg-3 col-sm-6">
                            <div class="featureIcon -type-1 ">
                                <div class="d-flex justify-center">
                                    <img src="#" data-src="<?=base_url()?>assets/img/featureIcons/3/1.svg" alt="image" class="js-lazy">
                                </div>
                                <div class="text-center mt-30">
                                    <h4 class="text-18 fw-500"><?=$pageBestTravelAgent->headline?></h4>
                                    <p class="text-15 mt-10"><?=strip_tags($pageBestTravelAgent->page_text)?></p>
                                </div>
                            </div>
                        </div>

                        <div data-anim-child="slide-up delay-3" class="col-lg-3 col-sm-6">
                            <div class="featureIcon -type-1 ">
                                <div class="d-flex justify-center">
                                    <img src="#" data-src="<?=base_url()?>assets/img/featureIcons/3/2.svg" alt="image" class="js-lazy">
                                </div>

                                <div class="text-center mt-30">
                                    <h4 class="text-18 fw-500"><?=$pageBestPrice->headline?></h4>
                                    <p class="text-15 mt-10"><?=strip_tags($pageBestPrice->page_text)?></p>
                                </div>
                            </div>
                        </div>

                        <div data-anim-child="slide-up delay-4" class="col-lg-3 col-sm-6">
                            <div class="featureIcon -type-1 ">
                                <div class="d-flex justify-center">
                                    <img src="#" data-src="<?=base_url()?>assets/img/featureIcons/3/3.svg" alt="image" class="js-lazy">
                                </div>

                                <div class="text-center mt-30">
                                    <h4 class="text-18 fw-500"><?=$pageBestTrustSafty->headline?></h4>
                                    <p class="text-15 mt-10"><?=strip_tags($pageBestTrustSafty->page_text)?></p>
                                </div>
                            </div>
                        </div>

                        <div data-anim-child="slide-up delay-5" class="col-lg-3 col-sm-6">
                            <div class="featureIcon -type-1 ">
                                <div class="d-flex justify-center">
                                    <img src="#" data-src="<?=base_url()?>assets/img/featureIcons/3/4.svg" alt="image" class="js-lazy">
                                </div>

                                <div class="text-center mt-30">
                                    <h4 class="text-18 fw-500"><?=$pageFastBooking->headline?></h4>
                                    <p class="text-15 mt-10"><?=strip_tags($pageFastBooking->page_text)?></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <section class="layout-pt-md">
                <div class="container">
                    <div class="row y-gap-30 justify-between items-center">
                        <div class="col-lg-5" id="page-content">
                            <h2 class="text-30 fw-600"><?=$pageContent->headline?></h2>
                            <p class="mt-5"><?=$pageContent->second_title?></p>
                            <?=$pageContent->page_text?>
                        </div>

                        <div class="col-lg-6">
                            <?php
                                $img = base_url().'assets/img/pages/about/2.png';
                                if ($pageContent->photo_path != null && $pageContent->photo_path != '') {
                                    $img = PHOTO_DOMAIN.'pages/'.$pageContent->photo_path.'-org.jpg';
                                }
                            ?>
                            <img src="<?=$img?>" alt="image" class="rounded-4">
                        </div>
                    </div>
                </div>
            </section>

            <!-- <section class="pt-60">
                <div class="container">
                    <div class="border-bottom-light pb-40">
                        <div class="row y-gap-30 justify-center text-center">

                            <div class="col-xl-3 col-6">
                                <div class="text-40 lg:text-30 lh-13 fw-600">4,958</div>
                                <div class="text-14 lh-14 text-light-1 mt-5">Destinations</div>
                            </div>

                            <div class="col-xl-3 col-6">
                                <div class="text-40 lg:text-30 lh-13 fw-600">2,869</div>
                                <div class="text-14 lh-14 text-light-1 mt-5">Total Properties</div>
                            </div>

                            <div class="col-xl-3 col-6">
                                <div class="text-40 lg:text-30 lh-13 fw-600">2M</div>
                                <div class="text-14 lh-14 text-light-1 mt-5">Happy customers</div>
                            </div>

                            <div class="col-xl-3 col-6">
                                <div class="text-40 lg:text-30 lh-13 fw-600">574,974</div>
                                <div class="text-14 lh-14 text-light-1 mt-5">Our Volunteers</div>
                            </div>

                        </div>
                    </div>
                </div>
            </section> -->

            <section class="layout-pt-lg layout-pb-lg">
                <div class="container">
                    <div class="row y-gap-20 justify-between items-end">
                        <div class="col-auto">
                            <div class="sectionTitle -md">
                                <h2 class="sectionTitle__title"><?=$pageTeam->headline?></h2>
                                <p class=" sectionTitle__text mt-5 sm:mt-0"><?=$pageTeam->second_title?></p>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex x-gap-15 items-center justify-center">
                                <div class="col-auto">
                                    <button class="d-flex items-center text-24 arrow-left-hover js-team-prev">
                                        <i class="icon icon-arrow-left"></i>
                                    </button>
                                </div>
                                <div class="col-auto">
                                    <div class="pagination -dots text-border js-team-pag"></div>
                                </div>
                                <div class="col-auto">
                                    <button class="d-flex items-center text-24 arrow-right-hover js-team-next">
                                        <i class="icon icon-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="overflow-hidden pt-40 js-section-slider"
                        data-gap="30"
                        data-slider-cols="xl-5 lg-4 md-2 sm-2 base-1"
                        data-nav-prev="js-team-prev"
                        data-pagination="js-team-pag"
                        data-nav-next="js-team-next">
                        <div class="swiper-wrapper">
                            <?php 
                                foreach ($ourTeam as $member) {
                                    $image = $member->user_pic != null && $member->user_pic != '' ? PHOTO_DOMAIN.'staff/'.$member->user_pic.'-std.jpg' : PHOTO_DOMAIN.'user_default.jpg';
                            ?>
                            <div class="swiper-slide">
                                <div class="">
                                    <img src="<?=$image?>" alt="<?=$member->fname . ' ' . $member->lname ?>" class="rounded-4 col-12">
                                    <div class="mt-10">
                                        <div class="text-18 lh-15 fw-500"><?=$member->fname . ' ' . $member->lname ?></div>
                                        <div class="text-14 lh-15"><?=$member->position?></div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-bg layout-pt-lg layout-pb-lg">
                <div class="section-bg__item -mx-20 bg-light-2"></div>

                <div class="container">
                    <div class="row justify-center text-center">
                        <div class="col-auto">
                            <div class="sectionTitle -md">
                                <h2 class="sectionTitle__title"><?=$pageTestimonial->headline?></h2>
                                <p class=" sectionTitle__text mt-5 sm:mt-0"><?=$pageTestimonial->second_title?></p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="overflow-hidden pt-80 js-section-slider"
                        data-gap="30"
                        data-slider-cols="xl-3 lg-3 md-2 sm-1 base-1">
                        <div class="swiper-wrapper">
                            <?php 
                                foreach ($testimonials as $testimonial) {
                                    $image = PHOTO_DOMAIN.'user_default.jpg';
                            ?>
                            <div class="swiper-slide">
                                <div class="testimonials -type-1 bg-white rounded-4 pt-40 pb-30 px-40">
                                    <h4 class="text-16 fw-500 text-blue-1 mb-20"><?=$testimonial->hotel_name?></h4>
                                    <p class="testimonials__text lh-18 fw-500 text-dark-1">&quot;<?=$testimonial->testimonial?>&quot;</p>

                                    <div class="pt-20 mt-28 border-top-light">
                                        <div class="row x-gap-20 y-gap-20 items-center">
                                            <div class="col-auto">
                                                <img class="size-60" src="<?=$image?>" alt="<?=$testimonial->name?>">
                                            </div>

                                            <div class="col-auto">
                                                <div class="text-15 fw-500 lh-14"><?=$testimonial->name?></div>
                                                <div class="text-14 lh-14 text-light-1 mt-5"><?=$testimonial->position?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- <div class="row y-gap-30 items-center pt-40 sm:pt-20">
                        <div class="col-xl-4">
                            <div class="row y-gap-30 text-dark-1">
                                <div class="col-sm-5 col-6">
                                    <div class="text-30 lh-15 fw-600">13m+</div>
                                    <div class="lh-15">Happy People</div>
                                </div>

                                <div class="col-sm-5 col-6">
                                    <div class="text-30 lh-15 fw-600">4.88</div>
                                    <div class="lh-15">Overall rating</div>

                                    <div class="d-flex x-gap-5 items-center pt-10">

                                        <div class="icon-star text-dark-1 text-10"></div>

                                        <div class="icon-star text-dark-1 text-10"></div>

                                        <div class="icon-star text-dark-1 text-10"></div>

                                        <div class="icon-star text-dark-1 text-10"></div>

                                        <div class="icon-star text-dark-1 text-10"></div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8">
                            <div class="row y-gap-30 justify-between items-center">

                                <div class="col-md-auto col-sm-6">
                                    <div class="d-flex justify-center">
                                        <img src="<?=base_url()?>assets/img/clients/1.svg" alt="image">
                                    </div>
                                </div>

                                <div class="col-md-auto col-sm-6">
                                    <div class="d-flex justify-center">
                                        <img src="<?=base_url()?>assets/img/clients/2.svg" alt="image">
                                    </div>
                                </div>

                                <div class="col-md-auto col-sm-6">
                                    <div class="d-flex justify-center">
                                        <img src="<?=base_url()?>assets/img/clients/3.svg" alt="image">
                                    </div>
                                </div>

                                <div class="col-md-auto col-sm-6">
                                    <div class="d-flex justify-center">
                                        <img src="<?=base_url()?>assets/img/clients/4.svg" alt="image">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> -->
                </div>
            </section>

            <?php $this->load->view('includes/subscribe'); ?>

            <?php $this->load->view('includes/footer'); ?>

        </main>
        <?php $this->load->view('includes/js'); ?>
        <script>
            $(document).ready(function() {
                $('#page-content p:not(:first)').addClass('text-dark-1 mt-20 lg:mt-40 md:mt-20');
            })
        </script>
    </body>
</html>
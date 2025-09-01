<!DOCTYPE html>
<html lang="en" data-x="html" data-x-toggle="html-overflow-hidden">

    <head>
        <?php $this->load->view('includes/head'); ?>
        <meta content="<?=$pageMain->seo_keywords != '' ? $pageMain->seo_keywords : '' ?>" name="keywords">
        <meta content="<?=$pageMain->seo_description != '' ? $pageMain->seo_description : '' ?>" name="description">
        <title><?=$pageMain->seo_title != '' ? $pageMain->seo_title : 'Home' ?></title>
    </head>

    <body>
        <?php $this->load->view('includes/preloader'); ?>

        <main>
            <?php $this->load->view('includes/header'); ?>

            <section class="layout-pt-lg layout-pb-lg">
                <div class="container">
                    <div class="row justify-center text-center">
                        <div class="col-auto">
                            <div class="sectionTitle -md">
                                <h2 class="sectionTitle__title"><?=$pageMain->headline?></h2>
                                <p class=" sectionTitle__text mt-5 sm:mt-0"><?=$pageMain->second_title?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row y-gap-30 justify-center pt-40 sm:pt-20">
                        <div class="col-xl-8 col-lg-10">
                            <div class="accordion -simple row y-gap-20 js-accordion">
                                <?php foreach ($siteFaqs as $faq) { ?>
                                <div class="col-12">
                                    <div class="accordion__item px-20 py-20 border-light rounded-4">
                                        <div class="accordion__button d-flex items-center">
                                            <div class="accordion__icon size-40 flex-center bg-light-2 rounded-full mr-20">
                                                <i class="icon-plus"></i>
                                                <i class="icon-minus"></i>
                                            </div>

                                            <div class="button text-dark-1"><?=$faq->question?></div>
                                        </div>

                                        <div class="accordion__content">
                                            <div class="pt-20 pl-60" class="content-body">
                                                <?=$faq->answer?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php $this->load->view('includes/subscribe'); ?>

            <?php $this->load->view('includes/footer'); ?>

        </main>
        <?php $this->load->view('includes/js'); ?>
        <script>
            $(document).ready(function() {
                $('#content-body p').addClass('text-15');
            })
        </script>
    </body>
</html>
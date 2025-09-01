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
                    <div class="tabs js-tabs">
                        <div class="row y-gap-30">
                            <div class="col-lg-12">
                                <div class="tabs__content js-tabs-content">
                                    <div class="tabs__pane -tab-item-1 is-tab-el-active" id="page-content">
                                        <h1 class="text-30 fw-600"><?=$pageMain->headline?></h1>
                                        <p class="text-15 mb-15"><?=$pageMain->second_title?></p>
                                        <?=$pageMain->page_text?>
                                    </div>
                                </div>
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
                $('#page-content p:not(:first)').addClass('text-15 text-dark-1 mt-5');
            })
        </script>
    </body>
</html>
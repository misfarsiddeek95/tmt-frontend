<!DOCTYPE html>
<html lang="en" data-x="html" data-x-toggle="html-overflow-hidden">

    <head>
        <?php $this->load->view('includes/head'); ?>

        <title>404</title>
    </head>

    <body>
        <?php $this->load->view('includes/preloader'); ?>

        <main>
            <?php $this->load->view('includes/header'); ?>

            <section class="layout-pt-lg layout-pb-lg">
                <div class="container">
                    <?php if ($this->session->flashdata('invalid_link') != '') {?>
                        <div class="row y-gap-30 justify-between items-center">
                            <div class="col-lg-6">
                                <img src="<?=base_url()?>assets/img/general/404.svg" alt="image">
                            </div>

                            <div class="col-lg-5">
                                <div class="no-page">
                                    <div class="no-page__title">Invalid <br/><span class="text-blue-1">Link</span></div>

                                    <h2 class="text-30 fw-600">Oops! It looks like you're lost.</h2>

                                    <div class="pr-30 mt-5"><?=$this->session->flashdata('invalid_link');?></div>

                                    <div class="d-inline-block mt-40 md:mt-20">
                                        <a href="<?=$this->session->flashdata('goto_signin');?>" class="button -md -dark-1 bg-blue-1 text-white">Go back to singin</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } elseif($this->session->flashdata('link_expired') != '') { ?>
                        <div class="row y-gap-30 justify-between items-center">
                            <div class="col-lg-6">
                                <img src="<?=base_url()?>assets/img/general/404.svg" alt="image">
                            </div>

                            <div class="col-lg-5">
                                <div class="no-page">
                                    <div class="no-page__title">Link <br/><span class="text-blue-1">Expired</span></div>

                                    <h2 class="text-30 fw-600">Oops! It looks like you're lost.</h2>

                                    <div class="pr-30 mt-5"><?=$this->session->flashdata('link_expired');?></div>

                                    <div class="d-inline-block mt-40 md:mt-20">
                                        <a href="<?=$this->session->flashdata('goto_home');?>" class="button -md -dark-1 bg-blue-1 text-white">Go back to homepage</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else {?>
                        <div class="row y-gap-30 justify-between items-center">
                            <div class="col-lg-6">
                                <img src="<?=base_url()?>assets/img/general/404.svg" alt="image">
                            </div>

                            <div class="col-lg-5">
                                <div class="no-page">
                                    <div class="no-page__title">40<span class="text-blue-1">4</span></div>

                                    <h2 class="text-30 fw-600">Oops! It looks like you're lost.</h2>

                                    <div class="pr-30 mt-5">The page you're looking for isn't available. Try to
                                        search again or use the go to.</div>

                                    <div class="d-inline-block mt-40 md:mt-20">
                                        <a href="<?=base_url()?>" class="button -md -dark-1 bg-blue-1 text-white">Go back to homepage</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>

            <?php $this->load->view('includes/subscribe'); ?>
            <?php $this->load->view('includes/footer'); ?>

        </main>

        <?php $this->load->view('includes/js'); ?>
    </body>

</html>
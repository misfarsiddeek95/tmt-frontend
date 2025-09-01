<div class="header-margin"></div>
<header
    data-add-bg=""
    class="header -dashboard bg-white js-header"
    data-x="header"
    data-x-toggle="is-menu-opened">
    <div data-anim="fade" class="header__container px-30 sm:px-20">
        <div class="-left-side">
            <a
                href="<?=base_url()?>"
                class="header-logo"
                data-x="header-logo"
                data-x-toggle="is-logo-dark">
                <img src="<?=base_url()?>assets/img/web-logo-black.png" alt="logo icon"/>
                <img src="<?=base_url()?>assets/img/web-logo-white.png" alt="logo icon"/>
            </a>
        </div>

        <div class="row justify-between items-center pl-60 lg:pl-20">
            <div class="col-auto">
                <div class="d-flex items-center">
                    <button data-x-click="dashboard">
                        <i class="icon-menu-2 text-20"></i>
                    </button>

                    <div class="single-field relative d-flex items-center md:d-none ml-30">
                        <input
                            class="pl-50 border-light text-dark-1 h-50 rounded-8"
                            type="email"
                            placeholder="Search"/>
                        <button class="absolute d-flex items-center h-full">
                            <i class="icon-search text-20 px-15 text-dark-1"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <div class="d-flex items-center">
                    <div class="header-menu" data-x="mobile-menu" data-x-toggle="is-menu-active">
                        <div class="mobile-overlay"></div>

                        <div class="header-menu__content">
                            <div class="mobile-bg js-mobile-bg"></div>

                            <div class="mobile-footer px-20 py-20 border-top-light js-mobile-footer"></div>
                        </div>
                    </div>

                    <div class="row items-center x-gap-5 y-gap-20 pl-20 lg:d-none">
                        <div class="col-auto">
                            <button class="button -blue-1-05 size-50 rounded-22 flex-center">
                                <i class="icon-email-2 text-20"></i>
                            </button>
                        </div>

                        <div class="col-auto">
                            <button class="button -blue-1-05 size-50 rounded-22 flex-center">
                                <i class="icon-notification text-20"></i>
                            </button>
                        </div>
                    </div>

                    <div class="pl-15">
                        <img
                            src="<?=PHOTO_DOMAIN.''.$this->session->userdata('profile_pic')?>"
                            alt="image"
                            class="size-50 rounded-22 object-cover" id="profile-picture" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
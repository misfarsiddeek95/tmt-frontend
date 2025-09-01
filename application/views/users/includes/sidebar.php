<div class="dashboard__sidebar bg-white scroll-bar-1">
    <div class="sidebar -dashboard">
        <div class="sidebar__item">
            <div class="sidebar__button <?php if($activeTab == 'dashboard') { echo '-is-active'; } else { echo ''; } ?>">
                <a href="<?=base_url('dashboard')?>" class="d-flex items-center text-15 lh-1 fw-500">
                    <img src="<?=base_url()?>assets/img/dashboard/sidebar/compass.svg" alt="image" class="mr-15"/>
                    Dashboard
                </a>
            </div>
        </div>

        <div class="sidebar__item">
            <div class="sidebar__button <?php if($activeTab == 'bookings') { echo '-is-active'; } else { echo ''; } ?>">
                <a href="<?=base_url('my-bookings')?>" class="d-flex items-center text-15 lh-1 fw-500">
                    <img src="<?=base_url('')?>assets/img/dashboard/sidebar/booking.svg" alt="image" class="mr-15"/>
                    Booking History
                </a>
            </div>
        </div>

        <div class="sidebar__item">
            <div class="sidebar__button <?php if($activeTab == 'wishlists') { echo '-is-active'; } else { echo ''; } ?>">
                <a href="<?=base_url('my-wishlist')?>" class="d-flex items-center text-15 lh-1 fw-500">
                    <img src="<?=base_url()?>assets/img/dashboard/sidebar/bookmark.svg" alt="image" class="mr-15"/>
                    Wishlist
                </a>
            </div>
        </div>

        <div class="sidebar__item">
            <div class="sidebar__button <?php if($activeTab == 'profile') { echo '-is-active'; } else { echo ''; } ?>">
                <a href="<?=base_url('profile')?>" class="d-flex items-center text-15 lh-1 fw-500">
                    <img src="<?=base_url()?>assets/img/dashboard/sidebar/gear.svg" alt="image" class="mr-15"/>
                    Profile
                </a>
            </div>
        </div>

        <div class="sidebar__item">
            <div class="sidebar__button">
                <a href="<?=base_url('sign-out');?>" class="d-flex items-center text-15 lh-1 fw-500">
                    <img src="<?=base_url()?>assets/img/dashboard/sidebar/log-out.svg" alt="image" class="mr-15"/>
                    Logout
                </a>
            </div>
        </div>
    </div>
</div>
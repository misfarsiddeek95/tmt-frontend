<?php if($activeTab != 'index') { ?>
   <div class="header-margin"></div>
<?php } ?>
<header
   data-add-bg="<?php if($activeTab == 'index') {echo ('bg-dark-1');} ?>"
   class="header bg-<?php if($activeTab == 'index') {echo ('green');} else { echo('dark-3'); } ?> js-header"
   data-x="header"
   data-x-toggle="is-menu-opened">
   <div data-anim="fade" class="header__container container px-30 sm:px-20">
      <div class="row justify-between items-center">
         <div class="col-auto">
            <div class="d-flex items-center">
               <a
                  href="<?=base_url();?>"
                  class="header-logo mr-20"
                  data-x="header-logo"
                  data-x-toggle="is-logo-dark">
               <img src="<?=base_url()?>assets/img/web-logo-white.png" alt="logo icon">
               <img src="<?=base_url()?>assets/img/web-logo-black.png" alt="logo icon"></a>
               <div class="header-menu " data-x="mobile-menu" data-x-toggle="is-menu-active">
                  <div class="mobile-overlay"></div>
                  <div class="header-menu__content">
                     <div class="mobile-bg js-mobile-bg"></div>
                     <div class="menu js-navList">
                        <ul class="menu__nav text-white -is-active">
                           <li>
                           <?php 
                              $prs = 'st='.base64_encode(base64_encode('0')).'&sv='.base64_encode(base64_encode('0')).'&ssd='.base64_encode(base64_encode(date('Y-m-d',$nextWeekFirstDay))).'&sed='.base64_encode(base64_encode(date('Y-m-d', $nextWeekFourthDay))).'&ac='.base64_encode(base64_encode('2')).'&cc='.base64_encode(base64_encode('0')).'&rc='.base64_encode(base64_encode('1')).'&ic='.base64_encode(base64_encode('0'));
                           ?>
                              <a href="<?=base_url().'search?prs='.base64_encode($prs)?>">Holiday Deals</a>
                           </li>
                           <!-- <li>
                              <a href="#">Resort Collection</a>
                           </li> -->
                           <li>
                              <a href="<?=base_url('about-us');?>">Who we are</a>
                           </li>
                           <li>
                              <a href="<?=base_url('contact-us');?>">Contact Us</a>
                           </li>
                        </ul>
                     </div>
                     <div class="mobile-footer px-20 py-20 border-top-light js-mobile-footer"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-auto">
            <div class="d-flex items-center">
               <div class="d-flex items-center ml-20 is-menu-opened-hide md:d-none">
                  <a href="<?=base_url('inquiry/main/internet-inquiry');?>" class="button px-30 fw-400 text-14 -white bg-white h-50 text-dark-1">Request a Quote</a>
                  <?php if (!$this->session->userdata('logged_in')) { ?>
                     <a href="<?=base_url('sign-up');?>" class="button px-30 fw-400 text-14 border-white -outline-white h-50 text-white ml-20">Sign In / Register</a>
                  <?php } else { ?>
                     <a href="<?=base_url('sign-out');?>" class="button px-30 fw-400 text-14 border-white -outline-white h-50 text-white ml-20">Sign Out</a>
                     <a href="<?=base_url('dashboard');?>" class="button px-30 fw-400 text-14 border-white -outline-white h-50 text-white ml-20"><i class="icon-user text-20"></i></a>
                  <?php } ?>
               </div>
               <div
                  class="d-none xl:d-flex x-gap-20 items-center pl-30 text-white"
                  data-x="header-mobile-icons"
                  data-x-toggle="text-white">
                  <div>
                     <?php if (!$this->session->userdata('logged_in')) { ?>
                        <a href="<?=base_url('sign-up');?>" class="d-flex items-center icon-user text-inherit text-22"></a>
                     <?php } else { ?>
                        <a href="<?=base_url('dashboard');?>" class="d-flex items-center icon-transmission text-inherit text-22" title="Dasboard"></a>
                     <?php } ?>
                  </div>
                  <div>
                     <button
                        class="d-flex items-center icon-menu text-inherit text-20"
                        data-x-click="html, header, header-logo, header-mobile-icons, mobile-menu"></button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</header>
<footer class="footer -type-3 text-white bg-dark-1">
   <div class="container">
      <div class="pt-60 pb-60">
         <div class="row y-gap-40 justify-between xl:justify-start">
            <div class="col-xl-2 col-lg-4 col-sm-6">
               <h5 class="text-16 fw-500 mb-30">Contact Us</h5>
               <div class="mt-30">
                  <div class="text-14 mt-30">Toll Free Customer Care</div>
                  <a href="#" class="text-18 fw-500 mt-5"><?=$footerContactInfo->seo_title?></a>
               </div>
               <div class="mt-35">
                  <div class="text-14 mt-30">Need live support?</div>
                  <a href="#" class="text-18 fw-500 mt-5"><?=$footerContactInfo->seo_keywords?></a>
               </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-sm-6">
               <h5 class="text-16 fw-500 mb-30">Company</h5>
               <div class="d-flex y-gap-10 flex-column">
                  <a href="<?=base_url('about-us');?>">About Us</a>
                  <a href="<?=base_url('anti-fraud-policy');?>">Anti fraud policy</a>
               </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-sm-6">
               <h5 class="text-16 fw-500 mb-30">Support</h5>
               <div class="d-flex y-gap-10 flex-column">
                  <a href="<?=base_url('contact-us');?>">Contact</a>
                  <a href="<?=base_url('faq');?>">FAQs</a>
                  <a href="#">Media</a>
                  <a href="#">Maldive Stories</a>
               </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-sm-6">
               <h5 class="text-16 fw-500 mb-30">Other Services</h5>
               <div class="d-flex y-gap-10 flex-column">
                  <a href="#">Maldives</a>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-sm-6">
               <h5 class="text-16 fw-500 mb-30">Get Updates & More</h5>
               <div class="single-field relative d-flex justify-end items-center pb-30">
                  <input class="bg-white rounded-8" type="email" placeholder="Your Email">
                  <button class="absolute px-20 h-full text-15 fw-500 underline text-dark-1">Subscribe</button>
               </div>
            </div>
         </div>
      </div>
      <div class="py-20 border-top-white-15">
         <div class="row justify-between items-center y-gap-10">
            <div class="col-auto">
               <div class="row x-gap-30 y-gap-10">
                  <div class="col-auto">
                     <div class="d-flex items-center">
                        © <?=date('Y');?> Travel X Maldives All rights reserved.
                     </div>
                  </div>
                  <div class="col-auto">
                     <div class="d-flex x-gap-15">
                        <a href="<?=base_url('privacy-policy');?>">Privacy</a>
                        <a href="<?=base_url('terms-of-use');?>">Terms</a>
                        <a href="#">Site Map</a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-auto">
               <div class="row y-gap-10 items-center">
                  <div class="col-auto">
                     <div class="d-flex x-gap-20 items-center">
                        <a href="<?=$socialMediaLinks->seo_description?>">
                        <i class="icon-facebook text-14"></i>
                        </a>
                        <a href="<?=$socialMediaLinks->seo_url?>">
                        <i class="icon-twitter text-14"></i>
                        </a>
                        <a href="<?=$socialMediaLinks->headline?>">
                        <i class="icon-instagram text-14"></i>
                        </a>
                        <a href="<?=$socialMediaLinks->second_title?>">
                        <i class="icon-linkedin text-14"></i>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</footer>
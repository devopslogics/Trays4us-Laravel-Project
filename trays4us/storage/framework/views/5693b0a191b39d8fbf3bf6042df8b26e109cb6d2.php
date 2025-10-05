<?php // The will be used only for SEO purpose ?>
<?php $__env->startPush('structured_data_markup'); ?>
<script type="application/ld+json">{
  "@context": "https://schema.org",
   "@type": "Organization",
    "url":"<?php echo e(url()->current()); ?>",
    "name":"<?php echo e($page_title); ?>",
    "description":"<?php echo e($page_description); ?>",
    "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "<?php echo e(url()->current()); ?>",
    "breadcrumb": {
      "@type": "BreadcrumbList",
      "itemListElement": [
       {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "<?php echo e(route('home')); ?>"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Create Custom",
          "item": "<?php echo e(route('create-custom')); ?>"
        }
      ]
    }
  }
}
 </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>



    <section class="tfu-create-custom-wrapper" >

        <div class="container-fluid">

            <div class="row" >

                <div class="col-xl-12  tfu-create-custom-content" >
                    <h1>Create Your Own Custom Tray</h1>
                </div>
            </div>

            <div class=" tfu-general-breadcumb-wrapper" >
                <ul class="shop-breadcrumb">
                    <li><a href="<?php echo e(route('home')); ?>" > Home </a></li>
                    <li>Create Custom</li>
                </ul>
            </div>

            <div class="row" >
              <div class="col-xl-12  tfu-Customizer-tools-button" >
                <a href="<?php echo e(route('upload-your-work')); ?>" >
                 <p>Launch Online Customizer Tool</p>
                </a>     
              </div>
            </div>

            <div class="row justify-content-center align-items-baseline" >
                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray" >
                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <a href="<?php echo e(route('license-artwork')); ?>/custom-item"> <img src="<?php echo e(asset('/assets/frontend-assets/images/round-tray.png')); ?>" alt="round-tray.png"  /></a>

                        </div>

                        <p>Round 15.7" </p>
                        <p>Tray</p>
                        <span>R157</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2  tfu-c-tray"  >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <a href="<?php echo e(route('license-artwork')); ?>/custom-item"><img src="<?php echo e(asset('/assets/frontend-assets/images/1612-rectangle-tray.png')); ?>" alt="1612-rectangle-tray.png" /></a>

                        </div>

                        <p>Large 16.5"x12.5" </p>
                        <p>Tray</p>
                        <span>1612</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"  >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <a href="<?php echo e(route('license-artwork')); ?>/custom-item"><img src="<?php echo e(asset('/assets/frontend-assets/images/1108-rectangle-tray.png')); ?>"  alt="1108-rectangle-tray.png"/></a>

                        </div>

                        <p>Medium 11"x8"</p>
                        <p>Tray</p>
                        <span>1108</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"  >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <a href="<?php echo e(route('license-artwork')); ?>/custom-item"><img src="<?php echo e(asset('/assets/frontend-assets/images/1105-rectangle-tray.png')); ?>"  alt="1105-rectangle-tray.png"/></a>

                        </div>

                        <p>Small 11"x5"</p>
                        <p>Tray</p>
                        <span>1105</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"   >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <a href="<?php echo e(route('license-artwork')); ?>/custom-item"><img src="<?php echo e(asset('/assets/frontend-assets/images/f8b2eb8a59003208d6d740726bb47068.png')); ?>"  alt="f8b2eb8a59003208d6d740726bb47068.png"/></a>

                        </div>
                       <p>Squared 4"x4"</p>
                        <p>Coaster</p>

                        <span>4x4</span>

                    </div>

                </div>

            </div>

            <div class="row justify-content-center align-items-baseline  ftu-tray-row" >

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"  >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <img src="<?php echo e(asset('/assets/frontend-assets/images/tfu-tray-c1.png')); ?>"  alt="tfu-tray-c1.png"/>

                        </div>

                        <p>Round 15.7" </p>
                        <p>Tray</p>
                        <span>R157</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"  >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <img src="<?php echo e(asset('/assets/frontend-assets/images/tfu-tray-c2.png')); ?>"  alt="tfu-tray-c2.png"/>

                        </div>

                        <p>Large 16.5"x12.5"  </p>
                        <p>Tray</p>
                        <span>1612</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"   >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <img src="<?php echo e(asset('/assets/frontend-assets/images/tfu-tray-c3.png')); ?>"  alt="tfu-tray-c3.png"/>

                        </div>

                        <p>Medium 11"x8" </p>
                        <p>Tray</p>
                        <span>1108</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"  >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <img src="<?php echo e(asset('/assets/frontend-assets/images/tfu-tray-c4.png')); ?>"  alt="tfu-tray-c4.png"/>

                        </div>

                        <p>Small 11"x5" </p>
                        <p>Tray</p>
                        <span>1105</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"  >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <img src="<?php echo e(asset('/assets/frontend-assets/images/tfu-tray-c5.png')); ?>"  alt="tfu-tray-c5.png"/>

                        </div>

                        <p>Squared 4"x4"</p>
                        <p>Coaster</p>
                        <span>4x4</span>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <section>

      <div class="container-fluid">
        <div class="row" >

         <div class="tfu-create-custom-content-wrapper" >

            <div class="tfu-create-custom-information" >
              <h3>1. Let us make the design for you</h3>
              <p>Do you own the copyright for the artwork, map or photograph
                    Would you like to use it on trays or coasters?</p>
              <p>We are happy to create a white labeldesign and the MOQ is just 12 trays or 32 coasters. Email us the link artwork at <span class="tfu-general-mail" >info@trays4.us</span> with your optional logo in any format (AI, EPS, JPG, PDF etc) and we will send the tray images for your approval. If you have multiple images or file sizes are large, we recommend using a file sharing service and sharing a link to the folder. Don’t worry about editing, cropping the image - we will do it for you and never charge for any design services. We will share the rendered product images for your review and approval. Naturally, you are still the designer and you retain the copyright for the original artwork you shared with us.</p>
              <a class="ftu-common-btn"  href="<?php echo e(route('license-artwork')); ?>/custom-item">Order Custom</a>
              <h3  class="tfu-designer-ps" >2. Are you a designer using Photoshop, Illustrator or InDesign?</h3>
              <p>You can design your trays and coasters using simple to use PNG templates, Adobe Illustrator PDF template or a templates for InDesign,
                You can download the templates here:
              </p>
              <a class="ftu-common-btn"  href="https://customtrays.link/2022">Templates</a>
           </div>
           <div class="tfu-create-custom-img-requirement" >
             <h3>3. General image requirements</h3>
             <h6>3.1. Reproduction rights</h6>
             <p>Please make sure you have the rights to reproduce the image you would like to apply to a tray. Please make sure the image is in the public domain or that the copyright has expired.We can only reproduce images that you have the rights to or images are in public domain. By submitting artwork to use, you agree to these term: </p>
             <a class="ftu-common-btn"  href="<?php echo e(route('home')); ?>/term-condition">Terms & conditions</a>
             <h6>3.2. Image specifications</h6>
             <p>The images should be scanned, ideally with a high quality scanner with 300 DPI resolution and RGB color setting.</p>
            </div>
             <table class="table tfu-create-custom-table ">
                <thead>
                  <tr>
                    <th scope="col">Item</th>
                    <th scope="col">SKU prefix</th>
                    <th scope="col">Exact tray measures</th>
                    <th scope="col">Image size, 300DPI, RGB</th>
                  </tr>
                </thead>
                <tbody>

                  <tr>
                    <td>Small tray 11”x5”  </td>
                    <td>1105-   </td>
                    <td>270 x 130mm</td>
                    <td>300 x 150mm  </td>
                  </tr>
                  <tr>
                    <td>Medium tray 11”x8”   </td>
                    <td>1108-</td>
                    <td>270 x 200mm</td>
                    <td>290 x 220mm</td>
                  </tr>
                  <tr>
                    <td>Large tray 16.5”x12.5”  </td>
                    <td>1612-</td>
                    <td>420x 320mm</td>
                    <td>440 x 340mm</td>
                  </tr>
                  <tr>
                    <td>Extra Large Round tray d=15.7”                    </td>
                    <td>R157-</td>
                    <td>400 x 400mm</td>
                    <td>430 x 430mm</td>
                  </tr>
                  <tr>
                    <td>Coaster 4”x4”                   </td>
                    <td>4x4-</td>
                    <td>100 x 100mm</td>
                    <td>105 x 105mm</td>
                  </tr>

                </tbody>
              </table>
            <div class="tfu-create-custom-img-requirement tfu-contact-wrapper" >
              <h6>3.3 Approval</h6>
              <p>Once design is approved Trays4Us will assign a unique SKU number to simplify reordering.</p>
              <h6 class="tfu-contact-us" >3.4 Contact Us</h6>
              <p class="tfu-contact-custom-btn" >Any question? </p>
              <a class="ftu-common-btn" href="<?php echo e(route('contact-us')); ?>">CONTACT US</a>
           </div>

         </div>

        </div>
      </div>

    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/frontend/artist/create-custom.blade.php ENDPATH**/ ?>
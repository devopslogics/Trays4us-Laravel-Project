<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo e(asset('/assets/frontend-assets/css/slick.css')); ?>"/>
<?php $__env->stopPush(); ?>

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
          "name": "LICENSE ARTWORK",
          "item": "<?php echo e(route('license-artwork')); ?>"
        }
      ]
    }
  }
}
 </script>


<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <section  class="tfu-license-artwork-wrapper">
        <div class="container-fluid">

            <div class=" tfu-general-breadcumb-wrapper" >
                
                <div class="tfu-general-heading" >
                    <h1>LICENSE ARTWORK</h1>
                </div>

                <ul class="shop-breadcrumb">
                    <li><a href="<?php echo e(route('home')); ?>" > Home </a></li>
                    <li>License Artwork</li>
                </ul>

            </div>


            <div class="row" >
                <div class="col-xl-12  tfu-license-artwork-content" >
                    <p>Elevate your retail offerings with our exclusive collection of trays featuring handpicked stock artistry. These trays not only serve as functional and stylish accessories for homes and hospitality, but they also showcase the unique visions of our featured artists. With a blend of premium quality woodwork and captivating imagery, our curated collection of trays is perfect for resellers looking to offer distinctive, art-inspired products and collections. If you are an artists or own the reproduction rights to an amazing artwork, lets connect.  </p>
                    <a class="ftu-common-btn"  href="<?php echo e(route('contact-us')); ?>">CONTACT US</a>
                </div>
            </div>

        </div>
    </section>


    <section class="tfu-featured-artists-wrapper" >
        <div class="container-fluid">
           <div class="row tfu-license-artwork-header" >
                <div class="col-xl-12  " >
                    <h2>STOCK ARTISTS</h2>
                </div>
            </div>

            <div class="row">
                <?php if($artists->isNotEmpty()): ?>
                    <div id="ajax_load_artists">
                        <div class="col-xl-12">
                        <?php $__currentLoopData = $artists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="tfu-artwork-slider-handler" >
                                <div class="tfu-artwork-slider-for">
                                    <div class="row tfu-slider-artwork-handler">
                                       <div class="col-12 col-sm-6  col-md-5  col-lg-4  col-xl-4 col-xxl-3">
                                          <div class="licence_author_img">
                                                <?php if( !empty($artist->artist_photo) && \Storage::disk('uploads')->exists('/users/' .$artist->artist_photo)): ?>
                                                    <img src="<?php echo e(url('uploads/users/'.$artist->artist_photo)); ?>" alt="<?php echo e($artist->artist_photo ?? ''); ?>" />
                                                <?php else: ?>
                                                    <img src="<?php echo e(asset('/assets/frontend-assets/images/no-image.png')); ?>"  />
                                                <?php endif; ?>
                                            </div>
                                            <p>Designs by this artist:</p>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-5 col-lg-8 col-xl-8 col-xxl-9">

                                            <?php if( !empty($artist->artist_logo) && \Storage::disk('uploads')->exists('/users/' .$artist->artist_logo)): ?>
                                                <div class="licence_author_logo">
                                                    <a href="<?php echo e(route('artist-detail',['slug' =>$artist->artist_slug ])); ?>">
                                                        <img src="<?php echo e(url('uploads/users/'.$artist->artist_logo)); ?>" alt="<?php echo e($artist->artist_logo ?? ''); ?>" class="author-logo-handler"/>
                                                    </a>
                                                </div>
                                                <?php else: ?>
                                                <div class="no_licence_author_logo">
                                                </div>
                                            <?php endif; ?>


                                         <div class="licence_author_content">
                                             <?php if(empty($artist->artist_logo) || !\Storage::disk('uploads')->exists('/users/' .$artist->artist_logo)): ?>
                                               <a href="<?php echo e(route('artist-detail',['slug' =>$artist->artist_slug ])); ?>">
                                                   <h2><?php echo e($artist->first_name); ?> <?php echo e($artist->last_name); ?></h2>
                                               </a>
                                             <?php endif; ?>
                                            <p><?php echo $artist->description; ?></p>
                                         </div>


                                        </div>
                                    </div>
                                </div>
                                <?php if($artist->products->isNotEmpty()): ?>
                                    <div class="tfu-slider-position">
                                        <div class="tfu-slider-nav-license-artwork">
                                            <?php $__currentLoopData = $artist->limited_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(!empty($product->feature_image) && \Storage::disk('uploads')->exists('/products/' .$product->feature_image)): ?>
                                                    <a href="<?php echo e(route('product-detail',['slug' => $product->product_slug ])); ?>">
                                                        <div>
                                                            <div class="tfu-slider-list-img" >
                                                                <img src="<?php echo e(url('uploads/products/small-'.$product->feature_image)); ?>" alt="<?php echo e($product->feature_image ?? ''); ?>" style="" />
                                                            </div>
                                                        </div>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <button class="custom-prev-arrow-artwork"><img src="<?php echo e(asset('/assets/frontend-assets/svg/left-arrow.svg')); ?>" alt="left-arrow.svg" /></button>
                                        <button class="custom-next-arrow-artwork"><img src="<?php echo e(asset('/assets/frontend-assets/svg/right-arrow.svg')); ?>" alt="right-arrow" /></button>
                                    </div>
                                <?php endif; ?>
                          </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php /*
                    <div class="tfu-artwork-slider-btn" >
                        <button class="tfu-artwork-slider-submit" id="load_more_btn">See More...</button>
                    </div> */ ?>
                <?php else: ?>
                    <p>Record not found</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('/assets/frontend-assets/js/slick.min.js')); ?>"></script>

    <script type="text/javascript">
        var ENDPOINT = "<?php echo e(route('license-artwork')); ?>";
        var page = 1;

        $('.tfu-slider-nav-license-artwork').slick({
            slidesToShow: 8,
            slidesToScroll: 1,
            arrows: true,
            infinite: true,
            focusOnSelect: false,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    },
                },

                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
            ],
            prevArrow: $('.custom-prev-arrow-artwork'),
            nextArrow: $('.custom-next-arrow-artwork')
        });
        jQuery(document).ready(function(){
            //----------------------------------------------------------------------------------------


            //----------------------------------------------------------------------------------------

            $("#load_more_btn").click(function(){
                page++;
                infinteLoadMore(page);
            });


            function infinteLoadMore(page) {
                $.ajax({
                    url: ENDPOINT + "?page=" + page,
                    type: "get",
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
                })
                    .done(function (response) {
                        $('.auto-load').hide();
                        if(response.record_found == 'yes') {
                            $('#ajax_load_artists').append(response.html);
                            $('.tfu-slider-nav-license-artwork').not('.slick-initialized').slick({
                                slidesToShow: 8,
                                slidesToScroll: 1,
                                arrows: true,
                                infinite: true,
                                focusOnSelect: false,
                                responsive: [
                                    {
                                    breakpoint: 1024,
                                    settings: {
                                        slidesToShow: 5,
                                        slidesToScroll: 1,
                                    },
                                    },
                                    {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 1,
                                    },
                                    },

                                    {
                                    breakpoint: 576,
                                    settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 1,
                                    },
                                    },
                                ],
                                prevArrow: $('.custom-prev-arrow-artwork'),
                                nextArrow: $('.custom-next-arrow-artwork')
                            });
                        } else {
                            Swal.fire({
                                reverseButtons: true,
                                title: 'No more artists found',
                                type: 'warning',
                                showCancelButton: true,
                                showConfirmButton : false,
                                cancelButtonText: 'Close',
                                cancelButtonColor: '#808080'
                            }).then((result) => {
                            })
                        }
                    })
                    .fail(function (jqXHR, ajaxOptions, thrownError) {
                        console.log('Server error occured');
                    });
            }

            //-----------------------------------------------------------------------------------------
        });

    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/frontend/artist/license-artwork.blade.php ENDPATH**/ ?>
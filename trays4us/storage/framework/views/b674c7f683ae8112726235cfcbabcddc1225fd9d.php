<?php if($fail_products->isNotEmpty()): ?>

        <div class="col-xl-12" >
            <h2 class="ftu-uploaded-result-title" >RESULT - Fail  (will not be uploaded)</h2>
            <?php $__currentLoopData = $fail_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fail_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="tfu-result-fail" >
               <img src="<?php echo e(asset('/assets/images/ftu-line-upload.svg')); ?>"  />
               <div class="ftu-fail-img-path" >
                 <div class="ftu-path-title" >
                    <p>
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                            <circle cx="7.5" cy="7.5" r="7.5" fill="#FF0000"/>
                            </svg></span>
                        <?php echo e($fail_product->fetaure_image_orginal_name); ?></p>
                  </div>
                   <?php /*
                  <div class="ftu-remove-path" >
                    <img src="{{ asset('/assets/images/isolation_Mode.svg') }}"  />
                  </div> */ ?>
               </div>
                    <div class="ftu-upload-data-box" >
                        <div class="row">
                         <div class="col-xl-5" >
                            <p class="ftu-title-status" ><input type="text" value="<?php echo e($fail_product->product_name); ?>" name="mu_product_name" data-sku="<?php echo e($fail_product->product_sku); ?>" data-mupid="<?php echo e($fail_product->id); ?>" class="mu_product_name"></p>
                            <h2 class="ftu-uploaded-product-title" ><?php echo e($fail_product->artist->display_name ? $fail_product->artist->display_name : $fail_product->artist->first_name.' '.$fail_product->artist->last_name); ?></h2>
                            <div class="row" >
                              <div class="col-xl-6 tfu-left-uploaded-result" >

                                  <?php
                                      $getProductTypeDetail = array();
                                      if(isset($fail_product->pt_sub_id) AND $fail_product->pt_sub_id > 0)
                                        $getProductTypeDetail  = \App\Traits\Definations::getProductTypeDetail($fail_product->pt_sub_id);
                                      $tags  = \App\Models\TempProducts::get_tags_list($fail_product->tags);
                                  ?>

                                  <p><?php echo e($getProductTypeDetail->child->type_name ?? ''); ?></p>
                                  <p><?php echo e($getProductTypeDetail->type_name ?? ''); ?></p>

                                 <p class="tfu-sku-fail" ><?php echo e($fail_product->product_sku); ?> repeated SKU !</p>

                                  <p class="tfu-price-success">$<?php echo e($fail_product->price); ?> / item</p>
                                  <p>MOQ: <span><?php echo e($fail_product->minimum_order_quantity); ?></span></p>
                              </div>
                              <div class="col-xl-6  tfu-right-uploaded-result " >
                                  <p><?php echo e($fail_product->style->style_name); ?></p>
                                  <p><?php echo e($fail_product->country->country_name ?? ''); ?></p>
                                  <p><?php echo e($fail_product->state->state_name ?? ''); ?></p>
                              </div>
                            </div>
                             <?php if($tags): ?>
                                 <?php /*
                                 <div class="tfu-uploaded-tags-box"  >
                                     <div class="tags-input" >
                                        <span class="data">
                                            {!! $tags !!}
                                        </span>
                                         <span class="autocomplete">
                                            <div class="autocomplete-items"></div>
                                        </span>
                                     </div>
                                 </div> */ ?>

                                 <div class="tfu-uploaded-tags-box tag_wrapper">

                                     <input type="hidden" name="tag_ids" data-sku="<?php echo e($fail_product->product_sku); ?>" class="tag-ids massu_tag_ids" value="<?php echo e($fail_product->tags); ?>">
                                     <div class="col-sm-10 tags-input">
                                         <div class="myTags" id="">
                                                    <span class="data">  <?php echo $tags; ?></span>

                                             <span class="autocomplete">
                                                <input type="text" fdprocessedid="7t76h">
                                                <div class="autocomplete-items"></div>
                                             </span>
                                         </div>
                                     </div>
                                 </div>


                             <?php endif; ?>

                         </div>
                         <div class="col-xl-7" >
                             <?php if($fail_product->images): ?>
                                 <ul class="ftu-mass-image-gallery-result sortable">
                                     <?php $__currentLoopData = $fail_product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery_image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                         <?php if($fail_product->feature_image == $gallery_image->image_name): ?>
                                             <li class="ui-state-default selector ftu-img-handle feature_image" id="<?php echo e($gallery_image->id); ?>"><img src="<?php echo e(url('uploads/temp_products/small-'.$gallery_image->image_name)); ?>" ></li>
                                         <?php endif; ?>

                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                     <?php $__currentLoopData = $fail_product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery_image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <?php if($fail_product->feature_image != $gallery_image->image_name): ?>
                                             <li class="ui-state-default selector ftu-img-handle" id="<?php echo e($gallery_image->id); ?>"><img src="<?php echo e(url('uploads/temp_products/small-'.$gallery_image->image_name)); ?>" ></li>
                                         <?php endif; ?>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </ul>
                             <?php endif; ?>
                            <p class="tfu-image-gallery-result-box" ><?php echo e($fail_product->product_description); ?></p>
                         </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

<?php endif; ?>

     <?php /*
    <div class="col-xl-12" >
    <div class="tfu-result-warning" >
     <h2 class="ftu-uploaded-result-title" >RESULT - Warning</h2>
     <img src="{{ asset('/assets/images/ftu-line-upload.svg') }}"  />
     <div class="ftu-fail-img-path" >
       <div class="ftu-path-title" >
          <p><span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
            <circle cx="7.5" cy="7.5" r="7.5" fill="#FF9900"/>
            </svg></span>Alyssa Watters_Veggies_1612-10708.png</p>
        </div>
        <div class="ftu-remove-path" >
          <img src="{{ asset('/assets/images/isolation_Mode.svg') }}"  />
        </div>
     </div>
     <div class="ftu-upload-data-box" >
        <div class="row">

           <div class="col-xl-5" >
              <p class="ftu-title-status" >Veggies</p>
              <h2 class="ftu-uploaded-product-title" >Alyssa Watters</h2>
              <div class="row" >
                <div class="col-xl-6 tfu-left-uploaded-result" >
                   <p>Large 16.5"x12.5"</p>
                   <p>Tray</p>
                   <p>1612-10708</p>
                   <p class="tfu-sku-price-fail"  >Price !</p>
                   <p>MOQ: <span>8</span></p>
                </div>
                <div class="col-xl-6  tfu-right-uploaded-result " >
                   <p>NO customizable</p>
                   <p class="tfu-sku-price-fail" >Country !</p>
                   <p>Maine</p>
                </div>
              </div>

              <div class="tfu-uploaded-tags-box"  >
                  <div class="tags-input" >
                      <span class="data">
                          <span class="tag"><span class="text" _value="87">Alissa Watters </span><span class="close">×</span></span>
                          <span class="tag"><span class="text" _value="88">snow</span><span class="close">×</span></span>
                      </span>
                      <span class="autocomplete">
                        <div class="autocomplete-items"></div>
                      </span>
                  </div>
              </div>

           </div>
           <div class="col-xl-7" >
              <div class="ftu-mass-image-gallery-result" >
                  <div class="ftu-img-handle" ><img src="https://hammanitechdemos.com/trays4us/uploads/products/product-feature-1700244445.png" ></div>
                  <div  class="ftu-img-handle" ><p class="tfu-uploaded-img-title" >img1</p><img src="https://hammanitechdemos.com/trays4us/uploads/products/product-feature-1699005613.png" ></div>
                  <div  class="ftu-img-handle" ><p class="tfu-uploaded-img-title" >img1</p><img src="https://hammanitechdemos.com/trays4us/uploads/products/product-feature-1699005252.png" ></div>
                  <div  class="ftu-img-handle" ><p class="tfu-uploaded-img-title" >img1</p><img src="https://hammanitechdemos.com/trays4us/uploads/products/product-feature-1700388535.png" ></div>
                  <div  class="ftu-img-handle" ><p class="tfu-uploaded-img-title" >img1</p><img src="https://hammanitechdemos.com/trays4us/uploads/products/product-feature-1699609929.png" ></div>
              </div>
              <p class="tfu-uploaded-description-result-box" >Description !</p>
           </div>

        </div>
     </div>
    <div class="tfu-uploaded-warning-btn" ><a href="#">OK to Upload with warnings</a></div>
  </div>
</div>
    */ ?>

    <?php if($products->isNotEmpty()): ?>
        <div class="col-xl-12" >

            <div class="tfu-result-success" >
                 <h2 class="ftu-uploaded-result-title" >RESULT - OK</h2>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <div class="tfu-upload-row-result" >
                    <img src="<?php echo e(asset('/assets/images/ftu-line-upload.svg')); ?>"  />
                    <div class="ftu-fail-img-path" >
                      <div class="ftu-path-title" >
                        <p><span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                            <circle cx="7.5" cy="7.5" r="7.5" fill="#00BB1E"/>
                            </svg></span><?php echo e($product->fetaure_image_orginal_name); ?></p>
                      </div>
                        <?php /*
                        <div class="ftu-remove-path" >
                            <img src="{{ asset('/assets/images/isolation_Mode.svg') }}"  />
                        </div> */ ?>
                    </div>
                    <div class="ftu-upload-data-box" >
                        <div class="row">

                        <div class="col-xl-5" >
                            <p class="ftu-title-status" ><input type="text" value="<?php echo e($product->product_name); ?>" name="mu_product_name" data-sku="<?php echo e($product->product_sku); ?>" data-mupid="<?php echo e($product->id); ?>" class="mu_product_name"></p>
                            <h2 class="ftu-uploaded-product-title" ><?php echo e($product->artist->display_name ? $product->artist->display_name : $product->artist->first_name.' '.$product->artist->last_name); ?></h2>
                            <div class="row" >
                                <div class="col-xl-6 tfu-left-uploaded-result" >

                                    <?php
                                        $getProductTypeDetail = array();
                                        if(isset($product->pt_sub_id) AND $product->pt_sub_id > 0)
                                          $getProductTypeDetail  = \App\Traits\Definations::getProductTypeDetail($product->pt_sub_id);

                                     $tags  = \App\Models\TempProducts::get_tags_list($product->tags);

                                    ?>

                                <p><?php echo e($getProductTypeDetail->child->type_name ?? ''); ?></p>
                                <p><?php echo e($getProductTypeDetail->type_name ?? ''); ?></p>
                                <p><?php echo e($product->product_sku); ?></p>
                                <p class="tfu-price-success"  >$<?php echo e($product->price); ?> / item</p>
                                <p>MOQ: <span><?php echo e($product->minimum_order_quantity); ?></span></p>
                                </div>
                                <div class="col-xl-6  tfu-right-uploaded-result " >
                                <p><?php echo e($product->style->style_name); ?></p>
                                <p><?php echo e($product->country->country_name ?? ''); ?></p>
                                <p><?php echo e($product->state->state_name ?? ''); ?></p>
                                </div>
                            </div>

                                <div class="tfu-uploaded-tags-box tag_wrapper">

                                    <input type="hidden" name="tag_ids[<?php echo e($product->id); ?>]" data-sku="<?php echo e($product->product_sku); ?>" class="tag-ids massu_tag_ids" value="<?php echo e($product->tags); ?>">
                                    <div class="col-sm-10 tags-input">
                                        <div class="myTags" id="">
                                            <span class="data">  <?php echo $tags; ?></span>

                                            <span class="autocomplete">
                                                        <input type="text" fdprocessedid="7t76h">
                                                        <div class="autocomplete-items"></div>
                                                    </span>
                                        </div>
                                    </div>
                                </div>


                        </div>
                        <div class="col-xl-7">
                            <?php if($product->images): ?>
                                <ul class="ftu-mass-image-gallery-result sortable">
                                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery_image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php if($product->feature_image == $gallery_image->image_name): ?>
                                            <li class="ui-state-default selector ftu-img-handle feature_image" id="<?php echo e($gallery_image->id); ?>"><img src="<?php echo e(url('uploads/temp_products/small-'.$gallery_image->image_name)); ?>" ></li>
                                        <?php endif; ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery_image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($product->feature_image != $gallery_image->image_name): ?>
                                                <li class="ui-state-default selector ftu-img-handle" id="<?php echo e($gallery_image->id); ?>"><img src="<?php echo e(url('uploads/temp_products/small-'.$gallery_image->image_name)); ?>" ></li>
                                            <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                            <p class="tfu-image-gallery-result-box" ><?php echo e($product->product_description); ?></p>
                        </div>

                        </div>
                    </div>
                 </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
    <script>
        $(document).ready(function() {
            var pass_array = [];

            $(".sortable").sortable({
                items: "> li:not(.feature_image)", // Exclude the first li with the class "feature_image"
                connectWith: ".feature_image",
                update: function (event, ui) {
                    // Get the sorted items
                    var sortedItems = $(this).sortable('toArray');
                    // Include the first li with the class "feature_image" in the array
                    var featureImageItem = $(this).find('.feature_image').attr('id');
                    sortedItems.unshift(featureImageItem);

                    $.ajax({
                        method: "POST",
                        url:"<?php echo e(route('sortable-mass-upload-images')); ?>",
                        data:{
                            "_token": "<?php echo e(csrf_token()); ?>",
                            "sortedItems": sortedItems
                        }
                    }).done(function(data) {
                    });
                }
            });
        });
    </script>
<?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/products/preview-mass-upload.blade.php ENDPATH**/ ?>
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" type="text/css" media="all" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css"/>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Setting</h3>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs menu-tabs">
                <li class="nav-item active">
                    <a class="nav-link" href="javascript:void(0)">General Settings</a>
                </li>
            </ul>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 mt-3">
                    <div class="card">
                        <div class="card-body p-0">
                            <form action="<?php echo e(route('site-update')); ?>" method="post" enctype="multipart/form-data" class="site_setting">
                                <?php echo e(csrf_field()); ?>

                                <div class="tab-content pt-0">
                                    <div id="general" class="tab-pane active">
                                        <div class="card mb-0">
                                            <div class="card-header">
                                                <h4 class="card-title">General Settings</h4>
                                            </div>

                                            <div class="card-body">
                                                <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <label class="form-check-label" for="enable_otp">Force all buyers to sign in every time with a one-time-password ?</label>
                                                            <input class="form-check-input" type="checkbox" name="enable_otp" value="1" id="enable_otp" <?php echo e($site_managements->enable_otp == 1 ? 'checked': ''); ?>>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <label class="form-check-label" for="send_email">Enable Email Verification on Signup ? </label>
                                                            <input class="form-check-input" type="checkbox" name="send_email" value="1" id="send_email" <?php echo e($site_managements->send_email == 1 ? 'checked': ''); ?>>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Frontend Catalogue Pagination</label>
                                                        <input type="text" class="form-control" name="pagination" value="<?php echo e($site_managements->pagination); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Admin  Pagination</label>
                                                        <input type="text" class="form-control" name="backend_pagination_listing" value="<?php echo e($site_managements->backend_pagination_listing); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Website Logo</label>
                                                        <div class="uploader">
                                                            <input type="file" class="form-control" name="website_logo">
                                                        </div>

                                                        <?php if( !empty($site_managements->website_logo) && \Storage::disk('uploads')->exists('/users/' . $site_managements->website_logo)): ?>
                                                            <img src="<?php echo e(url('uploads/users/'.$site_managements->website_logo)); ?>" class="site-logo" alt>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-6" style="display: none">
                                                    <div class="form-group">
                                                        <label>Favicon</label>
                                                        <div class="uploader">
                                                            <input type="file" class="form-control" name="fav_icon">
                                                        </div>
                                                        <p class="form-text text-muted small mb-0">Recommended image size is <b>16px x 16px</b> or <b>32px x 32px</b></p>
                                                        <?php if( !empty($site_managements->fav_icon) && \Storage::disk('uploads')->exists('/users/' . $site_managements->fav_icon)): ?>
                                                            <img src="<?php echo e(url('uploads/users/'.$site_managements->fav_icon)); ?>" class="fav-icon" alt>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Website Name</label>
                                                        <input type="text" class="form-control" name="site_name" value="<?php echo e($site_managements->site_name); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <input type="text" class="form-control" name="address" value="<?php echo e($site_managements->address); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <input type="text" class="form-control" name="city" value="<?php echo e($site_managements->city); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>State</label>
                                                        <input type="text" class="form-control" name="state" value="<?php echo e($site_managements->state); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Postal Code</label>
                                                        <input type="text" class="form-control" name="zip_code" value="<?php echo e($site_managements->zip_code); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Mobile Number</label>
                                                        <input type="text" class="form-control" name="mobile_number" value="<?php echo e($site_managements->mobile_number); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="text" class="form-control" name="email" value="<?php echo e($site_managements->email); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Currency symbol</label>
                                                        <input type="text" class="form-control" name="currency_symbol" value="<?php echo e($site_managements->currency); ?>">
                                                     </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Order lead time (Days)</label>
                                                        <input type="text" class="form-control" name="estimated_ship_days" value="<?php echo e($site_managements->estimated_ship_days); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Minimum order amount</label>
                                                        <input type="text" class="form-control" name="minimum_order_amount" value="<?php echo e($site_managements->minimum_order_amount); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>MSRP</label>
                                                        <input type="text" class="form-control" name="msrp_price" value="<?php echo e($site_managements->msrp_price); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Shipping Fee</label>
                                                        <input type="text" class="form-control" name="shipping_fee" value="<?php echo e($site_managements->shipping_fee); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="display_order">Display order</label>
                                                        <input type="hidden" id="sorting_order" name="sorting_order"
                                                               value="<?php echo e(is_array($site_managements->display_order_value) ? implode(',', $site_managements->display_order_value) : ''); ?>">
                                                        <select id="display_order_value" name="display_order_value[]" multiple class="form-control">
                                                            <option value="">Select display order</option>
                                                            <?php $__currentLoopData = $sorting_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <optgroup label="<?php echo e($key); ?>">
                                                                    <?php $__currentLoopData = $collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($item->id); ?>" <?php echo e((is_array($site_managements->display_order_value) && in_array($item->id, $site_managements->display_order_value) ? 'selected' : '')); ?>><?php echo e($item->badge); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </optgroup>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <fieldset class="ftu-filedset-input" >
                                                    <legend>Upload Your Artwork ( Customizer )</legend>
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-check-label" for="customizer_bedge">Bedge ID</label>
                                                                <select class="form-control" name="customizer_bedge" id="customizer_bedge">
                                                                    <option value="">Select Badge</option>
                                                                    <?php $__currentLoopData = $badges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($badge->id); ?>" <?php echo e($site_managements->customizer_bedge == $badge->id ? 'selected' : ''); ?>><?php echo e($badge->badge); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-check-label" for="customizer_artist_id">Artist ID</label>
                                                                <select class="form-control" name="customizer_artist_id" id="customizer_artist_id">
                                                                    <option  value="">Select  Artist</option>
                                                                    <?php $__currentLoopData = $artists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php
                                                                            $artist_name = $artist->first_name.' '.$artist->last_name;
                                                                            if($artist->display_name)
                                                                               $artist_name = $artist->display_name;
                                                                        ?>
                                                                        <option value="<?php echo e($artist->id); ?>" <?php echo e($site_managements->customizer_artist_id == $artist->id ? 'selected' : ''); ?>><?php echo e($artist_name); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-check-label" for="customizer_style_id">Style ID</label>
                                                                <select class="form-control" name="customizer_style_id" id="customizer_style_id">
                                                                    <option value="">Select Style</option>
                                                                    <?php $__currentLoopData = $themes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $theme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($theme->id); ?>" <?php echo e($site_managements->customizer_style_id == $theme->id ? 'selected' : ''); ?>><?php echo e($theme->style_name); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                         <?php /*
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-check-label" for="customizer_price">Customizer Price</label>
                                                                <input type="text" class="form-control" id="customizer_price" name="customizer_price" value="{{$site_managements->customizer_price}}">
                                                            </div>
                                                        </div> */ ?>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-check-label" for="customizer_minimums">Minimums(Design Types ID)</label>
                                                                <select class="form-control" name="customizer_minimums" id="customizer_minimums">
                                                                    <option  value="">Select Minimum</option>
                                                                    <?php $__currentLoopData = $customizables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customizable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($customizable->id); ?>" <?php echo e($site_managements->customizer_minimums == $customizable->id ? 'selected' : ''); ?>><?php echo e($customizable->customizable_name); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>


                                                            </div>
                                                        </div>

                                                    </div>
                                                </fieldset>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.js"></script>
    <script>
        $(document).ready(function () {

            $("#display_order_value").chosen( { width: '100%' });
            /*
            $('#display_order_valuess').chosen().change(function(){
                var myValues = $('#sorting_order').chosen().val();
                alert(myValues);
            });
            */

            $("#display_order_value").chosen({
                width: '100%'
            }).change(function(evt, params){


                var sorting_order = $('#sorting_order').val();
                var values = sorting_order ? sorting_order.split(',') : [];

                if (params.deselected) {
                    values = values.filter(function(item) {
                        return item !== params.deselected;
                    });
                }

                if (params.selected) {
                    values.push(params.selected);
                }

                $('#sorting_order').val(values.join(','));

            });

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/dashboard/site-setting.blade.php ENDPATH**/ ?>
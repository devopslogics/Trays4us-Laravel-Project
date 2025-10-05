<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Edit Customer</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="<?php echo e(route('edit-customer-submitted')); ?>" method="post" enctype="multipart/form-data" class="edit_customer_submitted" autocomplete="off">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="id" value="<?php echo e($customer->id); ?>">
                        <fieldset class="ftu-filedset-input">
                            <legend>Customer Info </legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo e($customer->first_name); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo e($customer->last_name); ?>">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" name="company" value="<?php echo e($customer->company); ?>">
                                </div>
                            </div>
                        </div>
                        </fieldset>


                        <fieldset class="ftu-filedset-input" >
                            <legend>Contact Info </legend>
                            <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="tel" class="form-control numeric_only" id="customer_phone"  name="phone" value="<?php echo e($customer->phone); ?>">
                                    <span id="customer_phone_error"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo e($customer->email); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shipping address 1</label>
                                    <input type="text" class="form-control" name="shiping_address1" value="<?php echo e($customer->shiping_address1); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shipping address 2</label>
                                    <input type="text" class="form-control" name="shiping_address2" value="<?php echo e($customer->shiping_address2); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" value="<?php echo e($customer->city); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input type="text" class="form-control zip-code" name="postal_code" value="<?php echo e($customer->postal_code); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control" name="country" id="country">
                                        <option>Select Country</option>
                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($country->id); ?>" <?php echo e($customer->country_id == $country->id ? 'selected' : ''); ?>><?php echo e($country->country_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <select class="form-control" name="state" id="state">
                                        <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($state->id); ?>" <?php echo e($state->id == $customer->state_id ? 'selected' : ''); ?>><?php echo e($state->state_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Website</label>
                                    <input type="text" class="form-control" name="website" value="<?php echo e($customer->website); ?>">
                                </div>
                            </div>

                            </div>
                        </fieldset>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="<?php echo e(route('customer')); ?>" class="btn btn-link">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

    <link rel="stylesheet" href="<?php echo e(asset('assets/phone_number/css/intlTelInput.css')); ?>">
    <script src="<?php echo e(asset('assets/phone_number/js/intlTelInput.js')); ?>"></script>

    <script type="text/javascript">

        var input = document.querySelector("#customer_phone");
        window.intlTelInput(input, {
            geoIpLookup: function(callback) {
                fetch("https://ipapi.co/json")
                    .then(function(res) { return res.json(); })
                    .then(function(data) { callback(data.country_code); })
                    .catch(function() { callback("us"); });
            },
            hiddenInput: "customer_full_phone",
            initialCountry: "auto",
            separateDialCode:true,
            utilsScript: "<?php echo e(asset('assets/phone_number/js/utils.js')); ?>",
        });

        $(document).ready(function() {


            $('#country').change(function () {
                var country_id = $(this).val();
                if (country_id) {
                    get_state_by_country_id(country_id);
                } else {
                    $('#state').empty().hide();
                }
            });

            //-----------------------------------------------------------------------------------------

            function get_state_by_country_id(country_id) {
                $.ajax({
                    url: "<?php echo e(route('get-state-by-country-id')); ?>",
                    type: 'GET',
                    data: { country_id: country_id },
                    dataType: 'json',
                    success: function (data) {
                        $('#state').empty().show();
                        $('#state').append('<option value="">Select State</option>');
                        $.each(data, function (key, value) {
                            $('#state').append('<option value="' + value.id + '">' + value.state_name + '</option>');
                        });
                    }
                });
            }

        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/users/customer/edit.blade.php ENDPATH**/ ?>
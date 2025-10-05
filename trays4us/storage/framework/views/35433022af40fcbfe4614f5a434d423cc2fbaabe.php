<script type="text/javascript">

    $(document).ready(function () {

          var timer;

        window.addEventListener("pageshow", function (event) {
            if (event.persisted || (typeof event.persistedSource !== "undefined" && event.persistedSource === "back_forward")) {
                window.location.reload();
            }
        });

          function debounce(){
              clearTimeout(timer);
              timer = setTimeout(function(){
                  $("#tfu-user-account-handler").fadeOut('fast');
              },450);
          }
          //--------------------------------------------------------------------------------------------------------

          $(".tfu-login-handler").hover(function() {
              // hover over
              $("#tfu-user-account-handler").show();
              $('.tfu-login-handler').addClass('active-login-handler');

              clearTimeout(timer);
            },function(){
              // hover out
              debounce();
            })
          //-------------------------------------------------------------------------------------------------------

          $(".tfu-user-account-popup").mouseenter(function(){
            clearTimeout(timer);
          });
        //--------------------------------------------------------------------------------------------------------

          $(".tfu-user-account-popup").mouseleave(function(){
            $('.tfu-login-handler').removeClass('active-login-handler');

            debounce();
          });

        //--------------------------------------------------------------------------------------------------------

        $(".numeric_only").keypress(function (e) {
            if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
        });

        // ----------------------------------------------------------------------------------------------------

        $('.zip-code').on('input', function() {
            var value = $(this).val();
            value = value.replace(/\D/g, '');
            if (value.length > 7) {
                value = value.substring(0, 7);
            }
            $(this).val(value);
        });

        //--------------------------------------------------------------------------------------------------------

        $(".tfu-btn-filter").click(function() {
            var toggle2 = $("#tfu-shop-filter-handler").toggle();
            console.log(toggle2);
            var image = $('.tfu-btn-filter span img');
            var upSrc = image.data('up');
            var downSrc = image.data('down');

            if ($("#tfu-shop-filter-handler").is(":hidden")) {
                image.attr('src',downSrc);
            } else {
                image.attr('src',upSrc);
            }

          })

        //--------------------------------------------------------------------------------------------------------

        $(document).on("click", function(event) {
            if (!$(event.target).closest("#ftu-navbarNav").length && !$(event.target).is(".ftu-nav-togglebar")) {
                $("#ftu-navbarNav").hide();
                $(".navbar-collapse").removeClass("show");
            }
        });

        //--------------------------------------------------------------------------------------------------------

        $("#header_search_btn").on("click", function(event) {
            $('#header_search_form').submit();
        });

        //--------------------------------------------------------------------------------------------------------
        $(document).on("click",".tfu_add_wish_list_popup",function() {
            var popup_html = `<div class="tfu-popup-useraccount">
                            <p>To add items to your wish list, please sign in</p>
                            <div class="ftu-signin-popup-btn">
                                <a class="nav-link" href="<?php echo e(route('sign-in')); ?>">Sign In</a>
                            </div>
                            <p>New account? <span><a href="<?php echo e(route('sign-up')); ?>">Start here</a></span></p>
                        </div>`;
            $('#tfu_general_body').html(popup_html);
            $('#tfu_general_modal').modal('show');

        });

        //--------------------------------------------------------------------------------------------------------

        $(document).on("click",".tfu_add_wish_list",function() {
            var _this = $(this);
            var productId = $(this).attr('data-pid');
            var already_wish_list = false;
            if(_this.hasClass('already_wish_list')) {
                already_wish_list = true;
            }
            $.ajax({
                url: "<?php echo e(route('add-wishlist')); ?>",
                type: "POST",
                data: { productId: productId,already_wish_list : already_wish_list , "_token": "<?php echo e(csrf_token()); ?>"},
                success: function(response) {
                    if(response.status == 'success') {
                        // Remove item from wishlist if there is already exist
                        // Same will be work like/dislike
                        if(already_wish_list) {
                            _this.removeClass('already_wish_list');
                            _this.find('img').attr('src',response.whishlist_icon);
                        }else {
                            _this.addClass('already_wish_list');
                            _this.find('img').attr('src',response.whishlist_icon);
                        }
                    }
                },
                error: function(xhr) {
                    // Handle the error (e.g., display an error message)
                    console.error(xhr);
                }
            });
        });

        //--------------------------------------------------------------------------------------------------------

        $(".remove_wishlist").on("click", function() {
            var _this = $(this);
            var wishlist_id = $(this).attr('data-wid');
            $.ajax({
                url: "<?php echo e(route('remove-wishlist')); ?>",
                type: "POST",
                data: { wishlist_id: wishlist_id , "_token": "<?php echo e(csrf_token()); ?>"},
                success: function(response) {
                    if($("tr.tfu_product_qty_wrapper").length == 1) {
                        location.reload();
                        return false;
                    }
                    if(response.status == 'success') {
                        $('#tr_'+wishlist_id).remove();
                    }
                },
                error: function(xhr) {
                    // Handle the error (e.g., display an error message)
                    console.error(xhr);
                }
            });
        });

        //--------------------------------------------------------------------------------------------------------

        $(document).on("click",".add_to_cart",function() {
            var _this = $(this);
            var productId = _this.attr('data-pid');

            // Quantity and cp(case pack) will only work in product detail page(single product page ) as well as wishlisting page
            var quantity = _this.closest('.tfu_product_qty_wrapper').find('.ftu-product-quantity').val();
           // var case_pack =$('.ftu-product-quantity').attr('data-cp');
            $.ajax({
                url: "<?php echo e(route('add-to-cart')); ?>",
                type: "POST",
                data: { productId: productId , quantity : quantity, "_token": "<?php echo e(csrf_token()); ?>"},
                success: function(response) {
                    if(response.status == 'success') {
                        _this.addClass('already_cart');
                        _this.text('Add '+response.case_pack+' more to Cart ($'+response.calculted_price+')');
                        $('#product_' + productId + ' .already_item_cart').text(response.current_added_item_quantity + ' items in Cart ($' + response.current_added_item_total_price + ')');
                        console.log('#product_' + productId + ' .already_item_cart');
                        _this.css({"background-color": '#FF6600',"color" : "#fff"});
                        $('#item_count').html(response.total_quantity);
                        $('#product_' + productId + ' .already_item_cart').addClass("cart_blinking");

                        setTimeout(function() {
                            $('#product_' + productId + ' .already_item_cart').removeClass("cart_blinking");
                        }, 2000); // 3 seconds (3 blinks at 1s each)
                    }
                },
                error: function(xhr) {
                    // Handle the error (e.g., display an error message)
                    console.error(xhr);
                }
            });
        });

        //---------------------------------- Delete custom product by user -----------------------------------------

        $(document).on("click", ".tfu_delete_custom_product", function() {
            var pid = $(this).attr('data-pid');
            var tfu_single_delete = $(this).hasClass('tfu_single_delete');

            // SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to delete this product?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                console.log(result);
                if (result.value) {
                    // Perform the delete action if confirmed
                    $.ajax({
                        type: 'get',
                        url: "<?php echo e(route('delete-customizer-product-by-user')); ?>",
                        data: { pid: pid },
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == 'success') {
                                if(tfu_single_delete) { // If single product want to delete then redirected to shop page
                                    window.location = "<?php echo e(route('frontend.products')); ?>";
                                } else {
                                    Swal.fire(
                                        'Deleted!',
                                        'The product has been deleted.',
                                        'success'
                                    );
                                    $('#product_' + pid).remove();
                                }
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message,
                                    'error'
                                );
                            }
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error!',
                                'An unexpected error occurred. Please try again.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        //----------------------------------------- Reload the current page --------------------------------------

        $(document).on("click", ".tfu-cancel-loading", function() {
            location.reload();
        });

        //--------------------------------------------------------------------------------------------------------

        $('.ftu-select-btn-qty').on("click", function() {
            _this = $(this);
            _this.closest('.tfu-wrapper-shop-select').find('.ftu-wrapper-select-quantity').toggleClass("active");
        });

        //--------------------------------------------------------------------------------------------------------

        $("body").on("keydown keypress", "input.ftu-product-quantity", function (event) {
            $(".ftu-wrapper-select-quantity .ftu-qty-options li").removeClass('active');
            if (event.keyCode === 13) {
                update_nearest_quantity2();
                update_area_when_custom(); // Update selection area when someone click outside from dropdown area when enter to textfield

                if ($(this).closest('.ftu-qty-input').find('.update_cart_btn').length) {
                    $(this).closest('.ftu-qty-input').find('.update_cart_btn').trigger('click');
                }
            }
        });

        //----------------------------------------------------------------------------------------

        $(document).mousedown(function (e) {
            if ( $(e.target).closest('.ftu-wrapper-select-quantity').length === 0 ) {
                if($('.ftu-wrapper-select-quantity').hasClass('.active')) {
                    update_nearest_quantity2();
                    update_area_when_custom(); // Update selection area when someone click outside from dropdown area when enter to textfield
                }
            }
        });

        //---------------------------------------------------------------------------------------------------------

        $("#back_to_top").on("click", function() {
            $(window).scrollTop(0);
        });


    });

    function updateName(selectedLi) {
        const $activeElements = $(selectedLi).closest('.ftu-qty-options').find('li.active');
        $activeElements.removeClass('active');

        $(selectedLi).addClass('active');

        const $wrapperShopSelect = $(selectedLi).closest('.tfu-wrapper-shop-select');
        $wrapperShopSelect.find('.ftu-wrapper-select-quantity').removeClass('active');
        $wrapperShopSelect.find('.ftu-select-btn-qty span').html($(selectedLi).html());
        $wrapperShopSelect.find('.ftu-product-quantity').val('');

        const dataQty = $(selectedLi).data('qty');
        $wrapperShopSelect.find('.ftu-select-btn-qty span').attr('data-qty', dataQty);

        if($('.change-quantity-on-selection').length > 0) {
            var price = $('.ftu-wrapper-select-quantity .ftu-product-quantity').attr('data-price');
            var calc_price = dataQty * price;

            $('.change-quantity-on-selection').text(dataQty);
            $('.change-price-on-selection').text(calc_price);
        }

    }

    function update_nearest_quantity2() {
        var nearest_quantity_input = $('.ftu-wrapper-select-quantity.active .ftu-product-quantity');
        var moq = parseInt(nearest_quantity_input.data('moq')) || 1;
        var casePack = parseInt(nearest_quantity_input.data('cp')) || 1;
        var customQuantity = parseInt(nearest_quantity_input.val());
       // alert(moq+'----'+casePack+'----'+customQuantity)
        if (!isNaN(customQuantity)) {
            var nearestMultiple = Math.ceil((customQuantity - moq) / casePack) * casePack + moq;
            if(nearestMultiple < moq)
                nearestMultiple = moq;
            nearest_quantity_input.val(nearestMultiple);
        }
    }

    function update_area_when_custom() {
        var quantity = parseInt($('.ftu-wrapper-select-quantity.active .ftu-product-quantity').val());
        if(quantity > 0) {
            // var case_pack = $('.ftu-product-quantity').attr('data-cp');
            // var quantity = $('.ftu-select-btn-qty span').attr('data-qty');
            var price = $('.ftu-wrapper-select-quantity.active .ftu-product-quantity').attr('data-price');
            var calc_price = quantity * price;
            $('.ftu-wrapper-select-quantity.active .ftu-select-btn-qty span').attr('data-qty', quantity);
            $('.ftu-wrapper-select-quantity.active .ftu-select-btn-qty span').html(quantity + ' ($' + calc_price+')');

        }

        $('.ftu-wrapper-select-quantity').removeClass('active');

        // This will only work for single product page
        if($('.change-quantity-on-selection').length > 0) {
            $('.change-quantity-on-selection').text(quantity);
            $('.change-price-on-selection').text(calc_price);
        }
    }

    //------------------------------------------ Just disable right click and inspect from user -------------
    <?php if(App::environment('production') && !Session::has('is_customer')): ?>
        var show_msg = 0;
        var options = '';

        function nocontextmenu(e) { return false; }
        document.oncontextmenu = nocontextmenu;
        document.ondragstart = function() { return false;}

        document.onmousedown = function (event) {
            event = (event || window.event);
            if (event.keyCode === 123) {
                return false;
            }
        }
        document.onkeydown = function (event) {
            event = (event || window.event);
            //alert(event.keyCode);   return false;
            if (event.keyCode === 123 ||
                event.ctrlKey && event.shiftKey && event.keyCode === 73 ||
                event.ctrlKey && event.shiftKey && event.keyCode === 75) {
                return false;
            }
            if (event.ctrlKey && event.keyCode === 85) {
                return false;
            }
        }
        function addMultiEventListener(element, eventNames, listener) {
            var events = eventNames.split(' ');
            for (var i = 0, iLen = events.length; i < iLen; i++) {
                element.addEventListener(events[i], function (e) {
                    e.preventDefault();
                    if (show_msg !== '0') {
                    }
                });
            }
        }
        addMultiEventListener(document, 'contextmenu', 'right_click');
        addMultiEventListener(document, 'cut copy print', 'copy_cut_paste_content');
        addMultiEventListener(document, 'drag drop', 'image_drop');
    <?php endif; ?>

    //----------------------------------------------------------------------------------------------------------------

</script>

<script>
    function onSubmit(token) {
        document.getElementById("header_search_form").submit();
    }
</script>
<?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/partials/frontend/common-js.blade.php ENDPATH**/ ?>
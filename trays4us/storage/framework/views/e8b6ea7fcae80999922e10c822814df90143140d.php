<script type="text/javascript">
    $(document).ready(function () {

        //-----------------------------------------------------------------------------------------------------------

        $(".change_status").click(function (event) {

            event.preventDefault();

            var msg = ($(this).attr('data-msg'));

            var type = ($(this).attr('data-type'));

            var url = ($(this).attr('href'));

            Swal.fire({

                reverseButtons: true,

                title: msg,

                type: 'warning',

                width:350,

                height:150,

                showCancelButton: true,

                cancelButtonText: 'No',

                confirmButtonText: 'Yes',

                confirmButtonColor: '#ff7129',

                cancelButtonColor: '#808080'

            }).then((result) => {

                if (result.value) {

                    window.location.href = url;

                }

            })

        });

        //------------------------------------------------------------------------------------------------------------

        $(".numeric_only").keypress(function (e) {
            if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
        });

        //------------------------------------------------------------------------------------------------------------

        $('.zip-code').on('input', function() {

            var value = $(this).val();
            // Remove any non-numeric characters

            value = value.replace(/\D/g, '');

            if (value.length > 7) {

                value = value.substring(0, 7);

            }

            $(this).val(value);

        });

    });

    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test($email);
    }

</script>

<?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/partials/admin/common-js.blade.php ENDPATH**/ ?>
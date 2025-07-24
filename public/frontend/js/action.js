$(document).ready(function(){

    var uRL = $('.site-url').val();

    var preloader = `<div class="preloader">
    <div class="loader">
        <div class="inner_loader"></div>
        <div class="inner_loader"></div>
        <div class="inner_loader"></div>
        <div class="inner_loader"></div>
    </div>
</div>`;
    
    function show_formAjax_error(data){
        if (data.status == 422) {
            $('.error').remove();
            $('.preloader').remove();
            $.each(data.responseJSON.errors, function (i, error) {
                var el = $(document).find('[name="' + i + '"]');
                el.after($('<span class="error">' + error[0] + '</span>'));
            });
        }
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    

    
    $('.item-qty').change(function(){
        var qty = $(this).val();
        var price = $(this).siblings('.item-price').val();
        var total = qty*price;
        $(this).parent('td').siblings().children('.product-total').html(total);
        grand_total();
    });

    function grand_total(){
        var amt = 0;
        $('.product-total').each(function(i){
            amt += parseInt($(this).html());
        })
        $('.grand-total').html(amt);
    }

    grand_total();

    



    

    
    // ========================================
    // script for User Login module
    // ========================================

    $('#user-login').validate({
        rules: {
            email: { required: true },
            password: { required: true },
        },
        messages: {
            email: { required: "Email is required" },
            password: { required: "Password is required" },
        },
        submitHandler: function (form) {
            $('form').append(preloader)
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/login',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Success",
                            text: "LoggedIn Successfully.",
                            showConfirmButton: false,
                            timer: 1500
                          });
                        setTimeout(function(){ window.location.href = uRL+'/user-profile'; }, 1500);
                    } else {
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: "Warning",
                            text: dataResult,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('.preloader').remove();
                    }
                },
                error: function(data){
                    show_formAjax_error(data)
                }
            });
        }
    });


    // ========================================
    // script for User Register module
    // ========================================

    $('#user-register').validate({
        rules: {
            name: { required: true },
            unique_name: { required: true },
            email_address: { required: true },
            phone: { required: true },
            country: { required: true },
            password: { required: true },
            confirm_password: { required: true,equalTo: "#password" },
        },
        messages: {
            name: { required: "Name is required" },
            unique_name: { required: "Unique Name is required" },
            email_address: { required: "Email Address is required" },
            phone: { required: "Phone is required" },
            country: { required: "Country is required" },
            password: { required: "Password is required" },
            confirm_password: { required: "Confirm Password is required" }
        },
        submitHandler: function (form) {
            $('form').append(preloader)
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/signup',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult.result == '1') {
                        setTimeout(function(){ window.location.href = uRL+'/signup/verification/'+dataResult.id; }, 1500);
                    } else {
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: dataResult,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('.preloader').remove();
                    }
                },
                error: function(data){
                    show_formAjax_error(data)
                }
            });
        }
    });

    $('#signup-verify').validate({
        rules: {
            otp: { required: true },
        },
        messages: {
            otp: { required: "OTP is required" },
        },
        submitHandler: function (form) {
            $('form').append(preloader);
            var formdata = new FormData(form);
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "SignedUp Successfully.",
                            showConfirmButton: false,
                            timer: 1500
                          });
                        setTimeout(function(){ window.location.href = uRL+'/user-profile/'; }, 2000);
                    } else {
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: dataResult,
                            showConfirmButton: false,
                            timer: 1500
                          });
                          $('.preloader').remove();
                    }
                },
                error: function(data){
                    show_formAjax_error(data)
                }
            });
        }
    });



    // ========================================
    // script for Update User Profile module
    // ========================================

    $('#update-profile').validate({
        rules: {
            name: { required: true },
            user_name: { required: true },
            phone: { required: true },
            country: { required: true },
        },
        messages: {
            name: { required: "Name is required" },
            user_name: { required: "User Name is required" },
            phone: { required: "Phone is required" },
            country: { required: "Country is required" },
        },
        submitHandler: function (form) {
            $('form').append(preloader)
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/user/edit-profile',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: 'Success',
                            text: 'Updated Successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function(){ window.location.href = uRL+'/user-profile'; }, 1500);
                    } else {
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: dataResult,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('.preloader').remove();
                    }
                },
                error: function(data){
                    show_formAjax_error(data)
                }
            });
        }
    });

    // ========================================
    // script for User Change Password module
    // ========================================

    $('#change-password').validate({
        rules: { 
            old_password: { required: true } ,
            password: { required: true } ,
            confirm_password: { required: true,equalTo: '#password' }
        },
        messages: { 
            old_password: { required: "Current Password is required" },
            password: { required: "Password is required" },
            confirm_password: { required: "Confirm password is required" },
        },
        submitHandler: function (form) {
            $('form').append(preloader);
            var formdata = new FormData(form);
            $.ajax({
                url: uRL+'/change-password',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Success!!!",
                            text: "Your password has been changed successfully. Login with your new password.",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function(){ window.location.href = uRL + '/login'; }, 2000);
                    } else {
                        $('.preloader').remove();
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            text: dataResult,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function(data){
                    show_formAjax_error(data)
                }
            });
        }
    });



    

    // ========================================
    // script for User Forgot Password module
    // ========================================

    $('#forgot-password').validate({
        rules: { email: { required: true } },
        messages: { email: { required: "Email Address is required" } },
        submitHandler: function (form) {
            $('form').append(preloader);
            var formdata = new FormData(form);
            $.ajax({
                url: uRL+'/forgot-password',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    $('.preloader').remove();
                    if(dataResult == '1'){
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Success",
                            text: "We have e-mailed your password reset link!",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else{
                        Swal.fire({
                            position: "top-end",
                            icon: "warning",
                            title: "Warning",
                            text: dataResult,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function(data){
                    show_formAjax_error(data)
                }
            });
        }
    });

    $('#reset-password').validate({
        rules: { 
            password: { required: true } ,
            confirm_password: { required: true,equalTo: '#password' }
        },
        messages: { 
            password: { required: "Password is required" },
            confirm_password: { required: "Confirm password is required" },
        },
        submitHandler: function (form) {
            $('form').append(preloader);
            var formdata = new FormData(form);
            $.ajax({
                url: uRL+'/update-user-password',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Success!!!",
                            text: "Your password has been changed successfully. Login with your new password.",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function(){ window.location.href = uRL + '/login'; }, 2000);
                    } else {
                        $('.preloader').remove();
                        Swal.fire({
                            position: "top-end",
                            icon: "warning",
                            text: dataResult,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function(data){
                    show_formAjax_error(data)
                }
            });
        }
    });


    $('.add-wishlist').click(function(){
        var product = $(this).attr('data-id');
        if($(this).parent('li').hasClass('active')){
            Swal.fire({
                position: "top-end",
                icon: "warning",
                title: "Warning",
                text: "Product Already Exists in your Wishlist.",
                showConfirmButton: false,
                timer: 1500
            });
        }else{
        $.ajax({
            url: uRL + '/user/add-wishlist',
            type: 'POST',
            data: {product:product},
            success: function (dataResult) {
                if (dataResult == '1') {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Success!!!",
                        text: "Added to Wishlist",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function(){ window.location.reload(); }, 2000);
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "warning",
                        text: dataResult,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
        }
    })

    $('.remove-wishlist').click(function(){
        var product = $(this).attr('data-id');
        $.ajax({
            url: uRL + '/user/remove-wishlist',
            type: 'POST',
            data: {product:product},
            success: function (dataResult) {
                if (dataResult == '1') {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Success!!!",
                        text: "Removed successfully",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function(){ window.location.reload(); }, 2000);
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "warning",
                        text: dataResult,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    })


    $('.add-cart').click(function(){
        var product = $(this).attr('data-id');
        if($(this).parent('li').hasClass('active')){
            Swal.fire({
                position: "top-end",
                icon: "warning",
                title: "Warning",
                text: "Product Already Exists in your Cart.",
                showConfirmButton: false,
                timer: 1500
            });
        }else{
        $.ajax({
            url: uRL + '/user/add-cart',
            type: 'POST',
            data: {product:product},
            success: function (dataResult) {
                if (dataResult == '1') {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Success!!!",
                        text: "Added to Cart",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function(){ window.location.reload(); }, 2000);
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "warning",
                        text: dataResult,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
        }
    })

    $('.remove-cart').click(function(){
        var product = $(this).attr('data-id');
        $.ajax({
            url: uRL + '/user/remove-cart',
            type: 'POST',
            data: {product:product},
            success: function (dataResult) {
                if (dataResult == '1') {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Success!!!",
                        text: "Removed successfully",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function(){ window.location.reload(); }, 2000);
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "warning",
                        text: dataResult,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    })


    $('.subscribe-now').click(function(){
        var email = $('.news-email').val();
        if(email != ''){
            if(IsEmail(email)){
                $.ajax({
                    url: uRL + '/submit-email',
                    type: 'POST',
                    data: {email:email},
                    success: function (dataResult) {
                        if (dataResult == '1') {
                            Swal.fire({
                                position: "top-center",
                                icon: "success",
                                title: "Success!!!",
                                text: "Submitted Successfully. Please Verify your email to receive emails.",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(function(){ window.location.reload(); }, 2000);
                        } else {
                            Swal.fire({
                                position: "top-center",
                                icon: "warning",
                                text: dataResult,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('.news-email').val('');
                        }
                    }
                });
            }else{
                Swal.fire({
                    position: "top-center",
                    icon: "warning",
                    text: 'Enter Valid Email',
                    showConfirmButton: false,
                    timer: 1500
                }); 
            }
        }else{
            Swal.fire({
                position: "top-center",
                icon: "warning",
                text: 'Enter Email',
                showConfirmButton: false,
                timer: 1500
            });  
        }
    });

    function IsEmail(email) {
        const regex =/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        }
        else {
            return true;
        }
    }


    $('#submit-review').validate({
        rules: { 
            review: { required: true } ,
        },
        messages: { 
            review: { required: "Review is required" },
        },
        submitHandler: function (form) {
            $('form').append(preloader);
            var formdata = new FormData(form);
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    $('.preloader').remove();
                    if (dataResult == '1') {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Success!!!",
                            text: "Your Review Submitted Successfully.",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#submit-review")[0].reset();
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "warning",
                            text: dataResult,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function(data){
                    show_formAjax_error(data)
                }
            });
        }
    })

    $('.search-input').keyup(function(){
        var val = $.trim($(this).val());
        if(val == ''){
            $('.search-autocomplete').empty();
        }else{
        $.ajax({
            url: uRL+'/get-search-autocomplete',
            type: 'POST',
            data: {val:val},
            success: function (dataResult) {
                $('.search-autocomplete').html(dataResult);
            },
        });
        }
    });


    $('#createWithdraw').validate({
        rules: { 
            method: { required: true } ,
            amount: { required: true } ,
        },
        messages: { 
            method: { required: "Select Method is required" },
            amount: { required: "Amount is required" },
        },
        submitHandler: function (form) {
            $('form').append(preloader);
            var formdata = new FormData(form);
            $.ajax({
                url: uRL+'/withdraw-requests/submit',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    $('.preloader').remove();
                    if (dataResult == '1') {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Success!!!",
                            text: "Your Request Submitted Successfully.",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#submit-review")[0].reset();
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "warning",
                            text: dataResult,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function(data){
                    show_formAjax_error(data)
                }
            });
        }
    })

    
});
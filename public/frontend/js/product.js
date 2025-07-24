$(function() {
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

    // ========================================
    // script for Add Product module
    // ========================================

    $('#category').change(function(){
        var cat = $(this).val();
        $.ajax({
            url: uRL + '/admin/get-category-sub-categories',
            type: 'POST',
            data: {cat:cat},
            success: function (dataResult) {
                if(dataResult.length > 0){
                    var htm = `<option value="" selected disabled>Select Sub Category</option>`;
                    $.each(dataResult,function(i){
                        htm += `<option value="`+dataResult[i].id+`">`+dataResult[i].name+`</option>`;
                    })
                }else{
                    var htm = `<option value="" selected disabled>No Sub Categories Found</option>`;
                }
                $('#sub-category').html(htm);
            }
        });
    })


    $('#add-product').validate({
        rules: {
            product_name: { required: true },
            category: { required: true },
            desc: { required: true },
            preview_link: { required: true },
        },
        messages: {
            product_name: { required: "Product Name is required" },
            category: { required: "Select Category" },
            desc: { required: "Description is required" },
            preview_link: { required: "Preview Link is required" },
        },
        submitHandler: function (form) {
            $('form').append(preloader)
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/submit-product',
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
                            title: "Success",
                            text: "Added Successfully Under Approval.",
                            showConfirmButton: false,
                            timer: 1500
                          });
                        setTimeout(function(){ window.location.href = uRL+'/my-products'; }, 1500);
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

    $('#update-product').validate({
        rules: {
            desc: { required: true },
            preview_link: { required: true },
        },
        messages: {
            desc: { required: "Description is required" },
            preview_link: { required: "Preview Link is required" },
        },
        submitHandler: function (form) {
            $('form').append(preloader)
            var formdata = new FormData(form);
            var slug = $('.slug').val();
            $.ajax({
                url: uRL + '/seller/'+slug+'/update',
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
                            title: "Success",
                            text: "Updated Successfully.",
                            showConfirmButton: false,
                            timer: 1500
                          });
                        setTimeout(function(){ window.location.href = uRL+'/my-products'; }, 1500);
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
})
$(function () {
    var uRL = $('.site-url').val();

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

   

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // $('.modal').on('hidden.bs.modal', function(e) {
    //     $(this).find('form')[0].reset();
    //   });

    // $('.change-logo').click(function () {
    //     $('.change-com-img').click();
    // });

    // delete data common function
    function destroy_data(name, url) {
        var el = name;
        var id = el.attr('data-id');
        var dltUrl = url + id;
        if (confirm('Are you Sure Want to Delete This')) {
            $.ajax({
                url: dltUrl,
                type: "DELETE",
                cache: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        el.parent().parent('tr').remove();
                    } else {
                        Toast.fire({
                            icon: 'warning',
                            title: dataResult
                        })
                    }
                }
            });
        }
    }

    function show_formAjax_error(data) {
        if (data.status == 422) {
            $('.error').remove();
            $.each(data.responseJSON.errors, function (i, error) {
                var el = $(document).find('[name="' + i + '"]');
                el.after($('<span class="error">' + error[0] + '</span>'));
            });
        }
    }

    // ========================================
    // script for Admin Logout
    // ========================================

    $('.admin-logout').click(function () {
        $.ajax({
            url: uRL + '/admin/logout',
            type: "GET",
            cache: false,
            success: function (dataResult) {
                if (dataResult == '1') {
                    setTimeout(function () {
                        window.location.href = uRL + '/admin';
                    }, 500);
                    Toast.fire({
                        icon: 'success',
                        title: 'Logged Out Succesfully.'
                    })
                }
            }
        });
    });

  
    // ========================================
    // script for Blog Category module
    // ========================================
    $('#addBlogCategory').validate({
        rules: { 
            category_name: { required: true }, 
        },
        messages: { 
            category_name: { required: "Category Name is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/blog-category',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                //    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/blog-category'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateBlogCategory').validate({
        rules: { 
            category_name: { required: true }, 
        },
        messages: { 
            category_name: { required: "Category Name is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('.id').val();
            $.ajax({
                url: uRL + '/admin/blog-category/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                //    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/blog-category'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".deleteBlogCategory", function () {
        destroy_data($(this), 'blog-category/')
    });

    // ========================================
    // script for Blog module
    // ========================================
    $('#addBlog').validate({
        rules: { 
            blog_title: { required: true }, 
            category: { required: true }, 
                        seo_description: { required: true }, 
            seo_keyword: { required: true }, 
        },
        messages: { 
            blog_title: { required: "Title is required." }, 
            category: { required: "Category is required." },
            seo_description: { required: "SEO Description is required." },
            seo_keyword: { required: "SEO Keywords is required." },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/blogs',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/blogs'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateBlog').validate({
        rules: { 
            blog_title: { required: true }, 
            category: { required: true }, 
                                   seo_description: { required: true }, 
            seo_keyword: { required: true }, 
            status: { required: true } // ✅ Added status validation
        },
        messages: { 
            blog_title: { required: "Title is required." }, 
            category: { required: "Category is required." }, 
                        seo_description: { required: "SEO Description is required." },
            seo_keyword: { required: "SEO Keywords is required." },
            status: { required: "Status is required." } // ✅ Error message for status
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('.id').val();
            $.ajax({
                url: uRL + '/admin/blogs/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                //    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/blogs'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".deleteBlog", function () {
        destroy_data($(this), 'blogs/')
    });

    // ========================================
    // script for Product Category module
    // ========================================
    $('#addProductCategory').validate({
        rules: { 
            category_name: { required: true }, 
        },
        messages: { 
            category_name: { required: "Category Name is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/product-category',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/product-category'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateProductCategory').validate({
        rules: { 
            category_name: { required: true }, 
        },
        messages: { 
            category_name: { required: "Category Name is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('.id').val();
            $.ajax({
                url: uRL + '/admin/product-category/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                //    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/product-category'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".deleteProductCategory", function () {
        destroy_data($(this), 'product-category/')
    });

    // ========================================
    // script for Product Sub Category module
    // ========================================
    $('#addProductSubCategory').validate({
        rules: { 
            name: { required: true }, 
            category: { required: true }, 
        },
        messages: { 
            name: { required: "Name is required." }, 
            category: { required: "Select Parent Category." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/product-sub-category',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/product-sub-category'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateProductSubCategory').validate({
        rules: { 
            name: { required: true }, 
            slug: { required: true }, 
            category: { required: true }, 
        },
        messages: { 
            name: { required: "Name is required." }, 
            slug: { required: "Slug is required." }, 
            category: { required: "Select Parent Category." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('.id').val();
            $.ajax({
                url: uRL + '/admin/product-sub-category/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/product-sub-category'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".deleteProductSubCategory", function () {
        destroy_data($(this), 'product-sub-category/')
    });

    // ========================================
    // script for Product Tags module
    // ========================================

    $('#addProductTag').validate({
        rules: { 
            tag_name: { required: true }, 
        },
        messages: { 
            tag_name: { required: "Tag Name is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/product-tags',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/product-tags'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click','.edit-productTag',function(){
        var id = $(this).attr('data-id');
        $.ajax({
            url: uRL + '/admin/product-tags/'+id+'/edit',
            type: 'GET',
            // data: formdata,
            // processData: false,
            // contentType: false,
            success: function (dataResult) {
                // console.log(dataResult.id);
                if(typeof dataResult == 'object'){
                    $('.id').val(dataResult.id);
                    $('input[name="tag_name"]').val(dataResult.name);
                    $('input[name="tag_slug"]').val(dataResult.slug);
                    $('input[name="seo_title"]').val(dataResult.page_title);
                    $('input[name="seo_desc"]').val(dataResult.page_desc);
                    $('#updateModal').modal('show');
                }else{
                    Toast.fire({
                        icon: 'warning',
                        title: dataResult
                    });
                }
                // if (dataResult == '1') {
                //     Toast.fire({
                //         icon: 'success',
                //         title: 'Added Succesfully.'
                //     });
                //     setTimeout(function () { window.location.href = uRL + '/admin/product-tags'; }, 1000);
                // }
            },
            // error: function (error) {
            //     show_formAjax_error(error);
            // }
        });
    });

    $('#updateProductTag').validate({
        rules: { 
            name: { required: true }, 
            slug: { required: true }, 
            category: { required: true }, 
        },
        messages: { 
            name: { required: "Name is required." }, 
            slug: { required: "Slug is required." }, 
            category: { required: "Select Parent Category." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('.id').val();
            $.ajax({
                url: uRL + '/admin/product-tags/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/product-tags'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".deleteProductTag", function () {
        destroy_data($(this), 'product-tags/')
    });



    // ========================================
    // script for Product module
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

    $('#addProduct').validate({
        rules: { 
            product_title: { required: true }, 
            category: { required: true }, 
            price: { required: true }, 
        },
        messages: { 
            product_title: { required: "Title is required." }, 
            category: { required: "Category is required." }, 
            price: { required: "Price is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            formdata.append('images', $('input[name^=images]').prop('files'));
            $.ajax({
                url: uRL + '/admin/products',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/products'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateProduct').validate({
        rules: { 
            product_title: { required: true }, 
            category: { required: true }, 
            price: { required: true }, 
            preview_link: { required: true }, 
        },
        messages: { 
            product_title: { required: "Title is required." }, 
            category: { required: "Category is required." }, 
            price: { required: "Price is required." }, 
            preview_link: { required: "Preview Link is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('.id').val();
            $.ajax({
                url: uRL + '/admin/products/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                   console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/products'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".deleteProduct", function () {
        destroy_data($(this), 'products/')
    });

    $('#updateProductReview').validate({
        rules: { 
            rating: { required: true }, 
            feedback: { required: true }, 
            status: { required: true }, 
        },
        messages: { 
            rating: { required: "Rating is required." }, 
            feedback: { required: "Feedback is required." }, 
            status: { required: "Status is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('.id').val();
            $.ajax({
                url: uRL + '/admin/product-reviews/'+id+'/edit',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                   console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/product-reviews'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    // ========================================
    // script for Pages module
    // ========================================
    $('#addPage').validate({
        rules: { 
            page_title: { required: true }, 
        },
        messages: { 
            page_title: { required: "Title is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/pages',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/pages'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updatePage').validate({
        rules: { 
            page_title: { required: true }, 
        },
        messages: { 
            page_title: { required: "Title is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('.id').val();
            $.ajax({
                url: uRL + '/admin/pages/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/pages'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".deletePage", function () {
        destroy_data($(this), 'pages/')
    });

    $(document).on('click','.show-in-header',function(){
        var id = $(this).attr('id');
        if($('#'+id).is(':checked')){
           var status = 1;
        }else{
            var status = 0;
        }
        id = id.replace('checkhead','');
        $.ajax({
            url: uRL + '/admin/page_showIn_header', 
            type: 'POST',
            data: {id:id,status:status},
            success: function (dataResult) {
            }

        });
    })

    $(document).on('click','.show-in-footer',function(){
        var id = $(this).attr('id');
        if($('#'+id).is(':checked')){
           var status = 1;
        }else{
            var status = 0;
        }
        id = id.replace('checkfoot','');
        $.ajax({
            url: uRL + '/admin/page_showIn_footer',
            type: 'POST',
            data: {id:id,status:status},
            success: function (dataResult) {
            }
        });
    })

    // ========================================
    // script for Social Links module
    // ========================================
    $('#addSocialLink').validate({
        rules: { 
            name: { required: true }, 
            icon: { required: true }, 
            link: { required: true }, 
            status: { required: true }, 
        },
        messages: { 
            name: { required: "Name is required." }, 
            icon: { required: "Icon is required." }, 
            link: { required: "Link is required." }, 
            status: { required: "Status is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/social-links',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/social-links'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateSocialLink').validate({
        rules: { 
            name: { required: true }, 
            icon: { required: true }, 
            link: { required: true }, 
            status: { required: true }, 
        },
        messages: { 
            name: { required: "Name is required." }, 
            icon: { required: "Icon is required." }, 
            link: { required: "Link is required." }, 
            status: { required: "Status is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('.id').val();
            $.ajax({
                url: uRL + '/admin/social-links/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/social-links'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".deleteSocialLink", function () {
        destroy_data($(this), 'social-links/')
    });


    // ========================================
    // script for Testimonial module
    // ========================================
    $('#addTestimonial').validate({
        rules: { 
            client_name: { required: true }, 
            client_designation: { required: true }, 
            feedback: { required: true }, 
            status: { required: true }, 
        },
        messages: { 
            client_name: { required: "Client Name is required." }, 
            client_designation: { required: "Client Designation is required." }, 
            feedback: { required: "Feedback is required." }, 
            status: { required: "Status is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/testimonials',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/testimonials'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateTestimonial').validate({
        rules: { 
            client_name: { required: true }, 
            client_designation: { required: true }, 
            feedback: { required: true }, 
            status: { required: true }, 
        },
        messages: { 
            client_name: { required: "Client Name is required." }, 
            client_designation: { required: "Client Designation is required." }, 
            feedback: { required: "Feedback is required." }, 
            status: { required: "Status is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('.id').val();
            $.ajax({
                url: uRL + '/admin/testimonials/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/testimonials'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".deleteTestimonial", function () {
        destroy_data($(this), 'testimonials/')
    });

    // ========================================
    // script for Delete Newsletter Email module
    // ========================================

    $(document).on("click", ".deleteNewsletterEmail", function () {
        destroy_data($(this), 'newsletter-subscribers/')
    });

    // ========================================
    // script for Delete Product Review module
    // ========================================

    $(document).on("click", ".deleteProductReview", function () {
        destroy_data($(this), 'product-reviews/')
    });


    // ========================================
    // script for Block User
    // ========================================

    //User Change Status
    $(document).on('click','.blockUser',function(){
        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        if(status == '1'){
            status = '0';
        }else{
            status = '1';
        }
        $.ajax({
            url: uRL+'/admin/users/block',
            type: 'POST',
            data: {uId:id,status:status},
            success: function(dataResult){
                location.reload();
            }
        });
    });


    //Approve Seller
    $(document).on('click','.approveSeller',function(){
        var id = $(this).attr('data-id');
        $.ajax({
            url: uRL+'/admin/seller/approve',
            type: 'POST',
            data: {uId:id},
            success: function(dataResult){
                location.reload();
            }
        });
    });



    // ========================================
    // script for General Setting module
    // ========================================

    $('#updateGeneralSettings').validate({
        rules: {
            site_name: { required: true },
            site_email: { required: true },
            site_contact: { required: true },
            desc: { required: true },
            cur_format: { required: true },
            copyright_text: { required: true },
            seo_title: { required: true },
        },
        messages: {
            site_name: { required: "Website Name is Required" },
            site_email: { required: "Website Email is Required" },
            site_contact: { required: "Website Contact is Required" },
            desc: { required: "Description is Required" },
            cur_format: { required: "Currency Format is Required" },
            copyright_text: { required: "Copyright Text is Required" },
            seo_title: { required: "Website Seo Title is Required" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/general-settings',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    // console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.',
                        });
                        setTimeout(function () { 
                            window.location.href = uRL + '/admin/general-settings'; }, 1000);
                    }else if (dataResult == '0') {
                        Toast.fire({
                            icon: 'info',
                            title: 'Already Updated.',
                        });
                    }
                },
                error: function (error) {
                    // $('.loader-container').remove();
                    show_formAjax_error(error);
                }
            });
        }
    });
    // ========================================
    // script for Payment Gateway module
    // ========================================

    $('#updatePaymentGateway').validate({
        rules: {
            name: { required: true },
        },
        messages: {
            name: { required: "Name is Required" },
        },
        submitHandler: function (form) {
            var id = $('.id').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/payment-gateways/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.',
                        });
                        setTimeout(function () { 
                            window.location.href = uRL + '/admin/payment-gateways'; }, 1000);
                    }else if (dataResult == '0') {
                        Toast.fire({
                            icon: 'info',
                            title: 'Already Updated.',
                        });
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    // ========================================
    // script for Payment Setting module
    // ========================================

    $('#updatePaymentSettings').validate({
        rules: {
            commission: { required: true },
            tax_percent: { required: true },
        },
        messages: {
            commission: { required: "Commission is Required" },
            tax_percent: { required: "Tax Percentage is Required" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/payment-settings',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.',
                        });
                        setTimeout(function () { 
                            window.location.href = uRL + '/admin/payment-settings'; }, 1000);
                    }else if (dataResult == '0') {
                        Toast.fire({
                            icon: 'info',
                            title: 'Already Updated.',
                        });
                    }
                },
                error: function (error) {
                    // $('.loader-container').remove();
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('.updateHomeSection').click(function(){
        var id = $(this).parent('form').attr('id');
        var formdata = $('#'+id).serialize();
        $.ajax({
            url: uRL + '/admin/homepage-settings',
            type: 'POST',
            data: formdata,
            success: function (dataResult) {
                if (dataResult == '1') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Updated Succesfully.',
                    });
                }else if (dataResult == '0') {
                    Toast.fire({
                        icon: 'info',
                        title: 'Already Updated.',
                    });
                }
            },
            error: function (error) {
                show_formAjax_error(error);
            }
        });
    })



    $('#updateAccountSettings').validate({
        rules: {
            admin_name: { required: true },
            username: { required: true },
        },
        messages: {
            admin_name: { required: "Admin Name is Required" },
            username: { required: "Username is Required" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            if(confirm('Are you Sure Want to Change This?')){
            $.ajax({
                url: uRL + '/admin/edit-profile',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.',
                        });
                        setTimeout(function () {  window.location.reload(); }, 1000);
                    }else if (dataResult == '0') {
                        Toast.fire({
                            icon: 'info',
                            title: 'Already Updated.',
                        });
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
            }
        }
    });



    $('#updatePasswordSettings').validate({
        rules: {
            current_password: { required: true },
            new_password: { required: true },
            confirm_password: { required: true },
        },
        messages: {
            current_password: { required: "Current Password is Required" },
            new_password: { required: "New Password is Required" },
            confirm_password: { required: "Confirm New Password is Required" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            if(confirm('Are you Sure Want to Change This?')){
            $.ajax({
                url: uRL + '/admin/update-password',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.',
                        });
                        setTimeout(function () {  window.location.reload(); }, 1000);
                    }else {
                        Toast.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: dataResult
                        });
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
            }
        }
    });


    $('#updateBanner').validate({
        rules: {
            title: { required: true },
        },
        messages: {
            title: { required: "Title is Required" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/banner',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    // console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.',
                        });
                        setTimeout(function () { 
                            window.location.reload(); }, 1000);
                    }else if (dataResult == '0') {
                        Toast.fire({
                            icon: 'info',
                            title: 'Already Updated.',
                        });
                    }
                },
                error: function (error) {
                    // $('.loader-container').remove();
                    show_formAjax_error(error);
                }
            });
        }
    });

    // ========================================
    // script for Wthdraw Methods module
    // ========================================
    $('#addWithdrawMethod').validate({
        rules: { 
            name: { required: true }, 
            charge: { required: true }, 
            minimum_amount: { required: true }, 
            maximum_amount: { required: true }, 
        },
        messages: { 
            name: { required: "Method Name is required." }, 
            charge: { required: "Method Charge Percentage is required." }, 
            minimum_amount: { required: "Minimum Withdrawal Amount is required." }, 
            maximum_amount: { required: "Maximum Withdrawal Amount is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/withdraw-methods',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                //    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/withdraw-methods'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateWithdrawMethod').validate({
        rules: { 
            name: { required: true }, 
            charge: { required: true }, 
            minimum_amount: { required: true }, 
            maximum_amount: { required: true }, 
        },
        messages: { 
            name: { required: "Method Name is required." }, 
            charge: { required: "Method Charge Percentage is required." }, 
            minimum_amount: { required: "Minimum Withdrawal Amount is required." }, 
            maximum_amount: { required: "Maximum Withdrawal Amount is required." }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('.id').val();
            $.ajax({
                url: uRL + '/admin/withdraw-methods/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                //    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/withdraw-methods'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".deleteWithdrawMethod", function () {
        destroy_data($(this), 'withdraw-methods/')
    });

    $(document).on("click", ".deleteWithdrawRequest", function () {
        destroy_data($(this), 'withdraw-requests/')
    });

    $(document).on("click", ".changeRequestStatus", function () {
        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        $.ajax({
            url: uRL + '/admin/withdraw-requests/'+id+'/status',
            type: 'POST',
            data: {id:id,status:status},
            success: function (dataResult) {
                if (dataResult == '1') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Updated Succesfully.'
                    });
                    setTimeout(function () { window.location.href = uRL + '/admin/withdraw-requests'; }, 1000);
                }
            },
            error: function (error) {
                show_formAjax_error(error);
            }
        });
    });

    
})
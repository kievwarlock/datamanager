$(function () {
    "use strict";


    $('body').on( 'change', '.account-check input', function () {

        if( $(this).val() == 'set-all' ){

            if( $(this).prop('checked') ) {
                $(this).parents('table').find('.account-check input').prop('checked', true);
                $(this).parents('table').find('tr').addClass('active');
            }else{
                $(this).parents('table').find('.account-check input').prop('checked', false);
                $(this).parents('table').find('tr').removeClass('active');
            }
        }

        if( $(this).prop('checked') ) {
            $(this).parents('tr').addClass('active');
        }else{
            $(this).parents('tr').removeClass('active');
        }

    });




    $('body').on('click', '.attach-account-to-user', function () {


        var formData = new FormData();
        var selectedAccounts = $('.attach-account-form input[name="accounts"]:checked');

        if( selectedAccounts.length > 0 ){

            $('.ajax-preloader').addClass('active');

            selectedAccounts.each(function () {
                formData.append('accounts[]', $(this).val() );
            })

            $.ajax({
                url: '/group/link/',
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(res){


                    $('.ajax-preloader').removeClass('active');
                    if( res ){
                        $('.bs-example-modal-lg').modal('hide');
                        setTimeout(function () {
                            $('.content-window-main').html(res);
                        } , 400);
                    }

                },
                error: function(){
                    alert('Error!');

                }
            });
        }

    })

    $('body').on('click', '.unlink-account-to-user', function () {


        var formData = new FormData();
        var selectedAccounts = $('.unlink-account-to-user-form input[name="accounts"]:checked');

        if( selectedAccounts.length > 0 ){

            $('.ajax-preloader').addClass('active');
            selectedAccounts.each(function () {
                formData.append('accounts[]', $(this).val() );
            })

            $.ajax({
                url: '/group/unlink/',
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(res){

                    $('.ajax-preloader').removeClass('active');
                    if( res ){
                        $('.content-window-main').html(res);
                    }

                },
                error: function(){
                    alert('Error!');

                }
            });
        }

    })



})
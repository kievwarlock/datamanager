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



    // todo: change class name

    $('body').on('click', '.open-modal-new-group', function () {

        var selectedAccounts = $('.unlink-account-to-user-form input[name="accounts"]:checked');

        if( selectedAccounts.length > 0 ){
            $('.add-group').modal('show');
        }else{
            alert('NO accounts selected!');
        }

    });


    $('body').on('click', '.create-new-group', function () {

        $('.add-group-status.bg-success').hide();
        $('.add-group-status.bg-danger').hide();

        var formData = new FormData();
        var groupName = $('.add-group input[name="group-name"]').val();

        var selectedAccounts = $('.unlink-account-to-user-form input[name="accounts"]:checked');

        if( selectedAccounts.length > 0 ){
            selectedAccounts.each(function () {
                formData.append('accounts[]', $(this).val() );
            })
        }else{
            alert('NO accounts selected!');
            return false;
        }

        if( groupName.length > 0 ){

            $('.ajax-preloader').addClass('active');
            formData.append('group-name', groupName );

            $.ajax({
                url: '/group/create/',
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(res){

                    $('.ajax-preloader').removeClass('active');
                    console.log(res);
                    if( res ){
                        $('.add-group-status.bg-success').show();
                    }else{
                        $('.add-group-status.bg-danger').show();
                    }

                },
                error: function(){
                    alert('Error!');
                }
            });
        }else{
            alert('Enter group name !');
        }

    })



    function loadProfile( userId, userToken ){


        $('.ajax-preloader').addClass('active');

        $.ajax({
            url: '/user/view/',
            type: 'POST',
            data: {
                user_id: userId,
                user_token: userToken,
            },
            success: function(res){

                $('.ajax-preloader').removeClass('active');
                if( res ){
                    $('#view-user-profile .modal-content').html(res);
                    $('#view-user-profile').modal('show');
                }

            },
            error: function(){
                $('.ajax-preloader').removeClass('active');
                alert('Error!');

            }
        });
    }


    $('body').on('click', '.view-user-profile', function(e){

        e.preventDefault();

        var userId = $(this).data('id');
        var userToken = $(this).data('token');


        loadProfile(userId, userToken);

    })








})
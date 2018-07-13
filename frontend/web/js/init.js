$(function () {
    "use strict";

    $('body').on('click', '.add_user_to_group', function () {
        var groupId = $(this).data('group-id');
        var selectedUser = $(this).parents('.tab-pane').find('.select-user option:selected').val();

        console.log( 'groupId:', groupId );
        console.log( 'selectedUser:', selectedUser );
        $.ajax({
            url: '/site/add_user_to_group/',
            type: 'POST',
            data: {
                account_id:selectedUser ,
                group_id:groupId
            },
            success: function(res){
                //console.log(res);
                if( res ){
                    console.log(res);
                }

            },
            error: function(){
                alert('Error!');

            }
        });


    })



})
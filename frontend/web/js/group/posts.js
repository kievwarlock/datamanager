$(function () {
    "use strict";


    $('body').on('dblclick', '.tab-item-name', function (e) {
        e.preventDefault();
        var nameItem = $(this).text();
        $(this).parent().html('<input type="text" class="tab-item-name-edit" value="'+ nameItem +'" >');
    });

    $('body').on('click', function(event){
        if( event.target.className != 'tab-item-name-edit') {
            if( $('.tab-item-name-edit').length > 0 ){
                $('.tab-item-name-edit').each(function(){
                    var nameItem = $(this).val();
                    $(this).parent().html('<div class="tab-item-name" >'+ nameItem +'</div>');
                })
            }
        }
    })

    $('body').on('click', '.add-post-tab', function (e) {
        e.preventDefault();
        addPostTab();
    });




    function addPostTab() {

        var tabSelector = $('.post-tab');
        var countTabs = tabSelector.find('.nav.nav-tabs li').length;

        $.ajax({
            url: '/group/add-post-tab/',
            type: 'POST',
            data:{
                'count': countTabs,
            },
            success: function(res){



                if( res ){




                    if( countTabs > 1){
                        var labelContentTab = '<li role="presentation" >' +
                            '<a href="#post_'+countTabs+'" aria-controls="post_'+countTabs+'" role="tab" data-toggle="tab"><div class="tab-item-name">Post name '+countTabs+'</div></a>' +
                            '</li>';
                    }else{
                        var labelContentTab = '<li role="presentation" class="active" >' +
                            '<a href="#post_'+countTabs+'" aria-controls="post_'+countTabs+'" role="tab" data-toggle="tab"><div class="tab-item-name">Post name '+countTabs+'</div></a>' +
                            '</li>';
                    }


                    tabSelector.find('.add-post-tab').parent().before(labelContentTab);

                    if( countTabs > 1){
                        var tabContent = '<div role="tabpanel" class="tab-pane" id="post_'+countTabs+'">'+  res +'</div>';
                    }else{
                        var tabContent = '<div role="tabpanel" class="tab-pane active" id="post_'+countTabs+'">'+  res +'</div>';
                    }


                    tabSelector.find('.tab-content').append(tabContent);

                }

            },
            error: function(){
                alert('Error!');
            }
        });
    }



    // init default tab;

    addPostTab();

})
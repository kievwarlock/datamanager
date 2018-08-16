<?php

/* @var $this yii\web\View */

$this->title = 'Group page';
?>



<div class="group-page">
    <div class="group-account-block">
        <div class="group-account-tab custom-tab-style">



            <!-- Nav tabs -->
            <?php
            $active_all_accounts = '';
            $active_all_groups = '';
            if( $tab ){
                if( $tab == 'all_accounts'){
                    $active_all_accounts = 'active';
                }
                if( $tab == 'all_groups'){
                    $active_all_groups = 'active';
                }
            }else{
                $active_all_accounts = 'active';
            }
            ?>
            <ul id="groups-tab" class="nav nav-tabs" role="tablist">
                <li role="presentation" class="<?=$active_all_accounts?>">
                    <a href="#all_accounts" aria-controls="all_accounts" role="tab" data-toggle="tab">All accounts</a>
                </li>
                <li role="presentation" class="<?=$active_all_groups?>">
                    <a href="#all_groups" aria-controls="all_groups" role="tab" data-toggle="tab">All groups</a>
                </li>
            </ul>


            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane <?=$active_all_accounts?>" id="all_accounts">
                    <?= $this->render('tab/accounts.php',[
                        'accounts' => $accounts
                    ]) ?>
                </div>
                <div role="tabpanel" class="tab-pane <?=$active_all_groups?>" id="all_groups">
                    <?= $this->render('tab/groups.php',[
                        'groups' => $groups
                    ]) ?>
                </div>
            </div>


        </div>
    </div>





    <div class="post-block">
        <div class="post-tab custom-tab-style">




            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#post_1" aria-controls="post_1" role="tab" data-toggle="tab"><div class="tab-item-name">Post name 1</div></a>
                </li>
                <li >
                    <a href="#" class="add-post-tab" ><span class="add-tab-item"></span></a>
                </li>
            </ul>


            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="post_1">

                    <div class="group-tab-content">
                        <div class="group-tab-file-block">
                            <div class="group-tab-file-preview-image">
                                <div class="group-tab-file-preview-image-placeholder">

                                </div>
                            </div>
                            <div class="group-tab-file-input-block">
                                <input class="group-tab-file-input" type="file"/>
                                <div class="group-account-tab-nav-btn window-btn group-tab-file-input-download" >
                                    Download
                                </div>
                            </div>
                        </div>
                        <div class="group-tab-main">
                            <div class="group-tab-main-top">
                                <div class="group-tab-select-item">
                                    <select name="" id="">
                                        <option value="">Select 1</option>
                                        <option value="">Select 1</option>
                                        <option value="">Select 1</option>
                                    </select>
                                </div>
                                <div class="group-tab-select-item">
                                    <select name="" id="">
                                        <option value="">Select 1</option>
                                        <option value="">Select 1</option>
                                        <option value="">Select 1</option>
                                    </select>
                                </div>
                                <div class="group-tab-select-item">
                                    <select name="" id="">
                                        <option value="">Select 1</option>
                                        <option value="">Select 1</option>
                                        <option value="">Select 1</option>
                                    </select>
                                </div>
                            </div>



                            <div class="group-tab-main-text-block">
                                <div class="group-tab-textarea">
                                    <textarea name="" id="" cols="30" rows="4" placeholder="Description (max. 420 characters)"></textarea>
                                    <div class="group-tab-textarea-lang">RU</div>
                                </div>
                                <div class="group-tab-textarea">
                                    <textarea name="" id="" cols="30" rows="4" placeholder="Description (max. 420 characters)" ></textarea>
                                    <div class="group-tab-textarea-lang">US</div>
                                </div>
                                <div class="group-tab-textarea">
                                    <textarea name="" id="" cols="30" rows="4" placeholder="Description (max. 420 characters)"></textarea>
                                    <div class="group-tab-textarea-lang">DE</div>
                                </div>
                                <div class="group-tab-textarea">
                                    <textarea name="" id="" cols="30" rows="4" placeholder="Description (max. 420 characters)" ></textarea>
                                    <div class="group-tab-textarea-lang">FR</div>
                                </div>
                                <div class="group-tab-textarea">
                                    <textarea name="" id="" cols="30" rows="4" placeholder="Description (max. 420 characters)"></textarea>
                                    <div class="group-tab-textarea-lang">IT</div>
                                </div>
                                <div class="group-tab-textarea">
                                    <textarea name="" id="" cols="30" rows="4" placeholder="Description (max. 420 characters)"></textarea>
                                    <div class="group-tab-textarea-lang">ES</div>
                                </div>
                            </div>
                            <div class="group-tab-footer">
                                <div class="text-right">
                                    <div class="group-account-tab-nav-btn window-btn" >
                                        Publish
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>


</div>


<!-- Users accounts list modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= $this->render('modals/accounts-list.php',[
                'add_list_accounts' => $add_list_accounts,
                'accounts' => $accounts
            ]) ?>
        </div>
    </div>
</div>



<!--view-user-profile  Modal -->
<div class="modal fade" id="view-user-profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>



<!--view-group  Modal -->
<div class="modal fade" id="view-group-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>



<!-- Add group  -->
<?= $this->render('modals/add-group.php') ?>

<!-- Add NEW group  -->
<?= $this->render('modals/add-new-group.php') ?>




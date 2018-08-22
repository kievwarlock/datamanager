<?php
/*
 *
 * Owner accounts list $owner_accounts;
 * Group accounts list $group_accounts;
 *  $group_id
*/
?>


<div class="modal-content-inner">


    <div class="modal-head">
        <div class="row">
            <div class="col-xs-6">
                <h4 class="table-title" >All accounts</h4>
            </div>
            <div class="col-xs-6">
                <h4 class="table-title" >Group accounts</h4>
            </div>
        </div>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-xs-12 col-sm-6">


                <?php if( is_array($owner_accounts) ){ ?>
                    <div class="accounts-list-block">
                        <ul id="owner_accounts" >
                            <?php foreach ($owner_accounts as $account) { ?>
                                <li data-id="<?= $account['id']?>">
                                    <!-- <div>
                                    <?/*= $account['fullName'] */?> ( <?/*= $account['phoneNumber'] */?> ) - <?/*= $account['city'] */?> ( <?/*= $account['locale'] */?> )
                                </div>-->
                                    <?= $account['phoneNumber']?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>

            </div>

            <div class="col-xs-12 col-sm-6">


                <?php if( is_array($group_accounts) ){ ?>
                    <div class="accounts-list-block">
                        <ul id="group_accounts" >
                            <?php foreach ($group_accounts as $account) { ?>
                                <li data-id="<?= $account['id']?>" >
                                    <!--<div>
                                    <?/*= $account['fullName'] */?> ( <?/*= $account['phoneNumber'] */?> ) - <?/*= $account['city'] */?> ( <?/*= $account['locale'] */?> )
                                </div>-->
                                    <?= $account['phoneNumber']?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>

                <?php } ?>

            </div>



        </div>

    </div>
    <div class="modal-footer">
        <div class="text-right">
            <?php if( $group_id ){ ?>
                <div class="group-account-tab-nav-btn window-btn save-edit-group" data-id="<?=$group_id?>">Save changes</div>
            <?php }else{ } ?>
        </div>
    </div>






</div>
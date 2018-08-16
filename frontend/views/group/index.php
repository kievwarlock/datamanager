<?php

/* @var $this yii\web\View */

$this->title = 'Group page';
?>



<div class="group-page">
    <div class="group-account-block">
        <div class="group-account-tab custom-tab-style">



            <!-- Nav tabs -->

            <ul id="groups-tab" class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#all_accounts" aria-controls="all_accounts" role="tab" data-toggle="tab">All accounts</a>
                </li>
                <li role="presentation">
                    <a href="#all_groups" aria-controls="all_groups" role="tab" data-toggle="tab">All groups</a>
                </li>
            </ul>


            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="all_accounts">
                    <?= $this->render('tab/accounts.php',[
                        'accounts' => $accounts
                    ]) ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="all_groups">
                    <?= $this->render('tab/groups.php',[
                        'groups' => $groups
                    ]) ?>
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




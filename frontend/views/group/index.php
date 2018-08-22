<?php

/* @var $this yii\web\View */

$this->title = 'Group page';
?>



<div class="group-page">


    <div class="group-account-block">
        <?= $this->render('block-group.php',[
                'tab' => $tab,
                'accounts' => $accounts,
                'groups' => $groups,
                'add_list_accounts' => $add_list_accounts,
        ]) ?>
    </div>

    <div class="post-block">
        <?= $this->render('block-posts.php',[]) ?>
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




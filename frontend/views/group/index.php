<?php

/* @var $this yii\web\View */

$this->title = 'Group';
?>



<div class="group-page">
    <div class="group-account-block">
        <div class="group-account-tab custom-tab-style">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#all_accounts" aria-controls="all_accounts" role="tab" data-toggle="tab">All accounts</a>
                </li>
                <li role="presentation">
                    <a href="#all_groups" aria-controls="all_groups" role="tab" data-toggle="tab">All groups</a>
                </li>

            </ul>
            <div class="group-account-tab-nav">
                <div class="group-account-tab-nav-btn window-btn"  data-toggle="modal" data-target=".bs-example-modal-lg" >Add account</div>
                <div class="group-account-tab-nav-btn window-btn">Group</div>
                <div class="group-account-tab-nav-btn window-btn window-btn-danger unlink-account-to-user">Unlink</div>
            </div>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="all_accounts">

                    <?php if( is_array($accounts) ){
                        krsort($accounts);

                        ?>
                        <!--<pre>groups
                            <?php /*print_r( $accounts ) */?>
                        </pre>-->


                        <form name="unlink-account-to-user-form" class="unlink-account-to-user-form">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th width="20px">
                                        <div class="account-check">
                                            <label>
                                            <span>
                                            №
                                            </span>
                                                <input type="checkbox" value="set-all" name="">
                                            </label>
                                        </div></th>
                                    <th>User name</th>
                                    <th>User phone</th>
                                    <th>locale</th>
                                    <th>City</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $cnt = 1; foreach ( $accounts as $account) { ?>
                                    <tr>
                                        <th scope="row">
                                            <div class="account-check">
                                                <label>
                                            <span>
                                            <?= $cnt++ ?>
                                            </span>
                                                    <input type="checkbox" value="<?= $account['id'] ?>" name="accounts">
                                                </label>
                                            </div>
                                        </th>
                                        <td><?=$account['fullName']?></td>
                                        <td><?=$account['phoneNumber']?></td>
                                        <td><?=$account['locale']?></td>
                                        <td><?=$account['city']?></td>
                                        <td><a href="#">View Details</a></td>

                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </form>

                    <?php }else{
                        ?>
                        <div class="alert alert-danger error-form" role="alert" >
                            <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
                            <span class="sr-only">Error! No accounts!</span>
                            Error! Please try again later!
                            <?php if( $error ){ ?>
                                <p>
                                    <?=$error?>
                                </p>
                            <?php } ?>
                        </div>
                        <?php
                    }
                    ?>

                </div>
                <div role="tabpanel" class="tab-pane" id="all_groups">

                    <?php if( $groups ){?>
                        <pre>
                            <?php //print_r($groups) ?>
                        </pre>

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th width="20px">№</th>
                                <th>Group name</th>
                                <th>Owner</th>
                                <th>groupAccounts</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $cnt = 0; foreach ( $groups as $group ) { ?>
                                <tr>
                                    <th scope="row">
                                        <?=$cnt++;?>
                                    </th>
                                    <td><?=$group['name']?></td>
                                    <td><?=$group['owner']['username'] . '(' . $group['owner']['id'] . ')'; ?></td>
                                    <td>@<?=$group['groupAccounts']?></td>


                                </tr>
                            <?php } ?>


                            </tbody>
                        </table>


                    <?php } ?>



                </div>

            </div>
        </div>
    </div>
</div>


<!-- Large modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-content-inner">
                <?php if( is_array($add_list_accounts) ){ ?>
                    <h2>Users accounts list:</h2>
                    <form class="attach-account-form" name="attach-account-form">
                        <div class="modal-inner-table">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th width="20px">
                                    <div class="account-check">
                                        <label>
                                        <span>
                                        №
                                        </span>
                                            <input type="checkbox" value="set-all" name="">
                                        </label>
                                    </div></th>
                                <th>User name</th>
                                <th>User phone</th>
                                <th>locale</th>
                                <th>City</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $cnt = 1; foreach ( $add_list_accounts as $add_account ) { ?>
                                <tr>
                                    <th scope="row">
                                        <div class="account-check">
                                            <label>
                                        <span>
                                        <?= $cnt++ ?>
                                        </span>
                                                <input type="checkbox" value="<?= $add_account['id'] ?>" name="accounts">
                                            </label>
                                        </div>
                                    </th>
                                    <td><?=$add_account['fullName']?></td>
                                    <td><?=$add_account['phoneNumber']?></td>
                                    <td><?=$add_account['locale']?></td>
                                    <td><?=$add_account['city']?></td>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    </form>
                    <div class="text-center">
                        <div class="group-account-tab-nav-btn window-btn attach-account-to-user">Add accounts</div>
                    </div>

                <?php } ?>
            </div>

        </div>
    </div>
</div>
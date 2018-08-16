<div class="modal-content-inner">
    <?php if( is_array($add_list_accounts) ){ ?>

        <div class="row">

            <div class="col-xs-12 col-sm-6">
                <h4>All users:</h4>
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
                                    <th>Localization</th>
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
                                    <td><?=$add_account['city']?> ( <?=$add_account['locale']?> )</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <div class="col-xs-12 col-sm-6">
                <h4>Selected users:</h4>

                <?php if( is_array($accounts) ){
                    krsort($accounts);?>

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th width="20px">№</th>
                                <th>User name</th>
                                <th>Localization</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 1;
                            foreach ( $accounts as $token => $account) { ?>
                                <tr>
                                    <th scope="row">
                                        <?= $cnt++ ?>
                                    </th>
                                    <td><?=$account['fullName']?></td>
                                    <td><?=$account['city']?> ( <?=$account['locale']?> )</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>


                <?php } ?>

            </div>



        </div>

        <div class="text-right">
            <div class="group-account-tab-nav-btn window-btn attach-account-to-user">add selected</div>
        </div>

    <?php } ?>
</div>
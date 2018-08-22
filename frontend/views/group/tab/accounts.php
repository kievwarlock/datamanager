
<div class="group-account-tab-nav">
    <div class="group-account-tab-nav-btn window-btn"  data-toggle="modal" data-target=".bs-example-modal-lg" >
        Add account
    </div>
    <div class="group-account-tab-nav-btn window-btn open-modal-new-group" >
        Group
    </div>
    <div class="group-account-tab-nav-btn window-btn window-btn-danger unlink-account-to-user">
        Unlink
    </div>
</div>
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
            <?php $cnt = 1; foreach ( $accounts as $token => $account) { ?>
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
                    <td><a href="#" class="view-user-profile" data-id="<?=$account['id']?>" data-token="<?=$token?>" >View Details</a></td>

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
<div class="group-account-tab-nav">
    <div class="group-account-tab-nav-btn window-btn" data-toggle="modal" data-target=".add-new-group" >
        Add new group
    </div>
    <div class="group-account-tab-nav-btn window-btn window-btn-danger delete-group">
        Delete
    </div>
</div>
<?php if( $groups ){?>
    <!--<pre>
        <?php /*//print_r($groups) */?>
    </pre>-->

    <form name="group-form" class="group-form">
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
                    </div>
                </th>
                <th>Group name</th>
                <th>Members</th>
                <th>Owner</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $cnt = 1;
            foreach ( $groups as $group ) { ?>
                <tr>
                    <th scope="row">
                        <div class="account-check">
                            <label>
                                <span>
                                <?= $cnt++ ?>
                                </span>
                                <input type="checkbox" value="<?= $group['id'] ?>" name="groups">
                            </label>
                        </div>
                    </th>
                    <td><?=$group['name']?></td>
                    <td>
                        <strong>
                            <?=count($group['groupAccounts'])?>
                        </strong>
                         person
                    </td>
                    <td><?=$group['owner']['username'] . '(' . $group['owner']['id'] . ')'; ?></td>
                    <td>
                        <a href="#" class="view-group" data-id="<?= $group['id'] ?>" >
                            View Details
                        </a>
                    </td>

                </tr>
            <?php } ?>

            </tbody>
        </table>
    </form>




<?php } ?>
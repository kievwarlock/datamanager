

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
                <?php if( is_array($accounts) ){
                    echo $this->render('tab/accounts.php',[
                        'accounts' => $accounts
                    ]);
                }?>
            </div>
            <div role="tabpanel" class="tab-pane <?=$active_all_groups?>" id="all_groups">
                <?php if( is_array($groups) ){
                    echo $this->render('tab/groups.php',[
                        'groups' => $groups
                    ]);
                }?>
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




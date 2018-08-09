<header class="header">
    <div class="full-container">
        <div class="header-inner">
            <div class="mobile-nav-init" id="menu-init">
                <div class="mobile-nav-init-inner">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="header-logo">
                <img src="/frontend/web/img/LOGO.png" alt="Logo">
            </div>
            <div class="header-info">

                <div class="header-info-message">
                    <!--msg will be here-->
                    <!-- <img src="/web/img/icons/ic_message.svg" alt="message" title="messages">-->



                </div>
                <div class="header-info-user">
                    <div class="header-info-user-image">
                        <img src="/frontend/web/img/user-avatar.jpg" alt="">
                    </div>
                    <div class="header-info-user-name">
                        Admin
                    </div>
                    <?php
                    if(Yii::$app->user->isGuest){

                    }else{
                        $user = Yii::$app->user->identity;
                        $user_label = '<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>';
                        ?>
                        <div class="header-info-user-image">
                            <img src="/frontend/web/img/user-avatar.jpg" alt="">
                        </div>
                        <div class="header-info-user-name">
                            <?php echo $user->username;?>
                        </div>
                        <?php
                    }
                    ?>



                </div>


            </div>
        </div>
    </div>
</header>

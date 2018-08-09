<?php

use yii\widgets\Menu;
use yii\helpers\Html;

?>
<div class="main-sidebar">
    <div class="main-sidebar-inner">
        <div class="sidebar-nav">


            <?php

            //if( !Yii::$app->user->isGuest){
            echo Menu::widget([
                'options' => ['class' => 'sidebar-nav-menu'],
                'encodeLabels' => false,
                'items' => [
                    /* [
                         'label' => '<span class="glyphicon glyphicon-home" aria-hidden="true"></span><span>DASHBOARD</span>',
                         'url' => ['site/index'],
                     ],*/
                    [
                        'label' => '<span class="glyphicon glyphicon-user" aria-hidden="true"></span><span>Groups</span>',
                        'url' => ['group/index'],
                    ],
                    /*[
                        'label' => '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span><span>Create point</span>',
                        'url' => ['point/view'],
                    ],
                    [
                        'label' => '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span><span>Add event</span>',
                        'url' => ['site/event_add'],
                    ],
                    [
                        'label' => '<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span><span>Event list</span>',
                        'url' => ['site/event_list'],
                    ],*/
                    /*[
                        'label' => '<span class="glyphicon glyphicon-upload" aria-hidden="true"></span><span>Images upload</span>',
                        'url' => ['site/images'],
                    ],*/
                    /*[
                        'label' => ' <img src="/web/img/icons/ic_dasboard.svg" alt="DASHBOARD"><span>DASHBOARD</span>',
                        'url' => ['site/about'],
                    ],
                    ['label' => 'Products', 'url' => ['product/index'], 'items' => [
                        ['label' => 'New Arrivals', 'url' => ['product/index', 'tag' => 'new']],
                        ['label' => 'Most Popular', 'url' => ['product/index', 'tag' => 'popular']],
                    ]],*/

                ],
            ]);
            //}


            ?>


        </div>
        <div class="sidebar-logout">
            <ul class="sidebar-nav-menu">
                <li>

                    <?php
                    if (Yii::$app->user->isGuest) {
                        $user_label = '<img src="/frontend/web/img/icons/ic_logout.svg" alt="LOGOUT"><span>LOGIN</span>'; ?>

                        <?= Html::a($user_label, ['site/login'], ['data' => ['method' => 'post']]) ?>

                        <?php
                    } else {

                        $user_label = '<img src="/frontend/web/img/icons/ic_logout.svg" alt="LOGOUT"><span>LOGOUT</span>';
                        ?>


                        <?= Html::a($user_label, ['site/logout'], ['data' => ['method' => 'post']]) ?>

                        <?php
                    }
                    ?>

                </li>
            </ul>
        </div>
    </div>
</div>
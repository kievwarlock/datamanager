

<div class="group-tab-content">



    <div class="group-tab-file-block">

    <!--
        <div class="group-tab-file-preview-image">
            <div class="group-tab-file-preview-image-placeholder">

            </div>
        </div>
        <div class="group-tab-file-input-block">
            <input class="group-tab-file-input" type="file"/>
            <div class="group-account-tab-nav-btn window-btn group-tab-file-input-download" >
                Download
            </div>
        </div>
    -->
        <div class="image-form-block  form-item-block-image">
            <p>
                <label for="type">Post image:</label>
            </p>

            <div class="upload-images-block">
                <div class="upload-images-item">
                    <div class="upload-images-item-inner">
                        <div class="upload-images-item-crop"></div>
                        <div class="upload-images-item-crop-placeholder"></div>
                        <div class="upload-images-item-actions">
                            <div class="btn-group-vertical text-left">
                                <div class="btn btn-info upload-images-action-clear" data-toggle="tooltip" data-placement="left" title="Clear">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </div>
                                <div class="btn btn-warning upload-images-action-upload" data-toggle="tooltip" data-placement="left" title="Upload">
                                    <input type="file">
                                    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ( isset($avatar) and !empty($avatar) ) { ?>
            <script>
                $(function(){
                    setTimeout( function () {
                            $('.save-user-profile .upload-images-item-crop').croppie({
                                enableOrientation:true,
                                enableExif: true,
                                viewport: {
                                    width: 300,
                                    height: 300,
                                },
                                boundary: {
                                    width: 300,
                                    height: 300
                                },
                                url:'<?=$avatar?>'
                            });
                        }
                        , 400
                    )

                })
            </script>
        <?php } ?>


    </div>
    <div class="group-tab-main">
        <div class="group-tab-main-top">
            <div class="group-tab-select-item">
                <label for="">Group</label>
                <?php
                // Render a simple select by hiding the search control.

            /*    echo \kartik\select2\Select2::widget([
                    'id' => 'post-tab-group_' . $count,
                    'name' => 'post-tab-group_' . $count,
                    //'hideSearch' => true,
                    'data' => \yii\helpers\ArrayHelper::map($groups, 'id','name'),
                    'options' => ['placeholder' => 'Select group'],
                    'pluginOptions' => [
                        //'allowClear' => true
                    ],
                ]);*/



                echo \kartik\select2\Select2::widget( [
                    'id' => 'post-tab-group_' . $count,
                    'name' => 'post-tab-group_' . $count,
                    'hideSearch' => false,
                    'options' => [
                            'placeholder' => 'Select a theme'
                    ],
                    /*'pluginOptions' => [
                        'allowClear' => true,
                    ],*/
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' =>  0,
                        'language' => [
                            'errorLoading' => new \yii\web\JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => 'group/group-list',
                            'dataType' => 'json',
                            'data' => new \yii\web\JsExpression('function(params) {  return {group:params.term}; }'),
                            'processResults' => new \yii\web\JsExpression('
                            function (data, params) {
                              
                                return {
                                    results: data                         
                                };
                            }
                            '),
                        ],
                        'escapeMarkup' => new \yii\web\JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new \yii\web\JsExpression('function(group) {  return group.name; }'),
                        'templateSelection' => new \yii\web\JsExpression('function (group) {  return group.name; }'),
                    ],
                ]);


                ?>
            </div>
            <div class="group-tab-select-item">
                <label for="">Date, time</label>
                <?php

                echo \kartik\datetime\DateTimePicker::widget([
                    'id' => 'post-tab-date_' . $count,
                    'name' => 'post-tab-date_' . $count,
                    'options' => ['placeholder' => 'Date, time'],
                    //'convertFormat' => true,
                    'pluginOptions' => [
                        'format' => 'mm/dd/yyyy hh:ii',
                        'todayHighlight' => true
                    ]
                ]);
                ?>

            </div>
            <div class="group-tab-select-item">
                <label for="">Theme</label>
                <div class="group-tab-main-theme">
                    <?php
                    $data_array_user_selected = '2';
                    $data_array_user['1'] = 'one';
                    $data_array_user['2'] = 'two';
                    $data_array_user['3'] = 'three';

                    echo \kartik\select2\Select2::widget([
                        'id' => 'post-tab-tag_' . $count,
                        'name' => 'post-tab-tag_' . $count,
                        'value' => $data_array_user_selected,
                        'data' => $data_array_user,
                        'options' => ['multiple' => true, 'placeholder' => 'Select a theme']
                    ]);
                    ?>
                </div>
            </div>

        </div>




        <div class="group-tab-main-text-block">
            <div class="group-tab-textarea">
                <textarea name="" id="" cols="30" rows="4" placeholder="Description (max. 420 characters)"></textarea>
                <div class="group-tab-textarea-lang">RU</div>
            </div>
            <div class="group-tab-textarea">
                <textarea name="" id="" cols="30" rows="4" placeholder="Description (max. 420 characters)" ></textarea>
                <div class="group-tab-textarea-lang">US</div>
            </div>
            <div class="group-tab-textarea">
                <textarea name="" id="" cols="30" rows="4" placeholder="Description (max. 420 characters)"></textarea>
                <div class="group-tab-textarea-lang">DE</div>
            </div>
            <div class="group-tab-textarea">
                <textarea name="" id="" cols="30" rows="4" placeholder="Description (max. 420 characters)" ></textarea>
                <div class="group-tab-textarea-lang">FR</div>
            </div>
            <div class="group-tab-textarea">
                <textarea name="" id="" cols="30" rows="4" placeholder="Description (max. 420 characters)"></textarea>
                <div class="group-tab-textarea-lang">IT</div>
            </div>
            <div class="group-tab-textarea">
                <textarea name="" id="" cols="30" rows="4" placeholder="Description (max. 420 characters)"></textarea>
                <div class="group-tab-textarea-lang">ES</div>
            </div>
        </div>
        <div class="group-tab-footer">
            <div class="text-right">
                <div class="group-account-tab-nav-btn window-btn" >
                    Publish
                </div>
            </div>
        </div>
    </div>
</div>




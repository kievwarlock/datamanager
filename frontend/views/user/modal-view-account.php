<?php
namespace app\components;


if( !is_array($full_user_data) ){
    return 'Error data request';
}

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">USER: <i><?=$full_user_data['phoneNumber']?></i></h4>

</div>

<form class="save-user-profile">
    <div class="modal-body">




        <div class="form-group">


            <input type="hidden" name="avatarId" class="form-control" value="<?=$full_user_data['avatarId'] ?>" id="avatarId" placeholder="Avatar">


            <div class="image-form-block  form-item-block-image">
                <p>
                    <label for="type">Avatar:</label>
                    <?php

                    if( isset($avatar) and !empty($avatar) ){
                        echo '<img class="account-avatar" src="' . $avatar . '" alt="avatar" >';
                    }else{
                        echo 'No avatar !';
                    }
                    ?>
                </p>

            </div>



        </div>

        <div class="form-group">
            <p>
                <label for="locale">User Name:</label>
                <?=$full_user_data['fullName'] ?>
            </p>
            <p>
                <label for="locale">Locale:</label>
                <?=$full_user_data['locale'] ?>
            </p>
            <p>
                <label for="locale">City:</label>
                <?=$full_user_data['city'] ?>
            </p>
            <p>
                <label for="locale">Visible status:</label>
                <?php echo ($full_user_data['visible'] ) ? 'visible' : 'hidden';?>
            </p>
        </div>





    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>

</form>
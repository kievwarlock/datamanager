<!-- Add group  -->
<div class="modal fade add-new-group" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add selected accounts to group</h4>
            </div>
            <div class="modal-body">

                <p class="add-group-status bg-success">Group added!</p>
                <p class="add-group-status bg-danger">Error! Plz try again!</p>


                <label for="group-name"> Group name:</label>
                <input type="text" id="group-name" class="window-input" name="group-name" placeholder="Enter group name" />

            </div>
            <div class="modal-footer">
                <button type="button" class="group-account-tab-nav-btn window-btn window-btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="group-account-tab-nav-btn window-btn new-group">add group</button>
            </div>
        </div>
    </div>
</div>
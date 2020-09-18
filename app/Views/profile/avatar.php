<!-- Vertically centered scrollable modal -->
<div class="modal fade" id="select-avatar" tabindex="-1" role="dialog" aria-labelledby="avatarModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avatarModalLabel"><?php echo lang('View.profile.index.selectAvatar'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                if (!empty($profileAvatars)){
                    echo $profileAvatars['avatars'];
                }
                ?>
            </div>
            <style>
                .selected-avatar{
                    -moz-box-shadow:    inset 0 0 10px #000000;
                    -webkit-box-shadow: inset 0 0 10px #000000;
                    box-shadow:         inset 0 0 10px #000000;
                }
            </style>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang('View.profile.index.close'); ?></button>
                <button onclick="saveAvatar()" type="button" data-dismiss="modal" class="btn btn-primary"><?php echo lang('View.profile.index.save'); ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    function selectAvatar(avatarName,event) {
        document.getElementById('#selectedAvatar').value = avatarName
        let current = document.getElementsByClassName("selected-avatar");
        current[0].className = current[0].className.replace(" selected-avatar", "");
        event.className += " selected-avatar";
    }
    function saveAvatar() {
        let x = document.getElementById('#selectedAvatar').value
        if (x){
            requestDynamic('/save/avatar','savedAvatar=' + x)
            .then(function (res){
                document.querySelector('#avatarSourceLink').setAttribute('src',res.icon)
            }).catch(function (e){
                alert("Avatar"+ e)
            })
        }else{
            alert("<?php echo lang('View.profile.index.avatarProblem'); ?>")
        }
    }
</script>

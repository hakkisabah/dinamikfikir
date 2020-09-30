<style>
    #editor {
        height: 575px;
    }
</style>
<!-- Include stylesheet -->
<link rel="stylesheet" href="<?php echo $currentEditorCssLink ?>">
<div class="my-3 p-3 bg-white rounded shadow-sm">
    <?php
    $uri = service('uri');
    $segments = $uri->getSegments();
    $isUpdateSlug = !empty($segments[2]) ? '/' . $segments[2] : '';
    $currentEditorWaitingLink = '/' . $segments[0] . '/' . $segments[1] . $isUpdateSlug;
    session()->set('editorWaitingLink', $currentEditorWaitingLink);
    if (session()->get('success')):
        echo '<div id="editorAlerter" class="alert alert-success" role="alert">' .
            session()->get('success')
            . '<div id="editorWaiter"></div></div>';
        echo "<script>
               setTimeout(countget,1000)
                
                function buttonElementGetter(){
                   return document.getElementById('submitButtonForClickCheck')
                }
                
                function countget(){
                   if (timeEditored == 15){
                        buttonElementGetter().disabled = true
                   }
                    timeEditored--
                let editorWaiter = document.getElementById('editorWaiter');
                if (timeEditored > 0){
                    editorWaiter.innerHTML = String ( timeEditored )
                    setTimeout(countget,1000)    
                }else{
                    buttonElementGetter().disabled = false
                    let editorAlerter = document.getElementById('editorAlerter');
                    editorAlerter.setAttribute('class',editorAlerter.getAttribute('class').replace('',' d-none '))
                    timeEditored = 15
                }      
                }
            </script>";
    endif;
    ?>
    <?php
    if (isset($validation)): ?>
        <div class="col-12">
            <div class="alert alert-danger" role="alert">
                <?= $validation->listErrors() ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="container">
            <form id="titleImageForm" method="post" enctype="multipart/form-data">
                <?php helper(['form']); ?>

                <div class="row">
                    <div class="col-sm-4">
                        <div id="imageUploadPart" class="media table-hover">
                            <img class="img-thumbnail" id="tempImageDiv" src="<?php
                            if (isset($result->title_image)) {
                                echo $result->title_image;
                            } else {
                                echo !empty($validation->title_image) ? $validation->title_image : '';
                            }
                            ?>" style="display: none;"/>
                            <div id="spinnerField" class="sk-cube-grid" style="display: none">
                                <div class="sk-cube sk-cube1"></div>
                                <div class="sk-cube sk-cube2"></div>
                                <div class="sk-cube sk-cube3"></div>
                                <div class="sk-cube sk-cube4"></div>
                                <div class="sk-cube sk-cube5"></div>
                                <div class="sk-cube sk-cube6"></div>
                                <div class="sk-cube sk-cube7"></div>
                                <div class="sk-cube sk-cube8"></div>
                                <div class="sk-cube sk-cube9"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <label id="CheckClickforUpload" for="titleImage" class="custom-file-upload">
                            <i class="fa fa-cloud-upload"></i> <?php echo lang('View.dashboard.editor.titleImageUpload'); ?>
                        </label>
                        <input id="titleImage" type="file"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Create the editor container -->
    <form action="<?php
    $uri = service('uri');
    helper(['form']);
    echo $uri->getSegment(3) || $uri->getSegment(2) == 'updatecontent' ? '/dashboard/updatecontent' : '/dashboard/addcontent' ?>"
          method="post" enctype="multipart/form-data">
        <input type="text" name="title" id="inputTitle" class="form-control mb-2"
               value="<?php
               if (!empty($result->title)) {
                   echo $result->title;
               } else {
                   echo set_value('title');
               } ?>"
               placeholder="<?php echo lang('View.dashboard.editor.titlePlaceHolder'); ?>"
               required autofocus>
        <input type="file" id="imageHiddenForTitleImage" name="titleImage" style="display: none!important;">
        <input type="hidden" id="editorImagesHidden" name="editorImagesHidden"
               value="<?php echo isset($result->content_images) ? $result->content_images : '' ?>">
        <input type="hidden" id="contentId" name="contentId"
               value="<?php
               if (isset($result->content_id)) {
                   echo $result->content_id;
               } else {
                   echo isset($validation->content_id) ? $validation->content_id : '';
               }
               ?>">
        <input id="contentHiddenForDiv" type="hidden" name="contentHiddenForDiv">
        <input id="contentCalculator" type="hidden" name="contentCalculator">
        <div class="p4" onload="loadForUpdate()" id="editor"
             onkeyup="transferring()">
            <?php if (isset($result->content)) {
                echo '<p>' . $result->content . '</p>';
            } else {
                echo html_entity_decode(set_value('contentHiddenForDiv'));
            } ?>
        </div>
        <button id="submitButtonForClickCheck" onclick="transferring()" class="btn btn-lg btn-primary btn-block mt-2"
                type="submit"><?php echo lang('View.dashboard.editor.save'); ?>
        </button>
    </form>
</div>
<script>
    let tempEditorImages = (Array)("<?php echo !empty(session()->get('editorImageNamesHere')) ? implode(',', session()->get('editorImageNamesHere')) : '';?>")
    let timeEditored = 15
    function currentBase(){
        return  '<?php if (isset($currentBase)) {
            echo $currentBase;
        }?>'
    }
    function errorCallBack(whichError) {
        let errors = {
            imageExtension : "<?php echo lang('DF_Validation.errors.ext_in', ['imageExtensions' => 'jpg,jpeg,png']); ?>",
            imageSize : "<?php echo lang('DF_Validation.errors.max_size', ['imageSize' => '1mb']); ?>",
            browserError : "<?php echo lang('View.dashboard.editor.navigatorProblem'); ?>",
        }
        return errors[whichError]
    }
</script>
<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="<?php if (isset($currentBase)) {
    echo $currentBase;
} ?>public/assets/js/editorFunctions.js"></script>
<script src="<?php if (isset($currentBase)) {
    echo $currentBase;
} ?>public/assets/js/quillConf.js"></script>
<script src="<?php if (isset($currentBase)) {
    echo $currentBase;
} ?>public/assets/js/quillEditorManage.js"></script>
<script src="<?php if (isset($currentBase)) {
    echo $currentBase;
} ?>public/assets/js/editorLogic.js"></script>
<!-- Initialize Quill editor -->
<script>
    if (window.navigator.userAgent.indexOf("Edge") > -1 || msieversion() == true) {
        alert("<?php echo lang('View.dashboard.editor.navigatorProblem'); ?>")
    }

    // https://stackoverflow.com/questions/19999388/check-if-user-is-using-ie
    function msieversion() {

        let ua = window.navigator.userAgent;
        let msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))  // If Internet Explorer, return version number
        {
            return true
            // alert(parseInt(ua.substring(msie + 5, ua.indexOf(".", msie))));
        }
        // else  // If another browser, return 0
        // {
        //     alert('otherbrowser');
        // }
        return false;
    }

    loadForUpdate()
</script>
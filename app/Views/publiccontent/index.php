  <div class="card-group">
        <div class="card mt-5">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-muted text-center"><?php echo lang('View.publicContent.index.author'); ?></li>
            </ul>
        </div>
        <div class="card mt-5">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center"><a class="text-decoration-none"
                                                           href="/profile/<?php echo $userNameForContent = !empty($public_content_data['publicResult']['ContentsUserInfo']) ? $public_content_data['publicResult']['ContentsUserInfo']['user_name'] : '' ?>">
                        @<?php echo $userNameForContent ?></a>
                </li>
            </ul>
        </div>
    </div>
    <hr>
<style>
    @media only screen and (max-width: 360px) {
        h1 {
            font-size: 2rem!important;
        }
    }
</style>
<link rel="stylesheet" href="<?php echo $public_content_data['currentEditorCssLink'] ?>">
    <div class="jumbotron border bg-light">
        <?php
        if (!empty($public_content_data['publicResult'])) {
            echo '<p class="text-right text-muted">' . $public_content_data['publicResult']['content']['created_at'] . '</p>';
            echo '<h1 class="h1" style="word-break: break-all;line-height: 1.6;">' . $public_content_data['publicResult']['content']['title'] . '</h1>';
            echo '<hr>';
            echo '<div class="ql-editor">' . $public_content_data['publicResult']['content']['content'] . '</div>';
            echo '<hr>';
            echo !empty($public_content_data['publicResult']['content']['editable'])? '<a class="btn btn-sm btn-primary float-left" href="/dashboard/editor/' . $public_content_data['publicResult']['content']['slug'] . '" role="button">' . lang('View.publicContent.index.edit') . '</a>' : '';
            echo '<a class="btn btn-sm btn-primary float-right" href="#commenttext" role="button">' . lang('View.publicContent.index.writeComment') . '</a>';
        }
        echo '</div>
     <hr>
        <div id="dynamiccomments" class="jumbotron border ql-bg-black">
         <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h2 class="text-center text-muted border-bottom mb-3">' . lang('View.publicContent.index.comments') . '</h2>';
        if (!empty($public_content_data['allComments'])) {
            foreach ($public_content_data['allComments'] as $value) {
                        echo '<svg id="' . $value->comment_id . '" class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg"
                     preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32">
                    <title>'.  $value->commentedUser['user_name'] .'</title>
                    <rect width="100%" height="100%" fill="#007bff"/>
                    <image href="' . $value->commentedUser['icon_name'] . '" height="100%" width="100%"></image>
                </svg>';
                        echo !empty($value->isCommentOwner) ? '<small class="text-right" role="button"><a href="/comment/delete/' . $value->comment_id . '">' . lang('View.publicContent.index.deleteComment') . '</a></small>' : '';
                        echo '<p   class="media-body pb-3 mb-2 lh-125 border-bottom border-gray" style="word-wrap: break-word;"><small class="text-right text-muted">' . $value->created_at . '</small>';
                        echo '<strong class="d-block text-gray-dark">@<a href="/profile/' . $value->commentedUser['user_name'] . '">' . $value->commentedUser['user_name'] . '</a></strong>' . $value->comment . '
                        </p>';
                    }
        }else{
         echo '<p class="text-center">' . lang('View.publicContent.index.notHaveComment') . '</p>';
        }
        ?>
        <?php
        echo '</div></div>'
        ?>
    </div>
    <?php if (isset($validation)): ?>
        <div class="col-12">
            <div class="alert alert-danger" role="alert">
                <?= $validation->listErrors() ?>
            </div>
        </div>
    <?php endif; ?>
    <?php
    // endComment methodunda tanımlanmış olan ['result']
    // dizisi herhangi bir hatada burada kullanılacaktır
    helper(['form']);
    $contentId =  $public_content_data['publicResult']['content']['content_id'];
    $contentSlug = $public_content_data['publicResult']['content']['slug'];
    echo session()->get('userInfo')['isLoggedIn'] ? '
    <form method="post" action="/content/addcomment">
        <div class="form-group">
            <label class="text-muted ml-1 mt-2" for="commenttext">' . lang('View.publicContent.index.writeToComment') . '</label>
            <textarea name="comment" class="form-control" id="commenttext" rows="3">' . set_value('comment') . '</textarea>
            <input hidden name="content_id" value="' . $contentId . '">
            <input hidden name="contentslug" value="' . $contentSlug . '">
        </div>
       <button type="submit" class="btn btn-sm btn-primary float-right">' . lang('View.publicContent.index.writeComment') . '</button>' : lang('View.publicContent.index.loginForComment'); ?>

    </form>




<div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0"><?php echo lang('View.dashboard.contents.title'); ?></h6>
    <?php
    if (!empty($dashboard_contents_data['contentForDashboard'])) {
        $contentForDashboard = $dashboard_contents_data['contentForDashboard'];
        foreach ($contentForDashboard as $content) {
            echo '<div class="media text-muted pt-3">
            <svg style="cursor: pointer" class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>' . $content['title'] . '</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray text-truncate">';
            echo '<strong class="d-block text-gray-dark" style="cursor: pointer"><a href="/content/' . $content['slug'] . '">' . $content['title'] . '</a></strong>' . strip_tags($content['content']) . '<small class="d-block text-right text-muted mt-3">' . $content['created_at'] . '</small></p>';
            echo '</div>';
        }
    }

    ?>
</div>

<!-- Yorumlar.. -->
<div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0"><?php echo lang('View.dashboard.contents.comments'); ?></h6>
    <?php
    if (!empty($dashboard_contents_data['commentForDashBoard'])) {
        $merged = $dashboard_contents_data['commentForDashBoard'];
        foreach ($merged as $value) {
            echo '<div class="media text-muted pt-3">
        <svg style="cursor: pointer" class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title></title><rect width="100%" height="100%" fill="#e83e8c"/><text x="50%" y="50%" fill="#007bff" dy=".3em"></text></svg>
        <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <div class="d-flex justify-content-between align-items-center w-100">';
            echo '<strong style="cursor: pointer" class="text-gray-dark"><a onclick="' . $value['postRead'] . '" href="/content/' . $value['ContetOwnerSlug'] . '#' . $value['notificationLinkTargetId']  . '">' . $value['ContetOwnerTitle'] . '</a></strong>';
//            echo '<a href="/content/' . $value->content_id . '">Git</a>';
            echo '</div>
                 <span class="d-block">@' . $value['commentOwner'] . '</span>';
            echo '</div>
            </div>';
        }
    } else {
        echo '';
    }

    ?>
    <!--    <small class="d-block text-right mt-3">-->
    <!--        <a href="#">Tüm yorumlar</a>-->
    <!--    </small>-->
</div>

<script>
    function postRead(slug) {
        requestDynamic('/read/notification', 'notificationvar=' + slug)
    }
</script>
<?php

if (isset($headerIndex)) {
    echo $headerIndex['docType'];
    echo $headerIndex['htmlStart'];
    echo $headerIndex['header_metas'];
//    echo '<meta name="google-site-verification" content="QVmlhF0uPbjgIPyYRJYOzHYqMw9NfV9maVp3Z7FTHdg" />';
    echo $headerIndex['linksTag'];
    echo $headerIndex['titleInfo'];
} else {
    echo '<style>
.alert-danger{color:#a94442;background-color:#f2dede;border-color:#ebccd1}
</style>';
        echo '<html><body><div class="alert alert-danger" role="alert">'. lang('View.header.index.serviceProviderProblem') . '</div></body></html>';
        exit();

}



<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">

    <title><?= lang('DF_Messages.messages.HTTP.errors.title') ?></title>

    <style type="text/css">
        <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
    </style>
</head>
<body>

<div class="container text-center">

    <h1 class="headline"><?= lang('DF_Messages.messages.HTTP.errors.title') ?></h1>

    <p class="lead"><?= lang('DF_Messages.messages.HTTP.errors.message',['pageroute'=>'<a href="' . base_url() .'">' . base_url() . '</a>']) ?></p>

</div>

</body>

</html>

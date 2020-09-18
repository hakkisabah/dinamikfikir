<div class="form-group  row">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css">

    <?php echo view('admin/report/site_user') ?>
    <?php if (getenv('LOG_WITH_DB') === 'ON'){
        echo view('admin/report/guest_user');
    } ?>
</div>




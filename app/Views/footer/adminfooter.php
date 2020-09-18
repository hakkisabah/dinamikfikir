<!-- report sayfasında çalışmak üzere ayarlanacak kısım -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#site_user').DataTable({
            responsive: true,
            processing: true,
            "ajax": {
                "url": "/admin/usersreport",
                "type": "POST"
            },
            // "order" :
            // Arka uç tarafınd çalşan usersReport() methodu yorum satırlarında bahsedilen sıralama şeklinin aynısıdır
            // tek farkı burada sadece parametre belirterek basitçe yapabilmekteyiz..
            "order": [[ 3, 'desc' ], [ 4, 'asc' ]],
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "<?php echo lang('View.AdminPanel.report.admin_footer.sEmptyTable'); ?>",
                "sInfo":           "<?php echo lang('View.AdminPanel.report.admin_footer.sInfo'); ?>",
                "sInfoEmpty":      "<?php echo lang('View.AdminPanel.report.admin_footer.sInfoEmpty'); ?>",
                "sInfoFiltered":   "<?php echo lang('View.AdminPanel.report.admin_footer.sInfoFiltered'); ?>",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "<?php echo lang('View.AdminPanel.report.admin_footer.sLengthMenu'); ?>",
                "sLoadingRecords": "<?php echo lang('View.AdminPanel.report.admin_footer.sLoadingRecords'); ?>",
                "sProcessing":     "<?php echo lang('View.AdminPanel.report.admin_footer.sProcessing'); ?>",
                "sSearch":         "<?php echo lang('View.AdminPanel.report.admin_footer.sSearch'); ?>",
                "sZeroRecords":    "<?php echo lang('View.AdminPanel.report.admin_footer.sZeroRecords'); ?>",
                "oPaginate": {
                    "sFirst":    "<?php echo lang('View.AdminPanel.report.admin_footer.sFirst'); ?>",
                    "sLast":     "<?php echo lang('View.AdminPanel.report.admin_footer.sLast'); ?>",
                    "sNext":     "<?php echo lang('View.AdminPanel.report.admin_footer.sNext'); ?>",
                    "sPrevious": "<?php echo lang('View.AdminPanel.report.admin_footer.sPrevious'); ?>"
                },
                "oAria": {
                    "sSortAscending":  "<?php echo lang('View.AdminPanel.report.admin_footer.sSortAscending'); ?>",
                    "sSortDescending": "<?php echo lang('View.AdminPanel.report.admin_footer.sSortDescending'); ?>"
                },
                "select": {
                    "rows": {
                        "_": "<?php echo lang('View.AdminPanel.report.admin_footer._'); ?>",
                        "0": "",
                        "1": "<?php echo lang('View.AdminPanel.report.admin_footer.1'); ?>"
                    }
                }
            },
            columns: [
                { data: "user_name" },
                { data: "last_login_date" },
                { data: "total_content" },
                { data: "total_comment" },
                { data: "register_date" },
                { data: "role" }
            ],
            "deferRender": true
        });
        $('#guest_user').DataTable({
            responsive: true,
            processing: true,
            "ajax": {
                "url": "/admin/generalusersreport",
                "type": "POST"
            },
            "order": [[ 4, 'desc' ]],
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "<?php echo lang('View.AdminPanel.report.admin_footer.sEmptyTable'); ?>",
                "sInfo":           "<?php echo lang('View.AdminPanel.report.admin_footer.sInfo'); ?>",
                "sInfoEmpty":      "<?php echo lang('View.AdminPanel.report.admin_footer.sInfoEmpty'); ?>",
                "sInfoFiltered":   "<?php echo lang('View.AdminPanel.report.admin_footer.sInfoFiltered'); ?>",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "<?php echo lang('View.AdminPanel.report.admin_footer.sLengthMenu'); ?>",
                "sLoadingRecords": "<?php echo lang('View.AdminPanel.report.admin_footer.sLoadingRecords'); ?>",
                "sProcessing":     "<?php echo lang('View.AdminPanel.report.admin_footer.sProcessing'); ?>",
                "sSearch":         "<?php echo lang('View.AdminPanel.report.admin_footer.sSearch'); ?>",
                "sZeroRecords":    "<?php echo lang('View.AdminPanel.report.admin_footer.sZeroRecords'); ?>",
                "oPaginate": {
                    "sFirst":    "<?php echo lang('View.AdminPanel.report.admin_footer.sFirst'); ?>",
                    "sLast":     "<?php echo lang('View.AdminPanel.report.admin_footer.sLast'); ?>",
                    "sNext":     "<?php echo lang('View.AdminPanel.report.admin_footer.sNext'); ?>",
                    "sPrevious": "<?php echo lang('View.AdminPanel.report.admin_footer.sPrevious'); ?>"
                },
                "oAria": {
                    "sSortAscending":  "<?php echo lang('View.AdminPanel.report.admin_footer.sSortAscending'); ?>",
                    "sSortDescending": "<?php echo lang('View.AdminPanel.report.admin_footer.sSortDescending'); ?>"
                },
                "select": {
                    "rows": {
                        "_": "<?php echo lang('View.AdminPanel.report.admin_footer._'); ?>",
                        "0": "",
                        "1": "<?php echo lang('View.AdminPanel.report.admin_footer.1'); ?>"
                    }
                }
            },
            columns: [
                { data: "ip_id" },
                { data: "ip_address" },
                { data: "user_name" },
                { data: "end_point" },
                { data: "created_at" },
                { data: "cookie_consent" }
            ],
            "deferRender": true
        });
    } );
</script>
<!-- report sayfasında çalışmak üzere ayarlanacak kısım END -->

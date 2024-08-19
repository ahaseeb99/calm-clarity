<?php
overall_header(__("Transactions"));
?>
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <?php
        include_once TEMPLATE_PATH . '/dashboard_sidebar.php';
        ?>
        <!-- Dashboard Content
        ================================================== -->
        <div class="dashboard-content-container" data-simplebar>
            <div class="dashboard-content-inner">
                <?php print_adsense_code('header_bottom'); ?>
                <!-- Dashboard Headline -->
                <div class="dashboard-headline">
                    <h3><?php _e("Transactions") ?></h3>
                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="<?php url("INDEX") ?>"><?php _e("Home") ?></a></li>
                            <li><?php _e("Transactions") ?></li>
                        </ul>
                    </nav>
                </div>

                <table id="datatable">
                    <thead>
                    <tr>
                        <th class="small-width"></th>
                        <th><?php _e("Title") ?></th>
                        <th class="small-width"><?php _e("Amount") ?></th>
                        <th class="small-width"><?php _e("Premium") ?></th>
                        <th><?php _e("Payment Method") ?></th>
                        <th><?php _e("Date") ?></th>
                        <th class="small-width"><?php _e("Status") ?></th>
                        <th class="small-width"></th>
                    </tr>
                    </thead>
                    <?php if($total_item == "0"){ ?>
                        <tbody>
                        <tr>
                            <td colspan="7" class="text-center"><?php _e("No result found.") ?></td>
                        </tr>
                        </tbody>
                        <?php
                    }else{ ?>
                        <tbody>
                        <?php foreach($transactions as $trans){ ?>
                            <tr>
                                <td></td>
                                <td><?php _esc($trans['product_name']) ?></td>
                                <td><?php _esc($trans['amount']) ?></td>
                                <td><?php _esc($trans['premium']) ?></td>
                                <td><?php _esc($trans['payment_by']) ?></td>
                                <td><?php _esc($trans['time']) ?></td>
                                <td><?php _esc($trans['status']) ?></td>
                                <td>
                                    <?php if($trans['invoice'] != ""){ ?>
                                        <a href="<?php _esc($trans['invoice']) ?>" class="button ico" data-tippy-placement="top" title="<?php _e("Invoice") ?>" target="_blank"><i class="icon-feather-file-text"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    <?php } ?>
                </table>

                <div class="margin-bottom-30"></div>

                <?php print_adsense_code('footer_top'); ?>
                <!-- Footer -->
                <div class="dashboard-footer-spacer"></div>
                <div class="small-footer margin-top-15">
                    <div class="footer-copyright">
                        <?php _esc($config['copyright_text']); ?>
                    </div>
                    <ul class="footer-social-links">
                        <?php
                        if ($config['facebook_link'] != "")
                            echo '<li><a href="' . _esc($config['facebook_link'], false) . '" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a></li>';
                        if ($config['twitter_link'] != "")
                            echo '<li><a href="' . _esc($config['twitter_link'], false) . '" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a></li>';
                        if ($config['instagram_link'] != "")
                            echo '<li><a href="' . _esc($config['instagram_link'], false) . '" target="_blank" rel="nofollow"><i class="fa fa-instagram"></i></a></li>';
                        if ($config['linkedin_link'] != "")
                            echo '<li><a href="' . _esc($config['linkedin_link'], false) . '" target="_blank" rel="nofollow"><i class="fa fa-linkedin"></i></a></li>';
                        if ($config['pinterest_link'] != "")
                            echo '<li><a href="' . _esc($config['pinterest_link'], false) . '" target="_blank" rel="nofollow"><i class="fa fa-pinterest"></i></a></li>';
                        if ($config['youtube_link'] != "")
                            echo '<li><a href="' . _esc($config['youtube_link'], false) . '" target="_blank" rel="nofollow"><i class="fa fa-youtube"></i></a></li>';
                        ?>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
<?php ob_start() ?>
    <link rel="stylesheet" href="<?php _esc(TEMPLATE_URL); ?>/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?php _esc(TEMPLATE_URL); ?>/css/responsive.dataTables.min.css">
    <script src="<?php _esc(TEMPLATE_URL); ?>/js/jquery.dataTables.min.js"></script>
    <script src="<?php _esc(TEMPLATE_URL); ?>/js/dataTables.responsive.min.js"></script>
    <script>

        $(document).ready(function () {
            $('#datatable').DataTable({
                responsive: {
                    details: {
                        type: 'column'
                    }
                },
                "language": {
                    "paginate": {
                        "previous": "<?php _e("Previous") ?>",
                        "next": "<?php _e("Next") ?>"
                    },
                    "search": "<?php _e("Search") ?>",
                    "lengthMenu": "<?php _e("Display") ?> _MENU_",
                    "zeroRecords": "<?php _e("No result found.") ?>",
                    "info": "<?php _e("Page") ?> _PAGE_ - _PAGES_",
                    "infoEmpty": "<?php _e("No result found.") ?>",
                    "infoFiltered": "( <?php _e("Total Results") ?> _MAX_)"
                },
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0
                }]
            });
        });

    </script>
<?php
$footer_content = ob_get_clean();
include_once TEMPLATE_PATH . '/overall_footer_dashboard.php';
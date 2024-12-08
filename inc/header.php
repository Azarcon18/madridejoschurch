<?php
// Prevent direct access
defined('BASEPATH') or exit('No direct script access allowed');

// Ensure session authentication
// require_once('sess_auth.php');

// A helper function for sanitization
function safe_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo safe_output($_settings->info('title')) != false ? safe_output($_settings->info('title')) . ' | ' : '' ?>
        <?php echo safe_output($_settings->info('name')) ?>
    </title>
    <link rel="icon" href="<?php echo safe_output(validate_image($_settings->info('logo'))) ?>" />

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>dist/css/adminlte.css">
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>dist/css/custom.css">
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="<?php echo safe_output(base_url) ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

    <!-- jQuery and Plugins -->
    <script src="<?php echo safe_output(base_url) ?>plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo safe_output(base_url) ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo safe_output(base_url) ?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?php echo safe_output(base_url) ?>plugins/toastr/toastr.min.js"></script>
    <script>
        var _base_url_ = '<?php echo safe_output(base_url) ?>';
    </script>
    <script src="<?php echo safe_output(base_url) ?>dist/js/script.js"></script>
    <script src="<?php echo safe_output(base_url) ?>assets/js/scripts.js"></script>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>

    <!-- Custom Styles -->
    <style>
        #main-header {
            position: relative;
            background: rgb(0, 0, 0) !important;
            background: radial-gradient(circle, rgba(0, 0, 0, 0.485) 22%, rgba(0, 0, 0, 0.395) 49%, rgba(0, 212, 255, 0) 100%) !important;
        }
        #main-header:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('<?php echo safe_output(base_url . $_settings->info('cover')) ?>');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            filter: drop-shadow(0px 7px 6px black);
            z-index: -1;
        }
    </style>
</head>

<?php if ($_settings->chk_flashdata('success')): ?>
<script>
    $(function() {
        alert_toast("<?php echo safe_output($_settings->flashdata('success')) ?>", 'success');
    });
</script>
<?php endif; ?>

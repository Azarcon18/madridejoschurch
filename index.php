<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php') ?>
<body style="background-color: white;">
<?php 
// Sanitize and validate success flash data
if ($_settings->chk_flashdata('success')): 
    $success_message = htmlspecialchars($_settings->flashdata('success'), ENT_QUOTES, 'UTF-8');
?>
    <script>
    alert_toast("<?php echo $success_message; ?>",'success')
    </script>
<?php endif; ?>

<?php require_once('inc/topBarNav.php') ?>

<?php
// Sanitize page parameter
$page = isset($_GET['p']) ? filter_input(INPUT_GET, 'p', FILTER_SANITIZE_STRING) : 'home';

// Enhanced security for page inclusion
$allowed_pages = ['home', 'about', 'contact', 'products']; // Add your allowed pages
$page = in_array($page, $allowed_pages) ? $page : 'home';

// Secure page inclusion
try {
    if (is_dir($page)) {
        $index_file = $page . '/index.php';
        if (file_exists($index_file) && is_readable($index_file)) {
            include $index_file;
        } else {
            include '404.html';
        }
    } else {
        $page_file = $page . '.php';
        if (file_exists($page_file) && is_readable($page_file)) {
            include $page_file;
        } else {
            include '404.html';
        }
    }
} catch (Exception $e) {
    // Log the error and show a generic error page
    error_log('Page inclusion error: ' . $e->getMessage());
    include '500.html';
}
?>

<?php require_once('inc/footer.php') ?>

<!-- Modals (kept as in original code) -->
<div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
            </div>
            <div class="modal-body">
                <div id="delete_content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Other modals remain the same -->

<script>
    // Content Security Policy and protection against DevTools
    (function() {
        // Disable right-click context menu
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // Disable F12, Ctrl+Shift+I, Ctrl+U (common shortcuts for opening developer tools)
        document.addEventListener('keydown', function(e) {
            if (
                e.key === 'F12' || 
                (e.ctrlKey && (e.key === 'I' || e.key === 'i')) || 
                (e.ctrlKey && (e.key === 'U' || e.key === 'u'))
            ) {
                e.preventDefault();
                return false;
            }
        });

        // Optional: Add Content Security Policy meta tag
        const cspMeta = document.createElement('meta');
        cspMeta.httpEquiv = 'Content-Security-Policy';
        cspMeta.content = "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';";
        document.head.appendChild(cspMeta);
    })();
</script>
</body>
</html>

<?php
function deleteFolderContents($folderPath) {
    if (!is_dir($folderPath)) {
        echo "Error: Directory does not exist.";
        return false;
    }

    $files = array_diff(scandir($folderPath), array('.', '..'));

    foreach ($files as $file) {
        $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;

        if (is_file($filePath)) {
            unlink($filePath); // Delete file
        } elseif (is_dir($filePath)) {
            deleteFolderContents($filePath); // Recursive delete
            rmdir($filePath); // Delete empty directory
        }
    }

    echo "Folder contents deleted successfully.";
    return true;
}

// Example usage
$folderToDelete = __DIR__ . '/uploads/blog_uploads/YSzqldklKk';
deleteFolderContents($folderToDelete);
?>

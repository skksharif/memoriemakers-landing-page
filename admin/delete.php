<?php
if (isset($_POST['file'])) {
    $file = $_POST['file'];

    // Check if the file exists and delete it
    if (file_exists($file)) {
        unlink($file);
        echo "File deleted successfully.";
    } else {
        echo "File not found.";
    }

    // Redirect back to the gallery
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
?>

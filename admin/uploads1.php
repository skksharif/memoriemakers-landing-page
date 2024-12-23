<?php
if (isset($_POST['submit'])) {
    // Define the base target directory
    $base_dir = "../pages/prabha-img/";

    // Get the selected category
    $category = isset($_POST['category']) ? $_POST['category'] : '';

    // Initialize a variable to store the upload status
    $upload_success = true;

    // Verify that a category was selected
    if ($category) {
        $target_dir = $base_dir . str_replace(' ', '-', strtolower($category)) . "/";

        // Loop through each uploaded file
        foreach ($_FILES['files']['name'] as $key => $filename) {
            $target_file = $target_dir . basename($filename);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if the directory exists, if not, create it
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            // Validate the file
            $check = getimagesize($_FILES["files"]["tmp_name"][$key]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
                $upload_success = false;
            }


            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $uploadOk = 0;
                $upload_success = false;
            }

            if ($uploadOk == 0) {
                $upload_success = false;
            } else {
                if (!move_uploaded_file($_FILES["files"]["tmp_name"][$key], $target_file)) {
                    $upload_success = false;
                }
            }
        }

        // Redirect back to the form page with a success or error message
        if ($upload_success) {
            header("Location: " . "prabha-upload.php" . "?status=success");
        } else {
            header("Location: " . "prabha-upload.php" . "?status=error");
        }
        exit;
    } else {
        // Redirect back to the form page with an error message if no category was selected
        header("Location: " . $_SERVER['PHP_SELF'] . "?status=category_error");
        exit;
    }
}
?>

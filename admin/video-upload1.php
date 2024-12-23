<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $heading = $_POST['heading'];
    $video = $_FILES['video'];

    $target_dir = "../pages/jayaram-video/film-making/";
   
    $filename = uniqid() . '-' . basename($video["name"]);
    $target_file = $target_dir . $filename;

    // Create the category directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Validate file upload
    if ($video['error'] !== UPLOAD_ERR_OK) {
        header('Location: jayaram-upload.php?video-status=upload-error');
        exit();
    }

    // Check if the uploaded file is in the temporary directory
    if (!is_uploaded_file($video["tmp_name"])) {
        header('Location: jayaram-upload.php?video-status=tmp-file-error');
        exit();
    }

    // Check if the uploaded file is a valid video
    $videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowedTypes = ['mp4', 'avi', 'mov', 'wmv', 'mkv'];
    if (!in_array($videoFileType, $allowedTypes)) {
        header('Location: jayaram-upload.php?video-status=invalid-type');
        exit();
    }

    // Validate file size (limit to 50MB)
    if ($video["size"] > 50000000) {
        header('Location: jayaram-upload.php?video-status=invalid-size');
        exit();
    }

    // Move the uploaded file
    if (move_uploaded_file($video["tmp_name"], $target_file)) {
        $data = [
            "heading" => $heading,
            "video_path" => $target_file
        ];

        // Read existing videos from JSON file
        $videos = json_decode(file_get_contents('videos-jayaram.json'), true);

        // Append the new video data
        $videos[] = $data;

        // Write updated data back to JSON file
        file_put_contents('videos-jayaram.json', json_encode($videos, JSON_PRETTY_PRINT));

        header('Location: jayaram-upload.php?video-status=success');
        exit();
    } else {
        header('Location: jayaram-upload.php?video-status=error');
        exit();
    }
}
?>

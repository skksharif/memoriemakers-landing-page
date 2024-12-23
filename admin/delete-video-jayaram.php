<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $heading = $_POST['heading'];

    // Read existing videos from JSON file
    $videos = json_decode(file_get_contents('videos-jayaram.json'), true);

    // Search for the video to delete by heading
    foreach ($videos as $key => $video) {
        if ($video['heading'] === $heading) {
            $video_path = $video['video_path'];  // Get the video path from the video data

            // Delete the video file from the server
            if (file_exists($video_path)) {
                if (unlink($video_path)) {
                    // Remove the video from the JSON array
                    unset($videos[$key]);

                    // Reindex array
                    $videos = array_values($videos);

                    // Write updated data back to JSON file
                    file_put_contents('videos-jayaram.json', json_encode($videos, JSON_PRETTY_PRINT));

                    header('Location: jayaram-upload.php?video-status=delete-success');
                    exit();
                } else {
                    header('Location: jayaram-upload.php?video-status=delete-error');
                    exit();
                }
            } else {
                header('Location: jayaram-upload.php?video-status=file-not-found');
                exit();
            }
        }
    }

    // If video not found in JSON
    header('Location: jayaram-upload.php?video-status=video-not-found');
    exit();
}
?>

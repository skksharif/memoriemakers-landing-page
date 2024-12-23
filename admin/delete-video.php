<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fileToDelete = $_POST['file'];

    // Read existing videos from JSON file
    $jsonFile = 'videos.json';
    $videos = json_decode(file_get_contents($jsonFile), true);

    // Remove the video from the array
    $updatedVideos = array_filter($videos, function($video) use ($fileToDelete) {
        return $video['video_path'] !== $fileToDelete;
    });

    // Check if the file exists before attempting to delete
    if (file_exists($fileToDelete)) {
        unlink($fileToDelete); // Delete the video file
    }

    // Write the updated videos array back to JSON file
    file_put_contents($jsonFile, json_encode(array_values($updatedVideos), JSON_PRETTY_PRINT));

    // Redirect back to the upload page with a success message
    header('Location: jayaram-upload.php');
    exit();
}
?>

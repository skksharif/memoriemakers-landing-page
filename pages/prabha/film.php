<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Editing</title>
    <link rel="stylesheet" href="./video.css">
</head>
<body>
    <header>
        <h1>Film making</h1>
    </header>
    <div class="video-container">
        <?php
        // Define the path to the videos JSON file
        $json_file_path = '../../admin/videos-prabha.json';

        // Check if the file exists
        if (file_exists($json_file_path)) {
            // Read the JSON file content
            $json_data = file_get_contents($json_file_path);
            // Decode the JSON data into an array
            $videos = json_decode($json_data, true);

            // Loop through each video and display it
            if (!empty($videos)) {
                foreach ($videos as $video) {
                    // Get the video title and path
                    $heading = htmlspecialchars($video['heading']);
                    
                    // Get the original video path and replace part of the path
                    $original_video_path = htmlspecialchars($video['video_path']);
                    $trimmed_video_path = str_replace('../pages/prabha-video/film-making/', '../prabha-video/film-making/', $original_video_path);

                    echo "
                    <div class='video-item'>
                        <h2>{$heading}</h2>
                        <video controls>
                            <source src='{$trimmed_video_path}' type='video/mp4'>
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    ";
                }
            } else {
                echo "<p>No videos found.</p>";
            }
        } else {
            echo "<p>Unable to load video data.</p>";
        }
        ?>
    </div>
</body>
</html>

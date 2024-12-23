<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prabha Photography</title>
    <link rel="stylesheet" href="./css/upload-style.css">
</head>

<body>
    <center>
        <h1>Prabha Photography</h1>
    </center>
    <div class="upload-container">
        <form action="uploads1.php" method="post" enctype="multipart/form-data" class="form">
            <?php if (isset($_GET['status'])): ?>
                <div class="message <?php echo $_GET['status'] === 'success' ? 'success' : 'error'; ?>">
                    <?php
                    if ($_GET['status'] === 'success') {
                        echo 'Files have been successfully uploaded!';
                    } elseif ($_GET['status'] === 'error') {
                        echo 'There was an error uploading your files. Please try again.';
                    } elseif ($_GET['status'] === 'category_error') {
                        echo 'Please select a category.';
                    }
                    ?>
                </div>
            <?php endif; ?>

            <label for="file">Choose images to upload:</label>
            <input type="file" name="files[]" id="file" multiple required>

            <p>Select a category:</p>
            <label>
                <input type="radio" name="category" value="weddings" required>
                Weddings
            </label>
            <label>
                <input type="radio" name="category" value="candid" required>
                Candid
            </label>
            <label>
                <input type="radio" name="category" value="couple shoot" required>
                Couple Shoot
            </label>
            <label>
                <input type="radio" name="category" value="film making" required>
                Film Making
            </label>

            <br><br>
            <input type="submit" name="submit" value="Upload">
        </form>
        <form action="video-upload2.php" method="post" enctype="multipart/form-data" class="form" id="videoUploadForm">

            <label for="heading">Heading:</label>
            <input type="text" id="heading" name="heading" required><br><br>
            <label for="video">Select video:</label>
            <input type="file" id="video" name="video" accept="video/*" required>
            <br>
            <input type="submit" name="submit" value="Upload">

            <!-- Progress Bar -->
            <div class="progress-container" style="display: none;">
                <div class="progress-bar" id="progressBar" style="width: 0%;"></div>
                <div class="progress-text" id="progressText">0% uploaded</div>
            </div>
        </form>
    </div>

    <!-- Gallery display -->
    <?php
    $categories = ['weddings', 'candid', 'couple shoot', 'film making'];
    $base_dir = "../pages/jayaram-img/";

    foreach ($categories as $category) {
        $dir = $base_dir . str_replace(' ', '-', strtolower($category)) . '/';

        if (is_dir($dir)) {
            $files = scandir($dir);
            if (count($files) > 2) { // Check if there are files in the directory
                echo "<div class='category-heading'>$category</div>";
                echo "<div class='gallery'>";
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        echo "<div class='image-container'>
                                <img src='$dir$file' alt='$file'>
                                <form action='delete.php' method='post' style='display:inline;'>
                                    <input type='hidden' name='file' value='$dir$file'>
                                    <input type='submit' class='delete-button' value='Delete'>
                                </form>
                            </div>";
                    }
                }
                echo "</div>";
            }
        }
    }
    ?>
    <!-- Video Gallery Display -->
    <div class="uploaded-videos">
        <h2 class="videos-title">Uploaded Videos</h2>
        <?php
        $jsonFile = 'videos-prabha.json';

        if (file_exists($jsonFile) && sizeof(json_decode(file_get_contents($jsonFile), true)) > 0) {
            $videos = json_decode(file_get_contents($jsonFile), true);

            foreach ($videos as $video) {
                $videoPath = $video['video_path'];
                $heading = htmlspecialchars($video['heading']); // Use the heading as the title
                echo "<div class='video-item'>
                    <h3 class='video-heading'>$heading</h3>
                    <form action='delete-video-prabha.php' method='post' class='delete-form' style='display:inline;'>
                        <input type='hidden' name='heading' value='$heading'>
                        <input type='submit' class='delete-btn' value='Delete'>
                    </form>
                  </div>";
            }
        } else {
            echo "<p class='no-videos-message'>No videos uploaded yet.</p>";
        }
        ?>
    </div>


    <!-- JavaScript to maintain scroll position -->
    <script>
        // Store the scroll position before the page is unloaded
        window.addEventListener('beforeunload', function () {
            localStorage.setItem('scrollPosition', window.scrollY);
        });

        // Restore the scroll position when the page is loaded
        window.addEventListener('load', function () {
            if (localStorage.getItem('scrollPosition') !== null) {
                window.scrollTo(0, parseInt(localStorage.getItem('scrollPosition')));
                localStorage.removeItem('scrollPosition'); // Clear the stored position
            }
        });
    </script>
    <script>
        document.getElementById('videoUploadForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            const formData = new FormData(this);
            const xhr = new XMLHttpRequest();

            // Show progress bar
            document.querySelector('.progress-container').style.display = 'block';

            xhr.open('POST', this.action, true);

            // Track upload progress
            xhr.upload.onprogress = function (e) {
                if (e.lengthComputable) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    document.getElementById('progressBar').style.width = percentComplete + '%';
                    document.getElementById('progressText').textContent = Math.round(percentComplete) + '% uploaded';
                }
            };

            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById('progressText').textContent = 'Upload complete!';
                    setTimeout(() => {
                        window.location.reload(); // Reload the page after a short delay
                    }, 2000);
                } else {
                    document.getElementById('progressText').textContent = 'Upload failed. Please try again.';
                }
            };

            xhr.send(formData); // Send the FormData object
        });

    </script>

</body>

</html>
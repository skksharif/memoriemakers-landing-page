<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./sub-pages.css">
    <link href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/css/lightgallery-bundle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/lightgallery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/css/lg-autoplay.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/autoplay/lg-autoplay.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/css/lg-fullscreen.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/css/lg-share.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/fullscreen/lg-fullscreen.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/share/lg-share.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/css/lg-thumbnail.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/thumbnail/lg-thumbnail.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Gallery</title>
</head>

<body>
    <center>
        <h1>Couple Shoot</h1>
    </center>
   
    <div class="slide-show">
        <div class="slideshow-container">
            <?php
            $dir = "../prabha-img/couple-shoot/";
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {
                    while (($file = readdir($dh)) !== false) {
                        if ($file != "." && $file != "..") {
                            echo "<div class='slide fade'>";
                            echo "<img src='$dir$file' alt='Image'>";
                            echo "</div>";
                        }
                    }
                    closedir($dh);
                }
            }
            ?>
        </div>
    </div>
    <center>
        <p>The chance to immortalize unforgettable moments and the magic of love is what drive me to do what I do. I
            chose The Best Indian wedding Candid photography because I love to lose myself among people and let my
            photos tell a thousand tales which the eye rarely catches.</p>
    </center>
    <div class="gallery">
        <?php
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                echo "<div id='customize-thumbnails-gallery' class='grid-wrapper'>";
                while (($file = readdir($dh)) !== false) {
                    if ($file != "." && $file != "..") {
                        echo "<a href='$dir$file'>";
                        echo "<img src='$dir$file' />";
                        echo "</a>";
                    }
                }
                echo "</div>";
                closedir($dh);
            }
        }
        ?>
    </div>

    <script type="text/javascript">
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let slides = document.getElementsByClassName("slide");
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) { slideIndex = 1 }
            slides[slideIndex - 1].style.display = "block";
            setTimeout(showSlides, 3000); // Change image every 3 seconds
        }

        lightGallery(document.getElementById('customize-thumbnails-gallery'), {
            controls: true,
            thumbnail: true,
            autoplay: true,
            download: true,
            fullScreen: true,
            counter: true,
            plugins: [lgAutoplay, lgFullscreen, lgShare]
        });
    </script>

</body>

</html>
        
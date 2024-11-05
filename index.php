<?php
include('connect.php');


?>

<HTML>
<HEAD>
    
<title>J88-MOVIE ดูหนังออนไลน์ ดูหนังใหม่ HD ที่นี่เลย</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/slide-movie.css"/>
<link rel="stylesheet" href="css/label.css"/>
</HEAD>
<BODY>

<?php include('nav.php'); ?>

<!-- Top Banner -->

<div class="banner position-relative">
     <div class="container d-flex flex-column align-items-center justify-content-center text-center position-relative">
        <h2 class="banner-warning title mb-2">ยินดีต้อนรับสู่ J88-MOVIE</h2>
        <p class="banner-warning subtitle">ดูหนังออนไลน์ หนังใหม่ HD ฟรี ไม่มีโฆษณา</p>
        <br>
    </div>
    
    <img src="banner/banmovie.jpg" alt="Banner Image" class="banner-image">
    <img src="img/01.jpg" alt="Movie Icon" class="position-absolute top-50 end-0 translate-middle-y opacity-50 icon-style">
    <img src="img/02.jpg" alt="Cinema Icon" class="position-absolute top-50 start-0 translate-middle-y opacity-50 icon-style">
</div>

<div class="container">
    <div class="row">
        <!-- Left Menu with Popular Movies -->
        <div class="col-md-3 left-menu">
            <h4>หมวดหมู่หนัง</h4>
            <a href="index.php?">หน้าแรก</a>
            <a href="พากย์ไทย.php?">พากย์ไทย</a>
            <a href="ซับไทย.php?">ซับไทย</a>     
    
        </div>
        

        <!-- Movies Grid -->
        <div class="col-md-9">
            <div class="movie-slider">
                <h3>อัพเดท 10 เรื่องล่าสุด</h3>
                <div class="slick-slider-1" style="width: 100%; height:fit-content;">
                    <?php
                    // ดึงข้อมูลหนังล่าสุด 10 เรื่อง
                    $latestMoviesQuery = mysqli_query($con, "SELECT * FROM data_movie WHERE category LIKE 'movie' ORDER BY id DESC LIMIT 10");

                    while ($result = mysqli_fetch_array($latestMoviesQuery)) {
                        // กำหนดคลาสป้ายตามค่าของ CF
                        $labelClass = '';
                        if ($result['CF'] == 'HD') {
                            $labelClass = 'hd';
                        } elseif ($result['CF'] == 'ZOOM') {
                            $labelClass = 'zoom';
                        } elseif ($result['CF'] == 'เร็วๆนี้') {
                            $labelClass = 'comingsoon';
                        }

                        // กำหนดป้ายกำกับพากย์ไทยและซับไทย
                        $dubbedLabel = '';
                        $subbedLabel = '';

                        if (strpos($result['sound'], 'พากย์ไทย') !== false) {
                            $dubbedLabel = '<span class="label-dubbed">พากย์ไทย</span>';
                        }
                        if (strpos($result['sound'], 'ซับไทย') !== false) {
                            $subbedLabel = '<span class="label-subbed">ซับไทย</span>';
                        }

                        echo '<div class="col-md-3">
                        <div class="card mb-4 shadow-sm position-relative" style="background-color: #3c576f;">
                            <a href="./play.php?id='.$result['id'].'" target="_blank">
                                <img src="'.$result['img'].'" class="card-img-top" alt="'.$result['name'].'">
                                <div class="movie-title-overlay">'.$result['name'].'</div> <!-- เพิ่มส่วนแสดงชื่อหนัง -->
                            </a>
                            <span class="label-hd '.$labelClass.'">'.$result['CF'].'</span>
                            '.$dubbedLabel.'
                            '.$subbedLabel.'
                        </div>
                    </div>';
                
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
        
<div class="col-md-12">
    <div class="movie-slider">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 style="margin-left:20px;">รายการหนัง</h3>
            <a href="all-movies.php" class="btn btn-gradient-movie">ดูทั้งหมด</a>
        </div>
        <div class="slick-slider-2"style= width:100%;height:fit-content;>
            <?php 
            // การตั้งค่าหนังทั้งหมด
            $limit = 40;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;

            $search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

            // สร้างคำสั่ง SQL ตามการค้นหา
            if (!empty($search)) {
                $query = mysqli_query($con, "SELECT * FROM data_movie WHERE name LIKE '%$search%' ORDER BY id DESC LIMIT $limit OFFSET $offset");
            } else {
                // คำสั่ง SQL สำหรับหนังทั้งหมด
                $query = mysqli_query($con, "SELECT * FROM data_movie WHERE category='movie' ORDER BY id DESC LIMIT $limit OFFSET $offset");
            }

            // แสดงผลลัพธ์การค้นหา
            while ($result = mysqli_fetch_array($query)) {
                $labelClass = '';
                if ($result['CF'] == 'HD') $labelClass = 'hd';
                elseif ($result['CF'] == 'ZOOM') $labelClass = 'zoom';
                elseif ($result['CF'] == 'เร็วๆนี้') $labelClass = 'comingsoon';

                // กำหนดป้ายกำกับพากย์ไทยและซับไทย
                $dubbedLabel = '';
                $subbedLabel = '';

                if (strpos($result['sound'], 'พากย์ไทย') !== false) {
                    $dubbedLabel = '<span class="label-dubbed">พากย์ไทย</span>';
                }
                if (strpos($result['sound'], 'ซับไทย') !== false) {
                    $subbedLabel = '<span class="label-subbed">ซับไทย</span>';
                }

                echo '<div class="col-md-3">
                <div class="card mb-4 shadow-sm position-relative" style="background-color: #3c576f;">
                    <a href="./play.php?id='.$result['id'].'" target="_blank">
                        <img src="'.$result['img'].'" class="card-img-top" alt="'.$result['name'].'">
                        <div class="movie-title-overlay">'.$result['name'].'</div> <!-- เพิ่มส่วนแสดงชื่อหนัง -->
                    </a>
                    <span class="label-hd '.$labelClass.'">'.$result['CF'].'</span>
                    '.$dubbedLabel.'
                    '.$subbedLabel.'
                </div>
            </div>';
            }
            ?>
        </div>
    </div>      
</div>                   
<div class="col-md-12">
    <!-- หมวดละคร - ซีรี่ย์ -->
    <div class="movie-slider">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 style="margin-left:20px;">ละคร - ซีรี่ย์</h3>
            <a href="all-series.php" class="btn btn-gradient-movie">ดูทั้งหมด</a>
        </div>
        <div class="slick-slider-3" style="width:100%; height:fit-content;">
            <?php 
            // ดึงข้อมูลละคร - ซีรี่ย์
            $seriesQuery = mysqli_query($con, "SELECT * FROM data_movie WHERE category='series' ORDER BY id DESC");

            // แสดงผลลัพธ์สำหรับละคร - ซีรี่ย์
            while ($result = mysqli_fetch_array($seriesQuery)) {
                $labelClass = '';
                if ($result['CF'] == 'HD') $labelClass = 'hd';
                elseif ($result['CF'] == 'ZOOM') $labelClass = 'zoom';
                elseif ($result['CF'] == 'เร็วๆนี้') $labelClass = 'comingsoon';

                // กำหนดป้ายกำกับพากย์ไทยและซับไทย
                $dubbedLabel = '';
                $subbedLabel = '';
                $seriesStatusLabel = ''; // กำหนดตัวแปรสำหรับสถานะซีรีย์

                if (strpos($result['sound'], 'พากย์ไทย') !== false) {
                    $dubbedLabel = '<span class="label-dubbed">พากย์ไทย</span>';
                }
                if (strpos($result['sound'], 'ซับไทย') !== false) {
                    $subbedLabel = '<span class="label-subbed">ซับไทย</span>';
                }

                // ตรวจสอบสถานะของซีรีย์และเพิ่มป้ายกำกับ
                if (isset($result['status']) && $result['status'] == 'จบแล้ว') {
                    $seriesStatusLabel = '<span class="label-status label-complete">จบแล้ว</span>';
                } elseif (isset($result['status']) && $result['status'] == 'ยังไม่จบ') {
                    $seriesStatusLabel = '<span class="label-status label-ongoing">ยังไม่จบ</span>';
                }

                // เปลี่ยนลิงค์ไปที่ episode.php โดยส่ง series_id แทน
                echo '<div class="col-md-3">
                <div class="card mb-4 shadow-sm position-relative" style="background-color: #3c576f;">
                    <a href="./episode.php?id='.$result['id'].'" target="_blank">
                        <img src="'.$result['img'].'" class="card-img-top" alt="'.$result['name'].'">
                        <div class="movie-title-overlay">'.$result['name'].'</div> <!-- เพิ่มส่วนแสดงชื่อหนัง -->
                    </a>
                    <span class="label-hd '.$labelClass.'">'.$result['CF'].'</span>
                    '.$dubbedLabel.'
                    '.$subbedLabel.'
                    '.$seriesStatusLabel.' <!-- เพิ่มป้ายกำกับสถานะซีรีย์ -->
                </div>
            </div>';
            }
            ?>
        </div>
    </div>
</div>

<div class="col-md-12">
    <!-- หมวดอนิเมะ -->
    <div class="movie-slider">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 style="margin-left:20px;">อนิเมะ</h3>
            <a href="all-series.php" class="btn btn-gradient-movie">ดูทั้งหมด</a>
        </div>
        <div class="slick-slider-3" style="width:100%; height:fit-content;">
            <?php 
            // ดึงข้อมูลอนิเมะ
            $animeQuery = mysqli_query($con, "SELECT * FROM data_movie WHERE category='anime' ORDER BY id DESC");

            // แสดงผลลัพธ์สำหรับอนิเมะ
            while ($result = mysqli_fetch_array($animeQuery)) {
                $labelClass = '';
                if ($result['CF'] == 'HD') $labelClass = 'hd';
                elseif ($result['CF'] == 'ZOOM') $labelClass = 'zoom';
                elseif ($result['CF'] == 'เร็วๆนี้') $labelClass = 'comingsoon';

                // กำหนดป้ายกำกับพากย์ไทยและซับไทย
                $dubbedLabel = '';
                $subbedLabel = '';
                $animeStatusLabel = ''; // กำหนดตัวแปรสำหรับสถานะอนิเมะ

                if (strpos($result['sound'], 'พากย์ไทย') !== false) {
                    $dubbedLabel = '<span class="label-dubbed">พากย์ไทย</span>';
                }
                if (strpos($result['sound'], 'ซับไทย') !== false) {
                    $subbedLabel = '<span class="label-subbed">ซับไทย</span>';
                }

                // ตรวจสอบสถานะของซีรีย์และเพิ่มป้ายกำกับ
                if (isset($result['status']) && $result['status'] == 'จบแล้ว') {
                    $animeStatusLabel = '<span class="label-status label-complete">จบแล้ว</span>';
                } elseif (isset($result['status']) && $result['status'] == 'ยังไม่จบ') {
                    $animeStatusLabel = '<span class="label-status label-ongoing">ยังไม่จบ</span>';
                }

                // เปลี่ยนลิงค์ไปที่ episode.php โดยส่ง series_id แทน
                echo '<div class="col-md-3">
                <div class="card mb-4 shadow-sm position-relative" style="background-color: #3c576f;">
                    <a href="./episode.php?id='.$result['id'].'" target="_blank">
                        <img src="'.$result['img'].'" class="card-img-top" alt="'.$result['name'].'">
                        <div class="movie-title-overlay">'.$result['name'].'</div> <!-- เพิ่มส่วนแสดงชื่อหนัง -->
                    </a>
                    <span class="label-hd '.$labelClass.'">'.$result['CF'].'</span>
                    '.$dubbedLabel.'
                    '.$subbedLabel.'
                    '.$animeStatusLabel.' <!-- เพิ่มป้ายกำกับสถานะอนิเมะ -->
                </div>
            </div>';
            }
            ?>
        </div>
    </div>
</div>

<script>
    
    function playEpisode(movieId, episodeNumber) {
    const episodeContent = document.getElementById('episodeContent');
    fetch(`play.php?id=${movieId}&episode=${episodeNumber}&ajax=true`) // เพิ่มพารามิเตอร์ ajax=true
        .then(response => response.text())
        .then(data => {
            episodeContent.innerHTML = data;
            new bootstrap.Modal(document.getElementById('playModal')).show();
        })
        .catch(error => console.error('Error loading episode:', error));
}

</script>
    
<?php include('footer.php'); ?>


</BODY>
</HTML>

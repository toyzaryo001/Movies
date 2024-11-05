<?php
include('connect.php');

?>

<HTML>
<HEAD>
<title>J88-MOVIE ดูหนังออนไลน์ ดูหนังใหม่ HD ที่นี่เลย</title>
<meta charset="UTF-8">
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

<div class="container-fluid">
    <div class="row">
        <!-- Left Menu with Popular Movies -->
        <div class="col-md-2 left-menu">
            <h4>หมวดหมู่หนัง</h4>
            <a href="index.php?">หน้าแรก</a>
            <a href="พากย์ไทย.php?">พากย์ไทย</a>
            <a href="ซับไทย.php?">ซับไทย</a>
        </div>

        <!-- Movies Grid -->
        <div class="col-md-10">
            <h3>หนังซับไทยทั้งหมด</h3>
            <div class="row">
                <?php 
                // การตั้งค่าหนังซับไทยทั้งหมด
                $limit = 30;
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                $search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

                // สร้างคำสั่ง SQL ตามการค้นหา
                if (!empty($search)) {
                    $query = mysqli_query($con, "SELECT * FROM data_movie WHERE name LIKE '%$search%' ORDER BY id DESC LIMIT $limit OFFSET $offset");
                } else 
                    // สร้างคำสั่ง SQL สำหรับหนังซับไทย
                    $query = mysqli_query($con, "SELECT * FROM data_movie WHERE sound LIKE '%ซับไทย%' AND category = 'movie' ORDER BY id DESC LIMIT $limit OFFSET $offset");

                // แสดงผลลัพธ์การค้นหา
                while ($result = mysqli_fetch_array($query)) {
                    $labelClass = '';
                    if ($result['CF'] == 'HD') $labelClass = 'hd';
                    elseif ($result['CF'] == 'ZOOM') $labelClass = 'zoom';
                    elseif ($result['CF'] == 'เร็วๆนี้') $labelClass = 'comingsoon';

                    // กำหนดป้ายกำกับซับไทย
                    $dubbedLabel = '';
                    $subbedLabel = '<span class="label-dubbed">'.$result['sound'].'</span>';
                
                    if (strpos($result['sound'], 'ซับไทย') !== false) {
                        $subbedLabel = '<span class="label-subbed">ซับไทย</span>';
                    }

                    echo '<div class="col-md-2 mb-4">
                            <div class="card shadow-sm position-relative" style="background-color: #3c576f;">
                                <a href="./play.php?id='.$result['id'].'" target="_blank">
                                    <img src="'.$result['img'].'" class="card-img-top" alt="'.$result['name'].'">
                                    <div class="movie-title-overlay">'.$result['name'].'</div>
                                </a>
                                <span class="label-hd '.$labelClass.'">'.$result['CF'].'</span>
                                '.$dubbedLabel.'
                                '.$subbedLabel.' <!-- แสดงป้ายกำกับซับไทยถ้ามี -->
                            </div>
                        </div>';

                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
// คำนวณจำนวนหนังทั้งหมด
$totalQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM data_movie");
$totalResult = mysqli_fetch_assoc($totalQuery);
$totalMovies = $totalResult['total'];

// คำนวณจำนวนหน้าทั้งหมด
$totalPages = ceil($totalMovies / $limit);

// แสดงลิงก์สำหรับเปลี่ยนหน้า
echo '<nav aria-label="Page navigation example">';
echo '<ul class="pagination justify-content-center">';

// ปุ่มก่อนหน้า
if ($page > 1) {
    echo '<li class="page-item"><a class="page-link" href="?page='.($page - 1).'">ก่อนหน้า</a></li>';
}

// ลิงก์เลขหน้า
for ($i = 1; $i <= $totalPages; $i++) {
    echo '<li class="page-item '.($page == $i ? 'active' : '').'">
        <a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
}

// ปุ่มถัดไป
if ($page < $totalPages) {
    echo '<li class="page-item"><a class="page-link" href="?page='.($page + 1).'">ถัดไป</a></li>';
}

echo '</ul>';
echo '</nav>';
?>

<?php
include('footer.php');

?>

</BODY>
</HTML>

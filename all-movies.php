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
            <h3>หนังทั้งหมด</h3> <!-- เปลี่ยนเป็น "หนังทั้งหมด" -->
            <div class="row">
            <?php
            // การตั้งค่าหนังทั้งหมด
            $limit = 30;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;

            // รับค่าการค้นหาจากผู้ใช้ (ถ้ามี)
            $search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

            // สร้างคำสั่ง SQL สำหรับหนังทั้งหมดพร้อมเงื่อนไขการค้นหา
            $sql = "SELECT * FROM data_movie WHERE category='movie' ";
            if (!empty($search)) {
                $sql .= "AND name LIKE '%$search%' ";
            }
            $sql .= "ORDER BY id DESC LIMIT $limit OFFSET $offset";
            $query = mysqli_query($con, $sql);

            // แสดงผลลัพธ์การค้นหา
            while ($result = mysqli_fetch_array($query)) {
                $labelClass = '';
                if ($result['CF'] == 'HD') $labelClass = 'hd';
                elseif ($result['CF'] == 'ZOOM') $labelClass = 'zoom';
                elseif ($result['CF'] == 'เร็วๆนี้') $labelClass = 'comingsoon';

                $dubbedLabel = (strpos($result['sound'], 'พากย์ไทย') !== false) ? '<span class="label-dubbed">พากย์ไทย</span>' : '';
                $subbedLabel = (strpos($result['sound'], 'ซับไทย') !== false) ? '<span class="label-subbed">ซับไทย</span>' : '';

                echo '<div class="col-md-2 mb-4">
                    <div class="card shadow-sm position-relative" style="background-color: #3c576f;">
                        <a href="./play.php?id='.$result['id'].'" target="_blank">
                            <img src="'.$result['img'].'" class="card-img-top" alt="'.$result['name'].'">
                            <div class="movie-title-overlay">'.$result['name'].'</div>
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




<!--Footer-->
<div class="container-fluid"style="background-color: #09151f;padding: 25px;margin-top: 0px;border-radius: 10px;border: 2px solid #3c576f;">
  <div class="movie-footer-content pt-4" s>
    <p style="color:#7898a9; font-weight: 300;"> 
      <a href="/">J88-MOVIE.COM</a> 
      คือเว็บไซต์ <strong>ดูหนังออนไลน์ 2024</strong> ที่พึ่งเปิดให้บริการ ในการดูหนังโรงภาพยนตร์ หนังชนโรง และ <em><u>หนังใหม่ ปี 2024</u></em> ภาพและเสียงชัด ซับไทย พากย์ไทย และ Soundtrack ที่สามารถรับชมได้ผ่านหลายอุปกรณ์ แบบไม่จำกัด ไม่ว่าจะเป็น การรับชมบนคอมพิวเตอร์ และบนมือถือ สมาร์ทโฟน Android, Iphone และอุปกรณ์อื่นๆ ให้เว็บไซต์ J88-MOVIE.COM เป็นอีกหนึ่งทางเลือกในการดูหนัง และนอกจากนี้เว็บไซต์ของเรานั้นยังมีตัวเล่นหนังที่ทันสมัย และอัพเดทใหม่ ทำให้การดูหนังเป็นไปด้วยความลื่นไหล อีกทั้ง ดูหนังออนไลน์ฟรี ที่เว็บของเรา นั้นยังสามารถเลือกรับชมได้ในระดับความละเอียดที่หลากหลาย ไม่ว่าจะเป็น มาสเตอร์ HD FHD UHD และ 4K แบบไม่เปลืองเน็ตอีกด้วย
    </p>
    <p style="color:#7898a9; font-weight: 300;"> <strong>ดูหนังฟรีออนไลน์</strong> ดูหนังใหม่ชนโรง 2024 หนังเข้าใหม่ชนโรง ดูฟรี ภาพชัด มาสเตอร์ HD ซับไทย พากย์ไทย Soundtrack บนเว็บหนังที่มีความทันสมัย J88-MOVIE.COM และรองรับการใช้งานบนอุปกรณ์หลากหลายขนาดหน้าจอ ไม่ว่าจะเป็นรับชมหนังผ่านคอมพิวเตอร์ และอุปกรณ์เคลื่อนที่อย่างสมาร์ทโฟน <strong>หนังออนไลน์ 2024</strong> และ ซีรี่ย์ออนไลน์ มีให้เลือกหลากหลาย ไม่ว่าจะเป็น หนังแอคชั่น ผจญภัย สารคดี หนังสยองขวัญ ตลกขบขัน รักโรแมนติก มิวสิคัล จากหลากหลายประเทศ ฝรั่ง จีน เกาหลี ไทย และนอกจากนี้ยังมีหนังจาก Netflix, Disney Plus, HBO, Prime Video และอื่นๆอีกมากมาย ติดตามหนังใหม่ อัพเดทก่อนใครๆ ได้ที่นี่ ดูหนังฟรี ไม่มีวันหยุด ตลอด 24 ชั่วโมง</p>
  </div>
</div>

<footer class="blog-footer text-center" style="background-color: #09151f;padding: 25px;margin-top: 0px;border-radius: 10px;border: 2px solid #3c576f;">
    <h3 style="color:white;">ดูหนังออนไลน์ฟรี ได้ที่นี่เลย <a href="#" style="color:gold;">J88-MOVIE</a></h3>
</footer>

</BODY>
</HTML>

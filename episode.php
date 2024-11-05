<?php
include('connect.php');

$id = @$_GET['id'];


$query = mysqli_query($con, "SELECT * FROM data_movie WHERE id = $id");
$result = mysqli_fetch_array($query);

$query_episode = mysqli_query($con, "SELECT * FROM data_episodes WHERE data_movie_id = $id");

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($result['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    <style>
        body {
            background-color: #000;
            color: #f1c40f; /* สีเหลือง */
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #222;
        }
        .synopsis-box {
            background-color: #333;
            padding: 25px;
            border-radius: 10px;
            border: 2px solid #f39c12; /* สีเหลือง */
            margin-bottom: 20px;
        }
        .player-box {
            border: 2px solid #f39c12; /* สีเหลือง */
            padding: 20px;
            border-radius: 10px;
            background-color: #222;
            margin-top: 20px;
        }
        footer {
            background-color: #222;
            color: #f1c40f; /* สีเหลือง */
            padding: 10px 0;
        }
        h4, h5 {
            color: #f39c12; /* สีเหลือง */
        }

        .movie-image-container {
            width: 305px;
            position: relative;
            overflow: hidden;
            padding: 10px;
            background-color: #222; /* พื้นหลังสีดำ */
            border: 4px solid #f1c40f; /* กรอบสีเหลือง */
            max-width: 100%;
            height: 455px; /* ตั้งค่าให้เท่ากับความสูงของ iframe */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .movie-image {
            border-radius: 8px;
            max-height: 100%; /* ให้ภาพมีความสูงสูงสุดเท่ากับ container */
            max-width: 100%;
            transition: transform 0.3s ease; /* เอฟเฟ็กต์สำหรับการเลื่อนเมาส์ */
            width: 280px;
        }

        .movie-image:hover {
            transform: scale(1.05); /* ขยายขนาดเมื่อเลื่อนเมาส์ */
        }

        .video-frame-container {
            padding: 10px;
            background-color: #222; /* พื้นหลังสีดำ */
            border: 4px solid #f1c40f; /* กรอบสีเหลือง */
            border-radius: 8px;
            height:auto;
        }


    </style>
</head>
<body>

<!-- Navbar -->
<?php include('nav.php'); ?>


<!-- Movie Information and Player -->
<div class="container mt-4"> 
    <div class="row">
        <!-- ขยายคอลัมน์ของรูปภาพเป็น col-md-5 -->
        <div class="col-md-4 d-flex justify-content-center">
            <div class="movie-image-container">
                <img src="<?=$result['img'] ?>" class="img-fluid rounded movie-image" alt="<?=$result['name'] ?>">
            </div>
        </div>
        <div class="col-md-8">
            <div class="video-frame-container">
                <iframe width="100%" height="420" src="https://www.youtube.com/embed/<?=$result['vdo_ex'] ?>" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>  
    </div><br>
    <div class="synopsis-box">
        <h4>เรื่องย่อ - <?=$result['name'] ?></h4>
        <p><?=$result['tt']?></p>
    </div>
    <div class="synopsis-box">
        <h4>เลือกตอน</h4>
        <div class="list-group">
        <?php
            while($result_episode = mysqli_fetch_array($query_episode)) {
                echo '<a href="play.php?id='.$id.'&episode='.$result_episode['episode_number'].'" target="_blank "class="list-group-item list-group-item-action list-group-item-warning">'.$result_episode['episode_name'].' ตอนที่ '.$result_episode['episode_number'].'</a>';
            }
        ?>
        </div>
    </div>
</div>

 
<!--Footer-->

<div class="container">
  <div class="movie-footer-content pt-4" s>
    <p style="color:#7898a9; font-weight: 300;"> 
      <a href="/">J88-MOVIE.COM</a> 
      คือเว็บไซต์ <strong>ดูหนังออนไลน์ 2024</strong> ที่พึ่งเปิดให้บริการ ในการดูหนังโรงภาพยนตร์ หนังชนโรง และ <em><u>หนังใหม่ ปี 2024</u></em> ภาพและเสียงชัด ซับไทย พากย์ไทย และ Soundtrack ที่สามารถรับชมได้ผ่านหลายอุปกรณ์ แบบไม่จำกัด ไม่ว่าจะเป็น การรับชมบนคอมพิวเตอร์ และบนมือถือ สมาร์ทโฟน Android, Iphone และอุปกรณ์อื่นๆ ให้เว็บไซต์ J88-MOVIE.COM เป็นอีกหนึ่งทางเลือกในการดูหนัง และนอกจากนี้เว็บไซต์ของเรานั้นยังมีตัวเล่นหนังที่ทันสมัย และอัพเดทใหม่ ทำให้การดูหนังเป็นไปด้วยความลื่นไหล อีกทั้ง ดูหนังออนไลน์ฟรี ที่เว็บของเรา นั้นยังสามารถเลือกรับชมได้ในระดับความละเอียดที่หลากหลาย ไม่ว่าจะเป็น มาสเตอร์ HD FHD UHD และ 4K แบบไม่เปลืองเน็ตอีกด้วย
    </p>
    <p style="color:#7898a9; font-weight: 300;"> <strong>ดูหนังฟรีออนไลน์</strong> ดูหนังใหม่ชนโรง 2024 หนังเข้าใหม่ชนโรง ดูฟรี ภาพชัด มาสเตอร์ HD ซับไทย พากย์ไทย Soundtrack บนเว็บหนังที่มีความทันสมัย J88-MOVIE.COM และรองรับการใช้งานบนอุปกรณ์หลากหลายขนาดหน้าจอ ไม่ว่าจะเป็นรับชมหนังผ่านคอมพิวเตอร์ และอุปกรณ์เคลื่อนที่อย่างสมาร์ทโฟน <strong>หนังออนไลน์ 2024</strong> และ ซีรี่ย์ออนไลน์ มีให้เลือกหลากหลาย ไม่ว่าจะเป็น หนังแอคชั่น ผจญภัย สารคดี หนังสยองขวัญ ตลกขบขัน รักโรแมนติก มิวสิคัล จากหลากหลายประเทศ ฝรั่ง จีน เกาหลี ไทย และนอกจากนี้ยังมีหนังจาก Netflix, Disney Plus, HBO, Prime Video และอื่นๆอีกมากมาย ติดตามหนังใหม่ อัพเดทก่อนใครๆ ได้ที่นี่ ดูหนังฟรี ไม่มีวันหยุด ตลอด 24 ชั่วโมง</p>
  </div>
</div>

<footer class="blog-footer text-center" style="background-color: #09151f;">
    <h3 style="color:white;">ดูหนังออนไลน์ฟรี ได้ที่นี่เลย <a href="#" style="color:gold;">J88-MOVIE</a></h3>
</footer>
<!--End Footer-->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

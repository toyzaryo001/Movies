<?php
include('connect.php');


$id = @$_GET['id'];
$episode = @$_GET['episode']; // เปลี่ยนให้ดึงค่าจาก 'episode' แทน

// ตรวจสอบว่าเป็นการเข้าถึงหนังหรือ episode
if (!$episode) {
    // ดึงข้อมูลจากตาราง data_movie
    $query = mysqli_query($con, "SELECT * FROM data_movie WHERE id = $id");
    $result = mysqli_fetch_array($query);
    $is_movie = true;
    $video_url = !empty($result['vdo_thai']) ? $result['vdo_thai'] : $result['vdo_sub'];
    $title = "J88-MOVIE - " . (isset($result['name']) ? htmlspecialchars($result['name']) : "ไม่พบชื่อ");
} else {
    // ดึงข้อมูลจากตาราง data_episodes สำหรับ episode
    $query = mysqli_query($con, "SELECT * FROM data_episodes WHERE data_movie_id = $id AND episode_number = $episode");
    $result = mysqli_fetch_array($query);
    $is_movie = false;
    $video_url = isset($result['vdo_url']) ? $result['vdo_url'] : '';  // ตรวจสอบว่ามีค่านี้หรือไม่
    $title =  (isset($result['episode_name']) ? htmlspecialchars($result['episode_name']) : "ไม่พบชื่อ") . " - ตอนที่ " . htmlspecialchars($episode);
    
    // ตรวจสอบตอนสุดท้ายของซีรีส์นี้
    $last_episode_query = mysqli_query($con, "SELECT MAX(episode_number) as last_episode FROM data_episodes WHERE data_movie_id = $id");
    $last_episode_result = mysqli_fetch_array($last_episode_query);
    $last_episode = $last_episode_result['last_episode'];
}



?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
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

        .episode-slider .episode-slide {
            padding: 5px;
        }

    </style>
</head>
<body>

<!-- Navbar -->
<?php include('nav.php'); ?>



<!-- Movie or Episode Information -->
<div class="container mt-4">
    <?php if ($is_movie): ?>
            <!-- Display for Movie -->            
        <div class="row">
            <!-- Movie Information -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="movie-image-container">
                    <img src="<?=$result['img'] ?>" class="img-fluid rounded movie-image" alt="<?=$result['name'] ?>">
                </div>
            </div>
            <div class="col-md-8">
                <div  div class="video-frame-container">
                    <iframe width="100%" height="420" src="https://www.youtube.com/embed/<?=$result['vdo_ex'] ?>" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>  
        </div><br>
        <div class="synopsis-box">
            <h4>เรื่องย่อ - <?= htmlspecialchars($result['name']) ?></h4>
            <p><?= !empty($result['tt']) ? nl2br(htmlspecialchars($result['tt'])) : 'ไม่มีข้อมูลเรื่องย่อ' ?></p>
        </div>
    <?php else: ?>
        <!-- Display for Series Episode -->
        <h4><?= htmlspecialchars($result['episode_name']) ?> - ตอนที่ <?= htmlspecialchars($episode) ?></h4>
    <?php endif; ?>
</div>

<!-- Player Box -->
<div class="container">
    <div class="player-box">
        <h3>Player</h3>
        
        <!-- ปุ่มเลือกภาษา -->
        <div class="btn-group mb-3" role="group">
            <?php if ($is_movie): ?>
                <!-- Movie language selection buttons -->
                <?php if (!empty($result['vdo_thai'])): ?>
                    <button class="btn btn-outline-warning" onclick="switchPlayer('thai')">พากย์ไทย</button>
                <?php endif; ?>
                <?php if (!empty($result['vdo_sub'])): ?>
                    <button class="btn btn-outline-warning" onclick="switchPlayer('sub')">ซับไทย</button>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <!-- Iframe สำหรับเล่นวิดีโอ -->
        <iframe id="movie-player" width="100%" height="600" src="https://short.ink/<?= htmlspecialchars($video_url) ?>" frameborder="0" allowfullscreen></iframe>

        <!-- ปุ่มเลือกตอนสำหรับซีรีส์ -->
        <?php if (!$is_movie): ?>
            <div class="d-flex justify-content-between mt-3">
                
                <!-- ปุ่มตอนก่อนหน้า -->
                <a href="play.php?id=<?= $id ?>&episode=<?= max(1, $episode - 1) ?>" class="btn btn-outline-warning">ตอนก่อนหน้า</a>

                <!-- ปุ่มตอนถัดไป (แสดงเฉพาะเมื่อไม่ใช่ตอนสุดท้าย) -->
                <?php if ($episode < $last_episode): ?>
                    <a href="play.php?id=<?= $id ?>&episode=<?= $episode + 1 ?>" class="btn btn-outline-warning">ตอนต่อไป</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- Bottom เลือกตอน -->
<?php if (!$is_movie): ?>
    <div class="container mt-4">
        <h4>เลือกตอนทั้งหมด</h4>
        <div class="episode-slider">
            <?php
            // ดึงรายชื่อตอนทั้งหมดของซีรีส์จากฐานข้อมูล
            $episodes_query = mysqli_query($con, "SELECT episode_number, episode_name FROM data_episodes WHERE data_movie_id = $id ORDER BY episode_number");
            while ($episode_row = mysqli_fetch_assoc($episodes_query)):
            ?>
                <div class="episode-slide">
                    <a href="play.php?id=<?= $id ?>&episode=<?= $episode_row['episode_number'] ?>" class="btn btn-outline-warning w-100">
                        ตอนที่ <?= htmlspecialchars($episode_row['episode_number']) ?>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>

        <script>
        function switchPlayer(type) {
            var player = document.getElementById('movie-player');
            <?php if ($is_movie): ?>
                // Movie player selection
                if (type === 'thai') {
                    player.src = "https://short.ink/<?= htmlspecialchars($result['vdo_thai']) ?>";
                } else if (type === 'sub') {
                    player.src = "https://short.ink/<?= htmlspecialchars($result['vdo_sub']) ?>";
                }
            <?php else: ?>
                // Series episode
                if (type === 'episode') {
                    player.src = "https://short.ink/<?= htmlspecialchars($video_url) ?>";
                }
            <?php endif; ?>
        }
        </script>



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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

 <!-- เริ่มใช้งาน Slick Carousel -->
 <script>
        $(document).ready(function(){
            $('.episode-slider').slick({
                slidesToShow: 5,    // แสดงตอนละ 4 ปุ่ม
                slidesToScroll: 5,
                arrows: true,       // เปิดปุ่มลูกศร
                infinite: false,    // ไม่วนซ้ำ
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });
    </script>

</body>
</html>

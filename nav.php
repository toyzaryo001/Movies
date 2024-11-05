<?php
include('connect.php');
?>

<!-- Navbar -->
<nav class="navbar bg-primary" style="background-color: black !important; margin-top:10px; margin-left:25px;">
    <a class="navbar-brand" href="movie.php">
        <img src="banner/LOGO.png" alt="J88-MOVIE Logo" class="logo">
    </a>
    <div class="d-flex">
        <!-- เงื่อนไขในการแสดงปุ่มหน้าแรก -->
        <?php if (basename($_SERVER['PHP_SELF']) === 'episode.php' || basename($_SERVER['PHP_SELF']) === 'play.php'): ?>
            <a href="index.php" class="btn btn-outline-light me-2" style="color:white; border: 1px solid gold; border-radius: 30px; padding: 8px 15px;">
                หน้าแรก
            </a>
        <?php endif; ?>

        <?php if (basename($_SERVER['PHP_SELF']) !== 'episode.php' && basename($_SERVER['PHP_SELF']) !== 'play.php'): ?>
            <form class="d-flex" role="search" method="GET" action="" style="margin-right: 25px;">
                <input class="form-control me-2" type="search" name="search" placeholder="ค้นหาหนัง" aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <input type="hidden" name="page" value="1">
                <button class="btn btn-outline-success" type="submit" style="color:white;">ค้นหา</button>              
            </form>   
        <?php endif; ?>

        <button type="button" class="btn btn-request-nav mx-2" data-bs-toggle="modal" data-bs-target="#requestModal" style="border: 1px solid gold; border-radius: 30px; padding: 8px 15px; background-color: #333;">
            ขอหนังฟรี
        </button>
        <button type="button" class="btn btn-contact-nav mx-2" data-bs-toggle="modal" data-bs-target="#contactModal" style="border: 1px solid gold; border-radius: 30px; padding: 8px 15px; background: linear-gradient(45deg, #333, #555); color: white;">
            ติดต่อเรา
        </button>
    </div>
</nav>

<!-- Modal ขอหนัง -->
<div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; background-color: #333;">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" id="requestModalLabel" style="color: #ffc107; font-weight: bold;">ขอหนังฟรีง่ายๆ</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #fff; background-color: #ffc107; border-radius: 50%;"></button>
            </div>
            <div class="modal-body" style="color: #fff;">
                <form id="requestForm">
                    <div class="mb-3">
                        <label for="movieName" class="form-label" style="color: #ffc107;">แจ้งชื่อหนัง (ภาษาไทย หรือ ภาษาอังกฤษ)</label>
                        <input type="text" class="form-control" id="movieName" name="movieName" required style="background-color: #444; border: none; color: #fff;">
                    </div>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label" style="color: #ffc107;">เบอร์โทร (เมื่อหนังที่ขอไว้ได้อัปโหลดลงเว็บ)</label>
                        <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" required style="background-color: #444; border: none; color: #fff;">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: none;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #444; color: #fff; border: none; border-radius: 20px;">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="submitRequest()" style="background-color: #ffc107; color: #333; border: none; border-radius: 20px;">ส่งคำขอ</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* ตั้งค่าเริ่มต้นของโลโก้ */
    .logo {
        height: 50px;
        border: 1px solid gold;
        border-radius: 35px;
        padding: 5px;
        background-color: #333;
        transition: transform 0.3s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    /* เพิ่มเอฟเฟกต์ขยายและประกายเมื่อชี้เมาส์ */
    .logo:hover {
        transform: scale(1.1); /* ขยายเล็กน้อยเมื่อชี้เมาส์ */
        box-shadow: 0 0 10px gold, 0 0 20px gold;
        animation: sparkle 1.5s infinite ease-in-out;

    }

    .btn-outline-light {
        box-shadow: 0 0 10px gold, 0 0 20px gold;
        animation: sparkle 1.5s infinite ease-in-out;
    }

    .btn-request-nav {
        box-shadow: 0 0 10px gold, 0 0 20px gold;
        animation: sparkle 1.5s infinite ease-in-out;
    }

    .btn-contact-nav {
        box-shadow: 0 0 10px gold, 0 0 20px gold;
        animation: sparkle 1.5s infinite ease-in-out;
    }

    /* เอฟเฟกต์ประกายแวววาว */
    @keyframes sparkle {
        0% {
            box-shadow: 0 0 10px gold, 0 0 20px gold;
        }
        50% {
            box-shadow: 0 0 15px gold, 0 0 30px yellow;
        }
        100% {
            box-shadow: 0 0 10px gold, 0 0 20px gold;
        }
    }

    /* Custom modal styles */
    .modal-content {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    .modal-header h5 {
        font-family: 'Prompt', sans-serif;
        font-size: 1.25rem;
    }
    .modal-body label {
        font-weight: bold;
    }
    .modal-footer button {
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }
    .modal-footer button:hover {
        background-color: #555;
    }

    /* ปุ่มขอหนังและปุ่มติดต่อเรา */
    .btn-request-nav, .btn-contact-nav {
        transition: all 0.3s ease-in-out;
        font-weight: bold;
        text-transform: uppercase;
        color: gold;
    }

    .btn-request-nav:hover, .btn-contact-nav:hover {
        background-color: #444;
        color: #ffd700;
        border-color: #ffd700;
        transform: translateY(-3px);
        box-shadow: 0px 4px 15px rgba(255, 215, 0, 0.5);
    }

    /* ปุ่มติดต่อเราที่มีการไล่สี */
    .btn-contact-nav {
        background: linear-gradient(45deg, #222, #666);
        color: #ffd700;
        border: 1px solid #ffd700;
    }
</style>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

<script>
    // สไลด์หนัง
    $(document).ready(function(){
        $('.slick-slider-1').slick({
            autoplay: true,
            autoplaySpeed: 3000, // ตั้งเวลาให้เลื่อนได้ต่อเนื่อง (2 วินาที)
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: 5,
            slidesToScroll: 1, // เลื่อนไปทีละหนึ่งสไลด์
            cssEase: 'linear', // ใช้การเลื่อนแบบต่อเนื่อง
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    });

    $(document).ready(function(){
        $('.slick-slider-2').slick({
            autoplay: true,
            autoplaySpeed: 3000, // ตั้งเวลาให้เลื่อนได้ต่อเนื่อง (2 วินาที)
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: 8,
            slidesToScroll: 2, // เลื่อนไปทีละหนึ่งสไลด์
            cssEase: 'linear', // ใช้การเลื่อนแบบต่อเนื่อง
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    });

    $(document).ready(function(){
        $('.slick-slider-3').slick({
            autoplay: true,
            autoplaySpeed: 2000, // ตั้งเวลาให้เลื่อนได้ต่อเนื่อง (2 วินาที)
            dots: true,
            infinite: true,
            speed: 10000,
            slidesToShow: 8,
            slidesToScroll: 1, // เลื่อนไปทีละหนึ่งสไลด์
            cssEase: 'linear', // ใช้การเลื่อนแบบต่อเนื่อง
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    });

    // เกี่ยวกับขอหนัง
    function submitRequest() {
        const movieName = document.getElementById('movieName').value;
        const phoneNumber = document.getElementById('phoneNumber').value;

        if (movieName && phoneNumber) {
            $.ajax({
                type: "POST",
                url: "request_movie.php",
                data: { movieName: movieName, phoneNumber: phoneNumber },
                success: function(response) {
                    alert(response);
                    const modal = bootstrap.Modal.getInstance(document.getElementById('requestModal'));
                    modal.hide();
                    document.getElementById('requestForm').reset();
                },
                error: function() {
                    alert('เกิดข้อผิดพลาดในการส่งคำขอ');
                }
            });
        } else {
            alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        }
    }
</script>

<!--End navbar-->

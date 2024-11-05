<?php
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movieName = mysqli_real_escape_string($con, $_POST['movieName']);
    $phoneNumber = mysqli_real_escape_string($con, $_POST['phoneNumber']);

    // บันทึกคำขอหนังลงฐานข้อมูล
    $query = "INSERT INTO movie_requests (movie_name, phone_number) VALUES ('$movieName', '$phoneNumber')";
    if (mysqli_query($con, $query)) {
        echo "คำขอหนังของคุณได้รับการส่งเรียบร้อยแล้ว!";
    } else {
        echo "เกิดข้อผิดพลาด: " . mysqli_error($con);
    }
}
?>

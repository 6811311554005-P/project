<?php
// 1. ดึงไฟล์เชื่อมต่อฐานข้อมูลมาใช้
include 'connect.php'; 

// 2. เช็คว่ามีการส่งข้อมูลแบบ POST มาจริงไหม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. รับค่าจากฟอร์มมาเก็บไว้ในตัวแปร (ชื่อใน [' '] ต้องตรงกับ name ใน input ของหน้า add_employee)
    $position    = $_POST['position'];
    $first_name  = $_POST['first_name'];
    $last_name   = $_POST['last_name'];
    $phone       = $_POST['phone'];
    $edu_level   = $_POST['edu_level'];

    // 4. แสดงผลเพื่อทดสอบ (ขั้นตอนนี้สำคัญมาก เพื่อดูว่าข้อมูลมาครบไหม)
    echo "<h3>--- ทดสอบการรับข้อมูล ---</h3>";
    echo "<b>ชื่อ-นามสกุล:</b> " . $first_name . " " . $last_name . "<br>";
    echo "<b>ตำแหน่งที่สมัคร:</b> " . $position . "<br>";
    echo "<b>เบอร์โทรศัพท์:</b> " . $phone . "<br>";
    echo "<b>วุฒิการศึกษา:</b> " . $edu_level . "<br>";
    echo "<hr>";
    echo "<p style='color: green;'>ถ้าเห็นข้อมูลถูกต้อง แสดงว่าเราพร้อมเขียนคำสั่งบันทึกลง Database แล้วครับ!</p>";
    echo "<a href='add_employee.php'>กลับหน้าฟอร์ม</a>";

} else {
    // ถ้าใครแอบเข้าไฟล์นี้โดยไม่ผ่านการกดปุ่มบันทึก ให้เด้งกลับหน้าฟอร์ม
    header("location: add_employee.php");
    exit;
}
?>
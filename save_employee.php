<?php
include 'connect.php'; // ดึงไฟล์เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. รับค่าจากฟอร์มทั้งหมด (ใช้ mysqli_real_escape_string เพื่อป้องกัน Error ถ้าเผลอพิมพ์เครื่องหมาย ')
    $prefix = mysqli_real_escape_string($conn, $_POST['prefix']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $id_card = mysqli_real_escape_string($conn, $_POST['id_card']);
    $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
    $age = !empty($_POST['age']) ? $_POST['age'] : 'NULL'; // ถ้าไม่ได้ใส่อายุ ให้เป็นค่าว่างในระบบ
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    $marital_status = mysqli_real_escape_string($conn, $_POST['marital_status']);
    $ethnicity = mysqli_real_escape_string($conn, $_POST['ethnicity']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $religion = mysqli_real_escape_string($conn, $_POST['religion']);
    
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $line_id = mysqli_real_escape_string($conn, $_POST['line_id']);
    
    $edu_apply = mysqli_real_escape_string($conn, $_POST['edu_apply']);
    $edu_highest = mysqli_real_escape_string($conn, $_POST['edu_highest']);
    
    $last_company = mysqli_real_escape_string($conn, $_POST['last_company']);
    $last_position = mysqli_real_escape_string($conn, $_POST['last_position']);
    $last_salary = !empty($_POST['last_salary']) ? $_POST['last_salary'] : 'NULL';
    $reason_leaving = mysqli_real_escape_string($conn, $_POST['reason_leaving']);
    $experience_benefit = mysqli_real_escape_string($conn, $_POST['experience_benefit']);
    
    $ref_name = mysqli_real_escape_string($conn, $_POST['ref_name']);
    $ref_workplace = mysqli_real_escape_string($conn, $_POST['ref_workplace']);
    $ref_phone = mysqli_real_escape_string($conn, $_POST['ref_phone']);
    $ref_relation = mysqli_real_escape_string($conn, $_POST['ref_relation']);

    // 2. จัดการเรื่องอัปโหลดรูปภาพ
    $photo_name = "";
    if (isset($_FILES['emp_photo']) && $_FILES['emp_photo']['error'] == 0) {
        $ext = pathinfo($_FILES['emp_photo']['name'], PATHINFO_EXTENSION);
        $photo_name = "emp_" . time() . "." . $ext; // เปลี่ยนชื่อไฟล์ไม่ให้ซ้ำกัน (เช่น emp_1710839201.jpg)
        $upload_path = "uploads/" . $photo_name;
        move_uploaded_file($_FILES['emp_photo']['tmp_name'], $upload_path); // ย้ายไฟล์ไปเก็บในโฟลเดอร์ uploads
    }

    // 3. คำสั่ง SQL สำหรับบันทึกข้อมูล (INSERT)
    $sql = "INSERT INTO employees (
        emp_photo, prefix, full_name, id_card, birth_date, age, address, 
        marital_status, ethnicity, nationality, religion, phone, email, line_id, 
        edu_apply, edu_highest, last_company, last_position, last_salary, 
        reason_leaving, experience_benefit, ref_name, ref_workplace, ref_phone, ref_relation
    ) VALUES (
        '$photo_name', '$prefix', '$full_name', '$id_card', '$birth_date', $age, '$address',
        '$marital_status', '$ethnicity', '$nationality', '$religion', '$phone', '$email', '$line_id',
        '$edu_apply', '$edu_highest', '$last_company', '$last_position', $last_salary,
        '$reason_leaving', '$experience_benefit', '$ref_name', '$ref_workplace', '$ref_phone', '$ref_relation'
    )";

    // 4. สั่งให้ SQL ทำงาน และเช็คผลลัพธ์
    if (mysqli_query($conn, $sql)) {
        // ถ้าสำเร็จ ให้เด้งข้อความและกลับไปหน้า Dashboard
        echo "<script>
                alert('บันทึกข้อมูลใบสมัครสำเร็จ!'); 
                window.location='dashboard.php';
              </script>";
    } else {
        // ถ้า Error (เช่น ลืมสร้างตาราง หรือชื่อคอลัมน์ผิด) ให้แสดงข้อความสีแดง
        echo "<div style='color:red; padding:20px;'>
                <b>เกิดข้อผิดพลาดในการบันทึกข้อมูล:</b><br>" . mysqli_error($conn) . "<br><br>
                <b>คำสั่ง SQL ที่มีปัญหา:</b><br>" . $sql . "
              </div>";
    }
}
?>
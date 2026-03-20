<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_id = $_POST['emp_id'];
    $prefix = $_POST['prefix'];
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $name_arr = explode(" ", $full_name, 2);
    $first_name = $name_arr[0];
    $last_name = isset($name_arr[1]) ? $name_arr[1] : "";
    
    $id_card = $_POST['id_card'];
    $edu_highest = $_POST['edu_highest'];
    $last_position = $_POST['last_position'];

    // จัดการรูปภาพ (ถ้ามีการอัปโหลดใหม่)
    if (isset($_FILES['emp_photo']) && $_FILES['emp_photo']['error'] == 0) {
        $photo_name = "emp_" . time() . "_" . $_FILES['emp_photo']['name'];
        move_uploaded_file($_FILES['emp_photo']['tmp_name'], "uploads/" . $photo_name);
        // ลบรูปเก่าทิ้ง (ถ้ามี)
        if (!empty($_POST['old_photo']) && file_exists("uploads/" . $_POST['old_photo'])) {
            unlink("uploads/" . $_POST['old_photo']);
        }
    } else {
        $photo_name = $_POST['old_photo']; // ใช้รูปเดิม
    }

    // อัปเดตตารางหลัก
    $sql1 = "UPDATE employees SET 
             prefix = '$prefix', 
             first_name = '$first_name', 
             last_name = '$last_name', 
             id_card = '$id_card', 
             photo = '$photo_name' 
             WHERE emp_id = '$emp_id'";

    if (mysqli_query($conn, $sql1)) {
        // อัปเดตตารางรอง
        mysqli_query($conn, "UPDATE education SET degree_level = '$edu_highest' WHERE emp_id = '$emp_id'");
        mysqli_query($conn, "UPDATE work_experience SET position = '$last_position' WHERE emp_id = '$emp_id'");

        echo "<script>alert('แก้ไขข้อมูลเรียบร้อย!'); window.location='view_employees.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
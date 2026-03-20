<?php
include 'connect.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $emp_id = mysqli_real_escape_string($conn, $_GET['id']);

    // --- 1. ค้นหาชื่อไฟล์รูปภาพก่อนลบข้อมูลจากฐานข้อมูล ---
    $sql_img = "SELECT photo FROM employees WHERE emp_id = '$emp_id'";
    $res_img = mysqli_query($conn, $sql_img);
    $data_img = mysqli_fetch_assoc($res_img);
    $photo_name = $data_img['photo'];

    // --- 2. เริ่มต้น Transaction เพื่อความปลอดภัย ---
    mysqli_begin_transaction($conn);

    try {
        // ลบข้อมูลจากตารางย่อยที่มี Foreign Key เชื่อมอยู่ก่อน
        mysqli_query($conn, "DELETE FROM education WHERE emp_id = '$emp_id'");
        mysqli_query($conn, "DELETE FROM work_experience WHERE emp_id = '$emp_id'");
        mysqli_query($conn, "DELETE FROM employee_references WHERE emp_id = '$emp_id'");

        // ลบข้อมูลจากตารางหลัก
        $delete_main = mysqli_query($conn, "DELETE FROM employees WHERE emp_id = '$emp_id'");

        if ($delete_main) {
            // --- 3. ลบไฟล์รูปภาพออกจากโฟลเดอร์ (ถ้ามีรูป) ---
            if (!empty($photo_name) && file_exists("uploads/" . $photo_name)) {
                unlink("uploads/" . $photo_name);
            }

            mysqli_commit($conn);
            echo "<script>alert('ลบข้อมูลพนักงานและรูปถ่ายเรียบร้อยแล้ว'); window.location='view_employees.php';</script>";
        } else {
            throw new Exception("ไม่สามารถลบข้อมูลหลักได้");
        }

    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาด ให้ยกเลิกการกระทำทั้งหมด (Rollback)
        mysqli_rollback($conn);
        echo "<script>alert('เกิดข้อผิดพลาด: " . $e->getMessage() . "'); window.location='view_employees.php';</script>";
    }
} else {
    echo "<script>alert('รหัสพนักงานไม่ถูกต้อง'); window.location='view_employees.php';</script>";
}
?>
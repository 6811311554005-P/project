<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $emp_id = mysqli_real_escape_string($conn, $_GET['id']);

    // เริ่มต้น Transaction เพื่อความปลอดภัย (ลบต้องลบให้ครบทุกตาราง)
    mysqli_begin_transaction($conn);

    try {
        // 1. ลบจากตารางย่อยก่อน (Foreign Keys)
        mysqli_query($conn, "DELETE FROM education WHERE emp_id = '$emp_id'");
        mysqli_query($conn, "DELETE FROM work_experience WHERE emp_id = '$emp_id'");
        mysqli_query($conn, "DELETE FROM employee_references WHERE emp_id = '$emp_id'");

        // 2. ลบจากตารางหลัก
        mysqli_query($conn, "DELETE FROM employees WHERE emp_id = '$emp_id'");

        // บันทึกการลบ
        mysqli_commit($conn);
        echo "<script>alert('ลบข้อมูลเรียบร้อยแล้ว'); window.location='view_employees.php';</script>";
    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาดให้ยกเลิกการลบทั้งหมด
        mysqli_rollback($conn);
        echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล'); window.location='view_employees.php';</script>";
    }
}
?>
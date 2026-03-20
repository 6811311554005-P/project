<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // --- 1. จัดการอัปโหลดรูปภาพ ---
    $photo_name = "";
    if (isset($_FILES['emp_photo']) && $_FILES['emp_photo']['error'] == 0) {
        $ext = pathinfo($_FILES['emp_photo']['name'], PATHINFO_EXTENSION);
        $photo_name = "emp_" . time() . "." . $ext;
        if (!is_dir('uploads')) { mkdir('uploads', 0777, true); } // สร้างโฟลเดอร์ถ้าไม่มี
        move_uploaded_file($_FILES['emp_photo']['tmp_name'], "uploads/" . $photo_name);
    }

    // --- 2. รับค่าข้อมูลส่วนตัว (ตาราง employees) ---
    $prefix = mysqli_real_escape_string($conn, $_POST['prefix']);
    // แยกชื่อ-นามสกุล จาก input "full_name"
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $name_arr = explode(" ", $full_name, 2);
    $first_name = $name_arr[0];
    $last_name = isset($name_arr[1]) ? $name_arr[1] : "";

    $id_card = mysqli_real_escape_string($conn, $_POST['id_card']);
    $birth_date = $_POST['birth_date'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $line_id = mysqli_real_escape_string($conn, $_POST['line_id']);

    // บันทึกลงตาราง employees
    $sql1 = "INSERT INTO employees (prefix, first_name, last_name, id_card, birth_date, address, phone, email, line_id, photo) 
             VALUES ('$prefix', '$first_name', '$last_name', '$id_card', '$birth_date', '$address', '$phone', '$email', '$line_id', '$photo_name')";

    if (mysqli_query($conn, $sql1)) {
        $emp_id = mysqli_insert_id($conn); // ดึง ID ของพนักงานที่เพิ่งสร้าง

        // --- 3. บันทึกประวัติการศึกษา (ตาราง education) ---
        $degree_level = mysqli_real_escape_string($conn, $_POST['edu_highest']); // วุฒิสูงสุด
        $sql2 = "INSERT INTO education (emp_id, degree_level) VALUES ('$emp_id', '$degree_level')";
        mysqli_query($conn, $sql2);

        // --- 4. บันทึกประสบการณ์ทำงาน (ตาราง work_experience) ---
        $company = mysqli_real_escape_string($conn, $_POST['last_company']);
        $position = mysqli_real_escape_string($conn, $_POST['last_position']);
        $salary = !empty($_POST['last_salary']) ? $_POST['last_salary'] : 0;
        $exit_reason = mysqli_real_escape_string($conn, $_POST['reason_leaving']);
        
        $sql3 = "INSERT INTO work_experience (emp_id, company_name, position, salary, exit_reason) 
                 VALUES ('$emp_id', '$company', '$position', '$salary', '$exit_reason')";
        mysqli_query($conn, $sql3);

        // --- 5. บันทึกบุคคลอ้างอิง (ตาราง employee_references) ---
        $ref_name = mysqli_real_escape_string($conn, $_POST['ref_name']);
        $ref_work = mysqli_real_escape_string($conn, $_POST['ref_workplace']);
        $ref_phone = mysqli_real_escape_string($conn, $_POST['ref_phone']);
        $ref_rel = mysqli_real_escape_string($conn, $_POST['ref_relation']);

        $sql4 = "INSERT INTO employee_references (emp_id, ref_name, ref_workplace, ref_phone, relationship) 
                 VALUES ('$emp_id', '$ref_name', '$ref_work', '$ref_phone', '$ref_rel')";
        mysqli_query($conn, $sql4);

        // บันทึกสำเร็จทั้งหมด
        echo "<script>
                alert('บันทึกข้อมูลใบสมัครของคุณเรียบร้อยแล้ว');
                window.location='view_employees.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<?php
include 'connect.php';
$emp_id = $_GET['id'];

// ดึงข้อมูลเดิมจาก 4 ตาราง
$sql = "SELECT e.*, edu.degree_level, w.company_name, w.position, w.salary, w.exit_reason, r.ref_name, r.ref_workplace, r.ref_phone, r.relationship 
        FROM employees e
        LEFT JOIN education edu ON e.emp_id = edu.emp_id
        LEFT JOIN work_experience w ON e.emp_id = w.emp_id
        LEFT JOIN employee_references r ON e.emp_id = r.emp_id
        WHERE e.emp_id = '$emp_id'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลบุคลากร</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun&display=swap');
        body { font-family: 'Sarabun', sans-serif; background-color: #f8f9fa; }
        .form-container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 0 20px rgba(0,0,0,0.1); margin-top: 50px; }
    </style>
</head>
<body>
<div class="container mb-5">
    <div class="form-container">
        <h3 class="fw-bold text-primary mb-4 border-bottom pb-2">แก้ไขข้อมูลบุคลากร (ID: <?php echo $emp_id; ?>)</h3>
        <form action="update_employee.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="emp_id" value="<?php echo $data['emp_id']; ?>">
            
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">คำนำหน้า</label>
                    <select name="prefix" class="form-select">
                        <option value="นาย" <?php if($data['prefix']=='นาย') echo 'selected'; ?>>นาย</option>
                        <option value="นาง" <?php if($data['prefix']=='นาง') echo 'selected'; ?>>นาง</option>
                        <option value="นางสาว" <?php if($data['prefix']=='นางสาว') echo 'selected'; ?>>นางสาว</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">ชื่อ-นามสกุล</label>
                    <input type="text" name="full_name" class="form-control" value="<?php echo $data['first_name'].' '.$data['last_name']; ?>" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">เลขบัตรประชาชน</label>
                    <input type="text" name="id_card" class="form-control" value="<?php echo $data['id_card']; ?>" required>
                </div>
            </div>

            <div class="mt-4">
                <label class="form-label">รูปถ่ายปัจจุบัน:</label><br>
                <img src="uploads/<?php echo $data['photo']; ?>" style="width: 100px; margin-bottom: 10px;" class="rounded shadow-sm"><br>
                <label class="form-label">เปลี่ยนรูปถ่าย (ปล่อยว่างถ้าไม่เปลี่ยน)</label>
                <input type="file" name="emp_photo" class="form-control">
                <input type="hidden" name="old_photo" value="<?php echo $data['photo']; ?>">
            </div>

            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label class="form-label">วุฒิการศึกษาสูงสุด</label>
                    <input type="text" name="edu_highest" class="form-control" value="<?php echo $data['degree_level']; ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">ตำแหน่งล่าสุด</label>
                    <input type="text" name="last_position" class="form-control" value="<?php echo $data['position']; ?>">
                </div>
            </div>

            <div class="mt-5 d-flex justify-content-between">
                <a href="view_employees.php" class="btn btn-secondary px-5">ยกเลิก</a>
                <button type="submit" class="btn btn-warning px-5 fw-bold">บันทึกการแก้ไข</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<?php
include 'connect.php';

// รับค่า ID จาก URL
$emp_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

if (empty($emp_id)) {
    die("ไม่พบรหัสบุคลากร");
}

// SQL JOIN 4 ตารางเพื่อดึงข้อมูลทั้งหมดของพนักงานคนนี้
$sql = "SELECT e.*, edu.*, w.*, r.* FROM employees e
        LEFT JOIN education edu ON e.emp_id = edu.emp_id
        LEFT JOIN work_experience w ON e.emp_id = w.emp_id
        LEFT JOIN employee_references r ON e.emp_id = r.emp_id
        WHERE e.emp_id = '$emp_id'";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("ไม่พบข้อมูลในระบบ");
}

// จัดการรูปภาพ
$photo = !empty($data['photo']) ? "uploads/".$data['photo'] : "https://via.placeholder.com/150";
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดบุคลากร - <?php echo $data['first_name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap');
        body { font-family: 'Sarabun', sans-serif; background-color: #f8f9fa; padding-top: 30px; }
        .profile-header { background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .detail-card { background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; border-left: 5px solid #0d6efd; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .section-title { color: #0d6efd; font-weight: bold; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; margin-bottom: 20px; }
        .label { font-weight: bold; color: #6c757d; width: 150px; display: inline-block; }
        .emp-lg-img { width: 180px; height: 180px; object-fit: cover; border-radius: 15px; border: 5px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container pb-5">
    <div class="mb-4">
        <a href="view_employees.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>กลับหน้าหลัก</a>
        <button onclick="window.print();" class="btn btn-primary ms-2"><i class="fas fa-print me-2"></i>พิมพ์ข้อมูลพนักงาน</button>
    </div>

    <div class="profile-header d-flex align-items-center">
        <img src="<?php echo $photo; ?>" class="emp-lg-img me-5">
        <div>
            <h1 class="fw-bold mb-1"><?php echo $data['prefix'].$data['first_name']." ".$data['last_name']; ?></h1>
            <p class="text-muted fs-5 mb-0">รหัสพนักงาน: <?php echo str_pad($data['emp_id'], 5, "0", STR_PAD_LEFT); ?></p>
            <span class="badge bg-success mt-2 px-3 py-2">สถานะ: ปกติ</span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="detail-card">
                <h5 class="section-title"><i class="fas fa-user-circle me-2"></i>ประวัติส่วนตัว</h5>
                <p><span class="label">เลขบัตร ปชช:</span> <?php echo $data['id_card']; ?></p>
                <p><span class="label">วันเกิด:</span> <?php echo $data['birth_date']; ?></p>
                <p><span class="label">เบอร์โทรศัพท์:</span> <?php echo $data['phone']; ?></p>
                <p><span class="label">อีเมล:</span> <?php echo $data['email']; ?></p>
                <p><span class="label">Line ID:</span> <?php echo $data['line_id'] ?: '-'; ?></p>
                <p><span class="label">ที่อยู่:</span> <?php echo $data['address']; ?></p>
            </div>

            <div class="detail-card">
                <h5 class="section-title"><i class="fas fa-graduation-cap me-2"></i>ประวัติการศึกษา</h5>
                <p><span class="label">วุฒิสูงสุด:</span> <?php echo $data['degree_level'] ?: 'ไม่ระบุ'; ?></p>
                <p><span class="label">สาขาวิชา:</span> <?php echo $data['major'] ?: '-'; ?></p>
                <p><span class="label">สถาบัน:</span> <?php echo $data['institution'] ?: '-'; ?></p>
            </div>
        </div>

        <div class="col-md-5">
            <div class="detail-card">
                <h5 class="section-title"><i class="fas fa-briefcase me-2"></i>ประสบการณ์ทำงานล่าสุด</h5>
                <p><span class="label">บริษัท:</span> <?php echo $data['company_name'] ?: '-'; ?></p>
                <p><span class="label">ตำแหน่ง:</span> <?php echo $data['position'] ?: '-'; ?></p>
                <p><span class="label">เงินเดือน:</span> <?php echo number_format($data['salary'], 2); ?> บาท</p>
                <p><span class="label">สาเหตุที่ออก:</span> <?php echo $data['exit_reason'] ?: '-'; ?></p>
            </div>

            <div class="detail-card">
                <h5 class="section-title"><i class="fas fa-id-card-alt me-2"></i>บุคคลอ้างอิง</h5>
                <p><span class="label">ชื่อ-สกุล:</span> <?php echo $data['ref_name'] ?: '-'; ?></p>
                <p><span class="label">สถานที่ทำงาน:</span> <?php echo $data['ref_workplace'] ?: '-'; ?></p>
                <p><span class="label">เบอร์โทร:</span> <?php echo $data['ref_phone'] ?: '-'; ?></p>
                <p><span class="label">ความสัมพันธ์:</span> <?php echo $data['relationship'] ?: '-'; ?></p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
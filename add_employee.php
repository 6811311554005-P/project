<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกใบสมัครงาน - RLPD CSIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap');
        body { font-family: 'Sarabun', sans-serif; background-color: #f0f2f5; }
        .sidebar { min-height: 100vh; background: #30475e; color: white; position: sticky; top: 0; }
        .sidebar a { color: #e1e1e1; text-decoration: none; padding: 15px 20px; display: block; transition: 0.3s; }
        .sidebar a:hover { background: #222831; color: #f2a365; }
        .form-container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .section-title { border-left: 5px solid #0d6efd; padding-left: 15px; margin-bottom: 25px; color: #30475e; font-weight: bold; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 p-0 sidebar shadow">
            <div class="p-4 text-center">
                <h4 class="fw-bold text-white">RLPD CSIS</h4>
            </div>
            <nav>
                <a href="dashboard.php"><i class="fas fa-chart-line me-2"></i> แผงควบคุม</a>
                <a href="#"><i class="fas fa-users me-2"></i> รายชื่อบุคลากร</a>
                <a href="add_employee.php" class="bg-primary text-white"><i class="fas fa-user-plus me-2"></i> บันทึกใบสมัครงาน</a>
                <a href="#"><i class="fas fa-file-alt me-2"></i> รายงานพ้นสภาพ</a>
            </nav>
        </div>

        <div class="col-md-10 p-0">
            <div class="bg-white p-3 mb-4 shadow-sm d-flex justify-content-end px-5">
                <div class="text-end me-3">
                    <div class="fw-bold">เทวาสันต์ จันพล</div>
                    <div class="small text-muted">Administrator</div>
                </div>
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">AD</div>
            </div>

            <div class="container px-5 pb-5">
                <div class="form-container">
                    <form action="save_employee.php" method="POST" enctype="multipart/form-data">
                        
                        <h4 class="section-title">1. ข้อมูลตำแหน่งงาน</h4>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ตำแหน่งที่ต้องการสมัคร <span class="text-danger">*</span></label>
                                <input type="text" name="position" class="form-control" placeholder="เช่น พนักงานวิเคราะห์นโยบาย" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">เงินเดือนที่ต้องการ</label>
                                <input type="number" name="expected_salary" class="form-control" placeholder="0.00">
                            </div>
                        </div>

                        <h4 class="section-title">2. ประวัติส่วนตัว</h4>
                        <div class="row mb-3">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">คำนำหน้า</label>
                                <select name="prefix" class="form-select">
                                    <option>นาย</option>
                                    <option>นาง</option>
                                    <option>นางสาว</option>
                                </select>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="form-label">ชื่อ</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="form-label">นามสกุล</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">เลขบัตรประชาชน</label>
                                <input type="text" name="id_card" class="form-control" maxlength="13">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">วันเกิด</label>
                                <input type="date" name="birth_date" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">เบอร์โทรศัพท์</label>
                                <input type="tel" name="phone" class="form-control">
                            </div>
                        </div>

                        <h4 class="section-title">3. ประวัติการศึกษา</h4>
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">วุฒิการศึกษาล่าสุด</label>
                                <select name="edu_level" class="form-select">
                                    <option>ปริญญาตรี</option>
                                    <option>ปริญญาโท</option>
                                    <option>ปริญญาเอก</option>
                                    <option>อื่นๆ</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">คณะ/สาขาวิชา</label>
                                <input type="text" name="major" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">สถาบันการศึกษา</label>
                                <input type="text" name="university" class="form-control">
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light px-4">ล้างข้อมูล</button>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm"><i class="fas fa-save me-2"></i> บันทึกข้อมูลใบสมัคร</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
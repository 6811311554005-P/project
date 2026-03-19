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
        body { font-family: 'Sarabun', sans-serif; background-color: #f8f9fa; }
        .form-container { background: white; padding: 40px; border-radius: 10px; shadow: 0 0 15px rgba(0,0,0,0.1); margin-top: 20px; }
        .section-header { background: #e9ecef; padding: 10px 15px; border-radius: 5px; font-weight: bold; margin-bottom: 20px; color: #333; }
    </style>
</head>
<body>

<div class="container pb-5">
    <div class="form-container shadow-sm">
        <h2 class="text-center mb-4 fw-bold">ข้อมูลใบสมัครงาน</h2>
        <form action="save_employee.php" method="POST" enctype="multipart/form-data">
            
            <div class="section-header"><i class="fas fa-user me-2"></i> ประวัติส่วนบุคคล</div>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">รูปภาพ (ไฟล์ .jpg หรือ .png)</label>
                    <input type="file" name="emp_photo" class="form-control" accept="image/*">
                </div>
                <div class="col-md-2">
                    <label class="form-label">คำนำหน้า</label>
                    <select name="prefix" class="form-select">
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ชื่อ - สกุล <span class="text-danger">*</span></label>
                    <input type="text" name="full_name" class="form-control" placeholder="พิมพ์ชื่อและนามสกุล" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">เลขบัตรประจำตัวประชาชน</label>
                    <input type="text" name="id_card" class="form-control" maxlength="13">
                </div>
                <div class="col-md-4">
                    <label class="form-label">วัน/เดือน/ปีเกิด</label>
                    <input type="date" name="birth_date" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">อายุ</label>
                    <input type="number" name="age" class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="form-label">ที่อยู่ที่ติดต่อได้</label>
                    <textarea name="address" class="form-control" rows="2" placeholder="พิมพ์ที่อยู่ปัจจุบัน"></textarea>
                </div>
                <div class="col-md-3">
                    <label class="form-label">สถานภาพ</label>
                    <select name="marital_status" class="form-select">
                        <option value="โสด">โสด</option>
                        <option value="สมรส">สมรส</option>
                        <option value="หย่าร้าง">หย่าร้าง</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">เชื้อชาติ</label>
                    <input type="text" name="ethnicity" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">สัญชาติ</label>
                    <input type="text" name="nationality" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">ศาสนา</label>
                    <input type="text" name="religion" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">เบอร์โทร</label>
                    <input type="tel" name="phone" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">ID-Line</label>
                    <input type="text" name="line_id" class="form-control">
                </div>
            </div>

            <div class="section-header"><i class="fas fa-graduation-cap me-2"></i> การศึกษา</div>
            <div class="row g-3 mb-4">
                <div class="col-md-12">
                    <label class="form-label">วุฒิที่ใช้ในการสมัคร / ระดับการศึกษา / สาขาวิชา / ชื่อสถานศึกษาที่สำเร็จการศึกษา</label>
                    <input type="text" name="edu_apply" class="form-control" placeholder="พิมพ์ข้อมูลการศึกษาที่ใช้สมัคร">
                </div>
                <div class="col-md-12">
                    <label class="form-label">วุฒิการศึกษาสูงสุด / ระดับการศึกษา / สาขาวิชา / ชื่อสถานศึกษา / วันสำเร็จการศึกษา</label>
                    <input type="text" name="edu_highest" class="form-control" placeholder="พิมพ์ข้อมูลวุฒิการศึกษาสูงสุด">
                </div>
                <div class="col-md-12">
                    <label class="form-label">วุฒิการศึกษาที่เกี่ยวข้อง / ระดับการศึกษา / สาขาวิชา / ชื่อสถานศึกษา / วันสำเร็จการศึกษา</label>
                    <input type="text" name="edu_relevant" class="form-control" placeholder="พิมพ์ข้อมูลวุฒิการศึกษาที่เกี่ยวข้อง">
                </div>
            </div>

            <div class="section-header"><i class="fas fa-briefcase me-2"></i> ข้อมูลการทำงานและประสบการณ์</div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">ชื่อหน่วยงานล่าสุด</label>
                    <input type="text" name="last_company" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">ชื่อตำแหน่ง</label>
                    <input type="text" name="last_position" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">เงินเดือนล่าสุด</label>
                    <input type="number" name="last_salary" class="form-control">
                </div>
                <div class="col-md-8">
                    <label class="form-label">สาเหตุที่ออกจากงาน</label>
                    <input type="text" name="reason_leaving" class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="form-label">ประสบการณ์ที่ผ่านมาจะเป็นประโยชน์ต่องานอย่างไร</label>
                    <textarea name="experience_benefit" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="section-header"><i class="fas fa-users-cog me-2"></i> บุคคลอ้างอิง</div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">ชื่อ - สกุล (บุคคลอ้างอิง)</label>
                    <input type="text" name="ref_name" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">ชื่อสถานที่ทำงาน</label>
                    <input type="text" name="ref_workplace" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">เบอร์โทร</label>
                    <input type="tel" name="ref_phone" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">ความสัมพันธ์</label>
                    <input type="text" name="ref_relation" class="form-control">
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="reset" class="btn btn-secondary px-4">ล้างข้อมูล</button>
                <button type="submit" class="btn btn-primary px-5 shadow">บันทึกข้อมูลใบสมัคร</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
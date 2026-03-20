<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายชื่อบุคลากร - RLPD CSIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap');
        body { font-family: 'Sarabun', sans-serif; background-color: #f4f7f6; }
        .sidebar { min-height: 100vh; background: #2c3e50; color: white; position: sticky; top: 0; }
        .sidebar a { color: #bdc3c7; text-decoration: none; padding: 15px 20px; display: block; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #34495e; color: #3498db; border-left: 4px solid #3498db; }
        .main-content { background: white; min-height: 100vh; }
        .profile-img { width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd; }
        .table-card { border: none; border-radius: 15px; box-shadow: 0 0 20px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 p-0 sidebar shadow">
            <div class="p-4 text-center">
                <h4 class="fw-bold">RLPD CSIS</h4>
            </div>
            <nav>
                <a href="dashboard.php"><i class="fas fa-chart-line me-2"></i> แผงควบคุม</a>
                <a href="view_employees.php" class="active"><i class="fas fa-users me-2"></i> รายชื่อบุคลากร</a>
                <a href="add_employee.php"><i class="fas fa-user-plus me-2"></i> บันทึกใบสมัครงาน</a>
                <a href="#"><i class="fas fa-file-alt me-2"></i> รายงานพ้นสภาพ</a>
            </nav>
        </div>

        <div class="col-md-10 p-0 main-content">
            <nav class="navbar navbar-light bg-white p-3 mb-4 shadow-sm px-5">
                <span class="navbar-brand mb-0 h4 fw-bold text-secondary">ระบบบริหารจัดการบุคลากร</span>
            </nav>

            <div class="container px-5">
                <div class="card table-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold"><i class="fas fa-list me-2 text-primary"></i>รายชื่อผู้สมัครและพนักงาน</h5>
                        <a href="add_employee.php" class="btn btn-primary rounded-pill px-4"><i class="fas fa-plus me-2"></i>เพิ่มบุคลากร</a>
                    </div>

                    <form class="row g-3 mb-4" method="GET">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control border-start-0" placeholder="ค้นหาด้วย ชื่อ-นามสกุล หรือ เบอร์โทรศัพท์..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                <button type="submit" class="btn btn-primary">ค้นหา</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>รูปถ่าย</th>
                                    <th>ชื่อ - นามสกุล</th>
                                    <th>เบอร์โทรศัพท์</th>
                                    <th>ตำแหน่งล่าสุด</th>
                                    <th>วุฒิการศึกษา</th>
                                    <th class="text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'connect.php';
                                
                                $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                                // SQL แบบ JOIN เพื่อดึงข้อมูลข้ามตารางตามโครงสร้างของคุณ
                                $sql = "SELECT e.emp_id, e.prefix, e.first_name, e.last_name, e.phone, e.photo, 
                                               w.position, edu.degree_level 
                                        FROM employees e
                                        LEFT JOIN work_experience w ON e.emp_id = w.emp_id
                                        LEFT JOIN education edu ON e.emp_id = edu.emp_id";

                                if (!empty($search)) {
                                    $sql .= " WHERE e.first_name LIKE '%$search%' OR e.last_name LIKE '%$search%' OR e.phone LIKE '%$search%'";
                                }

                                $sql .= " GROUP BY e.emp_id ORDER BY e.emp_id DESC";
                                $result = mysqli_query($conn, $sql);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $i = 1;
                                    while($row = mysqli_fetch_assoc($result)) {
                                        // จัดการเรื่องรูปภาพ
                                        $photo = !empty($row['photo']) ? "uploads/".$row['photo'] : "https://via.placeholder.com/150";
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><img src="<?php echo $photo; ?>" class="profile-img shadow-sm"></td>
                                            <td>
                                                <div class="fw-bold"><?php echo $row['prefix'].$row['first_name']." ".$row['last_name']; ?></div>
                                                <small class="text-muted">ID: <?php echo str_pad($row['emp_id'], 5, "0", STR_PAD_LEFT); ?></small>
                                            </td>
                                            <td><?php echo $row['phone'] ?: '-'; ?></td>
                                            <td><span class="badge bg-info text-dark"><?php echo $row['position'] ?: 'ยังไม่มีข้อมูล'; ?></span></td>
                                            <td><?php echo $row['degree_level'] ?: '-'; ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="view_details.php?id=<?php echo $row['emp_id']; ?>" class="btn btn-sm btn-outline-primary" title="ดูข้อมูล"><i class="fas fa-eye"></i></a>
                                                    <a href="#" class="btn btn-sm btn-outline-warning" title="แก้ไข"><i class="fas fa-edit"></i></a>
                                                    <a href="delete_employee.php?id=<?php echo $row['emp_id']; ?>" class="btn btn-sm btn-outline-danger"onclick="return confirm('ยืนยันการลบข้อมูลพนักงานท่านนี้? การลบนี้จะไม่สามารถย้อนคืนได้');"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center py-5 text-muted'>ยังไม่มีข้อมูลบุคลากรในระบบ</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
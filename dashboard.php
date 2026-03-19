<?php
include 'connect.php'; 

// ข้อมูลจำลองสำหรับแสดงผล (Mockup Data)
$total_registered = 20; // จำนวนคนลงทะเบียนทั้งหมด
$new_hires_month = 3;   // รับเข้าใหม่เดือนนี้
$resigned_month = 1;    // พ้นสภาพเดือนนี้
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard - RLPD CSIS</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap');
        body { font-family: 'Sarabun', sans-serif; background-color: #f0f2f5; margin: 0; }
        
        /* Sidebar Design */
        .sidebar { min-height: 100vh; background: #30475e; color: white; position: sticky; top: 0; }
        .sidebar a { color: #e1e1e1; text-decoration: none; padding: 15px 20px; display: block; transition: 0.3s; }
        .sidebar a:hover { background: #222831; color: #f2a365; }
        
        /* Card & Navbar Design */
        .navbar-custom { background: white; padding: 12px 25px; border-bottom: 1px solid #e0e4e8; }
        .card-stat { border: none; border-radius: 15px; transition: 0.3s; }
        .card-stat:hover { transform: translateY(-5px); }
        .user-avatar { width: 40px; height: 40px; background: #0D8ABC; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .chart-container { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 p-0 sidebar">
            <div class="p-4 text-center">
                <h4 class="fw-bold text-white">RLPD CSIS</h4>
                <p class="small text-muted">ระบบจัดการบุคลากร</p>
            </div>
            <nav>
                <a href="#"><i class="fas fa-chart-line me-2"></i> แผงควบคุม</a>
                <a href="#"><i class="fas fa-users me-2"></i> รายชื่อบุคลากร</a>
                <a href="#"><i class="fas fa-user-plus me-2"></i> บันทึกใบสมัครงาน</a>
                <a href="#"><i class="fas fa-file-alt me-2"></i> รายงานพ้นสภาพ</a>
                <hr class="mx-3 border-secondary text-white-50">
                <a href="#" class="text-warning"><i class="fas fa-sign-out-alt me-2"></i> ออกจากระบบ</a>
            </nav>
        </div>

        <div class="col-md-10 p-0">
            
            <div class="navbar-custom d-flex justify-content-end align-items-center mb-4 shadow-sm">
                <div class="text-end me-3">
                    <div class="fw-bold text-dark">เทวาสันต์ จันพล</div>
                    <div class="text-muted small">สถานะ: <span class="badge bg-primary">Administrator</span></div>
                </div>
                <div class="user-avatar shadow-sm">AD</div>
            </div>

            <div class="px-4 pb-4">
                <h3 class="mb-4 fw-bold">สรุปภาพรวมข้อมูลบุคลากร</h3>

                <div class="row mb-4 g-4">
                    <div class="col-md-4">
                        <div class="card card-stat p-4 bg-white border-start border-primary border-5 shadow-sm">
                            <div class="text-muted small mb-1 fw-bold">จำนวนคนลงทะเบียนทั้งหมด</div>
                            <div class="h1 fw-bold text-primary"><?php echo $total_registered; ?> <span class="fs-5 text-muted">คน</span></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stat p-4 bg-white border-start border-success border-5 shadow-sm">
                            <div class="text-muted small mb-1 fw-bold">รับเข้าใหม่ (เดือนนี้)</div>
                            <div class="h1 fw-bold text-success"><?php echo $new_hires_month; ?> <span class="fs-5 text-muted">คน</span></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stat p-4 bg-white border-start border-danger border-5 shadow-sm">
                            <div class="text-muted small mb-1 fw-bold">พ้นสภาพ (เดือนนี้)</div>
                            <div class="h1 fw-bold text-danger"><?php echo $resigned_month; ?> <span class="fs-5 text-muted">คน</span></div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-5">
                        <div class="chart-container">
                            <h6 class="fw-bold mb-4 text-secondary"><i class="fas fa-chart-pie me-2"></i>สัดส่วนสถานะบุคลากร</h6>
                            <div style="height: 320px;"><canvas id="statusChart"></canvas></div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="chart-container">
                            <h6 class="fw-bold mb-4 text-secondary"><i class="fas fa-chart-bar me-2"></i>สถิติรับเข้า - พ้นสภาพ (ปี 2569)</h6>
                            <div style="height: 320px;"><canvas id="monthlyChart"></canvas></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. กราฟวงกลมสรุปสถานะ
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['กำลังปฏิบัติงาน', 'ทดลองงาน', 'พ้นสภาพ'],
            datasets: [{
                data: [15, 5, 1],
                backgroundColor: ['#198754', '#ffc107', '#dc3545'],
                hoverOffset: 10,
                borderWidth: 0
            }]
        },
        options: { 
            maintainAspectRatio: false, 
            plugins: { legend: { position: 'bottom', labels: { padding: 20 } } },
            cutout: '70%'
        }
    });

    // 2. กราฟแท่งเปรียบเทียบรายเดือน
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.'],
            datasets: [
                { label: 'รับเข้าใหม่', data: [5, 2, 3, 0, 0, 0], backgroundColor: '#0d6efd', borderRadius: 5 },
                { label: 'พ้นสภาพ', data: [1, 0, 1, 0, 0, 0], backgroundColor: '#dc3545', borderRadius: 5 }
            ]
        },
        options: { 
            maintainAspectRatio: false, 
            scales: { y: { beginAtZero: true, grid: { display: false } }, x: { grid: { display: false } } },
            plugins: { legend: { position: 'top' } }
        }
    });
</script>

</body>
</html>
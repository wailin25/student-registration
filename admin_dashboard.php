<?php
require 'includes/db.php';
require 'includes/admin_header.php';
require 'includes/navbar.php';

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Admin Auth Check
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: unauthorized.php');
    exit;
}

// Stats
$tables = ['students', 'payment', 'subjects'];
$stats = [];
foreach ($tables as $table) {
    $result = mysqli_query($mysqli, "SELECT COUNT(*) FROM $table");
    $stats[$table] = ($result) ? mysqli_fetch_array($result)[0] : 0;
}

// Payment Status
$paymentQuery = "SELECT pay_status, COUNT(*) as count FROM payment GROUP BY pay_status";
$paymentResult = mysqli_query($mysqli, $paymentQuery);
$paymentStatus = mysqli_fetch_all($paymentResult, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
  /* Sidebar and Main Content styling */
  #sidebar {
    width: 280px;
    min-height: 100vh;
    background-color: #17a2b8; /* Bootstrap info color */
    position: fixed;
    top: 56px; /* navbar height */
    left: 0;
    padding: 1rem;
    transition: transform 0.3s ease;
    overflow-y: auto;
  }
  #sidebar.hide {
    transform: translateX(-100%);
  }

  #main-content {
    margin-left: 280px;
    padding: 2rem 1rem;
    transition: margin-left 0.3s ease;
  }
  #main-content.full-width {
    margin-left: 0;
  }

  /* Responsive */
  @media (max-width: 768px) {
    #sidebar {
      top: 56px;
      transform: translateX(-100%);
      position: fixed;
      z-index: 1030;
    }
    #sidebar.show {
      transform: translateX(0);
    }
    #main-content {
      margin-left: 0;
    }
  }
</style>
</head>
<body>
<div id="sidebar">
    <?php require 'includes/sidebar.php'; ?>
</div>

<div id="main-content" style="margin-top:50px;">
  <div class="container-fluid pt-4">
    <h4 class="mb-4 text-primary text-center">📊 UCSM Admin Dashboard</h4>

    <div class="row mb-4">
        <?php foreach ($stats as $table => $count): ?>
        <div class="col-6 col-sm-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-uppercase text-muted mb-2"><?= htmlspecialchars($table) ?></h5>
                    <h2 class="text-primary stats-card"><?= htmlspecialchars($count) ?></h2>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="row mb-4">
        <!-- Recent Registrations -->
        <div class="col-12 col-lg-8 mb-4 mb-lg-0">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                    <h6 class="mb-0">နောက်ဆုံးစာရင်းသွင်းမှုများ</h6>
                    <a href="registrations.php" class="btn btn-sm btn-outline-primary py-1">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="d-none d-sm-table-cell">အချိန်</th>
                                    <th>ကျောင်းသား</th>
                                    <th class="d-none d-md-table-cell">ဘာသာရပ်</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- You can fetch and populate recent registrations here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Status -->
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0">ငွေပေးချေမှုအခြေအနေ</h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height:250px; width:100%">
                        <canvas id="paymentChart"></canvas>
                    </div>
                    <div class="mt-3">
                        <ul class="list-group">
                            <?php foreach($paymentStatus as $status): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <?= htmlspecialchars(ucfirst($status['pay_status'])) ?>
                                <span class="badge bg-primary rounded-pill"><?= htmlspecialchars($status['count']) ?></span>
                            </li>
                            <?php endforeach; ?>
                            <?php if (empty($paymentStatus)): ?>
                            <li class="list-group-item text-center py-2">No payment data available.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<!-- JS libraries -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleBtn = document.getElementById('sidebarToggle');

    // Sidebar toggle function
    function toggleSidebar() {
      if(window.innerWidth < 768){
        // For mobile: toggle 'show' class
        sidebar.classList.toggle('show');
      } else {
        sidebar.classList.toggle('hide');
        mainContent.classList.toggle('full-width');
      }
    }

    // Attach toggle event to toggle button (must be in navbar.php with id='sidebarToggle')
    if(toggleBtn){
      toggleBtn.addEventListener('click', toggleSidebar);
    }

    // Auto adjust on window resize
    function handleResize(){
      if(window.innerWidth < 768){
        sidebar.classList.add('hide'); 
        mainContent.classList.add('full-width');
        sidebar.classList.remove('show');
      } else {
        sidebar.classList.remove('hide');
        mainContent.classList.remove('full-width');
        sidebar.classList.remove('show');
      }
    }
    window.addEventListener('resize', handleResize);

    handleResize();

    // Chart.js payment chart
    const ctx = document.getElementById('paymentChart').getContext('2d');
    const paymentChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [
          <?php foreach($paymentStatus as $status): ?>
            '<?= addslashes(ucfirst($status['pay_status'])) ?>',
          <?php endforeach; ?>
        ],
        datasets: [{
          data: [
            <?php foreach($paymentStatus as $status): ?>
              <?= (int)$status['count'] ?>,
            <?php endforeach; ?>
          ],
          backgroundColor: [
            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'
          ],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }]
      },
      options: {
        maintainAspectRatio: false,
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              boxWidth: 12,
              padding: 20,
              font: { size: window.innerWidth < 576 ? 10 : 12 }
            }
          },
          tooltip: { enabled: window.innerWidth > 400 }
        },
        cutout: '70%'
      }
    });

    window.addEventListener('resize', function() {
      paymentChart.options.plugins.legend.labels.font.size = window.innerWidth < 576 ? 10 : 12;
      paymentChart.options.plugins.tooltip.enabled = window.innerWidth > 400;
      paymentChart.update();
    });

  });
</script>

<?php require 'includes/admin_footer.php'; ?>
<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>

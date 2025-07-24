<?php
require 'includes/header.php';
require 'includes/student_navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Dashboard - UCSMGY</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    :root {
      --primary: #4361ee;
      --primary-light: #5a75f0;
      --secondary: #3f37c9;
      --accent: #4895ef;
      --light: #f8f9fa;
      --dark: #212529;
      --gray: #6c757d;
      --light-gray: #e9ecef;
      --success: #4cc9f0;
      --warning: #f72585;
      --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      --border-radius: 12px;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f7fa;
      color: var(--dark);
      line-height: 1.6;
    }

    .dashboard-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    /* Welcome Banner */
    .welcome-banner {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
      padding: 2rem;
      border-radius: var(--border-radius);
      margin-bottom: 2rem;
      box-shadow: var(--card-shadow);
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .user-avatar {
      width: 80px;
      height: 80px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      flex-shrink: 0;
    }

    .welcome-text h1 {
      font-size: 1.8rem;
      margin-bottom: 0.5rem;
    }

    .welcome-text p {
      margin: 0;
      opacity: 0.9;
      font-size: 1rem;
    }

    /* Dashboard Grid */
    .dashboard-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 1.5rem;
    }

    /* Cards */
    .dashboard-card {
      background: white;
      border-radius: var(--border-radius);
      padding: 1.5rem;
      box-shadow: var(--card-shadow);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      display: flex;
      align-items: center;
      margin-bottom: 1.5rem;
      color: var(--primary);
    }

    .card-header i {
      font-size: 1.5rem;
      margin-right: 0.75rem;
    }

    .card-header h3 {
      margin: 0;
      font-size: 1.3rem;
    }

    /* Form Elements */
    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: var(--gray);
    }

    select, input {
      width: 100%;
      padding: 0.8rem 1rem;
      border-radius: 8px;
      border: 1px solid #ddd;
      font-size: 1rem;
      font-family: inherit;
      transition: border-color 0.3s;
    }

    select:focus, input:focus {
      border-color: var(--primary);
      outline: none;
      box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
    }

    /* Buttons */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.8rem 1.5rem;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      border: none;
      text-decoration: none;
    }

    .btn-primary {
      background: var(--primary);
      color: white;
    }

    .btn-primary:hover {
      background: var(--primary-light);
    }

    .btn-outline {
      background: transparent;
      color: var(--primary);
      border: 1px solid var(--primary);
    }

    .btn-outline:hover {
      background: rgba(67, 97, 238, 0.1);
    }

    .btn i {
      margin-right: 8px;
    }

    /* Fee Details */
    .fee-details {
      background: var(--light-gray);
      border-radius: var(--border-radius);
      padding: 1.5rem;
      margin-top: 1.5rem;
    }

    .detail-item {
      display: flex;
      justify-content: space-between;
      padding: 0.8rem 0;
      border-bottom: 1px solid #dee2e6;
    }

    .detail-item:last-child {
      border-bottom: none;
    }

    .detail-label {
      font-weight: 500;
    }

    .detail-value {
      font-weight: 600;
    }

    .badge {
      display: inline-block;
      padding: 0.35em 0.65em;
      font-size: 0.75em;
      font-weight: 700;
      line-height: 1;
      text-align: center;
      white-space: nowrap;
      vertical-align: baseline;
      border-radius: 0.25rem;
    }

    .badge-primary {
      color: #fff;
      background-color: var(--primary);
    }

    .badge-success {
      color: #fff;
      background-color: #28a745;
    }

    .badge-info {
      color: #fff;
      background-color: #17a2b8;
    }

    .badge-dark {
      color: #fff;
      background-color: var(--dark);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .welcome-banner {
        flex-direction: column;
        text-align: center;
      }
      
      .user-avatar {
        margin-bottom: 1rem;
      }
      
      .dashboard-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <!-- Welcome Banner -->
    <div class="welcome-banner">
      <div class="user-avatar">
        <i class="fas fa-user-graduate"></i>
      </div>
      <div class="welcome-text">
        <h1>Welcome back, <?php echo htmlspecialchars($student_name); ?></h1>
        <p><?php echo htmlspecialchars($student_email); ?></p>
        <p>Last login: <?php echo date('M j, Y g:i A'); ?></p>
      </div>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-grid" style="width: 700px;margin-left:250px;">
      <!-- Fee Calculator Card -->
      <div class="dashboard-card">
        <div class="card-header">
          <i class="fas fa-calculator"></i>
          <h3>Registration Fee Calculator</h3>
        </div>

        <form method="GET" id="feeCalculatorForm">
          <div class="form-group">
            <label for="year">Academic Year</label>
            <select name="year" id="year" required>
              <option value="">-- Select Year --</option>
              <option value="second">Second Year</option>
              <option value="third">Third Year</option>
              <option value="fourth">Fourth Year</option>
              <option value="final">Final Year</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i> Calculate Fee
          </button>
        </form>

        <?php
        $fees = [
            'second' => 30000,
            'third' => 32000,
            'fourth' => 33000,
            'final' => 35000
        ];

        if (isset($_GET['year']) && array_key_exists($_GET['year'], $fees)) {
            $selected = $_GET['year'];
            $fee_amount = number_format($fees[$selected]);
            $current_date = date('M j, Y');
            
            echo '
            <div class="fee-details">
              <h4>Fee Breakdown</h4>
              
              <div class="detail-item">
                <span class="detail-label">Academic Year</span>
                <span class="detail-value badge badge-primary">'.ucfirst($selected).' Year</span>
              </div>
              
              <div class="detail-item">
                <span class="detail-label">Registration Fee</span>
                <span class="detail-value badge badge-success">'.$fee_amount.' MMK</span>
              </div>
              
              <div class="detail-item">
                <span class="detail-label">Calculation Date</span>
                <span class="detail-value badge badge-info">'.$current_date.'</span>
              </div>
              
              <div class="detail-item" style="font-size: 1.1rem;">
                <span class="detail-label"><strong>Total Amount</strong></span>
                <span class="detail-value badge badge-dark">'.$fee_amount.' MMK</span>
              </div>
              
              <a href="registration_form.php?year='.$selected.'" class="btn btn-outline" style="width: 80%; margin-top: 1rem;">
                <i class="fas fa-file-alt"></i> Complete Registration Form
              </a>
            </div>';
        }
        ?>
      </div>

      <!-- Quick Links Card -->
      

        
        
      </div>
    </div>
  </div>
</body>
</html>

<?php require 'includes/footer.php'; ?>
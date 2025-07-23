<?php

require 'includes/db.php';

// Pagination variables
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$recordsPerPage = 15;
$offset = ($currentPage - 1) * $recordsPerPage;

// Search and filter variables
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$classFilter = isset($_GET['class']) ? $_GET['class'] : '';
$specializationFilter = isset($_GET['specialization']) ? $_GET['specialization'] : '';

// Base query
$query = "SELECT * FROM students WHERE 1=1";
$countQuery = "SELECT COUNT(*) FROM students WHERE 1=1";

// Add search conditions
if (!empty($searchTerm)) {
    $query .= " AND (student_name_mm LIKE ? OR student_name_en LIKE ? OR serial_no LIKE ? OR nrc LIKE ?)";
    $countQuery .= " AND (student_name_mm LIKE ? OR student_name_en LIKE ? OR serial_no LIKE ? OR nrc LIKE ?)";
}

// Add class filter
if (!empty($classFilter)) {
    $query .= " AND class = ?";
    $countQuery .= " AND class = ?";
}

// Add specialization filter
if (!empty($specializationFilter)) {
    $query .= " AND specialization = ?";
    $countQuery .= " AND specialization = ?";
}

// Prepare and execute count query
$countStmt = $mysqli->prepare($countQuery);

if (!empty($searchTerm)) {
    $searchParam = "%$searchTerm%";
    if (!empty($classFilter) && !empty($specializationFilter)) {
        $countStmt->bind_param("ssssss", $searchParam, $searchParam, $searchParam, $searchParam, $classFilter, $specializationFilter);
    } elseif (!empty($classFilter)) {
        $countStmt->bind_param("sssss", $searchParam, $searchParam, $searchParam, $searchParam, $classFilter);
    } elseif (!empty($specializationFilter)) {
        $countStmt->bind_param("sssss", $searchParam, $searchParam, $searchParam, $searchParam, $specializationFilter);
    } else {
        $countStmt->bind_param("ssss", $searchParam, $searchParam, $searchParam, $searchParam);
    }
} elseif (!empty($classFilter) || !empty($specializationFilter)) {
    if (!empty($classFilter) && !empty($specializationFilter)) {
        $countStmt->bind_param("ss", $classFilter, $specializationFilter);
    } elseif (!empty($classFilter)) {
        $countStmt->bind_param("s", $classFilter);
    } else {
        $countStmt->bind_param("s", $specializationFilter);
    }
}

$countStmt->execute();
$countStmt->bind_result($totalRecords);
$countStmt->fetch();
$countStmt->close();

$totalPages = ceil($totalRecords / $recordsPerPage);

// Add sorting and pagination
$sortField = isset($_GET['sort']) ? $_GET['sort'] : 'serial_no';
$sortOrder = isset($_GET['order']) && strtoupper($_GET['order']) === 'DESC' ? 'DESC' : 'ASC';
$query .= " ORDER BY $sortField $sortOrder LIMIT ?, ?";

// Prepare and execute main query
$stmt = $mysqli->prepare($query);

if (!empty($searchTerm)) {
    $searchParam = "%$searchTerm%";
    if (!empty($classFilter) && !empty($specializationFilter)) {
        $stmt->bind_param("ssssssii", $searchParam, $searchParam, $searchParam, $searchParam, $classFilter, $specializationFilter, $offset, $recordsPerPage);
    } elseif (!empty($classFilter)) {
        $stmt->bind_param("sssssii", $searchParam, $searchParam, $searchParam, $searchParam, $classFilter, $offset, $recordsPerPage);
    } elseif (!empty($specializationFilter)) {
        $stmt->bind_param("sssssii", $searchParam, $searchParam, $searchParam, $searchParam, $specializationFilter, $offset, $recordsPerPage);
    } else {
        $stmt->bind_param("ssssii", $searchParam, $searchParam, $searchParam, $searchParam, $offset, $recordsPerPage);
    }
} elseif (!empty($classFilter) || !empty($specializationFilter)) {
    if (!empty($classFilter) && !empty($specializationFilter)) {
        $stmt->bind_param("ssii", $classFilter, $specializationFilter, $offset, $recordsPerPage);
    } elseif (!empty($classFilter)) {
        $stmt->bind_param("sii", $classFilter, $offset, $recordsPerPage);
    } else {
        $stmt->bind_param("sii", $specializationFilter, $offset, $recordsPerPage);
    }
} else {
    $stmt->bind_param("ii", $offset, $recordsPerPage);
}

$stmt->execute();
$result = $stmt->get_result();
$students = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Get unique values for filters
$classes = $mysqli->query("SELECT DISTINCT class FROM students ORDER BY class")->fetch_all(MYSQLI_ASSOC);
$specializations = $mysqli->query("SELECT DISTINCT specialization FROM students ORDER BY specialization")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        #sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            transition: transform 0.3s ease;
            z-index: 1000;
        }
        #main-content {
            margin-left: 280px;
            transition: margin-left 0.3s ease;
            padding: 20px;
        }
        #main-content.full-width {
            margin-left: 0;
        }
        #sidebar-toggle {
            position: fixed;
            left: 290px;
            top: 70px;
            z-index: 1001;
            transition: left 0.3s ease;
        }
        #sidebar.hide {
            transform: translateX(-100%);
        }
        #sidebar.hide + #main-content {
            margin-left: 0;
        }
        #sidebar.hide ~ #sidebar-toggle {
            left: 10px;
        }
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
            }
            #sidebar.show {
                transform: translateX(0);
            }
            #main-content {
                margin-left: 0;
            }
            #sidebar-toggle {
                left: 10px;
            }
        }
        .table-responsive {
            overflow-x: auto;
        }
        .sort-link {
            text-decoration: none;
            color: inherit;
        }
        .sort-link:hover {
            color: #0d6efd;
        }
        .address-col {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
</head>
<body>
<?php require 'includes/admin_header.php'; ?>
<?php require 'includes/navbar.php'; ?>

<div id="sidebar" class="bg-dark text-white">
    <?php include 'includes/sidebar.php'; ?>
</div>

<div id="main-content" style="margin-top:70px;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Students</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="upload_students.php" class="btn btn-sm btn-outline-primary me-2">
                <i class="bi bi-upload"></i> Import Students
            </a>
            <a href="add_student.php" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i> Add Student
            </a>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Search & Filter</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="<?= htmlspecialchars($searchTerm) ?>" placeholder="Name, Serial No, or NRC">
                </div>
                <div class="col-md-3">
                    <label for="class" class="form-label">Class</label>
                    <select class="form-select" id="class" name="class">
                        <option value="">All Classes</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['class'] ?>" <?= $classFilter === $class['class'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($class['class']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="specialization" class="form-label">Specialization</label>
                    <select class="form-select" id="specialization" name="specialization">
                        <option value="">All Specializations</option>
                        <?php foreach ($specializations as $spec): ?>
                            <option value="<?= $spec['specialization'] ?>" <?= $specializationFilter === $spec['specialization'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($spec['specialization']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search"></i> Search
                    </button>
                    <a href="manage_students.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Student Records</h5>
            <div class="text-muted">
                Total: <?= number_format($totalRecords) ?> records
            </div>
        </div>
        <div class="card-body">
            <?php if (!empty($students)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>
                                    <a href="?search=<?= urlencode($searchTerm) ?>&class=<?= urlencode($classFilter) ?>&specialization=<?= urlencode($specializationFilter) ?>&sort=student_name_mm&order=<?= $sortField === 'student_name_mm' && $sortOrder === 'ASC' ? 'DESC' : 'ASC' ?>"
                                       class="sort-link">
                                        မြန်မာအမည်
                                        <?php if ($sortField === 'student_name_mm'): ?>
                                            <i class="bi bi-caret-<?= $sortOrder === 'ASC' ? 'up' : 'down' ?>"></i>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th>အင်္ဂလိပ်အမည်</th>
                                <th>
                                    <a href="?search=<?= urlencode($searchTerm) ?>&class=<?= urlencode($classFilter) ?>&specialization=<?= urlencode($specializationFilter) ?>&sort=serial_code&order=<?= $sortField === 'serial_code' && $sortOrder === 'ASC' ? 'DESC' : 'ASC' ?>"
                                       class="sort-link">
                                        Serial Code
                                        <?php if ($sortField === 'serial_code'): ?>
                                            <i class="bi bi-caret-<?= $sortOrder === 'ASC' ? 'up' : 'down' ?>"></i>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th>Serial No</th>
                                <th>Class</th>
                                <th>Specialization</th>
                                <th>NRC</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = $offset + 1; foreach ($students as $student): ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><?= htmlspecialchars($student['student_name_mm']) ?></td>
                                    <td><?= htmlspecialchars($student['student_name_en']) ?></td>
                                    <td><?= htmlspecialchars($student['serial_code']) ?></td>
                                    <td><?= htmlspecialchars($student['serial_no']) ?></td>
                                    <td><?= htmlspecialchars($student['class']) ?></td>
                                    <td><?= htmlspecialchars($student['specialization']) ?></td>
                                    <td><?= htmlspecialchars($student['nrc']) ?></td>
                                    <td><?= htmlspecialchars($student['phone']) ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="view_student.php?serial_no=<?= $student['serial_no'] ?>" 
                                               class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="edit_student.php?serial_no=<?= $student['serial_no'] ?>" 
                                               class="btn btn-sm btn-outline-secondary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="manage_students.php?delete=<?= $student['serial_no'] ?>" 
                                               class="btn btn-sm btn-outline-danger" title="Delete"
                                               onclick="return confirm('Are you sure you want to delete this student?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <nav aria-label="Page navigation" class="mt-3">
                    <ul class="pagination justify-content-center">
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link" 
                                   href="?page=<?= $currentPage - 1 ?>&search=<?= urlencode($searchTerm) ?>&class=<?= urlencode($classFilter) ?>&specialization=<?= urlencode($specializationFilter) ?>&sort=<?= $sortField ?>&order=<?= $sortOrder ?>">
                                    Previous
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                <a class="page-link" 
                                   href="?page=<?= $i ?>&search=<?= urlencode($searchTerm) ?>&class=<?= urlencode($classFilter) ?>&specialization=<?= urlencode($specializationFilter) ?>&sort=<?= $sortField ?>&order=<?= $sortOrder ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" 
                                   href="?page=<?= $currentPage + 1 ?>&search=<?= urlencode($searchTerm) ?>&class=<?= urlencode($classFilter) ?>&specialization=<?= urlencode($specializationFilter) ?>&sort=<?= $sortField ?>&order=<?= $sortOrder ?>">
                                    Next
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php else: ?>
                <div class="alert alert-info">No student records found.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleBtn = document.getElementById('sidebar-toggle');
    
    // Toggle sidebar
    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('hide');
        mainContent.classList.toggle('full-width');
    });
    
    // For mobile view
    const mobileMediaQuery = window.matchMedia('(max-width: 768px)');
    
    function handleMobileView(e) {
        if (e.matches) {
            sidebar.classList.add('hide');
            mainContent.classList.add('full-width');
        } else {
            sidebar.classList.remove('hide');
            mainContent.classList.remove('full-width');
        }
    }
    
    // Initial check
    handleMobileView(mobileMediaQuery);
    
    // Listen for changes
    mobileMediaQuery.addListener(handleMobileView);
});
</script>
</body>
</html>
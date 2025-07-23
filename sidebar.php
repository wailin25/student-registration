<?php
$student_pages = [
    'upload_students.php' => 'fa-file-excel',
    'add_student.php' => 'fa-user-plus',
    'manage_students.php' => 'fa-list',
    'analytics_students.php' => 'fa-chart-bar'
];

$subject_pages = [
    'create_subject.php' => 'fa-plus-circle',
    'manage_subjects.php' => 'fa-edit',
    'pre_requisite.php' => 'fa-check',
    'analytics_subject.php' => 'fa-chart-line'
];

$exam_pages = [
    'import_exam.php' => 'fa-upload',
    'manage_exams.php' => 'fa-calendar-alt',
    'analyics_exam.php' => 'fa-chart-pie'
];
?>

<div class="sidebar bg-info" id="sidebar" style="width: 280px; min-height: calc(100vh - 56px);margin-top: 0px;">
    <ul class="nav flex-column p-3">
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'admin_dashboard.php' ? 'active' : '' ?>" href="admin_dashboard.php">
                <i class="fas fa-tachometer-alt me-2"></i>
                <span> Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'manage_registrations.php' ? 'active' : '' ?>" href="manage_registrations.php">
                <i class="fas fa-file-signature me-2"></i> Registration Forms
            </a>
        </li>

        <!-- Student Management -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#studentCollapse">
                <i class="fas fa-user-graduate me-2"></i> Student Management
                <i class="fas fa-angle-down float-end mt-1"></i>
            </a>
            <div class="collapse <?= in_array($current_page, array_keys($student_pages)) ? 'show' : '' ?>" id="studentCollapse">
                <ul class="nav flex-column ms-3">
                    <?php foreach ($student_pages as $page => $icon): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $current_page == $page ? 'active' : '' ?>" href="<?= $page ?>">
                                <i class="fas <?= $icon ?> me-2"></i> <?= ucwords(str_replace('_', ' ', pathinfo($page, PATHINFO_FILENAME))) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </li>

        <!-- Subject Management -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#subjectCollapse" role="button">
                <i class="fas fa-book me-2"></i> Subject Management
                <i class="fas fa-angle-down float-end mt-1"></i>
            </a>
            <div class="collapse <?= in_array($current_page, array_keys($subject_pages)) ? 'show' : '' ?>" id="subjectCollapse">
                <ul class="nav flex-column ms-3">
                    <?php foreach ($subject_pages as $page => $icon): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $current_page == $page ? 'active' : '' ?>" href="<?= $page ?>">
                                <i class="fas <?= $icon ?> me-2"></i> <?= ucwords(str_replace('_', ' ', pathinfo($page, PATHINFO_FILENAME))) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </li>

        <!-- Exam Management -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#examCollapse" role="button">
                <i class="fas fa-file-alt me-2"></i> Exam Management
                <i class="fas fa-angle-down float-end mt-1"></i>
            </a>
            <div class="collapse <?= in_array($current_page, array_keys($exam_pages)) ? 'show' : '' ?>" id="examCollapse">
                <ul class="nav flex-column ms-3">
                    <?php foreach ($exam_pages as $page => $icon): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $current_page == $page ? 'active' : '' ?>" href="<?= $page ?>">
                                <i class="fas <?= $icon ?> me-2"></i> <?= ucwords(str_replace('_', ' ', pathinfo($page, PATHINFO_FILENAME))) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </li>
        
    </ul>
</div>

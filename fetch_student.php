<?php
// fetch_student.php
require 'includes/db.php';

header('Content-Type: application/json');

if (!isset($_GET['serial_no'])) {
    echo json_encode(['error' => 'Serial number is required']);
    exit;
}

$serialNo = $_GET['serial_no'];
$academicYearStart = $_GET['academic_year_start'] ?? '';
$academicYearEnd = $_GET['academic_year_end'] ?? '';

try {
    $stmt = $conn->prepare("SELECT * FROM students WHERE serial_no = ? AND academic_year_start = ? AND academic_year_end = ?");
    $stmt->execute([$serialNo, $academicYearStart, $academicYearEnd]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$student) {
        echo json_encode(['error' => 'Student not found']);
        exit;
    }
    
    // Format the data for the form
    $formattedData = [
        'class' => $student['class'],
        'specialization' => $student['specialization'],
        'entry_year' => $student['entry_year'],
        'student_name_mm' => $student['student_name_mm'],
        'student_name_en' => $student['student_name_en'],
        'nationality' => $student['nationality'],
        'religion' => $student['religion'],
        'birth_place' => $student['birth_place'],
        'nrc' => $student['nrc'],
        'dob' => $student['dob'],
        'address_township' => $student['address_township'],
        'address_region' => $student['address_region'],
        'phone' => $student['phone'],
        'father_name_mm' => $student['father_name_mm'],
        'father_name_en' => $student['father_name_en'],
        'father_nationality' => $student['father_nationality'],
        'father_religion' => $student['father_religion'],
        'father_nrc' => $student['father_nrc'],
        'father_birth_place' => $student['father_birth_place'],
        'father_address_township' => $student['father_address_township'],
        'father_address_region' => $student['father_address_region'],
        'father_phone' => $student['father_phone'],
        'father_job' => $student['father_job'],
        'mother_name_mm' => $student['mother_name_mm'],
        'mother_name_en' => $student['mother_name_en'],
        'mother_nationality' => $student['mother_nationality'],
        'mother_religion' => $student['mother_religion'],
        'mother_nrc' => $student['mother_nrc'],
        'mother_birth_place' => $student['mother_birth_place'],
        'mother_address_township' => $student['mother_address_township'],
        'mother_address_region' => $student['mother_address_region'],
        'mother_phone' => $student['mother_phone'],
        'mother_job' => $student['mother_job'],
        'entrance_exam_seat_number' => $student['entrance_exam_seat_number'],
        'entrance_exam_year' => $student['entrance_exam_year'],
        'entrance_exam_center' => $student['entrance_exam_center'],
        'supporter_name' => $student['supporter_name'],
        'supporter_relation' => $student['supporter_relation'],
        'supporter_job' => $student['supporter_job'],
        'supporter_address' => $student['supporter_address'],
        'supporter_phone' => $student['supporter_phone'],
        'grant_support' => $student['grant_support'],
        'current_house_no' => $student['current_home_no'],
        'current_street_no' => $student['current_street'],
        'current_quarter' => $student['current_quarter'],
        'current_village' => $student['current_village'],
        'current_township' => $student['current_township'],
        'current_phone' => $student['current_phone'],
        'signature_status' => $student['signature_status'],
        'citizen_status' => $student['citizen_status'],
        'father_citizen_status' => $student['father_citizen_status'],
        'mother_citizen_status' => $student['mother_citizen_status']
    ];
    
    echo json_encode($formattedData);
    
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
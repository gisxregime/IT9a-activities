<?php
require_once __DIR__ . '/db.php';
/** @var mysqli $conn */

function clean($value)
{
  return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
  $action = $_POST['action'];

  if ($action === 'insert') {
    $studentId = trim($_POST['student_id'] ?? '');
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $phoneNo = trim($_POST['phone_no'] ?? '');

    if ($studentId === '' || $firstName === '' || $lastName === '' || $gender === '' || $course === '') {
      header('Location: index.php?status=error&msg=' . urlencode('Please fill in all required fields.'));
      exit;
    }

    $stmt = $conn->prepare('INSERT INTO students (student_id, first_name, last_name, gender, email, course, phone_no) VALUES (?, ?, ?, ?, ?, ?, ?)');
    if (!$stmt) {
      header('Location: index.php?status=error&msg=' . urlencode('Database error: check students table in phpMyAdmin.'));
      exit;
    }
    $stmt->bind_param('sssssss', $studentId, $firstName, $lastName, $gender, $email, $course, $phoneNo);

    if ($stmt->execute()) {
      header('Location: index.php?status=success&msg=' . urlencode('Student added successfully.'));
      exit;
    }

    header('Location: index.php?status=error&msg=' . urlencode('Failed to add student.'));
    exit;
  }
}

$students = [];
$result = $conn->query('SELECT * FROM students ORDER BY id DESC');
if ($result) {
  while ($row = $result->fetch_assoc()) {
    $students[] = $row;
  }
}

$status = $_GET['status'] ?? '';
$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student CRUD</title>
  <link rel="stylesheet" href="packages/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="packages/fontawesome/css/all.min.css">
  <style>
    body {
      background: #f2f5f9;
    }
    .page-title {
      letter-spacing: 0.4px;
    }
    .action-col {
      min-width: 140px;
    }
  </style>
</head>
<body>
<div class="container py-4 py-lg-5">
  <div class="mb-4 d-flex align-items-center justify-content-between">
    <h1 class="h3 fw-bold page-title mb-0">Student Registration</h1>
  </div>

  <?php if ($msg !== ''): ?>
    <div class="alert <?= $status === 'success' ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
      <?= clean($msg) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <div class="row g-4">
    <div class="col-lg-4">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
          <strong><i class="fa-solid fa-user-plus me-2"></i>Insert Student</strong>
        </div>
        <div class="card-body">
          <form method="post">
            <input type="hidden" name="action" value="insert">

            <div class="mb-3">
              <label class="form-label">Student ID</label>
              <input type="text" name="student_id" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">First Name</label>
              <input type="text" name="first_name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Last Name</label>
              <input type="text" name="last_name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Gender</label>
              <select name="gender" class="form-select" required>
                <option value="">Select gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control">
            </div>

            <div class="mb-3">
              <label class="form-label">Course</label>
              <select name="course" class="form-select" required>
                <option value="">Select course</option>
                <option value="BSIT">BSIT</option>
                <option value="BSCS">BSCS</option>
                <option value="BSEMC">BSEMC</option>
                <option value="BSIS">BSIS</option>
                <option value="ACT">ACT</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Phone Number</label>
              <input type="text" name="phone_no" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100">
              <i class="fa-solid fa-floppy-disk me-2"></i>Save Student
            </button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white">
            <strong><i class="fa-solid fa-table me-2"></i>Student List</strong>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Student ID</th>
                  <th>Name</th>
                  <th>Gender</th>
                  <th>Email</th>
                  <th>Course</th>
                  <th>Phone</th>
                  <th class="action-col">Actions</th>
                </tr>
              </thead>
              <tbody>
              <?php if (count($students) === 0): ?>
                <tr>
                  <td colspan="8" class="text-center text-muted py-4">No students found.</td>
                </tr>
              <?php else: ?>
                <?php foreach ($students as $index => $student): ?>
                  <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= clean($student['student_id']) ?></td>
                    <td><?= clean($student['first_name'] . ' ' . $student['last_name']) ?></td>
                    <td><?= clean($student['gender']) ?></td>
                    <td><?= clean($student['email']) ?></td>
                    <td><?= clean($student['course']) ?></td>
                    <td><?= clean($student['phone_no']) ?></td>
                    <td class="action-col">
                      <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= (int) $student['id'] ?>">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= (int) $student['id'] ?>">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </td>
                  </tr>

                  <div class="modal fade" id="editModal<?= (int) $student['id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                      <div class="modal-content">
                        <form method="post" action="edit.php">
                          <input type="hidden" name="id" value="<?= (int) $student['id'] ?>">

                          <div class="modal-header">
                            <h5 class="modal-title">Edit Student</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>

                          <div class="modal-body row g-3">
                            <div class="col-md-6">
                              <label class="form-label">Student ID</label>
                              <input type="text" name="student_id" class="form-control" value="<?= clean($student['student_id']) ?>" required>
                            </div>
                            <div class="col-md-6">
                              <label class="form-label">Course</label>
                              <select name="course" class="form-select" required>
                                <option value="BSIT" <?= $student['course'] === 'BSIT' ? 'selected' : '' ?>>BSIT</option>
                                <option value="BSCS" <?= $student['course'] === 'BSCS' ? 'selected' : '' ?>>BSCS</option>
                                <option value="BSEMC" <?= $student['course'] === 'BSEMC' ? 'selected' : '' ?>>BSEMC</option>
                                <option value="BSIS" <?= $student['course'] === 'BSIS' ? 'selected' : '' ?>>BSIS</option>
                                <option value="ACT" <?= $student['course'] === 'ACT' ? 'selected' : '' ?>>ACT</option>
                              </select>
                            </div>
                            <div class="col-md-6">
                              <label class="form-label">First Name</label>
                              <input type="text" name="first_name" class="form-control" value="<?= clean($student['first_name']) ?>" required>
                            </div>
                            <div class="col-md-6">
                              <label class="form-label">Last Name</label>
                              <input type="text" name="last_name" class="form-control" value="<?= clean($student['last_name']) ?>" required>
                            </div>
                            <div class="col-md-6">
                              <label class="form-label">Gender</label>
                              <select name="gender" class="form-select" required>
                                <option value="Male" <?= $student['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= $student['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= $student['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                              </select>
                            </div>
                            <div class="col-md-6">
                              <label class="form-label">Phone Number</label>
                              <input type="text" name="phone_no" class="form-control" value="<?= clean($student['phone_no']) ?>">
                            </div>
                            <div class="col-12">
                              <label class="form-label">Email</label>
                              <input type="email" name="email" class="form-control" value="<?= clean($student['email']) ?>">
                            </div>
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Student</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="deleteModal<?= (int) $student['id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <form method="post" action="delete.php">
                          <input type="hidden" name="id" value="<?= (int) $student['id'] ?>">

                          <div class="modal-header">
                            <h5 class="modal-title">Delete Student</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Are you sure you want to delete <strong><?= clean($student['first_name'] . ' ' . $student['last_name']) ?></strong>?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="packages/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="packages/js/app.js"></script>
</body>
</html>
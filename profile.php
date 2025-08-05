<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $whatsapp = trim($_POST['whatsapp']);
        $dob = trim($_POST['dob']);

        try {
            $stmt = $pdo->prepare("UPDATE users SET 
                first_name = ?, last_name = ?, email = ?, whatsapp = ?, dob = ?
                WHERE id = ?");
            $stmt->execute([$first_name, $last_name, $email, $whatsapp, $dob, $user_id]);

            $message = "✅ Profile updated successfully!";
            $_SESSION['name'] = $first_name . ' ' . $last_name;
            // Role not updated here, so no changes
        } catch (PDOException $e) {
            $message = "❌ Error updating profile: " . $e->getMessage();
        }
    }
}

// Fetch user data to fill form
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    $message = "❌ Error fetching user data: " . $e->getMessage();
    $user = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile - Ticketist</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="profile-container">
    <div class="profile-content">
        <?php if ($message): ?>
            <div class="alert <?= strpos($message, '❌') !== false ? 'alert-error' : 'alert-success'; ?>">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="profile-grid">
            <!-- Left -->
            <div class="account-management">
                <h2>Profile Information</h2>
                <div class="profile-picture-section">
                    <div class="profile-picture">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop&crop=face" 
                             alt="Profile Picture" id="profile-preview">
                        <button class="remove-photo" onclick="removePhoto()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <button class="btn-secondary" onclick="document.getElementById('photo-upload').click()">
                        <i class="fas fa-upload"></i> Upload Photo
                    </button>
                    <input type="file" id="photo-upload" accept="image/*" style="display: none;" onchange="previewPhoto(this)">
                </div>
                <div style="margin-top: 20px;" class="btn-primary">
                    <a href="booking.php"><i class="fas fa-history"></i> View Booking History</a>
                </div>
            </div>

            <!-- Right -->
            <div class="profile-information">
                <form method="POST" class="profile-form">
                    <!-- Personal Info -->
                    <div class="form-section">
                        <h3>Personal Details</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" id="dob" name="dob" value="<?= isset($user['dob']) && $user['dob'] !== null ? date('Y-m-d', strtotime($user['dob'])) : '' ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="form-section">
                        <h3>Contact Info</h3>
                        <div class="form-group">
                            <label for="email">Email (required)</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="whatsapp">WhatsApp</label>
                                <input type="text" id="whatsapp" name="whatsapp" value="<?= htmlspecialchars($user['whatsapp'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <input type="text" id="role" name="role" readonly value="<?= htmlspecialchars($user['role'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="form-actions">
                        <button type="submit" name="update_profile" class="btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removePhoto() {
        document.getElementById('profile-preview').src = 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop&crop=face';
        document.getElementById('photo-upload').value = '';
    }
</script>
</body>
</html>

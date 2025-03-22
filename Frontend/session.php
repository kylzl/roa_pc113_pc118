<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['token'])) {
    $_SESSION['logged_in'] = true;
    echo json_encode(["status" => "success"]);
} else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            title: 'You are unauthorized!',
            icon: 'warning',
            confirmButtonText: 'Okay'
        }).then(() => {
            window.location.href = 'login-form.php';
        });
    </script>";
    exit;
}
?>

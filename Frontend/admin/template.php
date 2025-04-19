<?php
// include '../modals/profile-modal.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Attendance Monitoring</title>
  <link rel="icon" type="image/png" href="../images/uiia(2).png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
  <script src="../js/verify-token.js"></script>
  <style>
    body {
      background-color: #e9f1ff;
      font-family: 'Poppins', sans-serif !important;
      margin: 0;
      height: 100vh;
      font-size: small;
    }

    .sidebar {
      height: 100vh;
      width: 18%;
      position: fixed;
      top: 0;
      left: 0;
      background-color:  rgb(9, 3, 59);;
      box-shadow: 2px 0 5px rgba(255, 162, 162, 0.05);
    }

   h4.text-center-brand{
      color: rgb(3, 150, 255);
      font-weight: bold;
      margin-bottom: 2rem;
    }

    .sidebar a {
      padding: 12px 30px;
      display: block;
      color:#fff;
      font-weight: 500;
      text-decoration: none;
      transition: 0.3s;
      border-left: 4px solid transparent;
    }

    .sidebar a:hover, .sidebar a.active {
      background-color:rgb(56, 47, 138);
      border-left: 4px solid rgb(19, 13, 78);
      color:rgb(243, 247, 17);
    }

    .navbar {
      width: 100%;
      background-color:rgb(9, 3, 59);
      top: 0;
      position: fixed;
      z-index: 1000;
      overflow: hidden;
      display: flex;
      justify-content: space-between;
    }

  img.me-2-logo{
    padding-left: 50px;
    }

    .content {
      margin-top: 5%;
      margin-left: 18%;
      padding: 2rem;
    }
   .page-title {
      font-weight: 500;
      margin-right:100px;
      color: #e9f1ff;
    }

    .card-dashboard {
      border: none;
      border-radius: 10px;
      background-color:rgb(3, 150, 255);
      box-shadow: 0 5px 5px 0 #464646;
    }

    .modal-dialog-user {
      position: fixed;
      top: -10px;
      right: 10px;
      width: 15%;
      z-index: 9000; 
}

    #auth-user-name {
      cursor: pointer;
      color: #4a4a4a;
    }

    .modal-content .list-group a {
      font-size: 14px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg shadow-sm rounded p-2">
    <img src="../images/ams-logo.png" alt="" style="width: auto;  height: 50px;" class="me-2-logo">
      <h4 class="mb-0 page-title">
        <?php
          // $pagename = basename($_SERVER['PHP_SELF'], '.php');
          // switch($pagename){
          //     case 'users':
          //         echo 'Users';
          //         break;
          //     case 'reports':
          //         echo 'Reports';
          //         break;
          //     default:
          //         echo 'Dashboard';
          //         break;
          // }
        ?>
      </h4>

      <div class="d-flex align-items-center">
        <img src="../images/default-image.png"
             class="rounded-circle me-2"
             width="40"
             height="40"
             id="auth-user-image"
             data-bs-toggle="modal"
             data-bs-target="#userModal"
             style="cursor: pointer;">
      </div>
  </nav>

  <div class="sidebar mt-4 ">
    <a href="dashboard.php"><i class="fas fa-home me-4 mt-5 "></i> Dashboard</a>
    <a href="reports.php"><i class="fas fa-clipboard me-4"></i> Reports</a>
    <a href="student-list.php"><i class="fas fa-graduation-cap me-3"></i> Student Management</a>
    <a href="users.php"><i class="fas fa-users me-3"></i> Users</a>
  </div>



  <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-user">
      <div class="modal-content text-center p-3">
        <div class="modal-body">
          <img src="../images/default-image.png"
               class="rounded-circle mb-2"
               width="80"
               height="80"
               id="modal-auth-user-image"
               alt="Profile">
          <h6><p class="mb-0" id="auth-user-name"></p></h6>
          <p class="text-muted small mb-3" id="auth-user-email"></p>
          <hr>
          <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#updateProfileModal" data-id="${user.id}" >Profile</a>
          <a href="#" class="list-group-item list-group-item-action border-0" id="logoutButton">Logout</a>
          </div>
        </div>
      </div>
    </div>
  </div>





</body>
</html>

<script src="../js/logout.js"></script>
<script src="../js/template.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      const mainUserImage = document.getElementById('auth-user-image');
      const modalUserImage = document.getElementById('modal-auth-user-image');

      $('#userModal').on('show.bs.modal', function () {
          if (mainUserImage && modalUserImage) {
              modalUserImage.src = mainUserImage.src;
          }
      });
  });
</script>

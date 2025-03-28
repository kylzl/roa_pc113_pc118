
    <?php    
    include 'partials/header.php';
    include 'partials/sidebar.php';
    ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/verify-token.js"></script>   
    <div class="content">
        <nav class="navbar navbar-light bg-light mb-4">
            <div class="container-fluid d-flex justify-content-between">
                <span class="navbar-brand mb-0 h1">Dashboard</span>
            
            </div>
            
        </nav>

        <div class="">
        

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-3">
                    <div id="show-students" class="card text-white bg-danger p-3">
                        <h5>Total Students</h5>
                        <h3 id="total-students">0</h3>
                        <a href="students.php">See list</a>
                    </div>
                </div>
                <div class="col-md-3">
                <div id="show-employees" class="card text-white bg-success p-3">
                        <h5>Total Employee</h5>
                        <h3 id="total-employees">0</h3>
                        <a href="employees.php">See list</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>


    
    <script src="assets/js/fetch-employees.js"></script>   




 


<?php
include 'template.php';
include '../modals/upload-students-csv.php';
?>
<style>
    table.dataTable {
    border-collapse: collapse !important;
    background-color: aquamarine;
}

table.dataTable th,
table.dataTable td {
    /* border: 1px solid #09009; */
    padding: 6px 10px;
}

.btn-blue {
    background-color: #09033B;
    font-weight: bold;
    font-size: 20px;
    color: white;
    /* padding: 2px 4px; */
}
.btn-blue:hover{
    cursor: pointer;
    filter: brightness(95%);    
}

 .table-head {
    background-color:rgb(18, 51, 100);
    font-weight: bold;
}

</style>
<div class="content">
    <nav class="bar m-0 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">STUDENTS LIST</h5>
        </div>
        <div>
            <button class="btn blue px-3" data-bs-toggle="modal" data-bs-target="#addStudentModal" >
                +
            </button>
            <button class="btn" data-bs-toggle="modal" data-bs-target="#uploadStudentsModal" style="background-color:rgb(248, 233, 69); font-weight: bold;">
                UPLOAD/DOWNLOAD CSV
            </button>
        </div>
    </nav>

    <div class="container mt-3 px-0">

        <div class="card shadow-sm">
            <div class="card-body">
            <div class="container mt-3 px-0">
                <!-- <div class="d-flex justify-content-between mb-3">
                        <input type="text" class="form-control me-2 w-80" id="searchInput" placeholder="Search">
                        <select class="form-select w-25" id="yearLevelSelect"> 
                            <option selected disabled>Year Level</option>
                            <option value="first_year">First Year</option>
                            <option value="second_year">Second Year</option>
                        </select>
                    </div> -->
                <table class="table table-hover table-responsive" id="studentTable">
                    <thead class="table-secondary table-head">
                        <tr class="text-center">
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Students data here-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="../js/fetch-students.js"></script>

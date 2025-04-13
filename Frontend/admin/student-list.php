<?php
include 'template.php';
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<div class="content">
    <nav class="bar m-0">
        <div class="">
            <span class="bar-brand h6" id="total-students"></span>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadCsvModal">
                Import Students
            </button>
        </div>
    </nav>

    <div class="modal fade" id="uploadCsvModal" tabindex="-1" aria-labelledby="uploadCsvModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadCsvModalLabel">Upload CSV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="file" class="form-control mb-3" accept=".csv" id="csvInput" />
                    <button class="btn btn-primary w-100" onclick="upload()">Upload</button>
                </div>
            </div>
        </div>
    </div> 

    <div class="container mt-2 px-0">
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover table-striped table-bordered table-responsive" id="studentTable">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="../js/fetch-students.js"></script>
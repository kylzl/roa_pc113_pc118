<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/create-user.js"></script>
<!-- <script src="assets/js/verify-token.js"></script> -->

<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserLabel">Create User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createUserForm">
                    <div class="mb-3">
                        <label for="createUserName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="createUserName" placeholder="Your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="createUserEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="createUserEmail" placeholder="example@gmail.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="createUserPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="createUserPassword" placeholder="At least 6 characters" required>
                    </div>
                    <div class="mb-3">
                        <label for="createUserRole" class="form-label">Role</label>
                        <select class="form-control" id="createUserRole" required>
                            <option value="admin">Admin</option>
                            <option value="employee">Employee</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

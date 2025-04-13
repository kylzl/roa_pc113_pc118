<script src="../js/create-user.js"></script>
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserLabel">Create New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createUserForm">
                <div class="mb-3">
                        <label for="createUserImage" class="form-label">User Image</label>
                        <input type="file" class="form-control" id="createUserImage">
                    </div>
                    <div class="mb-3">
                        <label for="createUserName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="createUserName" required>
                    </div>
                    <div class="mb-3">
                        <label for="createUserEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="createUserEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="createUserPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="createUserPassword" required>
                    </div>
                    <div class="mb-3"></div>
                    <div class="mb-3">
                        <label for="createUserRole" class="form-label">Role</label>
                        <select class="form-control" id="createUserRole" required>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/update-user-modal.js"></script>

<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateUserLabel">Update User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateUserForm">
                    <input type="hidden" id="updateUserId">
                    <div class="mb-3">
                        <label for="updateUserName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="updateUserName" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateUserEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="updateUserEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateUserRole" class="form-label">Role</label>
                        <select class="form-control" id="updateUserRole" required>
                            <option value="admin">Admin</option>
                            <option value="employee">Employee</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
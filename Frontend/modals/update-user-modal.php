    <div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateUserLabel">Edit User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateUserForm">
                        <input type="hidden" id="updateUserId">
                        <div class="text-center mb-3">
                        <img 
                            id="update-profile-img-preview" 
                            src="../images/default-image.png" 
                            class="rounded-circle border" 
                            width="100" 
                            height="100" 
                            alt="Profile Preview"
                        />
                        <input 
                            type="file" 
                            name="profile_image" 
                            class="form-control mt-2" 
                            accept="image/*" 
                            onchange="previewImage(event)"
                        >
                    </div>

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
                                <option value="manager">Manager</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/update-user.js"></script>

    <script>
        let image = user.image 
                            ? `<img src="http://amsbackend.test/storage/${user.image}" alt="User Image" class="img-thumbnail" style="width: 50px; height: 50px;">` 
                            : `<img src="../images/default-image.png" alt="Default Image" class="img-thumbnail" style="width: 50px; height: 50px;">`;
    </script>
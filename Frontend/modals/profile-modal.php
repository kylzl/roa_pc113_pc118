<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="updateProfileForm" enctype="multipart/form-data">
        <div class="modal-body text-start">
          <div class="text-center mb-3">
            <img src="../images/default-image.png" id="update-profile-img-preview" class="rounded-circle" width="100" height="100" />
            <input type="file" name="profile_image" class="form-control mt-2" accept="image/*" onchange="previewImage(event)">
          </div>

          <div class="mb-3">
            <label for="updateName" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="updateName" name="name" >
          </div>

          <div class="mb-3">
            <label for="updateEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="updateEmail" name="email" >
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary w-100">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const previewImage = (e) => {
    $('#update-profile-img-preview').attr('src', URL.createObjectURL(e.target.files[0]));
  };
</script>

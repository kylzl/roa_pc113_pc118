<div class="modal fade" id="uploadStudentsModal" tabindex="-1" aria-labelledby="uploadCsvModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload CSV File</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="file" id="csvInput" class="dropify" accept=".csv" />
        <button class="btn btn-primary w-100 mt-3" onclick="upload()">Upload</button>
      </div>
    </div>
  </div>
</div>

<style>
    .dropify-wrapper .dropify-message p {
        font-size: 14px; 
    }
</style>

<script>
$(document).ready(function () {
  $('.dropify').dropify({
    messages: {
      default: 'Drag & drop a CSV file or click',
      replace: 'Drag & drop or click to replace',
      remove: 'Remove',
      error: 'Oops, something went wrong.'
    },
    error: {
      fileExtension: 'Only CSV files are allowed.'
    }
  });
});

function upload() {
  const notyf = new Notyf();
  const fileInput = document.getElementById("csvInput");

  if (!fileInput || fileInput.files.length === 0) {
    notyf.error("Please select a CSV file first.");
    return;
  }

  const token = localStorage.getItem("token");
  if (!token) {
    notyf.error("Authorization token is missing. Please log in again.");
    return;
  }

  const formData = new FormData();
  formData.append("csv_file", fileInput.files[0]);

  console.log("Uploading file to API...");

  $.ajax({
    url: "http://amsbackend.test/api/students/upload-csv",
    type: "POST",
    headers: {
      "Authorization": `Bearer ${token}`, 
      "Accept": "application/json"
    },
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {
      console.log("Upload success:", data);
      notyf.success(data.message || "File uploaded successfully!");
      $('#uploadStudentsModal').modal('hide');
    },
    error: function (xhr) {
      const error = xhr.responseJSON?.message || "Unknown error occurred.";
      console.error("Upload error:", error);
      notyf.error("Error: " + error);
    }
  });
}

</script>


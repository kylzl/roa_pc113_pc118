const currentPage = window.location.pathname.split("/").pop();
document.querySelectorAll(".sidebar a").forEach(link => {
  const linkPage = link.getAttribute("href");
  if (linkPage === currentPage) {
    link.classList.add("active");
  }
});

document.addEventListener('DOMContentLoaded', function () {
    const userImage = document.getElementById('auth-user-image');
    const modalUserImage = document.getElementById('modal-auth-user-image'); // Updated id

    if (userImage && modalUserImage) {
        modalUserImage.src = userImage.src;
    }
});
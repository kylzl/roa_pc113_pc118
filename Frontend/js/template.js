
const currentPage = window.location.pathname.split("/").pop();
document.querySelectorAll(".sidebar a").forEach(link => {
  const linkPage = link.getAttribute("href");
  if (linkPage === currentPage) {
    link.classList.add("active");
  }
});
document.addEventListener("DOMContentLoaded", function () {
  const hamburger = document.getElementById("hamburger");
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");

  // Open Sidebar
  hamburger.addEventListener("click", function () {
    sidebar.classList.add("open");
    overlay.classList.add("active");
  });

  // Close Sidebar when clicking outside
  overlay.addEventListener("click", function () {
    sidebar.classList.remove("open");
    overlay.classList.remove("active");
  });
});

function goTo(page) {
  document.body.style.opacity = "0";
  setTimeout(() => {
    window.location.href = page;
  }, 200);
}

window.addEventListener("DOMContentLoaded", () => {
  document.body.style.opacity = "0";
  document.body.style.transition = "opacity 0.4s ease";
  setTimeout(() => {
    document.body.style.opacity = "1";
  }, 50);
});

document.getElementById("themeToggle")?.addEventListener("click", () => {
  document.body.classList.toggle("dark");
});

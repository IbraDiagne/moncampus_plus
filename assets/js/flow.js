// Enregistrer le niveau choisi
function selectLevel(level) {
  localStorage.setItem("niveau", level);
  window.location.href = "semestre.php";
}

// Enregistrer le semestre
function selectSemestre(semestre) {
  localStorage.setItem("semestre", semestre);
  window.location.href = "matieres.php";
}

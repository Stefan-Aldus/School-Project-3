let young = document.getElementById("young");
let sharp = document.getElementById("sharp");
let old = document.getElementById("old");

young.addEventListener("click", () => {
  window.location.assign("./producten/jonge-kaas.php");
});
old.addEventListener("click", () => {
  window.location.assign("./producten/oude-kaas.php");
});
sharp.addEventListener("click", () => {
  window.location.assign("./producten/scherpe-kaas.php");
});

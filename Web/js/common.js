function addBorder(id) {
  const div = document.getElementById(id);
  div.classList.add('addBorder');
}

function rmvBorder(id) {
  const div = document.getElementById(id);
  div.classList.remove('addBorder');
}

function displayPassword(id1, id2) {
  const passField = document.getElementById(id1);
  const eyeField = document.getElementById(id2);

  eyeField.src = (passField.type === 'password') ? "asset/view.png" : "asset/hide.png";
  passField.type = (passField.type === 'password') ? 'text' : 'password';
}

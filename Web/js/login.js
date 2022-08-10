function handleSubmit(e) {
  var flag = true;

  var ids = {
    inputUsername: "username",
    inputPass1: "pass1"
  }

  for (const id in ids) {
    const text = document.getElementById(id).value
    if (text === '') {
      document.getElementById(ids[id]).style.visibility = 'visible'
      flag = false;
    } else {
      document.getElementById(ids[id]).style.visibility = 'hidden'
    }
  }
  return flag;
}


function changeUserType(id) {
  const active = document.getElementsByClassName('btnActive')
  var current = document.getElementById(id)
  active[0].className = active[0].className.replace(" btnActive", "")
  current.className += " btnActive"

  if (id === "customer" || id === "vendor") {
    document.getElementById('inputUserType').value = id === "customer" ? 'customer' : 'vendor'
  } else {
    document.getElementById('inputUserType').value = 'shipper'
  }
}

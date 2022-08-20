var counter = 1;
var limit = 50;

function addInput(divName) {
  if (counter === limit) {
    alert("You have reached the limit of adding " + counter + " inputs");
  } else {
    let div1 = document.createElement("div");
    div1.classList.add(
      "rounded",
      "w-full",
      "flex-col",
      "flex",
      "rounded-md",
      "bg-white",
      "py-3",
      "my-4",
      "px-6",
      "border",
      "border-[#e0e0e0]"
    );
    let div2 = document.createElement("div");
    div2.classList.add(
      "rounded",
      "w-full",
      "flex-col",
      "flex",
      "rounded-md",
      "bg-white",
      "py-3",
      "my-4",
      "px-6",
      "border",
      "border-[#e0e0e0]"
    );
    div1.innerHTML =
      "<input class='form-control' type='text' name='field[]' pattern='^[A-Za-z0-9-_ ]*$' placeholder='Field Name'>";
    div2.innerHTML =
      "<input class='form-control' type='text' name='val[]' pattern='^[A-Za-z0-9-\\/\\\\.,_%#& ]*$' placeholder='Value'>";
    document.getElementById(divName).appendChild(div1);
    document.getElementById(divName).appendChild(div2);
    counter++;
  }
}

function handleSubmit(e) {
  var flag = true;

  var ids = {
    inputName: "name",
    inputAddress: "address",
    inputHub: "disHub",
    inputLatitude: "latitude",
    inputLongitude: "longitude",
    inputUsername: "username",
    inputPass1: "pass1",
    inputPass2: "pass2",
  };

  const nameBlock = document.getElementById("nameBlock");
  const addressBlock = document.getElementById("addressBlock");
  const coordinateBlock = document.getElementById("coordinateBlock");
  const hubBlock = document.getElementById("hubBlock");
  if (hubBlock.hasChildNodes()) {
    delete ids["inputName"];
    delete ids["inputAddress"];
    delete ids["inputLatitude"];
    delete ids["inputLongitude"];
  } else {
    delete ids["inputHub"];
  }

  for (const id in ids) {
    const text = document.getElementById(id).value;
    if (text === "") {
      document.getElementById(ids[id]).style.visibility = "visible";
      flag = false;
    } else {
      document.getElementById(ids[id]).style.visibility = "hidden";
    }
  }

  const pass1 = document.getElementById("inputPass1").value;
  const pass2 = document.getElementById("inputPass2").value;

  if (pass1 !== pass2) {
    document.getElementById("wrongpass").style.visibility = "visible";
    flag = false;
  } else {
    document.getElementById("wrongpass").style.visibility = "hidden";
  }

  return flag;
}

function detectPass(id1, id2, id3) {
  const input = document.getElementById(id1).value;
  const div = document.getElementById(id2).style;
  const label = document.getElementById(id3);

  const strongPass =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}/;
  const mediumPass = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9]).{8,}/;
  if (input.match(strongPass)) {
    div.backgroundColor = "green";
    div.width = "80%";
    label.style.color = "green";
    label.textContent = "Strong";
  } else if (input.match(mediumPass)) {
    div.backgroundColor = "#FFD700";
    div.width = "50%";
    label.style.color = "#FFD700";
    label.textContent = "Medium";
  } else {
    div.backgroundColor = "red";
    div.width = "35%";
    label.style.color = "red";
    label.textContent = "Week";
  }
}

function changeUserType(id) {
  const active = document.getElementsByClassName("btnActive");
  var current = document.getElementById(id);
  active[0].className = active[0].className.replace(" btnActive", "");
  current.className += " btnActive";

  const nameBlock = document.getElementById("nameBlock");
  const addressBlock = document.getElementById("addressBlock");
  const coordinateBlock = document.getElementById("coordinateBlock");
  const hubBlock = document.getElementById("hubBlock");

  if (id === "customer" || id === "vendor") {
    hubBlock.innerHTML = null;
    document.getElementById("inputUserType").value =
      id === "customer" ? "customer" : "vendor";

    if (
      !nameBlock.hasChildNodes() &&
      !addressBlock.hasChildNodes() &&
      !coordinateBlock.hasChildNodes()
    ) {
      const block1 = document.createElement("div");
      block1.className = "input-block";
      block1.innerHTML = `<span id='name' class='req' style="float:right;">* Require</span>
                          <div style="clear:both;"></div>
                          <div class='wrapper'>
                            <div id='field1' class='input-control inside'>
                              <input id='inputName' type='text' placeholder=' ' name='name'
                              onclick="addBorder('field1')"
                              onBlur="rmvBorder('field1')">
                              <label class='move-out'>Name</label>
                            </div>
                          </div>`;

      const block2 = document.createElement("div");
      block2.className = "input-block";
      block2.innerHTML = `<span id='address' class='req' style="float:right;">* Require</span>
                          <div style="clear:both;"></div>
                          <div class='wrapper'>
                            <div id='field2' class='input-control inside'>
                              <input id='inputAddress' type='text' placeholder=' ' name='address'
                              onclick="addBorder('field2')"
                              onBlur="rmvBorder('field2')">
                              <label class='move-out'>Address</label>
                            </div>
                          </div>`;

      const block3 = document.createElement("div");
      block3.className = "input-block";
      block3.innerHTML = `<span id='latitude' class='req' style="float:left; margin-left: 10px;">* Require</span>
                          <span id='longitude' class='req' style="float:right; margin-right: 10px;">* Require</span>

                          <div style="clear:both;"></div>
                          <div class='wrapperSplit1' style="float: left; margin-left: 10px">
                            <div id='field6' class='input-control inside'>
                              <input id='inputLatitude' type='text' placeholder=' ' name='latitude'
                              onclick="addBorder('field6')"
                              onBlur="rmvBorder('field6')">
                              <label class='move-out'>Latitude</label>
                            </div>
                          </div>

                          <div class='wrapperSplit1' style="float:right; margin-right: 10px">
                            <div id='field7' class='input-control inside'>
                              <input id='inputLongitude' type='text' placeholder=' ' name='longitude'
                              onclick="addBorder('field7')"
                              onBlur="rmvBorder('field7')">
                              <label class='move-out'>Longitude</label>
                            </div>
                          </div>`;

      nameBlock.appendChild(block1);
      addressBlock.appendChild(block2);
      coordinateBlock.appendChild(block3);
    }
  } else {
    nameBlock.innerHTML = null;
    addressBlock.innerHTML = null;
    coordinateBlock.innerHTML = null;
    document.getElementById("inputUserType").value = "shipper";

    if (!hubBlock.hasChildNodes()) {
      const block1 = document.createElement("div");
      block1.className = "input-block";
      block1.innerHTML = `<span id='disHub' class='req' style="float:right;">* Require</span>
                          <div style="clear:both;"></div>
                          <div class="list-wrapper">
                            <div class="select-btn">
                              <label class="move-out">Select Hub</label>
                              <i class="uil uil-angle-down"></i>
                            </div>
                            <div class="content">
                                <input id="inputHub" spellcheck="false" type="text" name="disHub">
                              <ul class="options"></ul>
                            </div>
                         </div>`;

      hubBlock.appendChild(block1);

      const { wrapper, selectBtn, searchInp, options, countries } =
        getDropdownAttrs();

      addCountry();

      searchInp.addEventListener("keyup", () => {
        let arr = [];
        let searchWord = searchInp.value.toLowerCase();
        arr = countries
          .filter((data) => {
            return data.toLowerCase().startsWith(searchWord);
          })
          .map((data) => {
            let isSelected =
              data == selectBtn.firstElementChild.innerText ? "selected" : "";
            return `<li onclick="updateName(this)" class="${isSelected}">${data}</li>`;
          })
          .join("");
        options.innerHTML = arr
          ? arr
          : `<p style="margin-top: 10px;">Oops! Country not found</p>`;
      });
      selectBtn.addEventListener("click", () =>
        wrapper.classList.toggle("active")
      );
    }
  }
}

function updateName(selectedLi) {
  const { searchInp, wrapper, selectBtn } = getDropdownAttrs();
  searchInp.value = selectedLi.innerText;
  addCountry(selectedLi.innerText);
  wrapper.classList.remove("active");
  selectBtn.firstElementChild.style.color = "black";
  selectBtn.firstElementChild.innerText = selectedLi.innerText;
}

function addCountry(selectedCountry) {
  const { options, countries } = getDropdownAttrs();

  options.innerHTML = "";
  countries.forEach((country) => {
    let isSelected = country == selectedCountry ? "selected" : "";
    let li = `<li onclick="updateName(this)" class="${isSelected}">${country}</li>`;
    options.insertAdjacentHTML("beforeend", li);
  });
}

function getDropdownAttrs() {
  const wrapper = document.querySelector(".list-wrapper"),
    selectBtn = wrapper.querySelector(".select-btn"),
    searchInp = wrapper.querySelector("input"),
    options = wrapper.querySelector(".options");
  let countries = [
    "Shayna Kennermann",
    "Reena Ventum",
    "Melania McClarence",
    "Rosaline Bosche",
    "Laurence Puddan",
    "Garrot Appleton",
    "Penny Cairns",
    "Christabel Twentyman",
    "Arnoldo Burnhill",
    "Dexter Rowth",
    "Fenelia Dallander",
    "Amelie Schout",
    "Libby Bertome",
    "Mirilla Mabbitt",
  ];

  return { wrapper, selectBtn, searchInp, options, countries };
}

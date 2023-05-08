// Enable search option for select elements
$(document).ready(function () {
  //change select boxes to select mode to be searchable
  $("select").select2();
});

// A function for searching goods base on serial number
function search(val) {
  const resultBox = document.getElementById("s-result");
  const selected = document.getElementById("selected");
  const serialNumber = document.getElementById("serialNumber");

  if (val.length > 6) {
    serialNumber.value = val;
    resultBox.innerHTML =
      "<img id='loading' src='/spa/public/img/loading.gif' alt=''>";
    axios
      .get("getData/" + val)
      .then((response) => {
        resultBox.innerHTML = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
  } else {
    resultBox.innerHTML = "";
    selected.innerHTML = "";
  }
}

// A function to add a good to the relation box
function add(event) {
  const id = event.target.getAttribute("data-id");
  const remove = document.getElementById(id);

  const partnumber = event.target.getAttribute("data-partnumber");
  const price = event.target.getAttribute("data-price");
  const mobis = event.target.getAttribute("data-mobis");

  const result = document.getElementById("s-result");
  const selected = document.getElementById("selected");

  result.removeChild(remove);

  const item =
    `<div class='matched-item' id='m-` +
    id +
    `'>
            <p>` +
    partnumber +
    `</p>
            <i class='material-icons remove' onclick='remove(` +
    id +
    `)'>do_not_disturb_on</i>
            </div>`;

  selected.innerHTML += item;

  const relation_form = document.getElementById("relation-form");

  const input =
    ` <input id='c-` +
    id +
    `' type='checkbox' name='value[]' value='` +
    id +
    `' hidden checked>`;
  relation_form.innerHTML += input;
}

// A function to load data a good to the relation box
function load(event, pattern_id) {
  const id = event.target.getAttribute("data-id");
  const remove = document.getElementById(id);

  const result = document.getElementById("s-result");
  const selected = document.getElementById("selected");

  const mode = document.getElementById("mode");
  mode.value = "update-" + pattern_id;

  result.removeChild(remove);

  if (id) {
    selected.innerHTML =
      "<img id='loading' src='/spa/public/img/loading.gif' alt=''>";
    axios
      .get("loadData/" + id)
      .then((response) => {
        setData(response.data);
        axios
          .get("loadDescription/" + id)
          .then((response) => {
            setValue(response.data);
          })
          .catch((error) => {
            console.log(error);
          });
      })
      .catch((error) => {
        console.log(error);
      });
  }
}

// a function to set data
function setData(items) {
  const selected = document.getElementById("selected");
  const relation_form = document.getElementById("relation-form");

  selected.innerHTML = "";

  for (item of items) {
    selected.innerHTML +=
      `<div class='matched-item' id='m-` +
      item.id +
      `'>
            <p>` +
      item.partnumber +
      ` </p>
            <i class='material-icons remove' onclick='remove(` +
      item.id +
      `)'>do_not_disturb_on</i>
            </div>`;
    const input =
      ` <input id='c-` +
      item.id +
      `' type='checkbox' name='value[]' value='` +
      item.id +
      `' hidden checked>`;
    relation_form.innerHTML += input;
  }
}

// A function to remove added goods from relation box
function remove(id) {
  const item = document.getElementById("m-" + id);
  const remove_checkbox = document.getElementById("c-" + id);

  remove_checkbox.remove();
  item.remove();
}

// Get the selected input value to send data;
function setValue(data) {
  const name = document.getElementById("name");
  const car_id = document.getElementById("car_id");
  const status = document.getElementById("status");

  name.value = data.name;
  $("#car_id").val(data.name);
  $("#car_id").select2().trigger("change");
  car_id.value = data.car;
  $("#status").val(data.name);
  $("#status").select2().trigger("change");
  status.value = data.status;
}

// A function to handle the form submission
function send() {
  const data = [index, name, car_id, status];

  axios
    .post("/saveRelation", {
      firstName: "Finn",
      lastName: "Williams",
    })
    .then(
      (response) => {
        console.log(response);
      },
      (error) => {
        console.log(error);
      }
    );
}

var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("navbar").style.top = "0";
  }
  else {
    document.getElementById("navbar").style.top = "-50px";
  }
  prevScrollpos = currentScrollPos;
}

window.addEventListener('scroll', function() {
  var footer = document.getElementById('footer');
  var scrollPosition = window.innerHeight + window.pageYOffset;
  var documentHeight = document.body.offsetHeight;
  if (scrollPosition >= documentHeight) {
    footer.style.bottom = '0';
  } else {
    footer.style.bottom = '-50px';
  }
})

function confirmRemove(employeeID) {
  if (confirm("Are you sure you want to remove this employee?")) {
    window.location.href = "remove_employee.php?id=" + employeeID; /*+ "&IdCity=" + document.getElementById('cities').value;*/
  } else {
  }
}



document.addEventListener("DOMContentLoaded", function(){
  // Get the button that opens the modal
  var btn = document.getElementById("myBtn");

  // Get the modal
  var modal = document.getElementById("myModal");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks on the button, open the modal
  if (btn){
    btn.addEventListener('click', function (){
      modal.style.display = "block";
    });
  }

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
    document.getElementById("ModalForm").reset();
  }

  modal.addEventListener('click', function (e){
    if(e.target == modal){
      modal.style.display = "none";
      document.getElementById("ModalForm").reset();
    }
  });
});

function openModal(employeeID) {

  var employee = employees[employeeID];

  var modal = document.getElementById("myModal");
  modal.style.display = "block";

  document.getElementById("inputEmployeeID").value = employeeID;
  document.getElementById("inputFirstName").value = employee.FirstName;
  document.getElementById("inputLastName").value = employee.LastName;
  document.getElementById("inputTitle").value = employee.Title;
  document.getElementById("inputTitleOfCourtesy").value = employee.TitleOfCourtesy;
  document.getElementById("inputBirthDate").value = employee.BirthDate;
  document.getElementById("inputHireDate").value = employee.HireDate;
  document.getElementById("inputAddress").value = employee.Address;
  document.getElementById("inputIdCity").value = employee.IdCity;
};

document.addEventListener("DOMContentLoaded", function () {
  // Get references to the select and target elements
  const critlabel = document.getElementById("critlabel")
  const selectElement = document.getElementById("search_options");
  const search_city_properties = document.getElementById("search_city_properties");
  const search_year_properties = document.getElementById("search_year_properties");
  const search_title_properties = document.getElementById("search_title_properties");
  const search_employee_properties = document.getElementById("search_employee_properties");
  const submit_button = document.getElementById("submit_button");

  selectElement.addEventListener("change", function () {

    const selectedValue = selectElement.value;

    switch (selectedValue) {
      case "city":
        critlabel.style.display = "inline";
        search_city_properties.style.display = "inline";
        search_year_properties.style.display = "none";
        search_title_properties.style.display = "none";
        search_employee_properties.style.display = "none";
        break;
      case "years":
        critlabel.style.display = "inline";
        search_city_properties.style.display = "none";
        search_year_properties.style.display = "inline";
        search_title_properties.style.display = "none";
        search_employee_properties.style.display = "none";
        break;
      case "title":
        critlabel.style.display = "inline";
        search_city_properties.style.display = "none";
        search_year_properties.style.display = "none";
        search_title_properties.style.display = "inline";
        search_employee_properties.style.display = "none";
        break;
      case "employee":
        critlabel.style.display = "inline";
        search_city_properties.style.display = "none";
        search_year_properties.style.display = "none";
        search_title_properties.style.display = "none";
        search_employee_properties.style.display = "inline";
        break;
      default:
        critlabel.style.display = "none";
        search_city_properties.style.display = "none";
        search_year_properties.style.display = "none";
        search_title_properties.style.display = "none";
        search_employee_properties.style.display = "none";
        break;
    }
  });
});



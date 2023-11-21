// GET data from server using AJAX
const divTable = document.querySelector('.table-responsive');
divTable.addEventListener('click', (e) => {
	// pagination. if a link exists. link - e.target
	if(e.target.className === 'page-link'){
		e.preventDefault();
		let pageNumber = +e.target.dataset.page;
      // if pageNumber !== undefined set Ajax request on actions.php
      if(pageNumber) {
      	// отправить запрос
      	fetch('actions.php', {
      		method: 'POST',
      		body: JSON.stringify({ page: pageNumber })
      	})
      	// get dom text
      	.then((resp) => resp.text())
      	// insert dom to div.table-responsive
      	.then((data) => {
      		document.querySelector('.table-responsive').innerHTML = data;
      	});
      }
	}
});


// Create(Insert) city to DB (records: name and population)
const addCityForm = document.getElementById('addCityForm');
const btnAddSubmit = document.getElementById('btn-add-submit');

addCityForm.addEventListener('submit', (e) => {
   e.preventDefault();
   console.log(1);
   // поменять text кнопки
   btnAddSubmit.textContent = 'Saving...';
   // заблокировать кнопку
   btnAddSubmit.disabled = true;
   // отправить запрос
   // в массиве POST на сервере будут доступны поля name, population, addCity
   fetch('actions.php', {
  		method: 'POST',
  		// pass form
  		body: new FormData(addCityForm)
  	})
  	// get json from server
  	.then((resp) => resp.json())
  	// insert dom to div.table-responsive
  	.then((data) => {
  		// SweetAlert2 Modal window. Examples: https://sweetalert2.github.io/#examples
	    setTimeout(() => {
            Swal.fire({
                icon: data.answer,
                title: data.answer,
                html: data?.errors
            });
            // reset form
            if (data.answer === 'success') {
                addCityForm.reset();
            }
            // unblock send btn
            btnAddSubmit.textContent = 'Save';
            btnAddSubmit.disabled = false;
        }, 1000);
  	});
});





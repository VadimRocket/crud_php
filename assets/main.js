// GET data from server using AJAX
const divTable = document.querySelector('.table-responsive');
// Delegate events
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

    // Edit city. Get city for edit
    // check if btn Edit contains btn-edit class in table
    if(e.target.classList.contains('btn-edit')) {
        // get value from data-id attr 
        let id = +e.target.dataset.id;
        // if id !== undefined set Ajax request on actions.php
      if(id) {
        // отправить запрос если будет ключ get_city будем редактировать
        fetch('actions.php', {
            method: 'POST',
            body: JSON.stringify({ id: id, action: 'get_city' })
        })
        // get json data
        .then((resp) => resp.json())
        .then((data) => {
            if(data.answer === 'success') {
              // insert data to input fields. Edit form
              // Response: data = {"answer":"success","city":{"id":"33","name":"Willemstad","population":"2345"}}
              // Modal Form inputs Name: input id="editName" Population: input id=""editPopulation"
               const { id, name, population } = data.city;
               document.getElementById('editName').value = name;
               document.getElementById('editPopulation').value = population;
               // hidden input with id='id'
               document.getElementById('id').value = Number(id);
            }
        })
      }
    }

    // Delete city
    if (e.target.classList.contains('btn-delete')) {
        let id = +e.target.dataset.id;
        if (id) {
            fetch('actions.php', {
                method: 'POST',
                body: JSON.stringify({id: id, action: 'delete_city'})
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.answer === 'success') {
                    setTimeout(() => {
                        Swal.fire({
                            icon: data.answer,
                            title: data.answer,
                            html: data?.errors
                        });
                        if (data.answer === 'success') {
                            let tr = document.getElementById(`city-${id}`);
                            tr.remove();
                        }
                    }, 1000);
                }
            });
        }
    }
});


// Create(Insert) add city to DB (records: name and population)
addCityForm = document.getElementById('addCityForm');
btnAddSubmit = document.getElementById('btn-add-submit');

addCityForm.addEventListener('submit', (e) => {
   e.preventDefault();
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



// Edit city. Save data to DB (records: name and population)
editCityForm = document.getElementById('editCityForm');
btnEditSubmit = document.getElementById('btn-edit-submit');

editCityForm.addEventListener('submit', (e) => {
   e.preventDefault();
   // поменять text кнопки
   btnEditSubmit.textContent = 'Saving...';
   // заблокировать кнопку
   btnEditSubmit.disabled = true;
   // отправить запрос
   // в массиве POST на сервере будут доступны поля name, population, addCity
   fetch('actions.php', {
        method: 'POST',
        // pass form
        body: new FormData(editCityForm)
    })
    // get json from server
    .then((resp) => resp.json())
    // insert dom to div.table-responsive
    .then((data) => {
        setTimeout(() => {
            Swal.fire({
                icon: data.answer,
                title: data.answer,
                html: data?.errors
            });
            // if success rerender row data: name & population
            if (data.answer === 'success') {
                let idValue = document.getElementById('id').value; // get tr id
                let nameValue = document.getElementById('editName').value; // get input id
                let populationValue = document.getElementById('editPopulation').value; // get input id
                let tr = document.getElementById(`city-${idValue}`);
                tr.querySelector('.name').innerHTML = nameValue;
                tr.querySelector('.population').innerHTML = populationValue;
            }
            // unblock send btn
            btnEditSubmit.textContent = 'Save';
            btnEditSubmit.disabled = false;
        }, 1000);
    });
});


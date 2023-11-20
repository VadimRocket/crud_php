// GET data from server using AJAX
const divTable = document.querySelector('.table-responsive');
divTable.addEventListener('click', (e) => {
	// pagination. if a link exists. link - e.target
	if(e.target.className === 'page-link'){
		e.preventDefault();
		let pageNumber = +e.target.dataset.page;
      // if pageNumber !== undefined set Ajax request on actions.php
      if(pageNumber){
      	fetch('actions.php', {
      		method: 'POST',
      		body: JSON.stringify({ page: pageNumber })
      	})
      	// get dom text
      	.then((resp) => resp.text())
      	// insert dom to div.table-responsive
      	.then((data) => {
      		document.querySelector('.table-responsive').innerHTML = data;
      	})
      }
	}
});
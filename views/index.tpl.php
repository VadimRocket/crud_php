
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>CRUD PHP with Ajax & MySQL</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h1 class="text-center h2 my-3">CRUD PHP with Ajax MySQL</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <!-- Button -->
          <button class="btn btn-primary rounded btn-add" 
           data-bs-toggle="modal" 
           data-bs-target="#addCity"
          >Add city</button>
        </div>
        <!-- Table -->
        <div class="table-responsive my-3">
         <?php if(!empty($cities)): ?>
          <!-- Pagination -->
          <?= $pagination ?>
          <!-- .Pagination -->
          <table class="table table-hover">
            <thead class="table-dark">
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Population</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($cities as $city): ?>
              <tr id="city-<?= $city['id']?>">
                <th scope="row"><?= $city['id']?></th>
                <td><?= $city['name']?></td>
                <td><?= $city['population']?></td>
                <td>
                    <button class="btn btn-info btn-edit"
                      data-id="<?= $city['id']?>"
                      data-bs-toggle="modal" 
                      data-bs-target="#editCity"
                    >
                      Edit
                    </button>

                     <button class="btn btn-danger btn-delete"
                      data-id="<?= $city['id']?>"
                    >
                      Delete
                    </button>
                </td>
              </tr> 
            <?php endforeach;?>
            </tbody>
          </table>
           <!-- Pagination -->
           <?= $pagination ?>
          <!-- .Pagination -->
          <?php else: ?>
            <p>Cities not found...</p>
          <?php endif;?>
        </div>
      </div>
    </div>
  
    <!-- Modal add a city with id addCity-->
    <div class="modal fade" id="addCity" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add city</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal edit(update) a city with id editCity -->
    <div class="modal fade" id="editCity" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit city</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
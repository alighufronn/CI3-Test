<style>
    .todo-list {
        max-height: 300px;
    }
</style>

<div class="row">
  <div class="col-md-4 col-sm-6 col-12 todo">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-primary"><i class="fas fa-tasks"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">To Do</span>
        <span class="info-box-number todo-count">-</span>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-6 col-12 inprogress">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-info"><i class="fas fa-hourglass-half"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">In Progress</span>
        <span class="info-box-number inprogress-count">-</span>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-6 col-12 done">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-success"><i class="fas fa-check"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Done</span>
        <span class="info-box-number done-count">-</span>
      </div>
    </div>
  </div>
</div>

<div class="row">
    <!-- To Do -->
    <div class="col-md-6">
      <div class="card">
        <div class="card-header bg-gradient-primary">
          <h3 class="card-title">
            <i class="ion ion-clipboard mr-1"></i>
            To Do
          </h3>

          <div class="card-tools">
              <button type="button" class="btn btn-tool text-white" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </div>
        </div>
        <div class="card-body">
          <ul class="todo-list" id="todoList" data-widget="todo-list">
            <li class="empty-placeholder"></li>
          </ul>
        </div>
        <div class="card-footer clearfix">
          <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#todoAdd"><i class="fas fa-plus"></i> Add item</button>
        </div>
      </div>
    </div>

    <!-- In Progress -->
    <div class="col-md-6">
      <div class="card">
        <div class="card-header bg-gradient-info">
          <h3 class="card-title">
            <i class="ion ion-clipboard mr-1"></i>
            In Progress
          </h3>

          <div class="card-tools">
              <button type="button" class="btn btn-tool text-white" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </div>
        </div>
        <div class="card-body">
          <ul class="todo-list" id="inProgress" data-widget="todo-list">
                  
            <li class="empty-placeholder"></li>
          </ul>
        </div>
      </div>
    </div>
</div>

<div class="card">
  <div class="card-header bg-gradient-success">
    <h3 class="card-title">
      <i class="ion ion-clipboard mr-1"></i>
      Done
    </h3>

    <div class="card-tools">
        <button type="button" class="btn btn-tool text-white" data-card-widget="collapse"><i class="fas fa-minus"></i>
    </div>
  </div>
  <div class="card-body">
    <ul class="todo-list" id="done" data-widget="todo-list">
      <li class="empty-placeholder"></li>
    </ul>
  </div>
</div>



            <!-- Add Modal -->
            <div class="modal fade" id="todoAdd">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title text-bold">Tambahkan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="addForm">
                      <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" id="todoTitle" class="form-control">
                      </div>
                    </form>
                    <input type="text" id="todoStatus" value="todo" hidden>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="todoSave">Simpan</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- To Do Edit -->
            <div class="modal fade" id="todoEdit">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title text-bold">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="editForm">
                      <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" id="todoTitleEdit" class="form-control">
                      </div>
                      <input type="text" id="todoIDEdit" hidden>
                    </form>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="todoUpdate">Simpan</button>
                  </div>
                </div>
              </div>
            </div>

<script>
$(document).ready(function() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
    });

    // Menghitung jumlah
    function loadTodoCount() 
    {
      $.ajax({
        url: '<?= site_url('todoController/todo_count') ?>',
        method: 'GET',
        success: function(response) {
          response = JSON.parse(response);
          if (response.status === 'success') {
            console.log('Response: ', response.message);
            $('.todo-count').text(response.todo_count)
          } else {
            $('.todo-count').text('0');
          }
        },
        error: function(xhr, status, error) {
          console.error('Error: ', error);
        }
      })  
    }
    function loadProgressCount() 
    {
      $.ajax({
        url: '<?= site_url('todoController/progress_count') ?>',
        method: 'GET',
        success: function(response) {
          response = JSON.parse(response);
          if (response.status === 'success') {
            console.log('Response: ', response.message);
            $('.inprogress-count').text(response.progress_count)
          } else {
            $('.inprogress-count').text('0');
          }
        },
        error: function(xhr, status, error) {
          console.error('Error: ', error);
        }
      })  
    }
    function loadDoneCount() 
    {
      $.ajax({
        url: '<?= site_url('todoController/done_count') ?>',
        method: 'GET',
        success: function(response) {
          response = JSON.parse(response);
          if (response.status === 'success') {
            console.log('Response: ', response.message);
            $('.done-count').text(response.done_count)
          } else {
            $('.done-count').text('0');
          }
        },
        error: function(xhr, status, error) {
          console.error('Error: ', error);
        }
      })  
    }

    // Fungsi untuk memuat data
    function loads() {
        $.ajax({
            url: '<?= site_url('todoController/loads') ?>',
            method: 'GET',
            success: function(response) {
                console.log('Raw: ', response);
                var data = JSON.parse(response);
                console.log('Parsed: ', data);
                render(data);

                loadTodoCount();
                loadProgressCount();
                loadDoneCount();
                inisialisasiSortable();
            },
            error: function(xhr, status, error) {
                console.log('Error: ', error);
            }
        });
    }

    // Fungsi render
    function render(todo) {
        var todoList = $('#todoList');
        var inProgressList = $('#inProgress');
        var doneList = $('#done');

        if (todoList.length === 0 || inProgressList.length === 0 || doneList.length === 0) {
            console.error('Element with ID #todoList, #inProgress, or #done not found.');
            return;
        }

        if (!Array.isArray(todo)) {
            console.error('Invalid todo array.');
            return;
        }        

        todo.forEach(function(todos) {
            console.log('Todo item: ', todos);
            if (todos && todos.id && todos.title && todos.status !== undefined) {
                var list = `
                    <li data-id="${todos.id}">
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <span class="text text-title">${todos.title}</span>
                        <input type="text" class="todo-status" value="${todos.status}" hidden>
                        <div class="tools">
                            <button type="button" class="btn btn-warning btn-xs btnEdit"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-danger btn-xs btnDelete"><i class="fas fa-trash"></i></button>
                        </div>
                    </li>
                `;
                if (todos.status === 'todo') {
                    todoList.append(list);
                } else if (todos.status === 'progress') {
                    inProgressList.append(list);
                } else if (todos.status === 'done') {
                    doneList.append(list);
                }
            } else {
                console.error('Invalid todo item:', todos);
            }
        });

        inisialisasiSortable();
    }

    function renderUpdated(todo)
    {
      var list = $('li[data-id="' + todo.id +'"]');
      list.find('.text-title').text(todo.title);
    }

    function inisialisasiSortable() {
      $('.todo-list').sortable({
          connectWith: '.todo-list',
          placeholder: 'sort-highlight',
          handle: '.handle',
          forcePlaceholderSize: true,
          zIndex: 999999,
          scroll: true,
          scrollSensitivity: 100,
          stop: function(event, ui) {
              var item = ui.item;
              var newStatusId = item.closest('.todo-list').attr('id');

              var itemId = item.data('id');
              var itemTitle = item.find('.text-title').text();
              var newStatus;
              var location;

              if (newStatusId === 'todoList') {
                  newStatus = 'todo';
                  location = 'To Do';
              } else if (newStatusId === 'inProgress') {
                  newStatus = 'progress';
                  location = 'In Progress';
              } else if (newStatusId === 'done') {
                  newStatus = 'done';
                  location = 'Done';
              }

              item.find('.todo-status').val(newStatus);

              $.ajax({
                url: '<?= site_url('todoController/save_position') ?>',
                method: 'POST',
                data: {
                  item_id: itemId,
                  new_status: newStatus,
                },
                success: function(response) {
                  response = JSON.parse(response);
                  if (response.status === 'success') {
                    console.log(response);

                    Toast.fire({
                      icon: 'success',
                      title:'"' + itemTitle + '"' + ' berhasil dipindahkan ke ' + location,
                    });

                    loadTodoCount();
                    loadProgressCount();
                    loadDoneCount();
                  }
                },
              })

              updatePlaceholders();
          },
          update: function(event, ui) {
              updatePlaceholders();
          }
      }).disableSelection();

      updatePlaceholders();
    }

    function updatePlaceholders() {
      if ($('#todoList li').length === 1 && $('#todoList li').hasClass('empty-placeholder')) {
          $('#todoList .empty-placeholder').show();
      } else {
          $('#todoList .empty-placeholder').hide();
      }
      
      if ($('#inProgress li').length === 1 && $('#inProgress li').hasClass('empty-placeholder')) {
          $('#inProgress .empty-placeholder').show();
      } else {
          $('#inProgress .empty-placeholder').hide();
      }
      
      if ($('#done li').length === 1 && $('#done li').hasClass('empty-placeholder')) {
          $('#done .empty-placeholder').show();
      } else {
          $('#done .empty-placeholder').hide();
      }
    }

    // Mengambil data dengan ID
    $(document).on('click', '.btnEdit', function() 
    {
      $('#todoEdit').modal('show');

      var item = $(this).closest('li');
      var dataId = item.data('id');

      $.ajax({
        url: '<?= site_url('todoController/get_todo') ?>',
        method: 'POST',
        data: { id: dataId },
        success: function(response) {
          response = JSON.parse(response);
          if (response.status === 'success') {
            console.log('Response: ', response);
            var todo = response.data;

            $('#todoTitleEdit').val(todo.title);
            $('#todoIDEdit').val(todo.id);
          }
        },
      });
    });

    // Mengedit To Do
    $('#todoUpdate').on('click', function(e) {
      e.preventDefault();

      var titleEdit = $('#todoTitleEdit').val();
      var idEdit = $('#todoIDEdit').val();

      var todoEdit = {
        id: idEdit,
        title: titleEdit,
      };

      $.ajax({
        url: '<?= site_url('todoController/update_todo') ?>',
        method: 'POST',
        data: todoEdit,
        success: function(response) {
          response = JSON.parse(response);
          if (response.status === 'success') {
            renderUpdated(response.todo);
            console.log(response);
            console.log('Data succeed: ', todoEdit);

            Toast.fire({
              icon: 'success',
              title: response.message,
            });

            $('#todoEdit').modal('hide');
            $('#editForm')[0].reset();

            loadTodoCount();
            loadProgressCount();
            loadDoneCount();
          }
        },
        error: function(xhr, status, error) {
          console.log('Error: ', error);

          Toast.fire({
            icon: 'error',
            title: 'Gagal mengupdate data'
          });
        }
      })
    });

    
    // Hapus to do list
    $(document).on('click', '.btnDelete', function() 
    {
      var item = $(this).closest('li');
      var dataId = item.data('id');

      if (confirm('Apakah anda yakin ingin menghapus data ini?')) {
        $.ajax({
          url: '<?= site_url('todoController/delete_todo') ?>',
          method: 'POST',
          data: {id: dataId},
          success: function(response) {
            response = JSON.parse(response);
            if (response.status === 'success') {
              console.log(response);
              item.remove();
              updatePlaceholders();

              Toast.fire({
                icon: 'success',
                title: response.message,
              });

              loadTodoCount();
              loadProgressCount();
              loadDoneCount();
            }
          },
          error: function(xhr, status, error) {
            console.log('Error: ', error);
          }
        });
      }
    });

    loads();

    // Membuat To Do
    $('#todoSave').on('click', function(e) 
    {
        e.preventDefault();

        var todoTitle = $('#todoTitle').val();
        var todoStatus = $('#todoStatus').val();
        var id_user = '<?= htmlspecialchars($id_user ?? '', ENT_QUOTES, 'UTF-8'); ?>';

        var todoData = {
            id_user: id_user,
            title: todoTitle,
            status: todoStatus,
        };

        $.ajax({
            url: '<?= site_url('todoController/add_todo') ?>',
            method: 'POST',
            data: todoData,
            success: function(response) {
                response = JSON.parse(response);
                if (response.status === 'success') {
                    render([response.todo]);
                    console.log('Data: ', todoData);
                    console.log('Success: ', response);

                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil ditambahkan'
                    });
                    
                    $('#todoAdd').modal('hide');
                    $('#addForm')[0].reset();

                    loadTodoCount();
                    loadProgressCount();
                    loadDoneCount();

                    // Inisialisasi sortable setelah data ditambahkan
                    inisialisasiSortable();
                }
            },
            error: function(xhr, status, error) {
                console.log('Error: ', error);
                Toast.fire({
                    icon: 'error',
                    title: 'Gagal menambahkan data'
                });
            }
        });
    });

    loadTodoCount();
    loadProgressCount();
    loadDoneCount();
});


</script>
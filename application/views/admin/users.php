<?php if($logged_in): ?>
    <style>
        .selected-row {
            background-color: #3c8dbc !important;
            color: #fff;
        }
    </style>


    <?php if($role === 'admin'): ?>
    <input type="hidden" name="csrf_test_name" value="<?= $this->security->get_csrf_hash(); ?>">

        <div class="card">
            <div class="card-body">
                <div class="btn btn-primary float-right" data-toggle="modal" data-target="#addUser">Tambah User</div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover w-100 text-sm">
                    <thead class="table-bordered">
                        <tr>
                            <th style="width: 25%">Nama</th>
                            <th style="width: 25%">Username</th>
                            <th style="width: 25%">Role</th>
                            <th class="text-center" style="width: 25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="usersTable">
                        
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add User Modal -->
        <div class="modal fade" id="addUser">
            <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title text-bold">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <form id="addUserForm">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" id="namaUser" placeholder="Nama lengkap">
                    </div>
                    <div class="form-group">
                        <label for="">Role</label>
                        <select id="roleUser" class="form-control select2 w-100">
                            <option value="" disabled selected>── Select Role ──</option>
        
                            <?php foreach($roles as $role): ?>
                                <option value="<?= $role->role_name ?>"><?= $role->role_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Masukkan username">
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Masukkan password">
                    </div>
                </form>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveUser">Simpan</button>
                </div>
            </div>
            </div>
        </div>


        <!-- Edit User Modal -->
        <div class="modal fade" id="editUser">
            <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title text-bold">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <form id="editUserForm">
                    <input type="text" id="editID" hidden>
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" id="namaUserEdit" placeholder="Nama lengkap">
                    </div>
                    <div class="form-group">
                        <label for="">Role</label>
                        <select id="roleUserEdit" class="form-control select2 w-100">
                            <option value="" disabled>──     Select Role ──</option>
        
                            <?php foreach($roles as $role): ?>
                                <option value="<?= $role->role_name ?>"><?= $role->role_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" class="form-control" id="usernameEdit" placeholder="New Username">
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" id="passwordEdit" placeholder="New Password">
                    </div>
                </form>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnEditUser">Simpan</button>
                </div>
            </div>
            </div>
        </div>


      <script>
        $(document).ready(function() {
            $('#roleUser option').each(function() {
                var text = $(this).text();
                var capitalizedText = text.replace(/\b\w/g, function(letter) {
                    return letter.toUpperCase();
                });
                $(this).text(capitalizedText);
            });

            $('#roleUserEdit option').each(function() {
                var text = $(this).text();
                var capitalizedText = text.replace(/\b\w/g, function(letter) {
                    return letter.toUpperCase();
                });
                $(this).text(capitalizedText);
            });
        });
      </script>

      <script>
        $(document).ready(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
            });

            // Menampilkan data user
            loadUsers();

            function loadUsers() 
            {
                $.ajax({
                    url: '<?= site_url("UserController/load_users") ?>',
                    method: 'GET',
                    success: function(response) {
                        var users = JSON.parse(response);
                        renderUsers(users);
                    },
                    error: function(xhr, status, error) {
                        console.log('Error: ', error);
                    }
                });
            }

            function renderUsers(users) {
                var tbody = $('#usersTable');
                var role = '<?= $this->session->userdata("role") ?>';

                users.forEach(function(user) {
                    var row = `
                        <tr data-id="${user.id}" class="rowEdit">
                            <td>${user.name}</td>
                            <td>${user.username}</td>
                            <td>${user.role}</td>
                            <td class="text-center">
                                <button class="btn btn-danger btnDelete btn-sm" title="Hapus User"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    `;
                    tbody.append(row);
                });

                if (role !== 'admin') {
                    $('.btnEdit').hide();
                    $('.btnDelete').hide();
                }

                // Menghapus user
                $('.btnDelete').on('click', function() {
                    var row = $(this).closest('tr');
                    var user_id = row.data('id');
                    var csrf_token = $('input[name="csrf_test_name"]').val();

                    if (confirm('Apakah anda yakin ingin menghapus user ini?')) {
                        $.ajax({
                            url: '<?= site_url('UserController/delete_user') ?>',
                            method: 'POST',
                            data: { 
                                csrf_test_name: csrf_token,
                                id: user_id
                            },
                            success: function (response) {
                                response = JSON.parse(response);
                                if (response.status === 'success') {
                                    row.remove();
                                    Toast.fire({
                                        icon: 'success',
                                        title: response.message,
                                    });
                                } else {
                                    Toast.fire({
                                        icon: 'error',
                                        title: response.message,
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log('Error: ', error);
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Gagal menghapus data',
                                });
                            }
                        })
                    }
                });

                // Menampilkan data form edit
                $('table tbody tr').on('click', function() {
                    var modal = $('#editUser');
                    modal.modal('show');

                    var row = $(this).closest('tr');
                    var user_id = row.data('id');
                    var csrf_token = $('input[name="csrf_test_name"]').val();
                    
                    $('table tbody tr').removeClass('selected-row');
                    row.addClass('selected-row');

                    $.ajax({
                        url: '<?= site_url('UserController/get_users') ?>',
                        method: 'POST',
                        data: { 
                            csrf_test_name: csrf_token,
                            id: user_id 
                        },
                        success: function(response) {
                            response = JSON.parse(response);
                            if (response.status === 'success') {
                                 var user = response.user;

                                 $('#editID').val(user.id);
                                 $('#namaUserEdit').val(user.name);
                                 $('#roleUserEdit').val(user.role).trigger('change');
                                 $('#usernameEdit').val(user.username);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('Error: ', error);
                            Toast.fire({
                                icon: 'error',
                                title: 'Gagal menampilkan data',
                            });
                        }
                    });
                });

            }

            // Menyimpan data user
            $('#saveUser').on('click', function(e) {
                e.preventDefault();

                var modal = $('#addUser');

                var name = $('#namaUser').val();
                var role = $('#roleUser').val();
                var username = $('#username').val();
                var password = $('#password').val();
                var csrf_token = $('input[name="csrf_test_name"]').val();

                if (/\s/.test(username)) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Username tidak boleh memiliki spasi',
                    });
                    return;
                }

                var dataUser = {
                    csrf_test_name: csrf_token,
                    name: name,
                    role: role,
                    username: username,
                    password: password,
                };

                $.ajax({
                    url: '<?= site_url("UserController/add_user") ?>',
                    method: 'POST',
                    data: dataUser,
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status === 'success') {
                            renderUsers([response.user]);
                            console.log('Data berhasil disimpan: ', dataUser);
                            Toast.fire({
                                icon: 'success',
                                title: response.message,
                            });
                            modal.modal('hide');
                            $('#addUserForm')[0].reset();
                        } else (
                            Toast.fire({
                                icon: 'error',
                                title: response.message,
                            })
                        )
                    },
                    error: function(xhr, status, error) {
                        console.log('Error: ', error);
                        Toast.fire({
                            icon: 'error',
                            title: 'Gagal menyimpan data',
                        });
                    },
                })
            });

            // Mengedit user
            $('#btnEditUser').on('click', function(e) {
                e.preventDefault();

                var user_id = $('#editID').val();
                var name = $('#namaUserEdit').val();
                var role = $('#roleUserEdit').val();
                var username = $('#usernameEdit').val();
                var password = $('#passwordEdit').val();
                var csrf_token = $('input[name="csrf_test_name"]').val();

                console.log('Token: ', csrf_token);

                if(/\s/.test(username)) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Username tidak boleh memiliki spasi'
                    });
                    return;
                }

                var newData = {
                    csrf_test_name: csrf_token,
                    id: user_id,
                    name: name,
                    role: role,
                    username: username,
                    password: password
                };

                $.ajax({
                    url: '<?= site_url('UserController/edit_user') ?>',
                    method: 'POST',
                    data: newData,
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status === 'success') {
                            console.log('Response: ', response);
                            updateUserRow(response.user);
                            console.log('Data: ', newData);

                            Toast.fire({
                                icon: 'success',
                                title: response.message,
                            });
                            $('#editUser').modal('hide');
                            $('#editUserForm')[0].reset();
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: response.message
                            });

                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error: ', error);
                        console.log('Data', newData);
                        Toast.fire({
                            icon: 'error',
                            title: 'Gagal mengedit data',
                        });
                    }
                })
            });

            function updateUserRow(user) {
                var row = $('tr[data-id="' + user.id +'"]');
                row.find('td:nth-child(1)').text(user.name);
                row.find('td:nth-child(2)').text(user.username);
                row.find('td:nth-child(3)').text(user.role);
            }
        });
      </script>


    <?php endif; ?>
<?php endif; ?>
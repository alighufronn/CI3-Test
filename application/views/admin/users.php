<?php 
// $allowed_roles = array('admin', 'owner', 'guest');
// if (in_array($role, $allowed_roles)): 
?>
    <!-- Konten yang hanya dapat diakses oleh admin, owner, atau guest -->
    <?php //echo htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8'); ?>
<?php //endif; ?>


<?php if($logged_in): ?>
    <?php if($role === 'admin'): ?>

        <div class="card">
            <div class="card-body">
                <div class="btn btn-primary float-right">Tambah User</div>
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
                    <tbody>
                        <?php foreach($users as $user): ?>
                            <tr>
                                <td><?= $user->name ?></td>
                                <td><?= $user->username ?></td>
                                <td><?= $user->role ?></td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm m-1" title="Edit User"><i class="fas fa-edit"></i></button>
                                    <a href="" class="btn btn-danger btn-sm m-1" title="Hapus User"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>


    <?php endif; ?>
<?php endif; ?>
<style>
    #btnAdd {
        width: 100%;
    }
    .card-title {
        text-align: center;
    }
    @media (min-width: 576px) {
        #btnAdd {
            width: auto;
        }
        .card-title {
            text-align: left;
        }
    }

    #sell-table tbody tr {
        cursor: pointer;
    }
</style>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <div class="row">
                    <div class="col-sm-6 mt-3">
                        <label class="card-title">Shop</label>
                    </div>
                    <div class="col-sm-6 mt-3">
                        <?php if($role === 'admin'): ?>
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#add-modal">Add Item</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="sell-table" class="table display table-striped" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center table-bordered">No.</th>
                            <th class="text-nowrap">Nama Item</th>
                            <th class="text-center">Kategori</th>
                            <th>Harga</th>
                            <th class="text-center">Stock</th>
                        </tr>
                    </thead>
                    <tbody id="list-item">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div id="keranjang" style="max-height: 400px;">
                    <div class="card bg-gradient-light">
                        <div class="card-body">
                            <h5 class="text-bold">Item</h5>
                            <span>Rp. </span><span id="harga-item-satuan">100000</span>
                            <br><br>
                            <label for="">Total:</label>
                            <h5 class="text-bold">Rp. <span id="harga-item-total"></span></h5>
                            <div class="input-group">
                                <button class="btn btn-sm btn-primary" id="kurang"><i class="fas fa-minus"></i></button>
                                <input type="text" class="form-control form-control-sm text-center" id="qty-item" value="1">
                                <button class="btn btn-sm btn-primary" id="tambah"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($role === 'admin'): ?>
<!-- Add Modal -->
<div class="modal fade" id="add-modal">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <label class="modal-title">Tambahkan Item</label>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-add">
            <div class="form-group">
                <label for="">Nama Item</label>
                <input type="text" class="form-control" id="item" placeholder="Masukkan nama item">
            </div>
            <div class="form-group">
                <label for="">Kategori</label>
                <select id="kategori" class="form-control select2" style="width: 100%;">
                </select>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="form-group">
                        <label for="">Harga</label>
                        <input type="number" class="form-control text-right" id="harga">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Stock</label>
                        <input type="number" class="form-control text-right" id="stock">
                    </div>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary" id="saveItem">Simpan</button>
        </div>
      </div>
    </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="edit-modal">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <label class="modal-title">Tambahkan Item</label>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="text" id="editID" hidden>
            <div class="form-group">
                <label for="">Nama Item</label>
                <input type="text" class="form-control" id="editItem" placeholder="Masukkan nama item">
            </div>
            <div class="form-group">
                <label for="">Kategori</label>
                <select id="editKategori" class="form-control select2" style="width: 100%;">
                </select>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="form-group">
                        <label for="">Harga</label>
                        <input type="number" class="form-control text-right" id="editHarga">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Stock</label>
                        <input type="number" class="form-control text-right" id="editStock">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-danger" id="btnDeleteItem">Hapus</button>
          <button type="button" class="btn btn-primary" id="btnEditItem">Simpan</button>
        </div>
      </div>
    </div>
</div>
<?php endif; ?>

<script>
    $(document).ready(function() 
    {
        var userId = '<?= htmlspecialchars($id_user ?? '', ENT_QUOTES, 'UTF-8'); ?>';
        var userName = '<?= htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8'); ?>';
        var role = '<?= htmlspecialchars($role ?? '', ENT_QUOTES, 'UTF-8'); ?>';

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
        });

        var sellTable = $('#sell-table').DataTable({
            'lengthMenu': [[25, 50, 100, -1], ['25', '50', '100', 'Show all']],
            'responsive': true,
            'autoWidth': true,
            'scrollX': true,
            'scrollY': '600px',
            'language': {
                'lengthMenu': '_MENU_',
                'search': '',
                'searchPlaceholder': 'Search',
                'paginate': {
                    'previous': '⟵',
                    'next': '⟶',
                    'first': '',
                    'end': '',
                }
            }
        });

        function renderCategory(cats) 
        {
            var select = $('#kategori');
            select.empty();

            var defaultOption = '<option value="" disabled selected>━━ Pilih Kategori ━━</option>';
            select.append(defaultOption);

            cats.forEach(function(cat) {
                var option = `
                    <option value="${cat.kategori}">${cat.kategori}</option>
                `;

                select.append(option);
            });
        }

        function renderCategory2(cats) 
        {
            var select = $('#editKategori');
            select.empty();

            var defaultOption = '<option value="" disabled selected>━━ Pilih Kategori ━━</option>';
            select.append(defaultOption);

            cats.forEach(function(cat) {
                var option = `
                    <option value="${cat.kategori}">${cat.kategori}</option>
                `;

                select.append(option);
            });
        }

        // Memuat kategori
        function loadCategory() 
        {
            $.ajax({
                url: '<?= site_url('TransactionController/load_category') ?>',
                method: 'GET',
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success' && Array.isArray(data.categories)) {
                        renderCategory(data.categories);
                        renderCategory2(data.categories);
                    } else {
                        console.error('Response bukan array');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Gagal memuat kategori');
                }
            })
        }

        function loads()
        {
            $.ajax({
                url: '<?= site_url('TransactionController/loads') ?>',
                method: 'GET',
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        renderItems(data.items);
                    } else {
                        console.error('Response bukan array');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Gagal memuat kategori');
                }
            })
        }

        // Memuat item di tabel
        function renderItems(items)
        {
            var index = sellTable.rows().count() + 1;

            items.forEach(function(item) {
                var row = $('<tr>').attr('data-id', item.id);

                row.append(`<td class="text-center table-bordered">${index++}</td>`);
                row.append(`<td name="item">${item.item_name}</td>`);
                row.append(`<td name="kategori">${item.kategori}</td>`);
                row.append(`<td>Rp. <span name="harga">${item.harga}</span></td>`);
                row.append(`<td name="stock" class="text-center">${item.stock}</td>`);

                sellTable.row.add(row);
            });
            sellTable.columns.adjust().draw();
        }

        <?php if($role === 'admin'): ?>
            // Save Item
        $('#saveItem').on('click', function(e) 
        {
            e.preventDefault();

            var item = $('#item').val();
            var kategori = $('#kategori').find('option:selected').val();
            var harga = $('#harga').val();
            var stock = $('#stock').val();
            
            var itemData = {
                seller_id: userId,
                seller_name: userName,
                item_name: item,
                kategori: kategori,
                stock: stock,
                harga: harga
            };

            $.ajax({
                url: '<?= site_url('TransactionController/item_add') ?>',
                method: 'POST',
                data: itemData,
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        console.log('Data:', response);
                        renderItems([data.items]);

                        $('#add-modal').modal('hide');
                        $('#form-add').val('');

                        Toast.fire({
                            icon: 'success',
                            title: data.message,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ', error);
                }
            })
        });
        <?php endif; ?>

        // Menampilkan value di form edit
        $('#sell-table tbody').on('click', 'tr', function(e) 
        {
            e.preventDefault();

            if (role === 'admin') {
                $('#edit-modal').modal('show');
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Lu bukan admin jir'
                });
            }

            var id = $(this).data('id');
            var item = $(this).find('td[name="item"]').text();
            var kategori = $(this).find('td[name="kategori"]').text();
            var harga = $(this).find('td span[name="harga"]').text();
            var stock = $(this).find('td[name="stock"]').text();

            console.log('Value: ', id);

            $('#editID').val(id);
            $('#editItem').val(item);
            $('#editKategori').val(kategori).change();
            $('#editHarga').val(harga);
            $('#editStock').val(stock);
        });

        <?php if($role === 'admin'): ?>
            // Mengedit item
        function updateRow(item)
        {
            var row = sellTable.row($('tr[data-id="' + item.id + '"]')).node();

            $(row).find('td').eq(1).text(item.item_name);
            $(row).find('td').eq(2).text(item.kategori);
            $(row).find('td').eq(3).find('span[name="harga"]').text(item.harga);
            $(row).find('td').eq(4).text(item.stock);

            sellTable.draw(false);
        }
        $('#btnEditItem').on('click', function(e) 
        {
            e.preventDefault();

            var id = $('#editID').val();
            var item = $('#editItem').val();
            var kategori = $('#editKategori').val();
            var harga = $('#editHarga').val();
            var stock = $('#editStock').val();

            var newData = {
                id: id,
                item_name: item,
                kategori: kategori,
                harga: harga,
                stock: stock
            };

            $.ajax({
                url: '<?= site_url('TransactionController/item_edit') ?>',
                method: 'POST',
                data: newData,
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        updateRow(data.items[0]);
                        console.log('Response: ', response);

                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        });
                        $('#edit-modal').modal('hide');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ', error);

                    Toast.fire({
                        icon: 'error',
                        title: 'Gagal mengedit item'
                    })
                }
            });
        });

        // Menghapus item
        $('#btnDeleteItem').on('click', function() 
        {
            var id = $('#editID').val();
            var row = sellTable.row($('tr[data-id="'+ id +'"]'));

            $.ajax({
                url: '<?= site_url('TransactionController/item_delete') ?>',
                method: 'POST',
                data: {id: id},
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        console.log('Data', data);
                        row.remove().draw(false);
                        Toast.fire({
                            icon: 'success',
                            title: data.message,
                        });

                        $('#edit-modal').modal('hide');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ', error);
                    Toast.fire({
                        icon: 'error',
                        title: data.message
                    });
                }
            });
        });
        <?php endif; ?>

        loads();
        loadCategory();
    });
</script>

<script>
    $(document).ready(function() 
    {
        $('#kurang').on('click', function() 
        {
            var qty = parseInt($('#qty-item').val());
            if (qty > 1) {
                $('#qty-item').val(qty - 1);
            }
            totalHargaItem();
        });

        $('#tambah').on('click', function() 
        {
            var qty = parseInt($('#qty-item').val());
            $('#qty-item').val(qty + 1);
            totalHargaItem();
        });

        $('#qty-item').on('blur', function() 
        {    
            if ($(this).val() < 1) {
                $(this).val('1');
            }
            totalHargaItem();
        })

        function totalHargaItem()
        {
            var hargaItem = $('#harga-item-satuan').text();
            var qtyItem = $('#qty-item').val();

            var total = hargaItem * qtyItem;
            $('#harga-item-total').text(formatNumber(total));

            console.log('Total: ', total);
        }

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        totalHargaItem();
    });

</script>
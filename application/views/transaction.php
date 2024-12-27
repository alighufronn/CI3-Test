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

    #keranjang, #keranjang-text {
        display: none;
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
        <?php if($role !== 'admin'): ?>
            <label for="" class="text-bold" id="keranjang-text">Keranjang</label>
            <div id="keranjang" style="max-height: 450px; overflow-y: scroll; padding: 10px;">
                
            </div>
            <div class="card shadow" id="card-bayar">
                <div class="card-body">
                    <h5 class="text-bold">Total: Rp. <span id="grand-total">0</span></h5>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary w-100" id="btnCheckout" disabled>Checkout</button>
                </div>
            </div>
        <?php endif; ?>
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
                var row = $('<tr>').attr('data-id', item.id).attr('data-seller-id', item.seller_id).attr('data-seller-name', item.seller_name);

                row.append(`<td class="text-center table-bordered">${index++}</td>`);
                row.append(`<td name="item">${item.item_name}</td>`);
                row.append(`<td name="kategori">${item.kategori}</td>`);
                row.append(`<td>Rp. <span name="harga">${item.harga}</span></td>`);
                row.append(`<td name="stock" class="text-center stock">${item.stock}</td>`);

                sellTable.row.add(row);
            });
            sellTable.columns.adjust().draw();

            disableRow();
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
                        $('#form-add')[0].reset();

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

        // Menampilkan value di form edit
        $('#sell-table tbody').on('click', 'tr', function(e) 
        {
            e.preventDefault();

            if (role === 'admin') {
                $('#edit-modal').modal('show');
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

        // Mengedit item
        function updateRow(item)
        {
            var row = sellTable.row($('tr[data-id="' + item.id + '"]')).node();

            $(row).find('td').eq(1).text(item.item_name);
            $(row).find('td').eq(2).text(item.kategori);
            $(row).find('td').eq(3).find('span[name="harga"]').text(item.harga);
            $(row).find('td').eq(4).text(item.stock);

            sellTable.row(row).invalidate().draw(false);
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

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function calculateGrandTotal()
        {
            var grandTotal = 0;

            $('#keranjang').find('.harga-item-total').each(function() {
                var total = parseFloat($(this).text().replace(/[^0-9,-]+/g, ""));
                if (!isNaN(total)) {
                    grandTotal += total;
                }
            });

            $('#grand-total').text(grandTotal.toLocaleString("id-ID"));
        }

        <?php if($role !== 'admin'): ?>
            $('#sell-table tbody').on('click', 'tr', function() {
                var keranjang = $('#keranjang');
                var keranjangText = $('#keranjang-text');
                var checkout = $('#btnCheckout');
                
                var id = $(this).data('id');
                var seller_id = $(this).data('seller-id');
                var seller_name = $(this).data('seller-name');
                var item = $(this).find('td[name="item"]').text();
                var harga = $(this).find('td span[name="harga"]').text();
                var stock = $(this).find('td[name="stock"]').text();
                
                if (keranjang.find(`div[data-item-id="${id}"]`).length > 0) {
                    Toast.fire({
                        icon: 'info',
                        title: 'Item ini sudah ditambahkan ke dalam keranjang'
                    });
                    return;
                }

                console.log('Isi: ', stock);

                var card = `
                    <div class="card" data-item-id="${id}" data-seller-id="${seller_id}" data-seller-name="${seller_name}" data-stock="${stock}">
                        <div class="card-body">
                            <button class="btn btn-sm btn-danger float-right btnHapusItem"><i class="fas fa-trash"></i></button>
                            <h5 class="text-bold">${item}</h5>
                            <div class="text-xs text-gray">Stock: ${stock}</div>
                            <span>Rp. </span><span class="harga-item-satuan" id="harga-item-satuan">${harga}</span>
                            <br><br>
                            <h5 class="text-bold">Rp. <span class="harga-item-total" id="harga-item-total"></span></h5>
                            <div class="input-group">
                                <button class="btn btn-sm btn-primary kurang" id="kurang"><i class="fas fa-minus"></i></button>
                                <input type="text" class="form-control form-control-sm text-center qty-item" id="qty-item" value="1">
                                <button class="btn btn-sm btn-primary tambah" id="tambah"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    `;

                keranjang.append(card);

                keranjang.find('.kurang').last().on('click', function() 
                {
                    var qtyInput = $(this).siblings('.qty-item');
                    var qty = parseInt(qtyInput.val());
                    if (qty > 1) {
                        qtyInput.val(qty - 1);
                        totalHargaItem($(this).closest('.card'));
                    }
                });

                keranjang.find('.tambah').last().on('click', function() 
                {
                    var qtyInput = $(this).siblings('.qty-item');
                    var qty = parseInt(qtyInput.val());
                    var card = $(this).closest('.card');
                    var stock = parseInt(card.data('stock'));
                    
                    if (qty < stock) {
                        qtyInput.val(qty + 1);
                        totalHargaItem(card);
                    } else {
                        Toast.fire({
                            icon: 'warning',
                            title: 'Stock tidak mencukupi',
                        })
                    }
                });

                keranjang.find('.qty-item').last().on('blur', function() 
                {
                    var card = $(this).closest('.card');
                    var stock = parseInt(card.data('stock'));

                    var qty = parseInt($(this).val());
                    if (qty < 1 || isNaN(qty)) {
                        $(this).val(1);
                    }

                    if (qty > stock) {
                        $(this).val(stock);
                    }
                    totalHargaItem(card);
                });

                if (card.length > 0) {
                    checkout.prop('disabled', false);
                }

                keranjang.find('.btnHapusItem').last().on('click', function()
                {
                    var card = $(this).closest('.card');
                    card.remove();

                    if (keranjang.find('.card').length < 1) {
                        keranjang.css('display', 'none');
                        keranjangText.css('display', 'none');
                        checkout.prop('disabled', true);
                    }
                    calculateGrandTotal();
                });
                
                totalHargaItem(keranjang.find('.card').last());

                keranjang.css('display', 'block');
                keranjangText.css('display', 'block');

                calculateGrandTotal();
            });
        <?php endif; ?>

        function totalHargaItem(card)
        {
            var hargaItem = parseFloat(card.find('#harga-item-satuan').text().replace(/[^0-9.-]+/g, ""));
            var qtyItem = parseInt(card.find('.qty-item').val());

            var total = hargaItem * qtyItem;
            card.find('#harga-item-total').text(total.toLocaleString("id-ID"));

            console.log('Total: ', total);

            calculateGrandTotal();
        }

        calculateGrandTotal();


        <?php if($role !== 'admin'): ?>
            function disableRow() 
            {
                $('#sell-table tbody tr').each(function() {
                    var stock = parseInt($(this).find('.stock').text());
                    if (stock === 0) {
                        $(this).addClass('stock-0');
                        $(this).css('pointer-events', 'none');
                        $(this).css('filter', 'brightness(70%)');
                    } else {
                        $(this).removeClass('stock-0');
                        $(this).css('pointer-events', 'auto');

                        $(this).off('click').on('click', function() 
                        {
                            if (role === 'admin') {
                                $('#edit-modal').modal('show');
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
                    }
                });
            }

            disableRow();

            // Add
            $('#btnCheckout').on('click', function(e) {
                e.preventDefault();

                var items = [];

                $('#keranjang .card').each(function() {
                    var item = {
                        item_id: $(this).data('item-id'),
                        seller_id: $(this).data('seller-id'),
                        seller_name: $(this).data('seller-name'),
                        item_name: $(this).find('h5.text-bold').first().text(),
                        harga_satuan: parseIndonesianNumber($(this).find('.harga-item-satuan').text()),
                        qty: parseInt($(this).find('.qty-item').val()),
                        harga_total: parseIndonesianNumber($(this).find('.harga-item-total').text()),
                    };
                    items.push(item);
                });

                $.ajax({
                    url: '<?= site_url('TransactionController/checkout') ?>',
                    method: 'POST',
                    data: { items: items },
                    success: function(response) {
                        if (typeof response === 'string') {
                            response = JSON.parse(response);
                        }
                        
                        if (response.status === 'success') {
                            Toast.fire({
                                icon: 'success',
                                title: 'Checkout berhasil'
                            });

                            response.items.forEach(function(item) {
                                var row = $(`tr[data-id="${item.id}"]`);
                                console.log('Updating stock for item:', item.id, 'new stock:', item.new_stock);
                                row.find('.stock').text(item.new_stock);
                            });

                            disableRow();

                            $('#keranjang').empty();
                            $('#grand-total').text('0');
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: response.message
                            })
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error: ', error);
                        Toast.fire({
                            icon: 'error',
                            title: 'Error: Checkout gagal'
                        });
                    }
                });
            });

            function parseIndonesianNumber(numberString)
            {
                var cleanedString = numberString.replace(/\./g, '').replace(/,/g, '.');
                return parseFloat(cleanedString);
            }
        <?php endif; ?>

    });

</script>
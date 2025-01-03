<style>
  .user-list:hover {
    background-color: #007bff;
    cursor: pointer;
  }
  .empty-chat-message {
    text-align: center;
    color: #888;
    padding: 20px;
    font-size: 16px;
  }
  .direct-chat-text {
    cursor: pointer;
  }
  .chatAction {
    cursor: pointer;
  }
  /* .direct-chat-contacts {
    display: none;
  } */
</style>

<div class="row">
    <div class="col-3"></div>
    <div class="col-6">
        <div class="card card-success card-outline direct-chat direct-chat-success">
            <div class="card-header">
              <h3 class="card-title receiver-name">Direct Chat</h3>
        
              <div class="card-tools">
                <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle" id="toggleContactsButton">
                  <i class="fas fa-comments"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <!-- Chat -->
              <div class="direct-chat-messages chatColumn">
                <div class="direct-chat-msg chatReceiver">
                  
                </div>
        
                <div class="direct-chat-msg right chatSender">
                  
                </div>
              </div>
              <!-- /Chat -->
        
              <!-- Contact -->
              <div class="direct-chat-contacts">
                <ul class="contacts-list">
                  
                </ul>
              </div>
              <!-- /Contact -->
            </div>
            <div class="card-footer">
              <form action="#" method="post">
                <div class="input-group chatSend">
                  <input type="text" placeholder="Type Message ..." class="form-control chatMessage" required>
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-success btnSend" id="btnSend">Send</button>
                  </span>
                </div>
                <div class="input-group chatResend" hidden>
                  <input type="text" placeholder="Type Message ..." class="form-control chatRemessage" required>
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-success btnSend" id="btnResend">Re-Send</button>
                  </span>
                </div>
                <input type="text" class=" form-control chatRemessageId" hidden>
              </form>
            </div>
          </div>
    </div>
    <div class="col-3">

    </div>
</div>

<script>
    $(document).ready(function() 
    {
      // Mengambil data user
        function load_users()
        {
          $.ajax({
            url: '<?= site_url('ChatController/load_users') ?>',
            method: 'GET',
            success: function(response) {
                var users = JSON.parse(response);
                renderUsers(users);
            },
            error: function(xhr, status, respons) {
              console.log('Error: ', error);
            }
          })
        }

        // Menampilkan list user
        function renderUsers(users)
        {
          var listUsers = $('.contacts-list');

          var currentId = '<?= htmlspecialchars($id_user ?? '', ENT_QUOTES, 'UTF-8'); ?>';

          users.forEach(function(user) {
            if (user.id !== currentId) {
              var list =`
                  <li class="user-list" data-user-id="${user.id}">
                      <img class="contacts-list-img" src="<?= base_url('assets/AdminLTE/dist/img/avatar5.png') ?>" alt="${user.name} Avatar">
                      <div class="contacts-list-info">
                        <span class="contacts-list-name">
                          ${user.name}
                        </span>
                        <span class="contacts-list-msg">...</span>
                      </div>
                  </li>
              `;

              listUsers.append(list);
            }
          });
        }

        var contactList = $('.direct-chat-contacts');
        $('#toggleContactsButton').on('click', function() {
            contactList.prop('hidden', false);
        });
        
        // Menampilkan chat berdasarkan klik user
        $('.contacts-list').on('click', '.user-list', function() 
        {
            contactList.prop('hidden', true);

            $('.user-list').removeClass('selected');
            $(this).addClass('selected');
            
            var userId = $(this).data('user-id');
            var userName = $(this).find('.contacts-list-name').text();
            $('.receiver-name').text(userName);

            loadChatsWithUser(userId, userName);
        });

        // Mengambil data chat
        function loadChatsWithUser(userId, userName)
        {
          $.ajax({
            url: '<?= site_url('ChatController/load_chats_with_user') ?>',
            method: 'GET',
            data: { user_id: userId },
            success: function(response) {
              var data = JSON.parse(response);
              console.log('Data yang diterima: ', data);
              if (data.status === 'success') {
                renderChats(data.chats);
                scrollToBottom();

                localStorage.setItem('lastChatUserId', userId);
                localStorage.setItem('lastChatUserName', userName);
              }
            },
            error: function(xhr, status, error) {
              console.log('Gagal menampilkan pesan: ', xhr.responseText);
            }
          });
        }

        // Menampilkan chat
        function renderChats(chats, isNewMessage = false) 
        {
            var chatColumn = $('.chatColumn');

            if (!isNewMessage) {
                chatColumn.empty();
            }
            
            if (chats.length === 0 && !isNewMessage) {
                chatColumn.append('<div class="empty-chat-message">Chat masih kosong</div>');
                return;
            }

            var currentUser = '<?= htmlspecialchars($id_user ?? '', ENT_QUOTES, 'UTF-8'); ?>';

            chats = chats.filter(chat => chat !== null && chat !== undefined);

            chats.forEach(function(chat) {
                if (chat && chat.time) {
                    var time = chat.time.slice(0, 5);
                    var messageClass = chat.id_sender === currentUser ? 'right chatSender' : 'chatReceiver';

                    var existingMessage = $(`.direct-chat-msg[data-id="${chat.id}"]`);

                    if (existingMessage.length > 0) {
                        existingMessage.find('.direct-chat-text').text(chat.message);
                        existingMessage.find('.direct-chat-timestamp').text(chat.date + ' ' + time);
                    } else {
                        var message = `
                            <div class="direct-chat-msg ${messageClass}" data-id-sender="${chat.id_sender}" data-id="${chat.id}">
                              <div class="direct-chat-infos clearfix">
                                  <span class="direct-chat-name ${messageClass === 'right chatSender' ? 'float-right' : 'float-left'}">${chat.name_sender}</span>
                                  <span class="direct-chat-timestamp ${messageClass === 'right chatSender' ? 'float-left' : 'float-right'}">${chat.date} ${time}</span>
                              </div>
                              <img class="direct-chat-img" src="<?= base_url('assets/AdminLTE/dist/img/avatar5.png') ?>" alt="${chat.name_sender} Image">
                              <div class="direct-chat-text">
                                  ${chat.message}
                              </div>
                              <div class="chatAction w-50 float-right" hidden>
                                <a class="dropdown-item bg-light btnChatEdit">Edit</a>
                                <a class="dropdown-item bg-light btnChatDelete">Delete</a>
                              </div>
                            </div>
                        `;

                        chatColumn.append(message);
                    }
                } else {
                    console.error('Invalid chat object: ', chat);
                }
            });
        }


        // Show/Hide button action
        $(document).on('click', '.direct-chat-text', function() {
            var currentUser = '<?= htmlspecialchars($id_user ?? '', ENT_QUOTES, 'UTF-8'); ?>';
            var chatAction = $(this).next('.chatAction');

            var idSender = $(this).closest('.direct-chat-msg').data('id-sender');
            console.log('idSender: ', idSender, 'curentUser: ', currentUser);

            idSender = parseInt(idSender);
            currentUser = parseInt(currentUser);

            if (idSender === currentUser) {
              console.log('Condition: idSender === currentUser');

              var isHidden = chatAction.prop('hidden');
              chatAction.prop('hidden', !isHidden);

            } else {
              console.log('Condition: idSender !== currentUser');
            }

            $(this).closest('.direct-chat-msg').find('.chatAction').show();
        });

        // Auto scroll paling bawah
        function scrollToBottom()
        {
          var chatColumn = $('.chatColumn');
          chatColumn.scrollTop(chatColumn.prop('scrollHeight'));
        }
  
        // Mengirim pesan
        $('#btnSend').on('click', function(e) 
        {
            e.preventDefault();

            var message = $('.chatMessage').val();
            var date = new Date();
            var time = date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
            var senderId = '<?= htmlspecialchars($id_user ?? '', ENT_QUOTES, 'UTF-8'); ?>';
            var senderName = '<?= htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8'); ?>';

            var receiverId = $('.user-list.selected').data('user-id');
            var receiverName = $('.user-list.selected').find('.contacts-list-name').text().trim();

            var sendMessage = {
              message: message,
              date: date.toISOString().split('T')[0],
              time: time,
              id_sender: senderId,
              name_sender: senderName,
              id_receiver: receiverId,
              name_receiver: receiverName,
            };

            console.log('Raw: ', sendMessage);
            $.ajax({
              url: '<?= site_url('ChatController/send_chat') ?>',
              method: 'POST',
              data: sendMessage,
              success: function(response) {
                  var data = JSON.parse(response);
                  if (data.status === 'success') {
                    renderChats([data.chats], true);

                    $('.chatMessage').val('');

                    console.log('Data: ', sendMessage);
                  }
                  scrollToBottom();

                  var emptyChat = $('.empty-chat-message');
                  emptyChat.remove();
              },
              error: function(xhr, status, error) {
                console.log('Error: ', error);
              },
            });
        });

        // Menghapus pesan
        $(document).on('click', '.btnChatDelete', function() 
        {
            var dataId = $(this).closest('.direct-chat-msg').data('id');

            if (confirm('Ingin menghapus pesan ini?')) {
                $.ajax({
                    url: '<?= site_url('ChatController/delete_chat') ?>',
                    method: 'POST',
                    data: {id: dataId},
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status === 'success') {
                            console.log('ID: ', dataId);
                            console.log(response.message);

                            // Hapus pesan dari DOM
                            $(`.direct-chat-msg[data-id="${dataId}"]`).remove();

                            // Jika tidak ada pesan yang tersisa, tampilkan pesan kosong
                            if ($('.direct-chat-msg').length === 0) {
                                var chatColumn = $('.chatColumn');
                                chatColumn.append('<div class="empty-chat-message">Chat masih kosong</div>');
                            }

                        } else {
                            console.log(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Pesan tidak ditemukan');
                    }
                });
            }
        });


        // Menampilkan pesan yang ingin diedit
        $(document).on('click', '.btnChatEdit', function() 
        {
          $('.chatAction').hide();

          var chatSend = $('.chatSend').prop('hidden', true);
          var chatResend = $('.chatResend').prop('hidden', false);

          var chatVal = $(this).closest('.direct-chat-msg').find('.direct-chat-text').text().trim();
          var chatId = $(this).closest('.direct-chat-msg').data('id');

          console.log('ID: ', chatId);

          $('.chatRemessage').val(chatVal);
          $('.chatRemessageId').val(chatId);
        });

        // Update
        $('#btnResend').on('click', function(e) 
        {
          e.preventDefault();

          var chatRemessage = $('.chatRemessage').val();
          var chatRemessageId = $('.chatRemessageId').val();

          var dataEdit = {
            id: chatRemessageId,
            message: chatRemessage,
          };

          $.ajax({
            url: '<?= site_url('ChatController/edit_chat') ?>',
            method: 'POST',
            data : dataEdit,
            success: function(response) {
              var data = JSON.parse(response);
              if (data.status === 'success') {
                console.log('Berhasil diedit', data);
                renderChats([data.chats], true);

                $('.chatRemessage').val('');
                $('.chatResend').prop('hidden', true);
                $('.chatSend').prop('hidden', false);
              } else {
                console.error('Gagal mengedit pesan: ', data.message);
              }
            },
            error: function(xhr, status, error) {
              console.error('AJAX Error:', status, error);
            }
          });
        });

        loadChatsWithUser();
        load_users();
    });

    
</script>
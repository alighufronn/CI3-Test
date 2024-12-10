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
</style>

<span class="test">Test: </span>
<div class="row">
    <div class="col-3"></div>
    <div class="col-6">
        <div class="card card-success card-outline direct-chat direct-chat-success">
            <div class="card-header">
              <h3 class="card-title receiver-name">Direct Chat</h3>
        
              <div class="card-tools">
                <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
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
                <div class="input-group">
                  <input type="text" placeholder="Type Message ..." class="form-control chatMessage" required>
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-success btnSend" id="btnSend">Send</button>
                  </span>
                </div>
              </form>
            </div>
          </div>
    </div>
    <div class="col-3"></div>
</div>


<script>
    $(document).ready(function() 
    {
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

        function renderUsers(users)
        {
          var listUsers = $('.contacts-list');

          var currentId = '<?= htmlspecialchars($id_user ?? '', ENT_QUOTES, 'UTF-8'); ?>';

          users.forEach(function(user) {
            if (user.id !== currentId) {
              var list =`
                  <li class="user-list" data-user-id="${user.id}">
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

        $('.contacts-list').on('click', '.user-list', function() 
        {
            $('.user-list').removeClass('selected');

            $(this).addClass('selected');
            
            var userId = $(this).data('user-id');
            var userName = $(this).find('.contacts-list-name').text();
            $('.receiver-name').text(userName);

            loadChatsWithUser(userId, userName);
        });

        // function load_chats() 
        // {
        //     $.ajax({
        //         url: '<?= site_url('ChatController/load_chats') ?>',
        //         method: 'GET',
        //         success: function(response) {
        //             var data = JSON.parse(response);
        //             console.log('Data yang diterima: ', data);
        //             if (data.status === 'success') {
        //                 renderChats(data.chats);
        //                 scrollToBottom();
        //             } else {
        //               console.log('Error: ', data.message);
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             console.log('Gagal menampilkan pesan', xhr.responseText);
        //         }
        //     })
        // }

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
                renderChats(data.chats)
                scrollToBottom();
              }
            },
            error: function(xhr, status, error) {
              console.log('Gagal menampilkan pesan: ', xhr.responseText);
            }
          });
        }

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

          chats.forEach(function(chat)
          {
            if (chat.time) {
              var time = chat.time ? chat.time.slice(0, 5) : '';
              var messageClass = chat.id_sender === currentUser ? 'right chatSender' : 'chatReceiver';

              var message = `
                  <div class="direct-chat-msg ${messageClass}">
                    <div class="direct-chat-infos clearfix" data-id="${chat.id}">
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
          });
        }

        function scrollToBottom()
        {
          var chatColumn = $('.chatColumn');
          chatColumn.scrollTop(chatColumn.prop('scrollHeight'));
        }
  
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
              },
              error: function(xhr, status, error) {
                console.log('Error: ', error);
              },
            });
        });

        loadChatsWithUser();
        load_users();
        // load_chats();
    })
</script>
<div class="row">
    <div class="col-3"></div>
    <div class="col-6">
        <div class="card card-success card-outline direct-chat direct-chat-success">
            <div class="card-header">
              <h3 class="card-title">Direct Chat</h3>
        
              <div class="card-tools">
                <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                  <i class="fas fa-comments"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="direct-chat-messages">
                <div class="direct-chat-msg">
                  <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-left">Alexander Pierce</span>
                    <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                  </div>
                  <div class="direct-chat-text">
                    Is this template really for free? That's unbelievable!
                  </div>
                </div>
        
                <div class="direct-chat-msg right chatSender">
                  
                </div>
              </div>
                
        
              <div class="direct-chat-contacts">
                <ul class="contacts-list">
                  <li>
                    <a href="#">        
                      <div class="contacts-list-info">
                        <span class="contacts-list-name">
                          Count Dracula
                          <small class="contacts-list-date float-right">2/28/2015</small>
                        </span>
                        <span class="contacts-list-msg">How have you been? I was...</span>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="card-footer">
              <form action="#" method="post">
                <div class="input-group">
                  <input type="text" name="message" placeholder="Type Message ..." class="form-control chatMessage">
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
    $(document).ready(function() {

        function load_chats() 
        {
            $.ajax({
                url: '<?= site_url('ChatController/load_chats') ?>',
                method: 'GET',
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        renderSender(data.chats);
                        console.log('Pesan berhasil ditampilkan', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Gagal menampilkan pesan');
                }
            })
        }

        function renderSender(chats)
        {
            var chatSender = $('.chatSender');
            chatSender.empty();

            chats.forEach(function(chat) {
                var message = `
                    <div class="direct-chat-infos clearfix" data-id="${chat.id}">
                        <span class="direct-chat-name float-right chatSenderName">${chat.name}</span>
                        <span class="direct-chat-timestamp float-left chatDatetime">${chat.date} ${chat.time}</span>
                    </div>
                    <div class="direct-chat-text chatMessage">
                        ${chat.message}
                    </div>
                `;
                chatSender.append(message);
            });
        }
        
        $('#btnSend').on('click', function(e) {
            e.preventDefault();

            var message = $('.chatMessage');
            var date = new Date();
            var time = new Time();
            var senderId = '';
            var senderName = '';
        })
    })
</script>
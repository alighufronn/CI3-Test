<?php if($logged_in): ?>

<style>
    #users-card, #events-card, #chat-card, #todo-card {
        cursor: pointer;
    }
</style>

<div class="row">

    <?php //if($role === 'admin'): ?>
    <div class="col-lg-3 col-6" id="users-card">
        <div class="small-box bg-gradient-info">
          <div class="inner">
            <h3 class="user-count">-</h3>

            <p>Users Total</p>
          </div>
          <div class="icon">
            <i class="fas fa-user"></i>
          </div>
        </div>
    </div>
    <?php //endif; ?>

    <div class="col-lg-3 col-6" id="events-card">
        <div class="small-box bg-gradient-success">
          <div class="inner">
            <h3 class="event-count">-</h3>

            <p id="month-name">Events in</p>
          </div>
          <div class="icon">
            <i class="fas fa-calendar"></i>
          </div>
        </div>
    </div>
    <div class="col-lg-3 col-6" id="chat-card">
        <div class="small-box bg-gradient-warning">
          <div class="inner">
            <h3 class="chat-count">-</h3>

            <p>Chat sent</p>
          </div>
          <div class="icon">
            <i class="fas fa-comments"></i>
          </div>
        </div>
    </div>
    <div class="col-lg-3 col-6" id="todo-card">
        <div class="small-box bg-gradient-danger">
          <div class="inner">
            <h3 class="todo-count">-</h3>

            <p>You have to do</p>
          </div>
          <div class="icon">
            <i class="fas fa-tasks"></i>
          </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-calendar"></i>
                    Upcoming Events
                </div>
            </div>
            <div class="card-body" id="upcoming-events">
                
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-box role-admin">
            <span class="info-box-icon text-white" style="background-color: #00c0ef;"><i class="far fa-user"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Admin</span>
                <span class="info-box-number admin-count">-</span>
            </div>
        </div>
        <div class="info-box role-guest">
            <span class="info-box-icon text-white" style="background-color: #3c8dbc;"><i class="far fa-user"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Guest</span>
                <span class="info-box-number guest-count">-</span>
            </div>
        </div>
        <div class="info-box role-staff">
            <span class="info-box-icon" style="background-color: #d2d6de;"><i class="far fa-user"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Staff</span>
                <span class="info-box-number staff-count">-</span>
            </div>
        </div>
        <div class="card card-danger">
            <div class="card-body">
                <canvas id="pieChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Month names
        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' 
        ];

        const monthNamesShort = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        const currentMonthIndex = new Date().getMonth();
        const currentMonthName = monthNames[currentMonthIndex];

        $('#month-name').text(`Events in ${currentMonthName}`);


        // Card redirect
        $('#users-card').on('click', function() {
            window.location.href = '<?= site_url('users') ?>';
        });

        $('#events-card').on('click', function() {
            window.location.href = '<?= site_url('calendar') ?>';
        });

        $('#chat-card').on('click', function() {
            window.location.href = '<?= site_url('chat') ?>';
        });

        $('#todo-card').on('click', function() {
            window.location.href = '<?= site_url('todo') ?>';
        });

        
        function loadUserCount()
        {
            $.ajax({
                url: '<?= site_url('DashboardController/users_count') ?>',
                method: 'GET',
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        console.log('Response: ', response.message);
                        $('.user-count').text(response.user_count);
                    } else {
                        $('.user-count').text('0');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ', error);
                }
            });
        }

        function loadEventCount() 
        {
            $.ajax({
                url: '<?= site_url('DashboardController/events_count') ?>',
                method: 'GET',
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        console.log('Response: ', response.message);
                        $('.event-count').text(response.event_count);
                    } else {
                        $('.event-count').text('0');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ', error);
                },
            });
        }

        function loadChatCount()
        {
            $.ajax({
                url: '<?= site_url('DashboardController/chats_count') ?>',
                method: 'GET',
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        console.log('Response: ', response.message);
                        $('.chat-count').text(response.chat_count);
                    } else {
                        $('.chat-count').text('0');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ', error);
                }
            });
        }

        function loadTodoCount()
        {
            $.ajax({
                url: '<?= site_url('DashboardController/todos_count') ?>',
                method: 'GET',
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        console.log('Response: ', response.message);
                        $('.todo-count').text(response.todo_count);
                    } else {
                        $('.todo-count').text('0');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ', error);
                }
            });
        }

        function loadAdminCount()
        {
            $.ajax({
                url: '<?= site_url('DashboardController/admin_count') ?>',
                method: 'GET',
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        console.log('Response: ', response.message);
                        $('.admin-count').text(response.admin_count);
                    } else {
                        $('.admin-count').text('0');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ', error);
                }
            });
        }

        function loadStaffCount()
        {
            $.ajax({
                url: '<?= site_url('DashboardController/staff_count') ?>',
                method: 'GET',
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        console.log('Response: ', response.message);
                        $('.staff-count').text(response.staff_count);
                    } else {
                        $('.staff-count').text('0');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ', error);
                }
            });
        }

        function loadGuestCount()
        {
            $.ajax({
                url: '<?= site_url('DashboardController/guest_count') ?>',
                method: 'GET',
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        console.log('Response: ', response.message);
                        $('.guest-count').text(response.guest_count);
                    } else {
                        $('.guest-count').text('0');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ', error);
                }
            });
        }

        // Mengubah format tanggal
        function formatDate(dateStr)
        {
            const date = new Date(dateStr);
            const day = String(date.getDate()).padStart(2, '0');
            const month = monthNamesShort[date.getMonth()];
            const year = date.getFullYear();

            return `${day} ${month} ${year}`;
        }

        function loadUpcomingEvents()
        {
            $.ajax({
                url: '<?= site_url('DashboardController/get_upcoming_events') ?>',
                method: 'GET',
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        var eventContainer = $('#upcoming-events');
                        eventContainer.empty();

                        if (response.events.length === 0) {
                            eventContainer.append('<div class="form-group text-center"><h5>Tidak ada event terdekat</h5></div>')
                        } else {
                            response.events.forEach(function(event, index) {
                                var eventHTML = `
                                    <div class="form-group">
                                        <h${index === 0? '3' : '6'} ${index === 0 ? 'class="text-bold"' : ''}>${event.title}</h${index === 0? '2' : '6'}>
                                        <span class="text-sm" style="opacity: 50%;">${formatDate(event.start)}</span>
                                        <div class="dropdown-divider"></div>
                                    </div>
                                `;
                                eventContainer.append(eventHTML);
                            }); 
                        }
                    } else {
                        $('#upcoming-events').html('<div class="form-group text-center"><h5>Gagal memuat event terdekat</h5></div>')
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ', error);
                    $('#upcoming-events').html('<div class="form-group text-center"><h5>Gagal memuat event terdekat</h5></div>')
                }
            })
        }

        loadUpcomingEvents();
        loadTodoCount();
        loadUserCount();
        loadEventCount();
        loadChatCount();
        loadAdminCount();
        loadStaffCount();
        loadGuestCount();
    }); 
</script>

<script>
    $(document).ready(function() {
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        function capitalizeLabels(labels) {
            return labels.map(label => capitalizeFirstLetter(label));
        }

        // Pie Chart
        function updatePieChart(data)
        {
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');

            data.labels = capitalizeLabels(data.labels);
            var pieData = {
                labels: data.labels,
                datasets: data.datasets,
            };
            var pieOptions = {
                maintainAspectRatio : false,
                responsive : true,
            };
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            });
        }

        $.ajax({
            url: '<?= site_url('DashboardController/get_chart_data') ?>',
            method: 'GET',
            success: function(response) {
                console.log('Response: ', response);
                var data = JSON.parse(response);
                updatePieChart(data);
            },
            error: function(xhr, status, error) {
                console.error('Error: ', error);
            }
        });
    });
</script>
<?php endif; ?>
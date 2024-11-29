    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="sticky-top mb-3">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Draggable Events</h4>
                </div>
                <div class="card-body">
                  <div id="external-events">
                    <div class="external-event bg-success">Lunch</div>
                    <div class="external-event bg-warning">Go home</div>
                    <div class="external-event bg-info">Do homework</div>
                    <div class="external-event bg-primary">Work on UI design</div>
                    <div class="external-event bg-danger">Sleep tight</div>
                    <div class="checkbox">
                      <label for="drop-remove">
                        <input type="checkbox" id="drop-remove">
                        remove after drop
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Create Event</h3>
                </div>
                <div class="card-body">
                  <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                    <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>
                    </ul>
                  </div>
                  <div class="input-group">
                    <input id="new-event" type="text" class="form-control" placeholder="Event Title">
                    <div class="input-group-append">
                      <button id="add-new-event" type="button" class="btn btn-primary">Add</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="card card-primary">
              <div class="card-body p-0">
                  <div id="calendar"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


<script>
$(document).ready(function() {
    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    var currColor = '#3c8dbc';

    new Draggable(containerEl, {
        itemSelector: '.external-event',
        eventData: function(eventEl) {
            return {
                title: eventEl.innerText.trim(),
                backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color')
            };
        }
    });

    function convertToUTCPlus7(date) {
        var utcTime = date.getTime() + (7 * 60 * 60 * 1000);
        return new Date(utcTime);
    }

    var calendar = new Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        firstDay: 1,
        editable: true,
        droppable: true,
        displayEventTime: false,
        events: '<?= site_url('CalendarController/load_events') ?>',
        drop: function(info) {
            var title = info.draggedEl.innerText.trim();
            if (title) {
                var start = new Date(info.dateStr);
                start.setHours(0, 0, 0);
                var end = new Date(info.dateStr);
                end.setHours(23, 59, 59);

                var startUTC7 = convertToUTCPlus7(start);
                var endUTC7 = convertToUTCPlus7(end);
                var id_user = '<?= htmlspecialchars($id_user ?? '', ENT_QUOTES, 'UTF-8'); ?>';

                var eventId = 'evt-' + Math.random().toString(36).substr(2, 9);

                var existingEvents = calendar.getEvents();
                var isDuplicate = existingEvents.some(event => event.title === title && event.startStr === startUTC7.toISOString());

                if (!isDuplicate) {
                    var event = {
                        id: eventId,
                        title: title,
                        start: startUTC7.toISOString(),
                        end: endUTC7.toISOString(),
                        backgroundColor: window.getComputedStyle(info.draggedEl, null).getPropertyValue('background-color'),
                        borderColor: window.getComputedStyle(info.draggedEl, null).getPropertyValue('background-color'),
                        textColor: window.getComputedStyle(info.draggedEl, null).getPropertyValue('color'),
                        id_user: id_user,
                        allDay: false
                    };

                    $.ajax({
                        url: '<?= site_url('CalendarController/add_event') ?>',
                        method: 'POST',
                        data: event,
                        success: function(response) {
                            response = JSON.parse(response);
                            if (response.status === 'success') {
                                info.draggedEl.parentNode.removeChild(info.draggedEl);
                            } else {
                                alert('Failed to add event: ' + response.message);
                            }
                        },
                        error: function() {
                            alert('Failed to save event.');
                        }
                    });
                } else {
                    alert('Event already exists.');
                }
            } else {
                alert('Event title cannot be empty.');
            }
        },

        eventResize: function(info) {
            var start = new Date(info.event.start);
            var end = new Date(info.event.end);

            var startUTC7 = convertToUTCPlus7(start);
            var endUTC7 = convertToUTCPlus7(end);
            var id_user = '<?php echo htmlspecialchars($id_user ?? '', ENT_QUOTES, 'UTF-8'); ?>';

            var event = {
                id: info.event.id,
                title: info.event.title,
                start: startUTC7.toISOString(),
                end: endUTC7.toISOString(),
                backgroundColor: info.event.backgroundColor,
                borderColor: info.event.borderColor,
                textColor: info.event.textColor,
                id_user: id_user,
                allDay: false
            };
            $.ajax({
                url: '<?= site_url('CalendarController/update_event') ?>',
                method: 'POST',
                data: event,
                success: function(response) {
                    console.log('Event updated: ', response);
                },
                error: function() {
                    alert('Failed to update event.');
                }
            });
        },

        eventDrop: function(info) {
            var start = new Date(info.event.start);
            var end = new Date(info.event.end);

            var startUTC7 = convertToUTCPlus7(start);
            var endUTC7 = convertToUTCPlus7(end);
            var id_user = '<?php echo htmlspecialchars($id_user ?? '', ENT_QUOTES, 'UTF-8'); ?>';

            var event = {
                id: info.event.id,
                title: info.event.title,
                start: startUTC7.toISOString(),
                end: endUTC7.toISOString(),
                backgroundColor: info.event.backgroundColor,
                borderColor: info.event.borderColor,
                textColor: info.event.textColor,
                id_user: id_user,
                allDay: false
            };
            console.log("Event data before sending (drop): ", event);
            $.ajax({
                url: '<?= site_url('CalendarController/update_event') ?>',
                method: 'POST',
                data: event,
                success: function(response) {
                    console.log('Event updated: ', response);
                },
                error: function() {
                    alert('Failed to update event.');
                }
            });
        },
        
        eventClick: function(info) {
            if (confirm('Are you sure you want to delete this event?')) {
                $.ajax({
                    url: '<?= site_url('CalendarController/delete_event') ?>',
                    method: 'POST',
                    data: { id: info.event.id },
                    success: function() {
                        info.event.remove();
                    },
                    error: function() {
                        alert('Failed to delete event.');
                    }
                });
            }
        }
    });

    calendar.render();

    $('#color-chooser > li > a').click(function(e) {
        e.preventDefault();
        currColor = $(this).css('color');
        $('#add-new-event').css({
            'background-color': currColor,
            'border-color': currColor
        });
    });

    $('#add-new-event').click(function() {
        var val = $('#new-event').val().trim();
        if (val.length === 0) {
            alert('Event title cannot be empty.');
            return;
        }

        var event = $('<div />');
        event.css({
            'background-color': currColor,
            'border-color': currColor,
            'color': '#FFF'
        }).addClass('external-event').text(val);
        $('#external-events').prepend(event);
        $('#new-event').val('');

    });
});
</script>







<!-- <script>
$(document).ready(function() {
    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    var currColor = '#3c8dbc';

    new Draggable(containerEl, {
        itemSelector: '.external-event',
        eventData: function(eventEl) {
            return {
                title: eventEl.innerText.trim(),
                backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color')
            };
        }
    });

    function convertToUTCPlus7(date) {
        var utcTime = date.getTime() + (7 * 60 * 60 * 1000);
        return new Date(utcTime);
    }

    var calendar = new Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        firstDay: 1,
        editable: true,
        droppable: true,
        displayEventTime: false,
        events: '<?= site_url('CalendarController/load_events') ?>',
        drop: function(info) {
            var title = info.draggedEl.innerText.trim();
            if (title) {
                var start = new Date(info.dateStr);
                start.setHours(0, 0, 0);
                var end = new Date(info.dateStr);
                end.setHours(23, 59, 59);

                var startUTC7 = convertToUTCPlus7(start);
                var endUTC7 = convertToUTCPlus7(end);
                var id_user = '<?= htmlspecialchars($id_user ?? '', ENT_QUOTES, 'UTF-8'); ?>';

                var eventId = 'evt-' + Math.random().toString(36).substr(2, 9);

                var existingEvents = calendar.getEvents();
                var isDuplicate = existingEvents.some(event => event.title === title && event.startStr === startUTC7.toISOString());

                if (!isDuplicate) {
                    var event = {
                        id: eventId,
                        title: title,
                        start: startUTC7.toISOString(),
                        end: endUTC7.toISOString(),
                        backgroundColor: window.getComputedStyle(info.draggedEl, null).getPropertyValue('background-color'),
                        borderColor: window.getComputedStyle(info.draggedEl, null).getPropertyValue('background-color'),
                        textColor: window.getComputedStyle(info.draggedEl, null).getPropertyValue('color'),
                        id_user: id_user,
                        allDay: false
                    };

                    $.ajax({
                        url: '<?= site_url('CalendarController/add_event') ?>',
                        method: 'POST',
                        data: event,
                        success: function(response) {
                            response = JSON.parse(response);
                            if (response.status === 'success') {
                                info.draggedEl.parentNode.removeChild(info.draggedEl);
                            } else {
                                alert('Failed to add event: ' + response.message);
                            }
                        },
                        error: function() {
                            alert('Failed to save event.');
                        }
                    });
                } else {
                    alert('Event already exists.');
                }
            } else {
                alert('Event title cannot be empty.');
            }
        },

        eventResize: function(info) {
            var start = new Date(info.event.start);
            var end = new Date(info.event.end);

            var startUTC7 = convertToUTCPlus7(start);
            var endUTC7 = convertToUTCPlus7(end);
            var id_user = '<?php echo htmlspecialchars($id_user ?? '', ENT_QUOTES, 'UTF-8'); ?>';

            var event = {
                id: info.event.id,
                title: info.event.title,
                start: startUTC7.toISOString(),
                end: endUTC7.toISOString(),
                backgroundColor: info.event.backgroundColor,
                borderColor: info.event.borderColor,
                textColor: info.event.textColor,
                id_user: id_user,
                allDay: false
            };
            $.ajax({
                url: '<?= site_url('CalendarController/update_event') ?>',
                method: 'POST',
                data: event,
                success: function(response) {
                    console.log('Event updated: ', response);
                },
                error: function() {
                    alert('Failed to update event.');
                }
            });
        },
        eventDrop: function(info) {
            var start = new Date(info.event.start);
            var end = new Date(info.event.end);

            var startUTC7 = convertToUTCPlus7(start);
            var endUTC7 = convertToUTCPlus7(end);
            var id_user = '<?php echo htmlspecialchars($id_user ?? '', ENT_QUOTES, 'UTF-8'); ?>';

            var event = {
                id: info.event.id,
                title: info.event.title,
                start: startUTC7.toISOString(),
                end: endUTC7.toISOString(),
                backgroundColor: info.event.backgroundColor,
                borderColor: info.event.borderColor,
                textColor: info.event.textColor,
                id_user: id_user,
                allDay: false
            };
            console.log("Event data before sending (drop): ", event);
            $.ajax({
                url: '<?= site_url('CalendarController/update_event') ?>',
                method: 'POST',
                data: event,
                success: function(response) {
                    console.log('Event updated: ', response);
                },
                error: function() {
                    alert('Failed to update event.');
                }
            });
        },
        eventClick: function(info) {
            if (confirm('Are you sure you want to delete this event?')) {
                $.ajax({
                    url: '<?= site_url('CalendarController/delete_event') ?>',
                    method: 'POST',
                    data: { id: info.event.id },
                    success: function() {
                        info.event.remove();
                    },
                    error: function() {
                        alert('Failed to delete event.');
                    }
                });
            }
        }
    });

    calendar.render();

    $('#color-chooser > li > a').click(function(e) {
        e.preventDefault();
        currColor = $(this).css('color');
        $('#add-new-event').css({
            'background-color': currColor,
            'border-color': currColor
        });
    });

    $('#add-new-event').click(function() {
        var val = $('#new-event').val().trim();
        if (val.length === 0) {
            alert('Event title cannot be empty.');
            return;
        }

        var event = $('<div />');
        event.css({
            'background-color': currColor,
            'border-color': currColor,
            'color': '#FFF'
        }).addClass('external-event').text(val);
        $('#external-events').prepend(event);
        $('#new-event').val('');

    });
});
</script> -->

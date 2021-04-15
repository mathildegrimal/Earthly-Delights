document.addEventListener('DOMContentLoaded', () => {
    var calendarEl = document.getElementById('calendar-holder');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialDate: '2014-11-10',
        initialView:'timeGridWeek',
        editable: true,
        events : [
            {
                start: '2014-11-10T10:00:00',
                end: '2014-11-10T16:00:00',
                display:'background'
            }
        ],
        eventSources: [
            {
                url: "{{ path('fc_load_events') }}",
                method: "POST",
                extraParams: {
                    filters: JSON.stringify({})
                },
                failure: () => {
                    // alert("There was an error while fetching FullCalendar!");
                },
            },
        ],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        plugins: [ 'interaction', 'dayGrid', 'timeGrid' ], // https://fullcalendar.io/docs/plugin-index
        timeZone: 'UTC',
    });
    calendar.render();
});
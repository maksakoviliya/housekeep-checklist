import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction';

let calendar = null

window.initCalendar =  function initCalendar(events = []) {
    const calendarEl = document.getElementById('calendar')
    if (!calendarEl) return

    if (calendar) {
        calendar.destroy()
    }

    calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        events,
        selectable: true,
        displayEventTime: false,
        dateClick: function(info) {
            window.dispatchEvent(new CustomEvent('calendar-date-clicked', {
                detail: { date: info.dateStr }
            }))
        },
        eventClick: function(info) {
            window.dispatchEvent(new CustomEvent('calendar-event-clicked', {
                detail: { event: info.event }
            }))
        }
    })

    calendar.render()
}

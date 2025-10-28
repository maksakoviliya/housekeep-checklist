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

window.getCurrentPosition = function getCurrentPosition() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                window.dispatchEvent(new CustomEvent('geolocation-success', {
                    detail: { lat, lng }
                }))
            },
            function (error) {
                window.dispatchEvent(new CustomEvent('geolocation-error', {
                    detail: { error: error.message }
                }))

                // const lat = 54.45;
                // const lng = 34.55;
                //
                // window.dispatchEvent(new CustomEvent('geolocation-success', {
                //     detail: { lat, lng }
                // }))
            }
        );
    } else {
        alert('Geolocation is not supported by this browser.');
    }
}

const startToCleanBtn = document.getElementById('start-to-clean');
startToCleanBtn?.addEventListener('click', function () {
    getCurrentPosition()
})

window.addEventListener('property-form-mounted', function () {
    getCurrentPosition()
})


import {Calendar} from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction';

let calendar = null

window.initCalendar = function initCalendar(events = []) {
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
        dateClick: function (info) {
            window.dispatchEvent(new CustomEvent('calendar-date-clicked', {
                detail: {date: info.dateStr}
            }))
        },
        eventClick: function (info) {
            window.dispatchEvent(new CustomEvent('calendar-event-clicked', {
                detail: {event: info.event}
            }))
        }
    })

    calendar.render()
}

async function requestGeolocation() {
    if (!navigator.geolocation) {
        alert('Geolocation is not supported by this browser.');
        return null;
    }

    try {
        const position = await new Promise((resolve, reject) =>
            navigator.geolocation.getCurrentPosition(resolve, reject)
        );

        const {latitude: lat, longitude: lng} = position.coords;
        window.dispatchEvent(new CustomEvent('geolocation-success', {detail: {lat, lng}}));
        return {lat, lng};
    } catch (error) {
        console.log("error", error);
        window.dispatchEvent(new CustomEvent('geolocation-error', {detail: {error: error.message}}));
        return null;
    }
}

const startToCleanBtn = document.getElementById('start-to-clean');
startToCleanBtn?.addEventListener('click', async function () {
    await requestGeolocation()
})

window.addEventListener('property-form-mounted', async function () {
    await requestGeolocation()
})


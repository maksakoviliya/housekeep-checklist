<div>
    <div id="calendar"></div>
</div>

<script>
    window.addEventListener('init-calendar', e => {
        initCalendar(e.detail[0]?.schedule || []);
    });

    window.addEventListener('calendar-event-clicked', event => {
        @this.call('setEvent', event.detail)
    })
</script>

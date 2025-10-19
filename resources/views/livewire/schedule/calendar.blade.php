<div>
    <div wire:ignore id="calendar"></div>
</div>

<script>
    window.addEventListener('init-calendar', e => {
        initCalendar(e.detail[0]?.schedule || []);
    });
</script>
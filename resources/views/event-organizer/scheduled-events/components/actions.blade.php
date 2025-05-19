<div class="text-end">
    <a href="{{ route('event_organizer.custom-events.show', $event->id) }}" style="text-decoration: none;">
        <button type="button" data-id="{{ $event->id }}"
            class="btn btn-outline-success btn-sm me-2" style="width: 35px;">
            <i class="mdi mdi-pencil"></i>
        </button>
    </a>
</div>

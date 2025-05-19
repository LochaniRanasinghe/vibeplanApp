<div class="text-end">
    <a href="{{ route('event_organizer.event-requests.show', $eventRequest->id) }}" style="text-decoration: none;">
        <button type="button" data-id="{{ $eventRequest->id }}"
            class="btn btn-outline-success btn-sm me-2" style="width: 35px;">
            <i class="mdi mdi-checkbox-marked-circle"></i>
        </button>
    </a>
</div>

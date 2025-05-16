<div class="text-end">
    <a href="{{ route('admin.event-types.show', $eventType->id) }}" style="text-decoration: none;">
        <button type="button" data-id="{{ $eventType->id }}"
            class="btn btn-outline-success btn-sm me-2" style="width: 35px;">
            <i class="mdi mdi-pencil"></i>
        </button>
    </a>

    <button type="button" data-id="{{ $eventType->id }}"
        class="btn btn-outline-danger btn-sm" style="width: 35px;">
        <i class="mdi mdi-delete"></i>
    </button>
</div>

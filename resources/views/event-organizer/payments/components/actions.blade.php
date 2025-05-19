<div class="text-end">
    <a href="{{ route('event_organizer.payments.show', $payment->id) }}" style="text-decoration: none;">
        <button type="button" data-id="{{ $payment->id }}"
            class="btn btn-outline-success btn-sm me-2" style="width: 35px;">
            <i class="mdi mdi-pencil"></i>
        </button>
    </a>
</div>

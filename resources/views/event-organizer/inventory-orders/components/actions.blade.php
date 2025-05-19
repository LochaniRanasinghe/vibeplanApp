<div class="text-end">
    <a href="{{ route('event_organizer.inventory-orders.show', $order->id) }}" style="text-decoration: none;">
        <button type="button" data-id="{{ $order->id }}"
            class="btn btn-outline-info btn-sm me-2" style="width: 35px;">
            <i class="mdi mdi-eye"></i>
        </button>
    </a>
</div>

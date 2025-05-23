<div class="text-end">
    <a href="{{ route('inventory_staff.inventory-orders.show', $order->id) }}" style="text-decoration: none;">
        <button type="button" data-id="{{ $order->id }}"
            class="btn btn-outline-success btn-sm me-2" style="width: 35px;">
            <i class="mdi mdi-pencil"></i>
        </button>
    </a>
</div>

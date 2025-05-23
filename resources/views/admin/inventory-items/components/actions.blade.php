<div class="text-end">
    <a href="{{ route('admin.inventory-items.show', $item->id) }}" style="text-decoration: none;">
        <button type="button" data-id="{{ $item->id }}"
            class="btn btn-outline-success btn-sm me-2" style="width: 35px;">
            <i class="mdi mdi-pencil"></i>
        </button>
    </a>

    <form action="{{ route('admin.inventory-items.destroy', $item->id) }}" method="POST" class="d-inline"
        onsubmit="return confirm('Are you sure you want to delete this item?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger btn-sm" style="width: 35px;">
            <i class="mdi mdi-delete"></i>
        </button>
    </form>
</div>

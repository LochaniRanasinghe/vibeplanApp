<div class="text-end">
    {{-- View Invoice Button --}}
    <a href="{{ route('customer.customer.invoice.view', ['custom_event' => $row->id]) }}" class="btn btn-outline-primary btn-sm me-2">
        <i class="mdi mdi-file-document-outline"></i> View Invoice
    </a>

    {{-- Upload Payment Button --}}
    @if ($paymentStatus !== 'paid')
        <a href="{{ route('customer.customer.payment.upload', ['custom_event' => $row->id]) }}" class="btn btn-outline-success btn-sm">
            <i class="mdi mdi-upload"></i> Upload Payment
        </a>
    @endif
</div>

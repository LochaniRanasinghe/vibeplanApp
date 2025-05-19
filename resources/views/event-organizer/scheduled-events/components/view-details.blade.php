<div>
    <div class="card-body">
        <div class="row mt-3 mb-5 mx-2">
            <b>
                <h6 style="text-transform: uppercase; font-weight: bold;" class="mb-4">Edit Scheduled Events</h6>
            </b><br>

            <form action="{{ route('event_organizer.custom-events.update', $customEvent->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Event Title</label>
                        <input type="text" class="form-control readonly-field"
                            value="{{ $customEvent->request?->title }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Customer</label>
                        <input type="text" class="form-control readonly-field"
                            value="{{ $customEvent->request?->customer?->name ?? 'N/A' }}" readonly>
                    </div>
                                       
                </div>

                <div class="row mb-3">
                    <div class="col-md-5">
                        <label class="form-label">Event Type Added By</label>
                        <input type="text" class="form-control readonly-field"
                               value="{{ $customEvent->request?->eventType?->addedBy?->name ?? 'N/A' }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Event Type</label>
                        <input type="text" class="form-control readonly-field"
                            value="{{ $customEvent->request?->eventType?->name ?? 'N/A' }}" readonly>
                    </div>     
                    <div class="col-md-3">
                        <label class="form-label">Event Date</label>
                        <input type="text" class="form-control readonly-field"
                               value="{{ \Carbon\Carbon::parse($customEvent->request?->event_date)->format('Y-m-d') }}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Location</label>
                        <input type="text" class="form-control readonly-field"
                            value="{{ $customEvent->request?->location }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Guest Count</label>
                        <input type="text" class="form-control readonly-field"
                            value="{{ $customEvent->request?->guest_count }}" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control readonly-field" rows="3" readonly>{{ $customEvent->request?->description }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Finalized Date</label>
                        <input type="date" name="finalized_date" class="form-control"
                               value="{{ old('finalized_date', $customEvent->finalized_date ? \Carbon\Carbon::parse($customEvent->finalized_date)->format('Y-m-d') : '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select select2">
                            <option value="inprogress" {{ $customEvent->status === 'inprogress' ? 'selected' : '' }}>In
                                Progress</option>
                            <option value="confirmed" {{ $customEvent->status === 'confirmed' ? 'selected' : '' }}>
                                Confirmed</option>
                            <option value="cancelled" {{ $customEvent->status === 'cancelled' ? 'selected' : '' }}>
                                Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Total Price</label>
                        <input type="number" name="total_price" step="0.01" class="form-control"
                            value="{{ old('total_price', $customEvent->total_price) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $customEvent->notes) }}</textarea>
                </div>

                <div class="text-end">
                    <a href="{{ route('event_organizer.custom-events.index') }}" class="btn btn-outline-secondary me-2 px-4">Return
                        Back</a>
                    <button type="submit" class="btn btn-primary">Update Scheduled Event</button>
                </div>
            </form>
        </div>
    </div>
</div>
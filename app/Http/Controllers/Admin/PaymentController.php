<?php

namespace App\Http\Controllers\Admin;
use Throwable;

use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.payments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load(['customer', 'customEvent.organizer', 'customEvent.request']);
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $payment->update(['payment_status' => $validated['payment_status']]);

        flash()->success('Payment status updated successfully.');
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }

    public function getPaymentDetails(Request $request)
    {
        try {
            $query = Payment::with(['customer', 'customEvent'])
                ->select('payments.*')
                ->orderBy('payments.created_at', 'desc');

            return DataTables::eloquent($query)
                ->addColumn('customer', fn($payment) => $payment->customer?->name ?? 'N/A')
                ->addColumn('event', fn($payment) => $payment->customEvent?->request?->title ?? 'N/A')
                ->addColumn('amount', fn($payment) => '$' . number_format($payment->amount, 2))
                ->addColumn('payment_method', fn($payment) => ucfirst($payment->payment_method))
                ->addColumn('payment_status', function ($payment) {
                    $status = strtolower($payment->payment_status);
                    $badgeClass = match ($status) {
                        'pending'  => 'badge bg-warning text-dark',
                        'paid'     => 'badge bg-success',
                        'failed'   => 'badge bg-danger',
                        default    => 'badge bg-secondary',
                    };
                    return "<span class='{$badgeClass}'>" . ucfirst($status) . "</span>";
                })
                ->addColumn('paid_at', function ($payment) {
                    return $payment->paid_at 
                        ? Carbon::parse($payment->paid_at)->format('Y-m-d') 
                        : 'N/A';
                })
                ->addColumn('actions', function ($payment) {
                    return view('admin.payments.components.actions', compact('payment'))->render();
                })
                ->rawColumns(['payment_status', 'actions'])
                ->make(true);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

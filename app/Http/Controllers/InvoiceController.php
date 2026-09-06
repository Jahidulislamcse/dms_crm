<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Invoice, Client, Service, InvoiceItem};
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['client', 'createdBy']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invoices = $query->latest('issued_date')->paginate(12);

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $clients = Client::where('status', 'active')->get();
        $services = Service::where('active', true)->get();

        return view('invoices.create', compact('clients', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'issued_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issued_date',
            'advance_paid' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.service_name' => 'required|string|max:255',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $subtotal = collect($validated['items'])->sum(fn($i) => $i['qty'] * $i['unit_price']);
        $advance = $validated['advance_paid'] ?? 0;
        $total = $subtotal;
        $balance = max(0, $total - $advance);
        $status = $balance <= 0 ? 'paid' : ($advance > 0 ? 'partial' : 'unpaid');
        $invoiceNumber = 'INV-' . date('Ym') . '-' . str_pad(Invoice::count() + 1, 3, '0', STR_PAD_LEFT);

        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'client_id' => $validated['client_id'],
            'created_by' => Auth::id(),
            'subtotal' => $subtotal,
            'advance_paid' => $advance,
            'total' => $total,
            'balance' => $balance,
            'status' => $status,
            'notes' => $validated['notes'] ?? null,
            'issued_date' => $validated['issued_date'],
            'due_date' => $validated['due_date'],
        ]);

        foreach ($validated['items'] as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'service_name' => $item['service_name'],
                'qty' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'total' => $item['qty'] * $item['unit_price'],
            ]);
        }

        return redirect()->route('invoices.index')->with('success', "Invoice {$invoiceNumber} created!");
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'createdBy', 'items', 'reminders.sentBy']);
        return view('invoices.show', compact('invoice'));
    }
}

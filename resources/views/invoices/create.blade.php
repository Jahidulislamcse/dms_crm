@extends('layouts.app')

@section('title', 'Create New Invoice')
@section('header_title', 'Create New Client Invoice')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('invoices.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1">
            <i class="fa fa-arrow-left"></i> Back to Invoices List
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8" x-data="{
        clientServices: @js($clients->mapWithKeys(fn($c) => [$c->id => $c->clientServices->map(fn($cs) => ['name' => $cs->service->name ?? $cs->custom_name, 'price' => $cs->price, 'qty' => $cs->qty])])),
        clientAdvances: @js($clients->pluck('advance', 'id')),
        selectedClientId: '',
        advancePaid: 0,
        items: [
            { service_name: '', qty: 1, unit_price: 0 }
        ],
        onClientChange() {
            if (this.selectedClientId && this.clientServices[this.selectedClientId]) {
                const svcs = this.clientServices[this.selectedClientId];
                if (svcs.length > 0) {
                    this.items = svcs.map(s => ({ service_name: s.name, qty: s.qty, unit_price: s.price }));
                }
                this.advancePaid = this.clientAdvances[this.selectedClientId] || 0;
            }
        },
        addItem() {
            this.items.push({ service_name: '', qty: 1, unit_price: 0 });
        },
        removeItem(index) {
            if (this.items.length > 1) {
                this.items.splice(index, 1);
            }
        },
        get subtotal() {
            return this.items.reduce((sum, item) => sum + (Number(item.qty || 0) * Number(item.unit_price || 0)), 0);
        },
        get balanceDue() {
            return Math.max(0, this.subtotal - Number(this.advancePaid || 0));
        }
    }">
        <h2 class="text-lg font-bold text-slate-900 mb-6 pb-4 border-b border-slate-100">Invoice Details</h2>

        <form action="{{ route('invoices.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Select Client *</label>
                    <select name="client_id" x-model="selectedClientId" @change="onClientChange()" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                        <option value="">-- Choose Client --</option>
                        @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->company ?? 'No Company' }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Issue Date *</label>
                    <input type="date" name="issued_date" value="{{ date('Y-m-d') }}" required
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Due Date *</label>
                    <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+30 days')) }}" required
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Advance Deduction (৳)</label>
                    <input type="number" step="0.01" name="advance_paid" x-model="advancePaid" placeholder="0.00"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                </div>
            </div>

            <!-- Line Items Breakdown -->
            <div class="pt-6 border-t border-slate-100 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900">Invoice Billed Line Items</h3>
                    <button type="button" @click="addItem()" class="px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold text-xs rounded-lg transition-all flex items-center gap-1">
                        <i class="fa fa-plus text-[10px]"></i> Add Line Item
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200/80 rounded-xl">
                            <div class="flex-1">
                                <input type="text" :name="'items[' + index + '][service_name]'" x-model="item.service_name" placeholder="Service / Item Description" required
                                       class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-medium focus:outline-none focus:border-amber-500">
                            </div>

                            <div class="w-24">
                                <input type="number" :name="'items[' + index + '][qty]'" x-model="item.qty" placeholder="Qty" min="1" required
                                       class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-medium focus:outline-none focus:border-amber-500">
                            </div>

                            <div class="w-32">
                                <input type="number" step="0.01" :name="'items[' + index + '][unit_price]'" x-model="item.unit_price" placeholder="Unit Price ৳" required
                                       class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-medium focus:outline-none focus:border-amber-500">
                            </div>

                            <div class="w-28 text-right font-mono font-bold text-slate-900 text-xs">
                                ৳<span x-text="Number(item.qty * item.unit_price).toLocaleString()"></span>
                            </div>

                            <button type="button" @click="removeItem(index)" class="p-2 text-rose-400 hover:text-rose-600 rounded-lg">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Financial Calculation Summary Card -->
            <div class="p-4 bg-slate-900 text-white rounded-xl space-y-2 text-xs font-medium max-w-sm ml-auto">
                <div class="flex justify-between">
                    <span class="text-slate-400">Subtotal:</span>
                    <span class="font-mono font-bold">৳<span x-text="subtotal.toLocaleString()"></span></span>
                </div>
                <div class="flex justify-between text-emerald-400">
                    <span>Advance Credit Deducted:</span>
                    <span class="font-mono font-bold">-৳<span x-text="Number(advancePaid || 0).toLocaleString()"></span></span>
                </div>
                <div class="flex justify-between pt-2 border-t border-slate-800 text-sm font-bold">
                    <span>Balance Due:</span>
                    <span class="font-mono text-amber-400">৳<span x-text="balanceDue.toLocaleString()"></span></span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Invoice Notes / Payment Instructions</label>
                <textarea name="notes" rows="2" placeholder="e.g. Please pay via Bank Transfer or Bkash to company account."
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500"></textarea>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('invoices.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-200 transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-amber-500/20 transition-all flex items-center gap-2">
                    <i class="fa fa-file-invoice"></i> Save & Issue Invoice
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

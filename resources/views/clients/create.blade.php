@extends('layouts.app')

@section('title', 'Add New Client')
@section('header_title', 'Add New Client Profile')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('clients.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1">
            <i class="fa fa-arrow-left"></i> Back to Client List
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8">
        <h2 class="text-lg font-bold text-slate-900 mb-6 pb-4 border-b border-slate-100">Client Information</h2>

        <form action="{{ route('clients.store') }}" method="POST" class="space-y-6" x-data="{
            serviceRows: [
                { service_id: '', price: 0, qty: 1 }
            ],
            addService() {
                this.serviceRows.push({ service_id: '', price: 0, qty: 1 });
            },
            removeService(index) {
                if (this.serviceRows.length > 1) {
                    this.serviceRows.splice(index, 1);
                }
            }
        }">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Client Full Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Tanvir Ahmed"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Company / Organization Name</label>
                    <input type="text" name="company" value="{{ old('company') }}" placeholder="e.g. Tanvir Enterprise Ltd"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Phone Number (WhatsApp)</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. +880-171-XXXXXXX"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="e.g. client@company.com"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Assigned Social Media Manager (SMM)</label>
                    <select name="assigned_smm" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                        <option value="">-- Select SMM Account Manager --</option>
                        @foreach($smmUsers as $smm)
                        <option value="{{ $smm->id }}" {{ old('assigned_smm') == $smm->id ? 'selected' : '' }}>{{ $smm->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Assigned Sales Executive</label>
                    <select name="assigned_sales" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                        <option value="">-- Select Sales Rep --</option>
                        @foreach($salesUsers as $sales)
                        <option value="{{ $sales->id }}" {{ old('assigned_sales') == $sales->id ? 'selected' : '' }}>{{ $sales->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                        <option value="active" selected>Active</option>
                        <option value="onboarding">Onboarding</option>
                        <option value="paused">Paused</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Billing Cycle</label>
                    <select name="billing_cycle" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                        <option value="monthly" selected>Monthly Recurring</option>
                        <option value="quarterly">Quarterly</option>
                        <option value="one-time">One-Time Project</option>
                    </select>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-900">Service Package Subscriptions</h3>
                    <button type="button" @click="addService()" class="px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold text-xs rounded-lg transition-all flex items-center gap-1">
                        <i class="fa fa-plus text-[10px]"></i> Add Service Line
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="(row, index) in serviceRows" :key="index">
                        <div class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200/80 rounded-xl">
                            <div class="flex-1">
                                <select :name="'services[' + index + '][service_id]'" x-model="row.service_id" required
                                        class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-medium focus:outline-none focus:border-amber-500">
                                    <option value="">-- Select Service --</option>
                                    @foreach($services as $svc)
                                    <option value="{{ $svc->id }}">{{ $svc->name }} (Base: ৳{{ number_format($svc->base_price) }}/{{ $svc->unit }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-32">
                                <input type="number" step="0.01" :name="'services[' + index + '][price]'" x-model="row.price" placeholder="Price ৳" required
                                       class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-medium focus:outline-none focus:border-amber-500">
                            </div>

                            <div class="w-24">
                                <input type="number" :name="'services[' + index + '][qty]'" x-model="row.qty" placeholder="Qty" min="1" required
                                       class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-medium focus:outline-none focus:border-amber-500">
                            </div>

                            <button type="button" @click="removeService(index)" class="p-2 text-rose-400 hover:text-rose-600 rounded-lg">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('clients.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-200 transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-amber-500/20 transition-all">
                    Save Client Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Edit Client Profile')
@section('header_title', 'Edit Client Profile')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('clients.show', $client->id) }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1">
            <i class="fa fa-arrow-left"></i> Back to Client Profile
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8">
        <h2 class="text-lg font-bold text-slate-900 mb-6 pb-4 border-b border-slate-100">Update Profile: {{ $client->name }}</h2>

        <form action="{{ route('clients.update', $client->id) }}" method="POST" class="space-y-6" x-data="{
            serviceRows: @js($client->clientServices->map(fn($cs) => ['service_id' => $cs->service_id, 'price' => $cs->price, 'qty' => $cs->qty])),
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
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Client Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', $client->name) }}" required
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Company / Organization</label>
                    <input type="text" name="company" value="{{ old('company', $client->company) }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $client->phone) }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $client->email) }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Assigned SMM Manager</label>
                    <select name="assigned_smm" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                        <option value="">-- Select SMM Manager --</option>
                        @foreach($smmUsers as $smm)
                        <option value="{{ $smm->id }}" {{ old('assigned_smm', $client->assigned_smm) == $smm->id ? 'selected' : '' }}>{{ $smm->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Assigned Sales Rep</label>
                    <select name="assigned_sales" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                        <option value="">-- Select Sales Rep --</option>
                        @foreach($salesUsers as $sales)
                        <option value="{{ $sales->id }}" {{ old('assigned_sales', $client->assigned_sales) == $sales->id ? 'selected' : '' }}>{{ $sales->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                        <option value="active" {{ $client->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="onboarding" {{ $client->status == 'onboarding' ? 'selected' : '' }}>Onboarding</option>
                        <option value="paused" {{ $client->status == 'paused' ? 'selected' : '' }}>Paused</option>
                        <option value="inactive" {{ $client->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Billing Cycle</label>
                    <select name="billing_cycle" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                        <option value="monthly" {{ $client->billing_cycle == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="quarterly" {{ $client->billing_cycle == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                        <option value="one-time" {{ $client->billing_cycle == 'one-time' ? 'selected' : '' }}>One-Time Project</option>
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
                <a href="{{ route('clients.show', $client->id) }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-200 transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-amber-500/20 transition-all">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

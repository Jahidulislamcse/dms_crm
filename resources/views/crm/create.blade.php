@extends('layouts.app')

@section('title', 'Add New Prospect Lead')
@section('header_title', 'Add Prospect Lead to CRM')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="leadCreateForm()">

    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Create New Sales Prospect</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Enter contact info, pipeline stage, assigned sales rep, and required services</p>
        </div>
        <a href="{{ route('crm.index') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-all flex items-center gap-2">
            <i class="fa fa-arrow-left"></i> Back to Pipeline
        </a>
    </div>

    <!-- Form Card -->
    <form action="{{ route('crm.store') }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8 space-y-8">
        @csrf

        <!-- Section 1: Contact & Company Profile -->
        <div class="space-y-4">
            <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-amber-500/10 text-amber-600 flex items-center justify-center font-bold text-xs">
                    <i class="fa fa-user"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-sm">Lead & Prospect Contact Information</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Full Contact Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="e.g. Tanvir Hossain"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                    @error('name') <span class="text-rose-500 text-[11px] font-semibold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Company / Organization</label>
                    <input type="text" name="company" value="{{ old('company') }}" placeholder="e.g. Apex Holdings Ltd"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. +880 1700 000000"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="e.g. client@company.com"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Location / Address</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. Gulshan-2, Dhaka"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                </div>
            </div>
        </div>

        <!-- Section 2: Pipeline Assignment & Lead Source -->
        <div class="space-y-4">
            <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-blue-500/10 text-blue-600 flex items-center justify-center font-bold text-xs">
                    <i class="fa fa-filter"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-sm">Pipeline & Assignment Settings</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pipeline Stage <span class="text-rose-500">*</span></label>
                    <select name="stage_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                        @foreach($stages as $stage)
                            <option value="{{ $stage->id }}" {{ old('stage_id') == $stage->id ? 'selected' : '' }}>
                                {{ $stage->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Assigned Sales Representative <span class="text-rose-500">*</span></label>
                    <select name="assigned_to" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                        @foreach($salesReps as $rep)
                            <option value="{{ $rep->id }}" {{ (old('assigned_to', auth()->id()) == $rep->id) ? 'selected' : '' }}>
                                {{ $rep->name }} ({{ ucfirst($rep->role) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Lead Source <span class="text-rose-500">*</span></label>
                    <select name="source" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                        <option value="Facebook" {{ old('source') == 'Facebook' ? 'selected' : '' }}>Facebook Ads / Page</option>
                        <option value="Website" {{ old('source') == 'Website' ? 'selected' : '' }}>Website Form</option>
                        <option value="Referral" {{ old('source') == 'Referral' ? 'selected' : '' }}>Client Referral</option>
                        <option value="WhatsApp" {{ old('source') == 'WhatsApp' ? 'selected' : '' }}>WhatsApp Inquiry</option>
                        <option value="Cold Call" {{ old('source') == 'Cold Call' ? 'selected' : '' }}>Cold Call / Outreach</option>
                        <option value="Google Ads" {{ old('source') == 'Google Ads' ? 'selected' : '' }}>Google Search Ads</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Estimated Budget (৳)</label>
                    <input type="number" step="0.01" min="0" name="budget" x-model="budget" placeholder="0.00"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Next Follow-up Date</label>
                    <input type="date" name="next_followup" value="{{ old('next_followup') }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                </div>
            </div>
        </div>

        <!-- Section 3: Requirements Line Items -->
        <div class="space-y-4">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-bold text-xs">
                        <i class="fa fa-layer-group"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Requested Services & Requirements Breakdown</h3>
                </div>
                <button type="button" @click="addRequirement()" class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 font-bold text-xs border border-emerald-200 hover:bg-emerald-100 transition-all flex items-center gap-1.5">
                    <i class="fa fa-plus"></i> Add Item
                </button>
            </div>

            <div class="space-y-3">
                <template x-for="(req, index) in requirements" :key="index">
                    <div class="grid grid-cols-12 gap-2 items-center bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <div class="col-span-6 md:col-span-5">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Service / Package</label>
                            <input type="text" :name="`requirements[${index}][service_name]`" x-model="req.service_name" placeholder="e.g. Social Media Management" required
                                   class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-amber-500">
                        </div>
                        <div class="col-span-3 md:col-span-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Qty</label>
                            <input type="number" min="1" :name="`requirements[${index}][qty]`" x-model.number="req.qty" @input="updateTotalBudget()" required
                                   class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-amber-500">
                        </div>
                        <div class="col-span-3 md:col-span-3">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Unit Price (৳)</label>
                            <input type="number" min="0" step="0.01" :name="`requirements[${index}][unit_price]`" x-model.number="req.unit_price" @input="updateTotalBudget()" required
                                   class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-amber-500">
                        </div>
                        <div class="col-span-12 md:col-span-2 flex items-center justify-between md:justify-end gap-2 pt-2 md:pt-0">
                            <span class="text-xs font-extrabold text-slate-900 md:hidden">Total: ৳<span x-text="(req.qty * req.unit_price).toFixed(2)"></span></span>
                            <button type="button" @click="removeRequirement(index)" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-all" title="Remove Item">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Section 4: Initial Notes -->
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Initial Discussion & Activity Notes</label>
            <textarea name="notes" rows="3" placeholder="Enter details about client expectations, initial call summary, or special requirements..."
                      class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">{{ old('notes') }}</textarea>
        </div>

        <!-- Submit Buttons -->
        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('crm.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-bold text-xs hover:bg-slate-200 transition-all">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold text-xs shadow-md shadow-amber-500/20 transition-all">
                <i class="fa fa-check mr-1.5"></i> Save Prospect Lead
            </button>
        </div>
    </form>
</div>

<script>
    function leadCreateForm() {
        return {
            budget: 0,
            requirements: [
                { service_name: 'Social Media Management', qty: 1, unit_price: 25000 }
            ],
            addRequirement() {
                this.requirements.push({ service_name: '', qty: 1, unit_price: 0 });
            },
            removeRequirement(index) {
                if (this.requirements.length > 1) {
                    this.requirements.splice(index, 1);
                    this.updateTotalBudget();
                }
            },
            updateTotalBudget() {
                let sum = this.requirements.reduce((acc, item) => acc + (item.qty * item.unit_price), 0);
                if (sum > 0) {
                    this.budget = sum;
                }
            }
        }
    }
</script>
@endsection

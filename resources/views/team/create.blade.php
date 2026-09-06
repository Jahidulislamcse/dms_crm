@extends('layouts.app')

@section('title', 'Register Team Member')
@section('header_title', 'Register New Team Member')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <a href="{{ route('team.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1">
        <i class="fa fa-arrow-left"></i> Back to Team List
    </a>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8">
        <h2 class="text-lg font-bold text-slate-900 mb-6 pb-4 border-b border-slate-100">User Account Credentials</h2>

        <form action="{{ route('team.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Rafiq Ahmed"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Username *</label>
                    <input type="text" name="username" value="{{ old('username') }}" required placeholder="e.g. rafiq"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="e.g. rafiq@agency.com"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password *</label>
                    <input type="password" name="password" required placeholder="Minimum 6 characters"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Role *</label>
                    <select name="role" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                        @foreach($roles as $key => $label)
                        <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Avatar Highlight Color</label>
                <input type="color" name="color" value="{{ old('color', '#3b82f6') }}"
                       class="w-full h-10 p-1 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer">
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('team.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-200 transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-amber-500/20 transition-all">
                    Register User Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

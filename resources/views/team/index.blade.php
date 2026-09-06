@extends('layouts.app')

@section('title', 'Team & User Management')
@section('header_title', 'Super Admin Team & Role Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('team.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search team member name or username..."
                   class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500 w-64">

            <select name="role" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                <option value="">All Roles</option>
                @foreach($roles as $key => $label)
                <option value="{{ $key }}" {{ request('role') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-slate-800 text-white text-xs font-bold rounded-xl hover:bg-slate-900 transition-all">Filter</button>
        </form>

        <a href="{{ route('team.create') }}" class="px-4 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-bold text-xs rounded-xl shadow-lg shadow-amber-500/20 transition-all flex items-center justify-center gap-2">
            <i class="fa fa-user-plus"></i> Register Team Member
        </a>
    </div>

    <!-- Team Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($users as $user)
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full flex items-center justify-center font-bold text-white text-sm shadow-md" style="background-color: {{ $user->color ?? '#64748b' }}">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900">{{ $user->name }}</h4>
                    <p class="text-xs text-slate-400 font-mono">@ {{ $user->username }}</p>
                    <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 uppercase">
                        {{ $roles[$user->role] ?? $user->role }}
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('team.edit', $user->id) }}" class="p-2 text-amber-500 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition-all" title="Edit Staff">
                    <i class="fa fa-edit"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    @if($users->hasPages())
    <div class="p-4 bg-white rounded-2xl border border-slate-200/80">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection

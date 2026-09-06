<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Client, Service, User, ClientService};

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::with(['assignedSmm', 'assignedSales', 'clientServices']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $clients = $query->latest()->paginate(10);
        $smmUsers = User::where('role', 'smm')->where('active', true)->get();
        $salesUsers = User::where('role', 'sales')->where('active', true)->get();

        return view('clients.index', compact('clients', 'smmUsers', 'salesUsers'));
    }

    public function create()
    {
        $services = Service::where('active', true)->get();
        $smmUsers = User::where('role', 'smm')->where('active', true)->get();
        $salesUsers = User::where('role', 'sales')->where('active', true)->get();

        return view('clients.create', compact('services', 'smmUsers', 'salesUsers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:255',
            'assigned_smm' => 'nullable|exists:users,id',
            'assigned_sales' => 'nullable|exists:users,id',
            'status' => 'required|in:active,inactive,onboarding,paused',
            'billing_cycle' => 'required|in:monthly,quarterly,one-time',
            'advance' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'services' => 'nullable|array',
            'services.*.service_id' => 'required|exists:services,id',
            'services.*.price' => 'required|numeric|min:0',
            'services.*.qty' => 'required|integer|min:1',
        ]);

        $client = Client::create([
            'name' => $validated['name'],
            'company' => $validated['company'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'location' => $validated['location'] ?? null,
            'assigned_smm' => $validated['assigned_smm'] ?? null,
            'assigned_sales' => $validated['assigned_sales'] ?? null,
            'status' => $validated['status'],
            'billing_cycle' => $validated['billing_cycle'],
            'advance' => $validated['advance'] ?? 0,
            'notes' => $validated['notes'] ?? null,
            'onboarded_at' => now()->toDateString(),
        ]);

        if (!empty($validated['services'])) {
            foreach ($validated['services'] as $svc) {
                ClientService::create([
                    'client_id' => $client->id,
                    'service_id' => $svc['service_id'],
                    'price' => $svc['price'],
                    'qty' => $svc['qty'],
                ]);
            }
        }

        return redirect()->route('clients.index')->with('success', "Client '{$client->name}' created successfully!");
    }

    public function show(Client $client)
    {
        $client->load(['assignedSmm', 'assignedSales', 'clientServices.service', 'invoices', 'tasks.assignedTo', 'contentPosts']);
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        $client->load('clientServices');
        $services = Service::where('active', true)->get();
        $smmUsers = User::where('role', 'smm')->where('active', true)->get();
        $salesUsers = User::where('role', 'sales')->where('active', true)->get();

        return view('clients.edit', compact('client', 'services', 'smmUsers', 'salesUsers'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:255',
            'assigned_smm' => 'nullable|exists:users,id',
            'assigned_sales' => 'nullable|exists:users,id',
            'status' => 'required|in:active,inactive,onboarding,paused',
            'billing_cycle' => 'required|in:monthly,quarterly,one-time',
            'advance' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'services' => 'nullable|array',
            'services.*.service_id' => 'required|exists:services,id',
            'services.*.price' => 'required|numeric|min:0',
            'services.*.qty' => 'required|integer|min:1',
        ]);

        $client->update([
            'name' => $validated['name'],
            'company' => $validated['company'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'location' => $validated['location'] ?? null,
            'assigned_smm' => $validated['assigned_smm'] ?? null,
            'assigned_sales' => $validated['assigned_sales'] ?? null,
            'status' => $validated['status'],
            'billing_cycle' => $validated['billing_cycle'],
            'advance' => $validated['advance'] ?? 0,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Sync services
        ClientService::where('client_id', $client->id)->delete();
        if (!empty($validated['services'])) {
            foreach ($validated['services'] as $svc) {
                ClientService::create([
                    'client_id' => $client->id,
                    'service_id' => $svc['service_id'],
                    'price' => $svc['price'],
                    'qty' => $svc['qty'],
                ]);
            }
        }

        return redirect()->route('clients.show', $client->id)->with('success', "Client updated successfully!");
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', "Client '{$client->name}' deleted successfully!");
    }
}

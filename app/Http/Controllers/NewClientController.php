<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class NewClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('admin_side.appointments.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin_side.appointments.clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        Client::create($validated);

        return redirect()->route('admin.appointments.create')
            ->with('success', 'Client created successfully.');
    }

    public function edit(Client $client)
    {
        return view('admin_side.appointments.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $client->update($validated);

        return redirect()->route('admin_side.appointments.clients.index')
            ->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}
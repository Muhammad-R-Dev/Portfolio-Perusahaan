<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return Client::latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'project' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_awal' => 'required|date',
            'deadline' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $client = Client::create($validated);
        return response()->json($client, 201);
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'project' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_awal' => 'required|date',
            'deadline' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $client->update($validated);
        return response()->json($client);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
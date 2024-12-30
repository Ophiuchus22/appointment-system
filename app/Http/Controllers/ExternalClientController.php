<?php

namespace App\Http\Controllers;

use App\Models\ExternalClient;
use Illuminate\Http\Request;

class ExternalClientController extends Controller
{
    public function search(Request $request)
    {
        $term = $request->get('term');
        
        $clients = ExternalClient::search($term)
            ->select('id', 'first_name', 'last_name', 'email', 'phone_number', 'company_name', 'address')
            ->limit(5)
            ->get();
            
        return response()->json($clients);
    }
}

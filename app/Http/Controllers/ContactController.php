<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('tienda.contacto');
    }

    public function enviar(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:50',
            'mensaje' => 'required|string|max:5000',
        ]);

        // TODO: enviar email o guardar en BD
        return back()->with('success', 'Gracias por tu mensaje. Te responderemos a la brevedad.');
    }
}

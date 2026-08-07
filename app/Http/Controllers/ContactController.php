<?php

namespace App\Http\Controllers;

use App\Mail\MensajeContacto;
use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        $configuracion = Configuracion::first();

        if (! $configuracion?->email) {
            return back()
                ->withErrors(['email' => 'No se pudo enviar el mensaje porque no hay un correo de contacto configurado.'])
                ->withInput();
        }

        try {
            Mail::to($configuracion->email)->send(new MensajeContacto(
                destinatario: $configuracion->email,
                nombre: $data['nombre'],
                email: $data['email'],
                telefono: $data['telefono'] ?? null,
                mensaje: $data['mensaje'],
            ));

            return back()->with('success', 'Gracias por tu mensaje. Te responderemos a la brevedad.');
        } catch (\Throwable $e) {
            Log::error('Error enviando mensaje de contacto: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return back()
                ->withErrors(['email' => 'Hubo un problema al enviar el mensaje. Intentá nuevamente en unos minutos.'])
                ->withInput();
        }
    }
}

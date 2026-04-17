<?php

namespace App\Http\Controllers;

use App\Events\MessageCreate;
use App\Models\Message;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function viewChat() {

        $mensajes = Message::all(); //cojemos todos los registros de la bd en cuando a mensajes

        return Inertia::render('chat',compact('mensajes')); // aqui llamamos al componente que renderize el componente y le pase esto
    }

    public function createMessage(Request $request) {


        $request->validate([
            'content' => 'required|string|max:255' //confiramos que el mensaje es correcto
        ]);

        $mensaje = Message::create([
            'content' => $request->content, //usamos el mensaje ya validado
            'user_id' => auth()->id() //sacamso el id de la persona que a escrito
        ]);

        broadcast(new MessageCreate($mensaje))->toOthers(); //forma correcta de lanzar el evento

        return response()->json($mensaje, 201); //lo mandamos en json para axios indicando el codigo 201

    }

}

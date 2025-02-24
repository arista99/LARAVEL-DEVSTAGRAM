<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $manager = new ImageManager(new Driver());

        $imagen = $request->file('file');

        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        $imagenServidor = $manager->read($imagen);

        $imagenServidor->scale(1000, 1000);

        // Agregamos la imagen a la  carpeta en public donde se guardaran las imagenes
        $imagenesPath = public_path('uploads') . '/' . $nombreImagen;

        // Una vez procesada la imagen entonces guardamos la imagen en la carpeta que creamos
        $imagenServidor->save($imagenesPath);

        // Retornamos el nombre de la imagen, que es el nombre que nos da el ID único con uuid()
        return response()->json(['imagen' => $nombreImagen]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;
use App\Responses\ResponseMessages;

class usuarioController extends Controller
{   // Obtener todos los Usuarios
    public function index()
    {
        try {
            // Obtener todos los Usuarios
            $usuario = Usuario::all();
            // Si no se encontraron Usuarios
            if ($usuario->isEmpty()) {
                return ResponseMessages::error('No se encontraron usuarios', 404);
            }
            return ResponseMessages::success($usuario, 'Operación exitosa', 200);
        } catch (\Exception $e) {
            return ResponseMessages::error('Error interno del servidor', 500);
        }
    }
    // Obtener un usuarios por ID
    public function show($id)
    {
        try {
            // Obtener el usuarios por ID
            $usuario = Usuario::findOrFail($id);
            return ResponseMessages::success($usuario, 'Operación exitosa', 200);
        } catch (\Exception $e) {
            return ResponseMessages::error('Usuario no encontrado', 404);
        }
    }
    // Crear un nuevo usuario
    public function store(Request $request)
    {
        try {
            // Validar los datos del usuario
            $validator = $this->validateStudent($request);
            // Si la validación falla
            if ($validator->fails()) {
                return ResponseMessages::error($validator->errors(), 400);
            }
            // Encriptar la contraseña con SHA-256
            $request->merge([
                'clave' => hash('sha256', $request->clave)
            ]);
            $usuario = Usuario::create($request->only([
                'nombre',
                'correo_electronico',
                'usuario',
                'clave',
                'fecha_nacimiento',
                'telefono',
                'direccion',
                'rol',
                'estado'
            ]));
            return ResponseMessages::success($usuario, 'Usuario creado', 201);
        } catch (\Exception $e) {
            return ResponseMessages::error($e, 500);
        }
    }

    // Actualizar un usuario
    public function update(Request $request)
    {
        try {
            // Validar los datos del usuario
            $validator = $this->validateStudent($request, $request->id);
            // Si la validación falla
            if ($validator->fails()) {
                return ResponseMessages::error($validator->errors(), 400);
            }
            // Encriptar la contraseña con SHA-256
            if ($request->has('clave')) {
                $request->merge([
                    'clave' => hash('sha256', $request->clave)
                ]);
            }
            // Actualizar el usuario
            $usuario = Usuario::findOrFail($request->id);
            $usuario->update($request->only([
                'nombre',
                'correo_electronico',
                'usuario',
                'clave',
                'fecha_nacimiento',
                'telefono',
                'direccion',
                'rol',
                'estado'
            ]));
            return ResponseMessages::success($usuario, 'Usuario actualizado', 200);
        } catch (\Exception $e) {
            return ResponseMessages::error($e, 500);
        }
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        try {
            // Eliminar el usuario
            $usuario = Usuario::findOrFail($id);
            $usuario->delete();
            return ResponseMessages::success(null, 'Usuario eliminado', 200);
        } catch (\Exception $e) {
            return ResponseMessages::error('Usuario no encontrado', 404);
        }
    }

    // Validar los datos del usuario
    private function validateStudent($request, $id = null)
    {
        // Reglas de validación
        $rules = [
            'nombre' => 'required|string|max:100',
            'correo_electronico' => 'required|email|max:255|unique:usuario,correo_electronico,' . $id . ',id',  // Correcta validación de email con exclusión del ID
            'usuario' => 'required|string|max:50|unique:usuario,usuario,' . $id . ',id',  // Correcta validación de usuario con exclusión del ID
            'clave' => 'required|string',
            'fecha_nacimiento' => 'nullable|date',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'rol' => 'required|in:admin,usuario,moderador',
            'estado' => 'required|in:activo,inactivo'
        ];
        // Si se proporciona un ID, asegurarse de que el ID exista en la base de datos
        if ($id != null) {
            $rules['id'] = 'required|exists:usuario,id';  // Validar que el ID exista
        }
        // Crear el validador
        $validator = Validator::make($request->all(), $rules);
        return $validator;
    }
}

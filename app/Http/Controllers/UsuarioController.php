<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Http\Request;
use App\Usuario;
use App\Categoria;
use App\Mail\SendMailUser;
use App\Mail\SendNotificationUser;
use DB;
use Image;
use File;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $usuarios = Usuario::with('categoria')->get();
        $usuarios = Usuario::orderBy('created_at', 'desc')->paginate(5);

        $search = $request->get('search');
        if (!empty($search)) {
            $categoria = DB::table('categorias')->where('nome', 'LIKE', '%' . $search . '%')->first();
            $query = Usuario::where('nome', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('dt_nascimento', 'LIKE', '%' . $search . '%')
                ->orWhere('categoria_id', '=', $categoria ? $categoria->id : null);

            $usuarios = $query->orderBy('created_at', 'desc')->paginate(5);
        }

        return view('users.index', compact('usuarios', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::All();

        return view('users.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'email' => 'required|email|unique:usuarios|max:100',
            'nascimento' => 'required|date',
            'img' => 'image'
        ]);
        $usuarios = new Usuario([
            'nome' => $request->get('nome'),
            'email' => $request->get('email'),
            'dt_nascimento' => $request->get('nascimento'),
            'categoria_id' => $request->get('categoria')
        ]);
        if ($request->hasFile('img')) {
            $originalImage = $request->file('img');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path() . '/thumbnail/';
            $originalPath = public_path() . '/images/';
            $thumbnailImage->save($originalPath . time() . 'T' . $originalImage->getClientOriginalName());
            $thumbnailImage->resize(50, 50);
            $thumbnailImage->save($thumbnailPath . time()  . 'S' . $originalImage->getClientOriginalName());

            $usuarios->ft = time() . 'T' . $originalImage->getClientOriginalName();
            $usuarios->thumb = time() . 'S' . $originalImage->getClientOriginalName();
        }
        $usuarios->save();

        Mail::to($usuarios->email)->send(new SendMailUser($usuarios));

        return redirect('users')->with('success', 'Usuário cadastrado com sucesso!');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $categorias = Categoria::All();
        return view('users.edit', compact('usuario', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        
        if($usuario->email != $request->get('email')) {
            $validator = $request->validate([
                'nome' => 'required|max:255',
                'email' => 'required|email|unique:usuarios|max:100',
                'nascimento' => 'required|date',
                'img' => 'image'
            ]);
        } else {
            $validator = $request->validate([
                'nome' => 'required|max:255',
                'email' => 'required|email|max:100',
                'nascimento' => 'required|date',
                'img' => 'image'
            ]);
        }

        $usuario->nome = $request->get('nome');
        $usuario->email = $request->get('email');
        $usuario->dt_nascimento = $request->get('nascimento');
        $usuario->categoria_id = $request->get('categoria');
        if ($request->hasFile('img')) {

            // Caso tenha alguma foto antes do update irá ser apagada
            $image_path = public_path() . '/images/' . $usuario->ft;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $thumb_path = public_path() . '/thumbnail/' . $usuario->thumb;
            if (File::exists($thumb_path)) {
                File::delete($thumb_path);
            }

            $originalImage = $request->file('img');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path() . '/thumbnail/';
            $originalPath = public_path() . '/images/';
            $thumbnailImage->save($originalPath . time() . 'T' . $originalImage->getClientOriginalName());
            $thumbnailImage->resize(50, 50);
            $thumbnailImage->save($thumbnailPath . time()  . 'S' . $originalImage->getClientOriginalName());

            $usuario->ft = time() . 'T' . $originalImage->getClientOriginalName();
            $usuario->thumb = time() . 'S' . $originalImage->getClientOriginalName();
        }

        $usuario->save();

        return redirect('/users')->with('success', "Usuário atualizado com sucesso");
    }

    public function show($id)
    {
        $usuario = Usuario::where('id', $id)->with('categoria')->get();

        return view('users.vizualizar', compact('usuario'));
    }

    public function notificar($id)
    {
        $usuario = Usuario::findOrFail($id);
        Mail::to($usuario->email)->send(new SendNotificationUser($usuario));
        return redirect('/users')->with('success', 'E-mail disparado ao usuário ' . $usuario->nome);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        $image_path = public_path() . '/images/' . $usuario->ft;
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        $thumb_path = public_path() . '/thumbnail/' . $usuario->thumb;
        if (File::exists($thumb_path)) {
            File::delete($thumb_path);
        }

        return redirect('/users')->with('success', 'Usuário foi deletado com sucesso');
    }
}

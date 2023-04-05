<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_profile' => __('No tiene permisos para modificar este usuario.')]);
        }


        //auth()->user()->update($request->all());
        $elusuario = User::find(auth()->user()->id);
        $elusuario->name = $request->name;
        $elusuario->documento = $request->documento;
        $elusuario->email = $request->email;
        $elusuario->save();

        return back()->withStatus(__('Perfil modificado correctamente.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_password' => __('No puede realizar la modificación en este usuario.')]);
        }

        //        auth()->user()->update(['password' => Hash::make($request->get('password'))]);
        $modifclave = User::find(auth()->user()->id);
        $modifclave->password = Hash::make($request->get('password'));
        $modifclave->save();

        return back()->withPasswordStatus(__('Clave modificada correctamente.'));
    }
}

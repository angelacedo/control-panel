<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Facades\URL;
class Guest extends Controller
{
    public function home(){
        return view('index');
    }
    public function contact(){
        return view('contact');
    }

    public function work(){
        return view('work');
    }
    public function passwordreset(){
        return view('auth.resetpassword');
    }
    public function passwordreset_email(Request $request){
        $email = $request->input('email');
        $email_query = DB::table('users')->where('email', $email)->first();
       
        if($email_query != null){
            $hash = URL::temporarySignedRoute(
                'password_recover', now()->addMinutes(30), ['user' => auth()->user(), 'id' => $email_query->id, 'email' => $email_query->email]
            );
            
            Mail::to($email)->send(new ResetPassword($email_query->id, $email_query->username, $hash));
            Session::flash('reset_email_message', "Si has ingresado un email valido, usted habrá recibido un correo en su bandeja de notificaciones");  
            return back();
        }
        if($email_query == null){
            Session::flash('reset_email_message', "Si has ingresado un email valido, usted habrá recibido un correo en su bandeja de notificaciones");  
            return back();
        }
    }
    public function password_recover(Request $request){
       
        if ($request->hasValidSignature()) {
            return view('recoverpassword');    
        } else {
            return redirect('/login');
        }
        
    }
    public function password_recover_post(Request $request){
        $email = $request->email;
        $hashed_password = Hash::make($request->input('password'));
        
        $change_password = DB::table('users')->where('email', $email)->update(['password' => $hashed_password, 'updated_at' => date('Y-m-d G:i:s')]);
        if ($change_password == 1) {
            Session::flash('recover_message_done', 'Su correo ha sido reestablecido correctamente');
            return redirect('/login');
        } else {
            Session::flash('recover_message_error', 'Ha habido un error al cambiar su contraseña. Por favor, inténtelo de nuevo');
            return redirect('/login');

        }
    }
}

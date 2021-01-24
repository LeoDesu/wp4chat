<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ],[
            'email.required' => 'E-mail ຕ້ອງບໍ່ເປັນຄ່າວ່າງ',
            'email.email' => 'E-mail ຈະຕ້ອງເປັນ E-mail ເຊັ່ນ: myemail@example.com',
            'password.required' => 'ລະຫັດຜ່ານຕ້ອງບໍ່ເປັນຄ່າວ່າງ',
            'password.min' => 'ລະຫັດຜ່ານຕ້ອງມີຢ່າງໜ້ອຍ 8 ໂຕ'
        ]);
        if(Auth::attempt($request->only('email', 'password'))){
            return response()->json(Auth::user(), 200);
        }
        throw ValidationException::withMessages([
            'email' => ['E-mail ຫຼື ລະຫັດຜ່ານທີ່ປ້ອນແມ່ນບໍ່ຖືກຕ້ອງ.']
        ]);
    }
    public function logout(){
        Auth::logout();
    }
}

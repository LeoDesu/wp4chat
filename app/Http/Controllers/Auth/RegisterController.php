<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    protected function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],[
            'username.required' => 'ຊື່ຜູ້ໃຊ້ຕ້ອງບໍ່ເປັນຄ່າວ່າງ',
            'email.required' => 'E-mail ຕ້ອງບໍ່ເປັນຄ່າວ່າງ',
            'email.email' => 'E-mail ຈະຕ້ອງເປັນ E-mail ເຊັ່ນ: myemail@example.com',
            'password.required' => 'ລະຫັດຜ່ານຕ້ອງບໍ່ເປັນຄ່າວ່າງ',
            'password.min' => 'ລະຫັດຜ່ານຕ້ອງມີຢ່າງໜ້ອຍ 8 ໂຕ',
            'password.confirmed' => 'ຕ້ອງໄດ້ຢືນຢັນລະຫັດຜ່ານໃຫ້ຕົງກັບລະຫັດຜ່ານທີ່ປ້ອນ'
        ]);
        User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }
}

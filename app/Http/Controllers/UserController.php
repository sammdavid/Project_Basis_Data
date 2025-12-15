<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Prodi;
use App\Models\Pengaduan;
use App\Models\JenisPekerjaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // ============================
    // AUTH SECTION
    // ============================
public function register(Request $request)
{
    $request->validate([
        'nim' => 'required|unique:user,nim',
        'nama' => 'required',
        'password' => 'required|min:6',
        'jenis_kelamin' => 'required|string',
        'role' => 'required|string',
        'prodi' => 'required_if:role,mahasiswa|integer|nullable',
        'angkatan' => 'required_if:role,mahasiswa|integer|nullable',
    ]);

    $user = User::create([
        'nim' => $request->nim,
        'nama' => $request->nama,
        'jenis_kelamin' => $request->jenis_kelamin,
        'tempat_lahir' => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
        'alamat' => $request->alamat,
        'nomor_telepon' => $request->nomor_telepon,
        'jenis_pekerjaan_id' => $request->jenis_pekerjaan_id ?? null,
        'prodi' => $request->prodi ?? null,
        'angkatan' => $request->angkatan ?? null,
        'role' => 'Pelapor',
        'password' => Hash::make($request->password),
    ]);

    // ================================
    // INSERT KE OLAP (dim_pelapor)
    // ================================
    DB::connection('mysql_olap')->table('dim_pelapor')->insert([
        'user_id' => $user->user_id,
        'nim' => $user->nim,
        'nama' => $user->nama,
        'email' => $user->email ?? null,
        'angkatan' => $user->angkatan,
        'jenis_kelamin' => $user->jenis_kelamin,
        'nama_prodi' => $user->prodi ?? null,          // aman & sederhana
        'nama_pekerjaan' => null,                      // isi nanti kalau perlu
    ]);

    return redirect()->route('login')->with('success', 'Akun berhasil dibuat, silakan login.');
}
    public function login(Request $request)
    {
        $credentials = $request->only('nim', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('index')->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'NIM atau Password salah.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }

    public function create()
    {
        $listPekerjaan = JenisPekerjaan::all();
        return view('user.create', ['listPekerjaan' => $listPekerjaan]);
    }

    public function edit(User $user)
    {
        $listPekerjaan = JenisPekerjaan::all();
        return view('user.edit', [
            'user' => $user,
            'listPekerjaan' => $listPekerjaan
        ]);
    }

    public function profil()
    {
        $user = Auth::user();
        $totalPengaduan = Pengaduan::where('user_id', $user->user_id)->count();
        $menunggu = Pengaduan::where('user_id', $user->user_id)
            ->where('status_pengaduan', 'Menunggu')
            ->count();

        $diproses = Pengaduan::where('user_id', $user->user_id)
            ->where('status_pengaduan', 'Diproses')
            ->count();

        $selesai = Pengaduan::where('user_id', $user->user_id)
            ->where('status_pengaduan', 'Selesai')
            ->count();

        $ditolak = Pengaduan::where('user_id', $user->user_id)
            ->where('status_pengaduan', 'Ditolak')
            ->count();



        return view('pages.profil', compact(
            'user',
            'totalPengaduan',
            'menunggu',
            'diproses',
            'selesai',
            'ditolak'
        ));
    }

    public function editUser($user_id)
    {
        $user = User::findOrFail($user_id);
        $jenis_pekerjaan = JenisPekerjaan::all();
        $program_studi = Prodi::all();
        return view('pages.admin.users.edit', compact(
            'user',
            'jenis_pekerjaan',
            'program_studi'
        ));
    }

    public function updateUser(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('user', 'email')->ignore($user->user_id, 'user_id'),
                Rule::unique('admin', 'email'),
            ],
            'password' => 'nullable|min:6|confirmed',
            'account_type' => 'required|string|in:user,admin'
        ]);

        $newAccountType = $request->input('account_type');

        if ($newAccountType === 'user') {
            $user->nim = $request->nim;
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->tempat_lahir = $request->tempat_lahir;
            $user->tanggal_lahir = $request->tanggal_lahir;
            $user->alamat = $request->alamat;
            $user->nomor_telepon = $request->nomor_telepon;
            $user->jenis_pekerjaan_id = $request->jenis_pekerjaan_id;
            $user->prodi_id = $request->prodi_id;
            $user->angkatan = $request->angkatan;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            return redirect()->route('admin.kelola-user')->with('success', 'Data pengguna berhasil diperbarui.');
        }

        if ($newAccountType === 'admin') {
            DB::transaction(function () use ($user, $request) {
                Admin::create([
                    'nip'           => $user->nim,
                    'nama'          => $request->input('nama', $user->nama),
                    'email'         => $request->input('email', $user->email),
                    'jenis_kelamin' => $user->jenis_kelamin,
                    'tempat_lahir'  => $user->tempat_lahir,
                    'tanggal_lahir' => $user->tanggal_lahir,
                    'alamat'        => $user->alamat,
                    'nomor_telepon' => $user->nomor_telepon,
                    'jenis_pekerjaan_id' => $user->jenis_pekerjaan_id,
                    'password'      => $request->filled('password') ? Hash::make($request->password) : $user->password,
                ]);
                $user->delete();
            });

            return redirect()->route('admin.kelola-user')->with('success', 'Pengguna berhasil dipromosikan menjadi Admin!');
        }
    }
}



<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Mahasiwa;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;




class MahasiwaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  
     public function index()
    {
        //yang semulanya Mahasiswa::all menjadi mahasiswa with yang menyatakan relasi
        $mahasiswa = Mahasiwa::with('kelas')->get();
    
        // fungsi latest berfungsi untuk menampilkan berdasarkan data terakhir di input    
        $post = Mahasiwa::latest();
        // search berdasarkan nama atau nim
        if (request('search')) {
            $post->where('nama', 'like', '%' . request('search') . '%')->orWhere('nim','like','%' . request('search').'%');
        }

        //add pagination 
        return view('mahasiswa.index',[
            'mahasiswa' => $mahasiswa,
            'post' => $post -> paginate (5)
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas=Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.create',['kelas'=>$kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //melakukan validasi data, fungsi untuk memanggil file create.blade untuk pemrosesan
        $request->validate([
            'nim' => 'required|digits_between:8,10|unique:mahasiswa,nim',
            'nama' => 'required|string|max:20',
            'kelas' => 'required|string|max:5',
            'jurusan' => 'required|string|max:25',
            'email' => 'required|string',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|digits_between:8,10',
        ]);

        //fungsi eloquent untuk menambah data
        Mahasiwa::create($request->all());
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiwa $mahasiswa)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = $mahasiswa;
        return view('mahasiswa.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Mahasiwa $mahasiswa)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
         $Mahasiswa = $mahasiswa;
        return view('mahasiswa.edit', compact('Mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mahasiwa $mahasiswa)
    {
        //melakukan validasi data fungsi untuk memanggil file edit.blade untuk pemrosesan
    $data= $request->validate([
        'nim' => 'required|digits_between:8,10|unique:mahasiswa,nim',
            'nama' => 'required|string|max:20',
            'kelas' => 'required|string|max:5',
            'jurusan' => 'required|string|max:25',
            'email' => 'required|string',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|digits_between:8,10',
        ]);
        //fungsi eloquent untuk mengupdate data inputan kita
        //memanggil nama kolom dalam model mahasiswa yang sesuai dengan id mahasiswa yg di req
        Mahasiwa::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->update($data);

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiwa $mahasiswa)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiwa::where('id_mahasiswa',$mahasiswa->id_mahasiswa)->delete();
        return redirect()->route('mahasiswa.index')
            -> with('success', 'Mahasiswa Berhasil Dihapus');  
    }
}

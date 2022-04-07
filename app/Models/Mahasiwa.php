<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Mahasiwa as Authenticatable;  
use Illuminate\Notifications\Notifiable; 
use Illuminate\Database\Eloquent\Model; //Model Eloquent 

class Mahasiwa extends Model //Definisi Model

{
    protected $table='mahasiswa'; // Eloquent akan membuat model mahasiswa menyimpan record di tabel mahasiswa
    protected $primaryKey = 'nim'; // Memanggil isi DB Dengan primarykey
    protected $keyType='string';
    
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     

    protected $fillable = [
    'nim',
    'nama',
    'kelas',
    'kelas_id',
    'jurusan',
    ];

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }
};

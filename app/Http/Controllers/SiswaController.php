<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        // mengambil semua nama siswa menggunakan eloquent
        // foreach (Siswa::all() as $siswa) {
        //     echo $siswa->nama . "<br>";
        // }

        //     $siswa_laki = Siswa::where('jk', 'L')
        //         ->orderBy('nama')->get();
        //     foreach ($siswa_laki as $siswa) {
        //         echo $siswa->nis . " - " . $siswa->nama . "<br>";
        //     }

        // mengambil single model
        // mengambil model dengan nilai primary key
        // $siswa = Siswa::find('202101001');
        // // ambil model pertama yang cocok dengan batasan query
        // $siswa = Siswa::where('nis', '202101001')->first();
        // // alternatif untuk mengambil model pertama yang cocok dengan batasan query
        // $siswa = Siswa::firstWhere('nis', '202101001');

        // $siswa_pertama_dari_jurusan = Siswa::where('id_jurusan', '-', 3)->firstOr(function () {
        //     echo 'tidak ada hasil yang ditemukan';
        // });

        // // mengambil primarykey dengan findorfile
        // $siswa = Siswa::findorfile('202101001');
        // // mengambil pembatasan query dengan findorfile
        // $siswa = Siswa::where('id_jurusan', '>', 2)->firstOrfile();

        // mengambil semua siswa dengan query builder
        $siswa_all = DB::table('siswa')->get();
        foreach ($siswa_all as $siswa) {
            echo $siswa->nis . "-" . $siswa->nama .  "<br>";
        }

        // mengambil single row/column
        // mengambil satu row
        $siswa_all = DB::table('siswa')->where('nama', 'sugeng')->first();
        $siswa_all = DB::table('siswa')->where('nama', 'sugeng')->value('nis');
        $siswa_single_by_id = DB::table('siswa')->find('2021010001');

        // mengambil list nilai dari column
        $siswa_nis = DB::table('siswa')->pluck('nis');
        foreach ($siswa_nis as $nis) {
            echo $nis  .  "<br>";
        }
        foreach ($siswa_nis as $nama => $nis) {
            echo $nis  .  "<br>";
        }

        // agregat
        $jml_siswa = DB::table('siswa')->count();
        // mendapakan nis nama jenis kelamin
        $siswa = DB::table('siswa')->select('nis', 'nama', 'jk as jenisKelamin')->get();
        // mengambil data yang berbeda dengan disticnt
        $siswa = DB::table('siswa')->disticnt()->get();

        // raw expresion
        $siswa = DB::table('siswa')->select(DB::raw('count(*) as jml_siswa', 'id_jurusan'))->where('id_jurusan', '>', 0)->groupBy('id_jurusan')->get();

        // join
        $siswa = DB::table('siswa')->leftJoin('jurusan', 'siswa.id_jurusan', '-', 'jurusan.id_jurusan')->get();

        // union
        $jurusan_siswa = DB::table('siswa')->where('id_jurusan', '>', 1);

        $siswa = DB::table('siswa')->whereNull('nilai')->union($jurusan_siswa)->get();

        return $siswa;

        // order
        $siswa = DB::table('siswa')->orderBy('id_jurusan', 'asc')->get();
        // groupBy
        $siswa = DB::table('siswa')->orderBy('id_jurusan', 'asc')->groupBy('nis')->get();
        $siswa = DB::table('siswa')->orderBy('id_jurusan', 'asc')->groupBy('nis')->offset(3)->limit(6)->get();
    }

    public function store()
    {
        // $siswa = new Siswa;
        // $siswa->nama = $request->nama;
        // $siswa->save();
        // $siswa = new Siswa([
        //     'name' => 'Jong Koding'
        // ]);

        // $siswa = Siswa::firstOrCreate(
        //     ['nis' => '2021010001'],
        //     ['nama' => 'Jong Koding', 'jk' => 'L']
        // );

        // insert data menggunakan query builder
        // single record
        $siswa = DB::table('siswa')->insert(['nis' => "13", 'nama' => 'Jong Koding']);
        // double record
        $siswa = DB::table('siswa')->insert([
            ['nis' => "13", 'nama' => 'Jong Koding'],
            ['nis' => "14", 'nama' => 'Jong Koding Baru']
        ]);
    }
    public function update(Request $request, $id)
    {
        // $siswa = Siswa::find($id);
        // $siswa->nama = 'Jong Koding Berubah';
        // $siswa->save();

        // $siswa = Siswa::where('nis', $id)->update([
        //     'nama' => 'Jong Koding Berubah',
        //     'jk' => 'L'
        // ]);
        // $siswa = Siswa::updateOrCreate('nis', $id)->update([
        //     ['nis' => $id, 'nama' => 'jong koding berubah'],
        //     [
        //         'jk' => 'L',
        //         'tmp_lahir' => 'jakarta',
        //     ]
        // ]);

        // update data dengan query builder
        $siswa = DB::table('siswa')->where('nis', '2021010001')->update(['nama' => 'Jong Koding Berubah']);


        $siswa = DB::table('siswa')->updateOrInsert(
            ['nama' => 'Jong Koding Berubah'],
            [
                'jk' => 'L',
                'tmp_lahir' => 'jakarta'
            ]
        );
    }

    public function destroy($id)
    {
        // $siswa = Siswa::find($id);
        // $siswa->delete();

        // $siswa = Siswa::destroy('2021010001');
        // $siswa = Siswa::destroy('2021010001', '2021010002', '2021010003');
        // $siswa = Siswa::destroy(['2021010001', '2021010002', '2021010003']);
        // $siswa = Siswa::destroy('2021010001', '2021010002', '2021010003');
        // $siswa = Siswa::destroy(collect(['2021010001', '2021010002', '2021010003']));

        // $siswa = Siswa::where('tmp_lahir', 'Surabaya')->delete();

        // menghapus data menggunakan query builder
        $siswa = DB::table('siswa')->where('nis', '2021010001')->delere();
    }
}

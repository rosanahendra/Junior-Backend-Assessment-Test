<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Session\Session;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class UserApiController extends Controller
{ 

    public function daftar(Request $request): JsonResponse
    {
        $name = $request->name;
        $nik = $request->nik;
        $hp = $request->hp;
        $alert = '';
        $rek = '';
        if($hp){
            $querynum = DB::select("select count(peng_id) as total from pengguna where peng_hp = '".$hp."' limit 1");
            foreach($querynum as $rownum){ 
                if($rownum->total > 0){
                    $alert = 'Nomor handphone sudah pernah terdaftar';
                }
            }
        } else {
            $alert = 'Nomor handphone harus diisi';
        }

        if(!$name){
            $alert = 'Nama harus diisi';
        }

        if(!$nik){
            $alert = 'NIK harus diisi';
        }

        if($alert == ''){
            $date = date('Y-m-d H:i:s');
            $rek = rand(100000,999999);
            DB::select("insert into pengguna(peng_name, peng_nik, peng_hp, peng_rekening, created_at, updated_at)values
            ('$name', '$nik', '$hp', '$rek', '$date', '$date')");
            $alert = 'Data pengguna baru berhasil disimpan';
            $status = 200;
        } else {
            $status = 400;
        }
        $data['info'] = array(
            'status' => $status,
            'remark' => $alert,
            'nomor_rekening' => $rek
        );  
        
        return response()->json($data);
    }

    public function tabung(Request $request): JsonResponse
    {
        $nomor_rekening = $request->nomor_rekening;
        $nominal = $request->nominal;
        $alert = '';
        $tabungan = 0;
        if($nomor_rekening){
            $querynum = DB::select("select count(peng_id) as total from pengguna where peng_rekening = '".$nomor_rekening."' limit 1");
            foreach($querynum as $rownum){ 
                if($rownum->total == 0){
                    $alert = 'Maaf nomor rekening tidak terdaftar';
                }
            }
        } else {
            $alert = 'Nomor Rekening harus diisi';
        }

        $sisa = '-';
        if($alert == ''){
            $date = date('Y-m-d H:i:s');
            $query = DB::select("select peng_id, peng_tabungan from pengguna where peng_rekening = '".$nomor_rekening."' limit 1");
            foreach($query as $row){
                $tabung = $row->peng_tabungan + $nominal;
                DB::select("update pengguna set peng_tabungan = '$tabung' where peng_rekening = '".$nomor_rekening."'");
                $tabungan = 'Rp. '.str_replace(',', '.', number_format($tabung));
                DB::select("insert into mutasi(peng_id, muta_kode_transaksi, muta_nominal, muta_waktu)values('$row->peng_id', 'C', '$nominal', '$date')");
            }
            $alert = 'Setor nominal sebesar Rp. '.str_replace(',', '.', number_format($nominal)).' pada tabungan anda sukses';
            $status = 200;
        } else {
            $status = 400;
        }

        $nominal = 'Rp. '.str_replace(',', '.', number_format($nominal));
        $data['info'] = array(
            'status' => $status,
            'remark' => $alert,
            'nominal_setor' => $nominal,
            'sisa_saldo_tabungan' => $tabungan
        );  
        
        return response()->json($data);
    }

    public function tarik(Request $request): JsonResponse
    {
        $nomor_rekening = $request->nomor_rekening;
        $nominal = $request->nominal;
        $alert = '';
        $tabungan = 0;
        if($nomor_rekening){
            $querynum = DB::select("select count(peng_id) as total from pengguna where peng_rekening = '".$nomor_rekening."' limit 1");
            foreach($querynum as $rownum){ 
                if($rownum->total == 0){
                    $alert = 'Maaf nomor rekening tidak terdaftar';
                } else {
                    $querynum2 = DB::select("select peng_tabungan from pengguna where peng_rekening = '".$nomor_rekening."' limit 1");
                    foreach($querynum2 as $rownum2){ 
                        if($rownum2->peng_tabungan < $nominal){
                            $alert = 'Maaf saldo tersisa Anda hanya Rp. '.str_replace(',', '.', number_format($rownum2->peng_tabungan));
                        }
                    }
                }
            }
        } else {
            $alert = 'Nomor Rekening harus diisi';
        }

        $sisa = '-';
        if($alert == ''){
            $date = date('Y-m-d H:i:s');
            $query = DB::select("select peng_id, peng_tabungan from pengguna where peng_rekening = '".$nomor_rekening."' limit 1");
            foreach($query as $row){
                $sisa = $row->peng_tabungan - $nominal;
                DB::select("update pengguna set peng_tabungan = '$sisa' where peng_rekening = '".$nomor_rekening."'");
                $tabungan = 'Rp. '.str_replace(',', '.', number_format($sisa));
                DB::select("insert into mutasi(peng_id, muta_kode_transaksi, muta_nominal, muta_waktu)values('$row->peng_id', 'D', '$nominal', '$date')");
            }
            $alert = 'Penarikan tunai sebesar Rp. '.str_replace(',', '.', number_format($nominal)).' dari tabungan anda sukses';
            $status = 200;
        } else {
            $status = 400;
        }

        $nominal = 'Rp. '.str_replace(',', '.', number_format($nominal));
        $data['info'] = array(
            'status' => $status,
            'remark' => $alert,
            'jumlah_penarikan' => $nominal,
            'sisa_saldo_tabungan' => $tabungan
        );  
        
        return response()->json($data);
    }

    public function saldo($nomor_rekening): JsonResponse
    {
        $alert = '';
        $tabungan = 0;
        if($nomor_rekening){
            $querynum = DB::select("select count(peng_id) as total from pengguna where peng_rekening = '".$nomor_rekening."' limit 1");
            foreach($querynum as $rownum){ 
                if($rownum->total == 0){
                    $alert = 'Maaf nomor rekening tidak terdaftar';
                }
            }
        } else {
            $alert = 'Nomor Rekening harus diisi';
        }

        if($alert == ''){
            $query = DB::select("select peng_tabungan from pengguna where peng_rekening = '".$nomor_rekening."' limit 1");
            foreach($query as $row){
                $tabungan = 'Rp. '.str_replace(',', '.', number_format($row->peng_tabungan));
            }
            $alert = 'Data sukses tersedia';
            $status = 200;
        } else {
            $status = 400;
        }
        $data['info'] = array(
            'status' => $status,
            'remark' => $alert,
            'saldo_tabungan' => $tabungan
        );  
        
        return response()->json($data);
    }

    public function mutasi($nomor_rekening): JsonResponse
    {
        $alert = '';
        $mutasi = '';
        $tabungan = '';
        if($nomor_rekening){
            $querynum = DB::select("select count(peng_id) as total from pengguna where peng_rekening = '".$nomor_rekening."' limit 1");
            foreach($querynum as $rownum){ 
                if($rownum->total == 0){
                    $alert = 'Maaf nomor rekening tidak terdaftar';
                }
            }
        } else {
            $alert = 'Nomor Rekening harus diisi';
        }

        if($alert == ''){
            $query = DB::select("select peng_tabungan from pengguna where peng_rekening = '".$nomor_rekening."' limit 1");
            foreach($query as $row){
                $tabungan = 'Rp. '.str_replace(',', '.', number_format($row->peng_tabungan));
            }
            $query = DB::select("select b.muta_kode_transaksi as muta_kode_transaksi, b.muta_nominal as muta_nominal, b.muta_waktu as muta_waktu from pengguna a join mutasi b on a.peng_id = b.peng_id where a.peng_rekening = '".$nomor_rekening."'");
            $datas = [];
            foreach($query as $row){
                $datas[] = $row;
            }
            $mutasi = $datas;
            $alert = 'Data sukses tersedia';
            $status = 200;
        } else {
            $status = 400;
        }
        $data['info'] = array(
            'status' => $status,
            'remark' => $alert,
            'saldo_tabungan' => $tabungan,
            'mutasi' => $mutasi,
        );  
        
        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisPelayanan;
use App\Pelayanan;
use App\Upload;

class PelayananController extends Controller
{
    public function createPelayanan(Request $req){
		$newPelayanan = new Pelayanan;
		$newPelayanan->nik = $req->nik;
		$newPelayanan->jenis_pelayanan = $req->jenisPelayanan;
		$newPelayanan->isi_pelayanan = $req->komentar;
		$newPelayanan->save();
		foreach ($req->lampiran as $img) {
			$image = base64_decode($img['data']);
			$image_name = md5(uniqid(rand(), true));
			$filename = $image_name . '.' . 'png';
			//rename file name with random number
			$public = public_path();
			$path = $public."/assets/uploads/pelayanan/".$filename;
			//image uploading folder path
			file_put_contents($path . $filename, $image);
			// image is bind and upload to respective folder
			$newUpload = new Upload;
			$newUpload->file = $filename;
			$newUpload->id_lampiran = $newPelayanan->id;
			$newUpload->jenis_upload = 'Pelayanan';
			$newUpload->save();
		}
		return response()->json([
                'status' => true
        ],200);
	}
    public function jenisPelayanan(){
    	$jenisPelayanan = JenisPelayanan::all();
    	if($jenisPelayanan){
            return response()->json([
                'status' => true,
                'data' => $jenisPelayanan
            ],200);
        }else{
            return response()->json([
                'status' => false,
            ],401);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisAduan;
use App\Aduan;
use App\Upload;
use Illuminate\Support\Facades\DB;
class AduanController extends Controller
{
	public function getAduan(){
		$Aduan = Aduan::all();
		$aduans = array();
		foreach($Aduan as $a){
			$aduans[] = array(
				'data' => $a,
				'file' => DB::table('uploads')->where([
					    ['id_lampiran', '=', $a->id],
					    ['jenis_upload', '=', 'Aduan'],
					])->get()
			);	
		}
		if($Aduan){
		    return response()->json([
		        'status' => true,
		        'data' => $aduans
		    ],200);
		}else{
		    return response()->json([
		        'status' => false,
		    ],401);
		}
	}
	public function createAduan(Request $req){
		$newAduan = new Aduan;
		$newAduan->nik = $req->nik;
		$newAduan->jenis_aduan = $req->jenisAduan;
		$newAduan->isi_aduan = $req->komentar;
		$newAduan->save();
		foreach ($req->lampiran as $img) {
			$image = base64_decode($img['data']);
			$image_name = md5(uniqid(rand(), true));
			$filename = $image_name . '.' . 'png';
			//rename file name with random number
			$public = public_path();
			$path = $public."/assets/uploads/aduan/".$filename;
			//image uploading folder path
			file_put_contents($path, $image);
			// image is bind and upload to respective folder
			$newUpload = new Upload;
			$newUpload->file = $filename;
			$newUpload->id_lampiran = $newAduan->id;
			$newUpload->jenis_upload = 'Aduan';
			$newUpload->save();
		}
		return response()->json([
                'status' => true
        ],200);
	}
    public function jenisAduan(){
    	$jenisAduan = JenisAduan::all();
    	if($jenisAduan){
            return response()->json([
                'status' => true,
                'data' => $jenisAduan
            ],200);
        }else{
            return response()->json([
                'status' => false,
            ],401);
        }
    }
}

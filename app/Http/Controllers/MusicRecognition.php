<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Storage;

class MusicRecognition extends Controller
{

	private $http_method = "POST";
	private $http_uri = "/v1/identify";
	private $data_type = "audio";
	private $signature_version = "1" ;
	private $path = "musics";
	private $ACR_HOST;
	private $ACR_ACCESS_KEY;
	private $ACR_ACCESS_SECRET;


    public function sendFile(Request $request){
    	$this->getEnv();
    	$file = Input::file('file');
       
    	$ext = $file->getClientOriginalExtension();
    	$fileName = rand(1111,9999) .'.'.$ext;

    	$file->storeAs($this->path, $fileName);

    	return $this->recognitioRequest($fileName);

		Storage::delete("$this->path/$fileName");

    }


    private function alternativa($filename){

    }
    private function recognitioRequest($fileName){
    	$filePath = $this->path."/".$fileName;

    	$timestamp = time();

    	$string_to_sign = $this->http_method . "\n" . 
                  $this->http_uri ."\n" . 
                  $this->ACR_ACCESS_KEY . "\n" . 
                  $this->data_type . "\n" . 
                  $this->signature_version . "\n" . 
                  $timestamp;

    	$signature = hash_hmac("sha1", $string_to_sign, $this->ACR_ACCESS_SECRET, true);

    	$signature = base64_encode($signature);

    	$filesize =  Storage::size($filePath);

    	$realPath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

    	$realPath .= $filePath;

    	$cfile = new \CURLFile($realPath,'mp3', $fileName);

    	$postfields = array(
               "sample" => $cfile, 
               "sample_bytes"=>$filesize, 
               "access_key"=>$this->ACR_ACCESS_KEY, 
               "data_type"=>$this->data_type, 
               "signature"=>$signature, 
               "signature_version"=>$this->signature_version, 
               "timestamp"=>$timestamp);

    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->ACR_HOST);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);
		if($result){
			return $result;
		}else{
			return curl_error($ch);
		}
    }

    private function getEnv(){
    	$this->ACR_HOST = env("ACR_HOST", "your host");
		$this->ACR_ACCESS_KEY = env("ACR_ACCESS_KEY", "your access key");
		$this->ACR_ACCESS_SECRET = env("ACR_ACCESS_SECRET", "your access secret");
    }


}

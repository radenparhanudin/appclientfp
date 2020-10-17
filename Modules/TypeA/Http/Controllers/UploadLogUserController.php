<?php

namespace Modules\TypeA\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use TADPHP\TADFactory;
use Yajra\Datatables\Facades\Datatables;

class UploadLogUserController extends Controller
{
   public $base_url = "";
   function __construct()
   {
      $this->base_url = config('app.api_url');
   }

   public function index()
   {
      return view('typea::upload-log-user.index');
   }

   public function store(Request $request)
   {
      if ($request->ajax()) {
         // return $request->all();
         $mesin_id = $request->get('mesin_id');
         $client   = new Client();
         $dataBody = array(
               'mesin_id' => $mesin_id, 
         );
         $response = $client->request('post',$this->base_url . 'mdl/mesin/upload-log-user/get_mesin', [
            'headers' => [
               'Content-Type'  => 'application/x-www-form-urlencoded',
               'Accept'        => 'application/json', 
               'Authorization' => 'Bearer ' . session()->get('token'), 
            ],
            'form_params' => $dataBody
         ]);

         $body = json_decode($response->getBody(), true);
         // return $body;
         // ip_address: "192.168.1.76"
         // serial_number: "OID70100570119022741b"

         try {
            $tad_factory       = new TADFactory(['ip'=> $body['content']['ip_address']]);
            $tad               = $tad_factory->get_instance();
            $get_all_user_info = $tad->get_all_user_info()->to_array()['Row'];
            $dataBody['data']  = [];
            // return $get_all_user_info;
            foreach ($get_all_user_info as $gaui) {
               $dataBody['data'][] = array(
                  'mesin_id'     => $mesin_id, 
                  'PIN'          => $gaui['PIN2'], 
                  'nama_pegawai' => $gaui['Name'], 
               );
            }
         } catch (\Exception $e) {
            return $e->getMessage();
            return response()->json([
               'errors' => true, 
               'message' => 'Tidak dapat memulai koneksi dengan perangkat ', 
            ], 422);
         }
         $client = new Client();
         try {
            $response = $client->request('post',$this->base_url . 'mdl/mesin/upload-log-user', [
               'headers' => [
                  'Content-Type'  => 'application/x-www-form-urlencoded',
                  'Accept'        => 'application/json', 
                  'Authorization' => 'Bearer ' . session()->get('token'), 
               ],
               'form_params' => $dataBody
            ]);
            $body = json_decode($response->getBody(), true);
            return $body;
            if ($body['success']) {
               return response()->json([
                  'success' => true,
                  'message' => $body['message'],
               ]);
            }
         } catch (RequestException $exception) {
            $errException = $exception->getResponse()->getBody(true);
            $data = json_decode($errException, true);
            return $data;
         }
      }
      else{
         return abort(404);
      }
   }

   public function data(Request $request)
   {
      if ($request->ajax()) {
         $client = new Client();
         try {
            $response = $client->request('post',$this->base_url . 'mdl/mesin/upload-log-user/data', [
               'headers' => [
                  'Content-Type'  => 'application/x-www-form-urlencoded',
                  'Accept'        => 'application/json', 
                  'Authorization' => 'Bearer ' . session()->get('token'), 
               ]
            ]);
            $body = json_decode($response->getBody(), true);
            $collection = collect($body);

            return Datatables::of($collection)
            ->addIndexColumn()
            ->rawColumns([])
            ->make(true);
         } catch (RequestException $exception) {
            $errException = $exception->getResponse()->getBody(true);
            $data = json_decode($errException, true);
            return response()->json([
               'errors' => true, 
               'message' => $data, 
            ], 402);
         }
      }
      else{
         return abort(404);
      }
   }

   
   private function attributes()
   {
      return [
         'mesin_id' => 'Mesin',
      ];
   }

   private function rules()
   {
      return [
         'mesin_id' => 'required',
      ];
   }
   /*Additional*/
   public function get_mesin(Request $request)
   {
      if ($request->ajax()) {
         $client = new Client();
         try {
            $response = $client->request('post',$this->base_url . 'mdl/mesin/upload-log-user/get_mesin', [
               'headers' => [
                  'Content-Type'  => 'application/x-www-form-urlencoded',
                  'Accept'        => 'application/json', 
                  'Authorization' => 'Bearer ' . session()->get('token'), 
               ]
            ]);
            $body = json_decode($response->getBody(), true);
            if ($body['success']) {
               return response()->json([
                  'success' => true,
                  'content' => $body['content']
               ]);
            }
         } catch (RequestException $exception) {
            $errException = $exception->getResponse()->getBody(true);
            $data = json_decode($errException, true);
            return response()->json([
               'errors' => true, 
               'message' => $data, 
            ], 402);
         }
      }
      else{
         return abort(404);
      }
   }
}

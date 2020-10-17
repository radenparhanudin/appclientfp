<?php

namespace Modules\TypeA\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use TADPHP\TADFactory;
use Yajra\Datatables\Facades\Datatables;


class RegisterMesinController extends Controller
{

   public $base_url = "";
   function __construct()
   {
      $this->base_url = config('app.api_url');
   }

   public function index()
   {
      return view('typea::register-mesin.index');
   }

   public function store(Request $request)
   {
      if ($request->ajax()) {
         $this->validate($request, $this->rules(), $this->attributes());
         try {
            $tad_factory = new TADFactory(['ip'=> $request->get('ip_address')]);
            $tad         = $tad_factory->get_instance();
            $dataBody    = array(
               'ip_address'       => $request->get('ip_address'), 
               'nama_mesin'       => $request->get('nama_mesin'), 
               'no_mesin'         => $request->get('no_mesin'), 
               'platform'         => $tad->get_platform()->to_array()['Row']['Information'], 
               'serial_number'    => $tad->get_serial_number()->to_array()['Row']['Information'], 
               'oem_vendor'       => $tad->get_oem_vendor()->to_array()['Row']['Information'], 
               'mac_address'      => $tad->get_mac_address()->to_array()['Row']['Information'], 
               'device_name'      => $tad->get_device_name()->to_array()['Row']['Information'], 
               'manufacture_time' => $tad->get_manufacture_time()->to_array()['Row']['Information'], 
               'firmware_version' => $tad->get_firmware_version()->to_array()['Row']['Information']
            );
         } catch (\Exception $e) {
            return response()->json([
               'errors' => true, 
               'message' => 'Tidak dapat memulai koneksi dengan perangkat ' .$request->get('ip_address'), 
            ], 422);
         }
         $client = new Client();
         try {
            $response = $client->request('post',$this->base_url . 'mdl/mesin/register', [
               'headers' => [
                  'Content-Type'  => 'application/x-www-form-urlencoded',
                  'Accept'        => 'application/json', 
                  'Authorization' => 'Bearer ' . session()->get('token'), 
               ],
               'form_params' => $dataBody
            ]);
            $body = json_decode($response->getBody(), true);
            if ($body['success'] || $body['errors']) {
               return $body;
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

   public function edit(Request $request, $id)
   {
      if ($request->ajax()) {
         $client = new Client();
         try {
            $response = $client->request('get',$this->base_url . 'mdl/mesin/register/' . $id . '/edit', [
               'headers' => [
                  'Authorization' => 'Bearer ' . session()->get('token'), 
               ]
            ]);
            $body = json_decode($response->getBody(), true);
            if ($body['success']) {
               return response()->json([
                  'success' => true,
                  'content' => [
                     'id'              => $body['content']['id'], 
                     'edit_ip_address' => $body['content']['ip_address'], 
                  ]
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

   public function update(Request $request, $id)
   {
      if ($request->ajax()) {
         $this->validate($request, $this->rules_update(), $this->attributes_update());
         // return $request->all();
         $dataBody    = array(
            'ip_address'       => $request->get('edit_ip_address'), 
         );
         $client = new Client();
         try {
            $response = $client->request('put',$this->base_url . 'mdl/mesin/register/' . $id, [
               'headers' => [
                  'Content-Type'  => 'application/x-www-form-urlencoded',
                  'Accept'        => 'application/json', 
                  'Authorization' => 'Bearer ' . session()->get('token'), 
               ],
               'form_params' => $dataBody
            ]);
            $body = json_decode($response->getBody(), true);
            if ($body['success'] || $body['errors']) {
               return $body;
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

   public function destroy(Request $request, $id)
   {
   }

   public function data(Request $request)
   {
      if ($request->ajax() == true) {
         $client = new Client();
         try {
            $response = $client->request('post',$this->base_url . 'mdl/mesin/register/data', [
               'headers' => [
                  'Content-Type'  => 'application/x-www-form-urlencoded',
                  'Accept'        => 'application/json', 
                  'Authorization' => 'Bearer ' . session()->get('token'), 
               ]
            ]);
            $body = json_decode($response->getBody(), true);
            
            $collection = collect($body);

            return Datatables::of($collection)
            ->addColumn('action', function ($collection) {
               return '<a href="'.route('typea.register-mesin.edit', ['id' => $collection['id']]).'" class="btn btn-info btn-sm btn-edit"><i class="fa fa-pencil mr-1"></i> Edit</a>';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
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
         'ip_address' => 'IP Address',
         'no_mesin'   => 'Nomor Mesen',
         'nama_mesin' => 'Nama Mesin',
      ];
   }

   private function rules()
   {
      return [
         'ip_address' => 'required|ip',
         'no_mesin'   => 'required|numeric',
         'nama_mesin' => 'required',
      ];
   }

   private function attributes_update()
   {
      return [
         'edit_ip_address' => 'IP Address',
      ];
   }

   private function rules_update()
   {
      return [
         'edit_ip_address' => 'required|ipv4',
      ];
   }
}

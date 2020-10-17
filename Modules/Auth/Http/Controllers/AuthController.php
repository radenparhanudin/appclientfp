<?php
namespace Modules\Auth\Http\Controllers;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
   public $base_url = "";

   function __construct()
   {
      $this->base_url = config('app.api_url');
   }
   public function index()
   {
      return view('auth::index');
   }
   public function login(Request $request)
   {
      if ($request->ajax()) {
         $client = new Client();
         try {
            $response = $client->request('post',$this->base_url . 'login', [
               'headers' => [
                  'Content-Type' => 'application/x-www-form-urlencoded',
               ],
               'form_params' => [
                  'username' => $request->get('username'),
                  'password' => $request->get('password')
               ]
            ]);
            $body = json_decode($response->getBody(), true);
            $request->session()->put('token', $body['success']['token']);
            return response()->json([
               'success' => true,
               'message' => 'Anda akan diarahkan kehalaman dashboard dalam waktu 3 detik.',
            ]);
         } catch (RequestException $exception) {
            $errException = $exception->getResponse()->getBody(true);
            $data = json_decode($errException, true);
            if ($data['error'] == "Unauthorised") {
               return response()->json([
                  'errors' => true,
                  'message' => 'Login Gagal!. Silahkan di coba lagi dengan username dan password yang valid',
               ], 401);
            }
         }
      }
      else{
         return abort(404);
      }
   }
   public function logout(Request $request)
   {
      $request->session()->forget('token');
      return redirect()->route('auth.index');
   }
}
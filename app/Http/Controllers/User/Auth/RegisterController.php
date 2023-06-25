<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Broker;
use App\Models\User;
use App\Models\Server;
use App\Models\Period;
use App\Models\Product;
use App\Models\TradingAccount;
use App\Models\EaPaymentHistory;
use App\Models\PaymentServer;
use App\Models\Deposit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RegisterController extends Controller
{
    public function index($refferal_id = ''){
      
      $tradingAccount = TradingAccount::where('id',$refferal_id)->first();
      $banks = Bank::select('id','name')->get();
      $brokers = Broker::select('id','name')->get();
      $servers = Server::select('id','name')->get();

      $periods = Period::get();
        $products = Product::select('id','name')->get();
        foreach ($periods as $period) {
            $period->name = $period->start_date.' - '.$period->end_date;
        }        

      return view('user.auth.register',compact('banks','brokers','tradingAccount','servers','periods','products'));
    }


    public function register(Request $request) {

        $body = $request->all();

        $validator = [
          'purchase_receipt_image' => 'required|max:300000',
          'deposit_amount' => 'required|numeric|min:1000',
        ];
        $validator = Validator::make($body, $validator);
        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->all() ?? 'Something went wrong');

            return redirect()->back();
        }

        $userCheckEmail = User::where('email',$request->email)->first();

        if ($request->password != $request->confirm_password) {

          session()->flash('warning','Password tidak sesuai');

          return redirect()->back();
        }

        if ($userCheckEmail) {
          
          session()->flash('warning','Akun yang anda masukan sudah terdaftar , sedang dalam proses approval admin');
          return redirect()->back();
        }
           
        $data = [
          'bank_id' => $request->bank_account,
          'name' => $request->name,
          'email' => $request->email,
          'username' => $request->username,
          'password' => $request->password,
          'mobile_number' => $request->phone_number,
          'age' => $request->age,
          'gender' => $request->gender,
          'id_number' => $request->no_ktp,
          'nationality' => $request->nationality,
          'bank_account_number' => $request->bank_account_number,
          'bank_branch' => $request->bank_branch,
          'status' => 'pending',
        ];

        $check = $this->create($data);

        $user = User::where('email',$request->email)->first();

        
        if($user) {
          User::findOrFail($user->id)->roles()->sync(2);
          $firstTradingAccount = TradingAccount::where('id',1)->first();

          //get model and depth
          $dataTrading = [
            'user_id' => $user->id,
            'broker_id' => $request->broker_id,
            'nickname' => $request->account_nickname,
            'parent_id' => $request->referral_id ?? $firstTradingAccount->id,
            'deposit_amount' => $request->deposit_amount,
            'server_id' => $request->server_id,
            'trading_id_login' => $request->trading_id,
            'trading_password' => $request->trading_password,
            'trade_mode' => $request->trade_mode,
            'status' => 'pending',
          ];

          $currentTime = date("Y-m-d", strtotime(now()));
          $dataPaymentServer= [
            'product_id' => $request->product_id,
            'activated_at' => $currentTime,
            'expired_at' => date("Y-m-d", strtotime(date("Y-m-d", strtotime($currentTime)) . " + 1 year")),
            'amount' => $request->amount,
            'status' => 'pending',
        ];

          $tradingAccount = TradingAccount::create($dataTrading);

          //update model and depth
          $result = $this->getParentLevel($tradingAccount->id);
          $getContent = json_decode($result->getContent());
          $referralContents = $getContent->referralStructure;
          
          $referralIds = [];
          $model = null;
          $depth = null;

          foreach ($referralContents as $referralContent) {
            $referralIds[] = $referralContent->id;
          }

          array_push($referralIds,$tradingAccount->id);

          if ($referralIds) {
            $model = implode(',', $referralIds);
            $depth = count($referralIds)-1;
          }

          $tradingAccount->model = $model ?? $updateTradingAccount->id;
          $tradingAccount->depth = $depth ?? 0;
          $tradingAccount->save();

          //create payment server
          $paymentServer = PaymentServer::create($dataPaymentServer);
          
          $paymentServer->trading_account()->associate($tradingAccount);
          $paymentServer->save();

          //save Image
          $key = 'purchase_receipt_image';
          $collection = null;
          if (! $collection) {
              $collection = $key;
          }
          
          if ($request->hasFile($key)) {
              $paymentServer->addMediaFromRequest($key)->toMediaCollection($collection);
          }

          $deposit = Deposit::create([
            'amount' => $request->deposit_amount,
            'status' => 'pending',
          ]);

        $deposit->trading_account()->associate($tradingAccount);
        $deposit->save();
        }

        return redirect("register")->withSuccess('Register account berhasil, account sedang dalam proses approval admin');
    }

    public function getParentLevel($userId)
    {
      $user = TradingAccount::find($userId);

      if (!$user) {
          return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
      }

      $referralStructure = [];
      $referrer = $user->parent;

      while ($referrer) {
          $referralStructure[]= [
              'id' => $referrer->id,
          ];
          $referrer = $referrer->parent;
      }

      return response()->json(['referralStructure' => array_reverse($referralStructure)]);
    }

    public function getData(Request $request) {
      $tradingAccount = TradingAccount::where('id',$request->id)->first();
      return $tradingAccount;
  }

    public function create(array $data)
    {
      return User::create([
        'bank_id' => $data['bank_id'],
        'name' => $data['name'],
        'email' => $data['email'],
        'username' => $data['username'],
        'password' => Hash::make($data['password'],),
        'mobile_number' => $data['mobile_number'],
        'age' => $data['age'],
        'gender' => $data['gender'],
        'id_number' => $data['id_number'],
        'nationality' => $data['nationality'],
        'bank_account_number' => $data['bank_account_number'],
        'bank_branch' => $data['bank_branch'],
        'status' => $data['status'],
      ]);
    }    
}

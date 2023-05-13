<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;
use Illuminate\Support\Facades\Auth;
use \Razorpay\Api\Api;

class PaymentController extends Controller
{
    /**
     * Write code on Method
     * 
     * @return response()

     */
    
    private $razorpayId;
    private $razorpayKey;
    
    public function __construct() {
        $this->razorpayId = env('RAZORPAY_LIVE_KEY_ID');
        $this->razorpayKey = env('RAZORPAY_LIVE_KEY_SECRET');
    }

     public function index()
     {        
        $amount = 1;
        $currency = 'INR';
        // Create an instance of Razorpay
        $api = new Api($this->razorpayId, $this->razorpayKey);

        // Create order
        $order = $api->order->create(array(
            'receipt' => 'OrderID' . rand(),
            'amount' => $amount * 100, // amount in paise
            'currency' => $currency
        ));

        $orderId = $order['id'];

        // Return to the payment process page with the necessary parameters
        return view('webpages.razorpay', compact('orderId', 'amount', 'currency'));
        }
 
 
     /**
      * Write code on Method
      *
      * @return response()
      */
 
     public function store(Request $request)
     {
         $input = $request->all();
         $api = new Api($this->razorpayId, $this->razorpayKey);
         $payment = $api->payment->fetch($input['razorpay_payment_id']);
        //  dd($api,$payment);
        
         if(count($input)  && !empty($input['razorpay_payment_id'])) {
             try {
                 $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
                //  dd($payment, $response,  $response['notes']);                 
                 if ($response) {
                    foreach ($response as $key=>$value) {
                        is_null($response[$key]) ? $response[$key]='' : $response[$key]=$value;
                    }
                    //  dd($response);
                    $payment_data = [
                        'r_payment_id' => $response['order_id'],
                        'amount' => $response['amount'],
                        'currency' => $response['currency'],
                        'status' => $response['status'],
                        'order_id' => $response['order_id'],
                        'invoice_id' => $response['invoice_id'],
                        'international' => $response['international'],
                        'method' => $response['method'],
                        'amount_refunded' => $response['amount_refunded'],
                        'refund_status' => $response['refund_status'],
                        'captured' => $response['captured'],
                        'description' => $response['description'],
                        'card_id' => $response['card_id'],
                        'bank' => $response['bank'],
                        'wallet' => $response['wallet'],
                        'vpa' => $response['vpa'],
                        'user_email' => $response['email'],
                        'contact' => $response['contact'],
                        'notes' => '',
                        'fee' => $response['fee'],
                        'tax' => $response['tax'],
                        'error_code' => $response['error_code'],
                        'error_description' => $response['error_description'],
                        'error_source' => $response['error_source'],
                        'error_step' => $response['error_step'],
                        'error_reason' => $response['error_reason'],
                        'acquirer_data' => '',
                        'user_id' => Auth::user()->id,
                    ];
                    $payment = Payment::create($payment_data);
                    if ($payment) {
                        Auth::user()->school->is_demo = 0;
                        // dd($payment, $payment->user, $payment->user->name);
                        Auth::user()->school->save();
                        return redirect('dashboard')->withSuccess('Payment Successful. You now have access to the entire LMS for 1 year!');
                    }
                    else {
                        return redirect('dashboard')->with('error', 'Error desc:'. $response['error_description']);
                    }
                }
                //  dd($payment, $response);
             } catch (Exception $e) {
                 return  $e->getMessage();
                 Session::put('error',$e->getMessage());
                 return redirect()->back();
             }
         }
 
         Session::put('success', 'Payment successful');
         return redirect()->back();
     }
}

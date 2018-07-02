<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Product;
use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;
use URL;
use Session;
use Redirect;
//use Input;
/** All Paypal Details class * */
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class AddMoneyController extends HomeController {

    private $_api_context;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        /** setup PayPal api context * */
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    /**
     * Show the application paywith paypalpage.
     *
     * @return IlluminateHttpResponse
     */
    public function payWithPaypal() {
        return view('paypal.paywithpaypal');
    }

    /**
     * Store a details of payment with paypal.
     *
     * @param IlluminateHttpRequest $request
     * @return IlluminateHttpResponse
     */
    public function postPaymentWithpaypal(Request $request) {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);
        $total = $cart->totalPrice;
        $products->setName('name') /** item name * */
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice($request->get('totalPrice'));/** unit price * */
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
                ->setTotal($request->get('amount'));
        $transaction = new Transaction();
        $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Your transaction description');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment.status')) /** Specify return URL * */
                ->setCancelUrl(URL::route('payment.status'));
        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; * */
        try {
            $payment->create($this->_api_context);
        } catch (PayPalExceptionPPConnectionException $ex) {
            if (Config::get('app.debug')) {
                Session::put('error', 'Connection timeout');
                return Redirect::route('paypal.paywithpaypal');
                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; * */
                /** $err_data = json_decode($ex->getData(), true); * */
                /** exit; * */
            } else {
                Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::route('paypal.paywithpaypal');
                /** die('Some error occur, sorry for inconvenient'); * */
            }
        }
        
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session * */
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {            
            /** redirect to paypal * */
            return Redirect::away($redirect_url);
        }
        Session::put('error', 'Unknown error occurred');
        return Redirect::route('paypal.paywithpaypal');
    }

    public function getPaymentStatus(Request $request) {
        /** Get the payment ID before session clear * */
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID * */
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            Session::put('error', 'Payment failed');
            return Redirect::route('shopping_cart.shop');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary * */
        /** to execute a PayPal account payment. * */
        /** The payer_id is added to the request query parameters * */
        /** when the user is redirected from paypal back to your site * */
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /*         * Execute the payment * */
        $result = $payment->execute($execution, $this->_api_context);
        //var_dump($result->id);
        //var_dump($result->transactions[0]->amount->total);
        //var_dump($result->payer->payer_info->shipping_address->city);exit;
        
          /*$ins_paypal = new Paypal;

          $ins_paypal->transaction_id = $result->id;
          $ins_paypal->email = $result->payer->payer_info->email;
          $ins_paypal->country = $result->payer->payer_info->shipping_address->country_code;
          $ins_paypal->state = $result->payer->payer_info->shipping_address->state;
          $ins_paypal->city = $result->payer->payer_info->shipping_address->city;
          $transactions = array();
          foreach($result->transactions as $transaction){
          $transactions[] = $transaction;
          }

          $ins_paypal->total = $transaction->amount->total;
          $ins_paypal->save();

          /** dd($result);exit; /** DEBUG RESULT, remove it later * */
        if ($result->getState() == 'approved') {
            /** it's all right * */
            /** Here Write your database logic like that insert record or value in database if you want * */
            Session::put('success', 'Payment success');
            return Redirect::route('paypal.paywithpaypal');
        }
        Session::put('error', 'Payment failed');

        return Redirect::route('paypal.paywithpaypal');
    }

    /*public function paymentInfo(Request $request) {
        if ($request->tx) {
            if ($payment = Payment::where('transaction_id', $request->tx)->first()) {
                $payment_id = $payment->id;
            } else {
                $payment = new Payment;
                $payment->item_number = $request->item_number;
                $payment->transaction_id = $request->tx;
                $payment->currency_code = $request->cc;
                $payment->payment_status = $request->st;
                $payment->save();
                $payment_id = $payment->id;
            }
            return 'Payment has been done and your payment id is : ' . $payment_id;
        } else {
            return 'Payment has failed';
        }
    }

    public function payment(Request $request) {
        $product = Product::find($request->id);
        return view('payment', compact('product'));
    }*/

}

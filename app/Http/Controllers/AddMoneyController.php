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
    public function payWithpaypal(Request $request) {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        var_dump($payer);
        $item_1 = new Item();
        $item_1->setName('Item 1') /** item name * */
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice($request->get('price'));/** unit price * */
        var_dump($item_1);
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        var_dump($item_list);
        $amount = new Amount();
        $amount->setCurrency('USD')
                ->setTotal($request->get('totalPrice'));
        var_dump($amount);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Your transaction description');
        var_dump($transaction);
        exit;
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('status.paypal')) /** Specify return URL * */
                ->setCancelUrl(URL::route('status.paypal'));

        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; * */
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return Redirect::route('paywithpaypal');
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::route('paywithpaypal');
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
        \Session::put('error', 'Unknown error occurred');
        return Redirect::route('paywithpaypal');
    }

    public function getPaymentStatus() {
        /** Get the payment ID before session clear * */
        
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID * */
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error', 'Payment failed');
            return Redirect::route('paywith');
        }
        
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        
        /*         * Execute the payment * */
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            \Session::put('success', 'Payment success');
            return Redirect::route('paywith');
        }
        
        \Session::put('error', 'Payment failed');        
        return Redirect::route('paywith');
    }

}

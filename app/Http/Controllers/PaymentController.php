<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * checkout details
     *
     * @return \Illuminate\View\View
     */
    public function checkoutPayment(string $productId)
    {
        $product = Product::find($productId);
        $user = Auth::user();
        return view("products.payment", [
            "user" => $user,
            "intent" => $user->createSetupIntent(),
            "product" => $product,
        ]);
    }
    /**
     * process the payment
     *
     * @return \Illuminate\View\View
     */
    public function processPayment(Request $request, string $product, $price)
    {
        $user = Auth::user();
        $paymentMethod = $request->input("payment_method");
        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);
        try {
            $user->charge($price * 100, $paymentMethod);
        } catch (\Exception $e) {
            return back()->withErrors([
                "message" => "Error creating subscription. " . $e->getMessage(),
            ]);
        }
        return redirect()->route('products.success');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourApplication;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Webhook;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // Step 1: Start payment
    public function start($id)
    {
        $application = TourApplication::findOrFail($id);

        // 20% payment
        $amount = ceil($application->final_amount * 0.20); // in BDT

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'bdt',
                    'product_data' => [
                        'name' => "Tour Payment #{$application->id}",
                    ],
                    'unit_amount' => $amount * 100, // Stripe amount in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('web.profile'),
            // 'cancel_url' => route('web.profile'),
            'metadata' => [
                'application_id' => $application->id
            ]
        ]);

        // Save Stripe session ID
        // $application->stripe_session_id = $session->id;
        // $application->save();
        $application->dues = $application->final_amount - $amount;
        $application->payment_status = "Partial Paid";
        $application->save();

        return redirect($session->url);
    }

    // Step 2: Callback after payment
    public function callback(Request $request)
    {
        $session_id = $request->query('session_id');

        if (!$session_id) {
            return redirect()->route('web.profile')->with('error', 'Payment session not found.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = \Stripe\Checkout\Session::retrieve($session_id);

        if ($session->payment_status !== 'paid') {
            return redirect()->route('web.profile')->with('error', 'Payment not completed.');
        }

        // Update application
        $application_id = $session->metadata->application_id;
        $application = TourApplication::find($application_id);
        if ($application) {
            $application->payment_status = 'Partial Paid';
            $application->dues = $application->final_amount - ($session->amount_total / 100); // Stripe amount in BDT
            $application->save();
        }

        return redirect()->route('web.profile')->with('success', 'Payment completed successfully!');
    }
}

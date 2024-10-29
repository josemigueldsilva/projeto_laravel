<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Importa a classe Log
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        $amount = 1000; // Valor em centavos (ex: 1000 = $10.00)
        return view('payment.form', compact('amount'));
    }

    public function processPayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                'amount' => 1000, // Valor em centavos
                'currency' => 'usd',
                'description' => 'Pagamento para criar torneio',
                'source' => $request->stripeToken,
            ]);

            // Marcar o usuário como tendo pago
            $request->user()->update(['paid' => true]);

            return redirect()->route('torneios.index')->with('success', 'Pagamento realizado com sucesso!');

        } catch (\Exception $e) {
            // Registra o erro no log para depuração
            Log::error('Erro ao processar pagamento: ' . $e->getMessage());
            return redirect()->route('principal')->with('error', 'Erro ao processar o pagamento. Tente novamente.');
        }
    }
}

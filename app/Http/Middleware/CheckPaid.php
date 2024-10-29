<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPaid
{
    public function handle($request, Closure $next)
    {
        if (!$request->user() || !$request->user()->paid) {
            return redirect()->route('payment.form')->with('error', 'Você precisa fazer o pagamento antes de criar um torneio.');
        }
    
        return $next($request);
    }
}
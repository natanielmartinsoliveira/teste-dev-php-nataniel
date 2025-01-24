<?php

namespace App\Http\Adapters;

use Illuminate\Support\Facades\Http;

class CnpjValidatorAdapter
{
    public function validate($cnpj)
    {
        $response = Http::get("https://brasilapi.com.br/api/cnpj/v1/{$cnpj}");

        if ($response->failed() || !$response->json()) {
            return false;
        }

        return $response->json();
    }

    private function isValidCnpj($cnpj)
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $weights = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($t = 12; $t < 14; $t++) {
            $sum = 0;
            for ($i = 0; $i < $t; $i++) {
                $sum += $cnpj[$i] * $weights[$i + (14 - $t)];
            }
            $remainder = ($sum % 11);
            if ($cnpj[$t] != ($remainder < 2 ? 0 : 11 - $remainder)) {
                return false;
            }
        }
        return true;
    }

    private function isValidCpf($cpf)
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $sum = 0;
            for ($i = 0; $i < $t; $i++) {
                $sum += $cpf[$i] * (($t + 1) - $i);
            }
            $remainder = ($sum % 11);
            if ($cpf[$t] != ($remainder < 2 ? 0 : 11 - $remainder)) {
                return false;
            }
        }
        return true;
    }
}

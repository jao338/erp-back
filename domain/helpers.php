<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

function requestFromFrontend(): bool
{
    $domain = request()->headers->get('referer') ?: request()->headers->get('origin');

    if (is_null($domain)) {
        return false;
    }

    $domain = Str::replaceFirst('https://', '', $domain);
    $domain = Str::replaceFirst('http://', '', $domain);
    $domain = Str::endsWith($domain, '/') ? $domain : "{$domain}/";

    $stateful = array_filter(config('sanctum.stateful', []));

    return Str::is(Collection::make($stateful)->map(fn($uri): string => trim((string) $uri) . '/*')->all(), $domain);
}

function isCPF($cpf = null)
{
    if (empty($cpf)) {
        return false;
    }

    $cpf = preg_replace('/[^\d]/', '', $cpf);
    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

    if (strlen($cpf) != 11) {
        return false;
    }

    if (
        $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' ||
        $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' ||
        $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' ||
        $cpf == '99999999999'
    ) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }

    return true;
}

function isCNPJ($cnpj)
{
    $cnpj = preg_replace('/[^\d]/', '', $cnpj);

    if (strlen($cnpj) !== 14) {
        return false;
    }

    if (preg_match('/(\d)\1{13}/', $cnpj)) {
        return false;
    }

    $cnpj_original = $cnpj;
    $primeiros_numeros_cnpj = substr($cnpj, 0, 12);

    $primeiro_calculo = multiplica_cnpj($primeiros_numeros_cnpj);
    $primeiro_digito = ($primeiro_calculo % 11) < 2 ? 0 : 11 - ($primeiro_calculo % 11);
    $primeiros_numeros_cnpj .= $primeiro_digito;

    $segundo_calculo = multiplica_cnpj($primeiros_numeros_cnpj, 6);
    $segundo_digito  = ($segundo_calculo % 11) < 2 ? 0 : 11 - ($segundo_calculo % 11);

    $cnpj = $primeiros_numeros_cnpj . $segundo_digito;

    return $cnpj === $cnpj_original;
}

function digits($value)
{
    return preg_replace('/[^\d]/', '', $value);
}

function getFixtureJson(string $path, string $file, bool $decode = true): string | array
{
    $path = base_path() . "/tests/Fixtures/{$path}";

    $arquivo = file_get_contents("{$path}/{$file}.json");

    return $decode ? json_decode($arquivo, true) : $arquivo;
}

function mod($var, $var2)
{
    $result  = round((float)($var / $var2), 10);
    $iResult = (int)($result);

    return $result - $iResult;
}

function maskCpfCnpj(string $value): string
{
    //Remove all characters that are not digits
    $value = preg_replace('/\D/', '', $value);

    //CPF
    if (strlen((string) $value) === 11) {
        return substr((string) $value, 0, 3) . '.***.***-' . substr((string) $value, -2);
    }

    //CNPJ
    if (strlen((string) $value) === 14) {
        return substr((string) $value, 0, 2) . '.***.***/' . substr((string) $value, -6);
    }

    return '';
}

function toCpfCnpj(string $value): string
{
    $value = preg_replace('/\D/', '', $value);

    //CPF
    if (strlen((string) $value) === 11) {
        return substr((string) $value, 0, 3) . '.' . substr((string) $value, 3, 3) . '.' . substr((string) $value, 6, 3) . '-' . substr((string) $value, -2);
    }

    //CNPJ
    if (strlen((string) $value) === 14) {
        return substr((string) $value, 0, 2) . '.' . substr((string) $value, 2, 3) . '.' . substr((string) $value, 5, 3) . '/' . substr((string) $value, 8, 4) . '-' . substr((string) $value, -2);
    }

    return '';
}

function getRateDaily(float $monthRate): float
{
    $decimalRate = $monthRate / 100.0;
    $dailyRate   = pow(1 + $decimalRate, 1 / 30) - 1;

    return $dailyRate * 100.0;
}

function data($value)
{
    return date("d/m/Y", strtotime($value));
}

function setDate($value)
{
    if (trim($value) == '') {
        return null;
    }

    return \DateTime::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
}


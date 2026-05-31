<?php

namespace Vendor\ShopPackage\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiVersion
{
    /**
     * Проверяет наличие и корректность заголовка X-API-VERSION.
     * Версию можно задать для конкретного маршрута через параметр $version,
     * либо она берётся из конфигурации shop.api_version.
     */
    public function handle(Request $request, Closure $next, ?string $version = null): Response
    {
        $headerVersion = $request->header('X-API-VERSION');

        if (is_null($headerVersion)) {
            return response()->json([
                'error' => 'Заголовок X-API-VERSION обязателен.',
            ], 400);
        }

        if (!ctype_digit((string) $headerVersion)) {
            return response()->json([
                'error' => 'X-API-VERSION должен содержать только числовое значение.',
            ], 400);
        }

        $required = $version ?? config('shop.api_version', 1);

        if ((int) $headerVersion !== (int) $required) {
            return response()->json([
                'error'    => "Неподдерживаемая версия API. Ожидается: {$required}, получено: {$headerVersion}.",
                'required' => (int) $required,
            ], 400);
        }

        return $next($request);
    }
}

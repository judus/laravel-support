<?php

namespace Maduser\Laravel\Support\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ReflectionException;
use Throwable;

trait ResponsableTrait
{
    use JsonableTrait;
    use HtmlableTrait;

    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     *
     * @param string  $filename
     *
     * @return Response|JsonResponse
     * @throws Throwable
     */
    public function toResponse($request, string $filename = null)
    {
        if ($request->wantsJson() || empty($this->view)) {
            return response()->json($this->toArray());
        }

        return response()->make($this->toHtml());
    }
}

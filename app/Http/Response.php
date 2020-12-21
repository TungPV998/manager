<?php

namespace App\Http;

use App\Exceptions\BaseException;
use Exception;
use Illuminate\Http\JsonResponse;

trait Response
{
    protected $http_status_code = 200;
    protected $success = true;
    protected $code = 200;
    protected $message;
    protected $data = [];
    protected $headers = [];
    /**
     * @var Exception
     */
    protected $exception;

    public function setHeaders(array $headers)
    {
        foreach ($headers as $key => $value) {
            $this->headers[$key] = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @param array ...$other_data
     * @return $this
     */
    public function addData(array $data, array ...$other_data)
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
        foreach ($other_data as $other_datum) {
            foreach ($other_datum as $key => $value) {
                $this->data[$key] = $value;
            }
        }
        return $this;
    }

    /**
     *
     * @param int $code https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
     * @return $this
     */
    public function setHttpStatusCode(int $code)
    {
        $this->http_status_code = $code;

        return $this;
    }


    /**
     * @param int $code
     * @return $this
     */
    public function setMessageCode(int $code)
    {
        $this->code = $code;

        return $this;
    }


    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    public function setException(Exception $e)
    {
        $this->exception = $e;

        return $this;
    }

    /**
     * @param bool $success
     * @return JsonResponse
     */
    private function getResponse(bool $success): JsonResponse
    {
        $data = [
            'success' => $success,
            'code' => $this->code,
            'message' => (string)$this->message,
        ];
        if (is_array($this->data) && count($this->data) > 0)
            $data['data'] = $this->data;


        if (env('APP_DEBUG') === true && $this->exception) {
            $data['debug'] = [
                'message' => (string)$this->exception->getMessage(),
                'code' => $this->exception->getCode(),
                'file' => $this->exception->getFile(),
                'line' => $this->exception->getLine(),
            ];
            if ($this->exception instanceof BaseException) {
                $data['debug']['message'] = $this->exception->getPrivateMessage();
            }
        }
        return response()->json($data, $this->http_status_code, $this->headers);
    }

    /**
     * @return JsonResponse
     */
    public function getResponseSuccess(): JsonResponse
    {
        return $this->getResponse(true);
    }

    /**
     * @return JsonResponse
     */
    public function getResponseError(): JsonResponse
    {
        return $this->getResponse(false);
    }
}

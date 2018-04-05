<?php declare(strict_types=1);

namespace Sakila\Http\Controllers\Api;

use Illuminate\Http\Response;
use Sakila\Transformer\Transformer;

class AbstractController
{
    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Transformer\Transformer $transformer
     */
    public function __construct(Transformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param mixed $data
     * @param int   $code
     *
     * @return \Illuminate\Http\Response
     */
    protected function response($data = null, $code = Response::HTTP_OK): Response
    {
        if ($data) {
            $data = $this->transformer->transform($data);
        }

        return new Response($data, $code);
    }
}

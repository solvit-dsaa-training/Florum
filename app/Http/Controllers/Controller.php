<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     *     @OA\Server(
     *      url="/api"
     *
     *   ),

     * @OA\Info(
     *      version="1.0.0",
     *      title="Florum",
     *      description="Documentation of all api for florum project",
     *      @OA\Contact(
     *          email="info@florum.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * ),
     * @OA\SecurityScheme(
     *       scheme="bearer",
     *       securityScheme="bearer",
     *       type="http",
     *       in="header",
     *       name="Authorization",
     * ),
     */
    

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

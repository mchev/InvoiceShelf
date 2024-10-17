<?php

namespace App\Http\Controllers\V1\Admin\Template;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplatesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->authorize('manage templates');

        $response = Template::all();

        return $response;
    }
}

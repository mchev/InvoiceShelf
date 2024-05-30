<?php

namespace App\Http\Controllers\V1\Admin\Modules;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Space\ModuleInstaller;

class CopyModuleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->authorize('manage modules');

        $response = ModuleInstaller::copyFiles($request->module, $request->path);

        return response()->json([
            'success' => $response,
        ]);
    }
}

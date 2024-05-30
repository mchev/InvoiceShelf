<?php

namespace App\Http\Controllers\V1\PDF;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Estimate;

class EstimatePdfController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Estimate $estimate)
    {
        if ($request->has('preview')) {
            return $estimate->getPDFData();
        }

        return $estimate->getGeneratedPDFOrStream('estimate');
    }
}

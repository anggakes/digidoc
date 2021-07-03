<?php

namespace App\Http\Controllers;

use App\Models\DocumentClassification;
use Illuminate\Http\Request;

class DocumentClassificationController extends Controller
{
    //
    public function index()
    {
        //
        $data = DocumentClassification::latest()->simplePaginate(10);
        return view('document_classification.index', [
            'data' => $data,
        ])
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}

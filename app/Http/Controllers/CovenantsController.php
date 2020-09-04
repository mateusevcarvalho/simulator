<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CovenantsController extends Controller
{
    public function index()
    {
        $covenants = convert_file_json_to_array(path_data('convenios.json'));
        return response()->json($covenants);
    }
}

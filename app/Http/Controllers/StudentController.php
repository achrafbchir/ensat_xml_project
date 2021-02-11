<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ManipulateXML;

class StudentController extends Controller
{
    public function importCSVFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|file'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
            /*return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();
            */
        }

        $file = $request->file("excel_file");
        //dd($file);

        $array = ManipulateXML::convertExcelToXML($file);

        return $array;
    }
}

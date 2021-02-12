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
            'excel_file' => 'required|file',
            'plural'     => 'required',
            'single'     => 'required'
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
        $plural = $request->plural;
        $single = $request->single;
        //dd($file);

        $array = ManipulateXML::convertExcelToXML($file, $plural, $single);

        return $array;
    }

    public function isValidDTD(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'xml_file' => 'required|file',
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

        $file = $request->file("xml_file");

        return ManipulateXML::isValidDTD($file);

    }

    public function isValidXSD(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'xml_file' => 'required|file',
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

        $file = $request->file("xml_file");

        return ManipulateXML::isValidXSD($file);

    }
}

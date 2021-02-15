<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ManipulateXML;

define("niveau", ["AP1", "AP2", "Ginf1", "Ginf2", "Ginf3", "Gil1", "Gil2", "Gil3", "Gsea1", "Gsea2", "Gsea3", "Gstr1", "Gstr2", "Gstr3", "G3ei1", "G3ei2", "G3ei3" ]);
define("xml_files", ["Students", "Modules", "Prof", "Notes"]);

class StudentController extends Controller
{
    //public $niveau = ["AP1", "AP2", "GINF1", "GINF2", "GINF3", "GIL1", "GIL2", "GIL3", "GSEA1", "GSEA2", "GSEA3", "GSTR1", "GSTR2", "GSTR3", "G3EI1", "G3EI2", "G3EI3" ];

    public function importCSVFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|file',
            'plural'     => 'required',
            'single'     => 'required',
            'class_name' => 'required|in:'.implode(",",niveau),
            'xml_file_name'  => 'required|in:'.implode(',',xml_files)
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
        $class_name = $request->class_name;
        $xml_file_name = $request->xml_file_name;
        //dd($file);

        $array = ManipulateXML::convertExcelToXML($file, $plural, $single, $class_name, $xml_file_name);

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
            'xsd_file_name' => 'required|in:'.implode(',',xml_files)
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
        $xsd_file_name = $request->xsd_file_name;

        return ManipulateXML::isValidXSD($file, $xsd_file_name);

    }
}

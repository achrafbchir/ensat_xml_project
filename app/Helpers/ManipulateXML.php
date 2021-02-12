<?php

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ManipulateXML {

    public static function convertExcelToXML(UploadedFile $file, $plural, $single)
    {
        #convert excel table to array
        //$csv_array = fgetcsv($file);
        $row = 1;
        $converted_csv_to_array = array();
        $keys = array();
        $csv_file = fopen($file->path(), "r");
        while (($csv_array = fgetcsv($csv_file)) !== FALSE) {
            #get the keys from the first row of the csv file
            if($row == 1)
            {
                $keys = array_values($csv_array);
            }
            else
            {
                $converted_csv_to_array[] = array_combine($keys, array_values($csv_array));
            }
            $row++;
        }

        //return $converted_csv_to_array;

        #create xml string
        $xml_string = new SimpleXMLElement(self::arrayToXml($converted_csv_to_array,"<$plural/>", null, $single));

        #save xml file
        return $xml_string->asXML("$plural.xml");

    }

    // Define a function that converts array to xml. 
    public static function arrayToXml($array, $rootElement = null, $xml = null, $key = null) { 
        $_xml = $xml; 
        
        // If there is no Root Element then insert root 
        if ($_xml === null) { 
            $_xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<root/>'); 
        } 
        
        // Visit all key value pair 
        foreach ($array as $k => $v) { 
            
            // If there is nested array then 
            if (is_array($v)) {  
                
                // Call function for nested array 
                self::arrayToXml($v, $k, $_xml->addChild($key)); 
                } 
                
            else { 
                
                // Simply add child element.  
                $_xml->addChild($k, htmlspecialchars($v)); 
            } 
        } 

        //return $_xml->validate();
        
        return $_xml->asXML(); 
    }

    public static function isValidDTD($file)
    {
        //dd(File::files(public_path()));
        //return Storage::get('students.xml');

        $xml_file = new DOMDocument;
        $xml_file->resolveExternals = true;
        //dd(fopen($file->path(), "r"));
        //dd($file->path());
        //dd($file->path());

        //dd(fopen('D:\developpement\ensat_xml_project\public\students.xml', "r"));
        $xml_file->load($file->path() );
        //dd($xml_file->saveXML()); 
        //dd($xml_file->getElementsByTagName('student'));
        if($xml_file->validate())
        {
            return 100;
        }
        return 2;
    }

    public static function libxml_display_error($error)
    {
        $return = "<br/>\n";
        switch ($error->level) {
            case LIBXML_ERR_WARNING:
                $return .= "<b>Warning $error->code</b>: ";
                break;
            case LIBXML_ERR_ERROR:
                $return .= "<b>Error $error->code</b>: ";
                break;
            case LIBXML_ERR_FATAL:
                $return .= "<b>Fatal Error $error->code</b>: ";
                break;
        }
        $return .= trim($error->message);
        if ($error->file) {
            $return .=    " in <b>$error->file</b>";
        }
        $return .= " on line <b>$error->line</b>\n";

        return $return;
    }

    public static function libxml_display_errors() {
        $errors = libxml_get_errors();
        foreach ($errors as $error) {
            print self::libxml_display_error($error);
        }
        libxml_clear_errors();
    }

    // Enable user error handling
    //libxml_use_internal_errors(true);

    public static function isValidXSD($file)
    {
        $xml_file = new DOMDocument;
        $xml_file->resolveExternals = true;

        //dd(fopen('D:\developpement\ensat_xml_project\public\students.xml', "r"));
        $xml_file->load($file->path() );
        //dd($xml_file->saveXML()); 
        //dd($xml_file->getElementsByTagName('student'));
        if (!$xml_file->schemaValidate('students.xsd')) {
            print '<b>DOMDocument::schemaValidate() Generated Errors!</b>';
            self::libxml_display_errors();
        }
        else
        {
            return 150;
        }
    }
}

<?php

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ManipulateXML {

    public static function convertExcelToXML(UploadedFile $file)
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


        #create xml file
        return self::arrayToXml($converted_csv_to_array,"<students/>", null, "student");

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
        
        return $_xml->asXML(); 
    } 
}

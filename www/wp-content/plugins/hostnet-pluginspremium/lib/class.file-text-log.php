<?php
/**
 * Handles text logging
 * 
 * @version 1.0.0
 * @author Eudes
 */
class File_Text_Log {

    private $file_handle;
    private $type;
    private $path;
    private $string;
    private $file_name;

    function __construct ( string $type, string $path ) {
        $this->type = $type;
        $this->path = $path;
        $this->file_name = $type . '-' . date('Ymd');
        $this->file_handle = fopen($path . '/' . $this->file_name . '.txt', 'a');        
    }

    function log ( string $string, $complex_data = [] ) {
        
        $this->string = $this->format_string($string);        

        fwrite($this->file_handle, $this->string);

        if ( $complex_data ) {
            fwrite($this->file_handle, $this->format_complex_data($complex_data));
        }

    }

    private function format_string ( string $string ) {
        $date_time = time() . ' - ' . date('Ymd-G:i:s') . ' - ';
        return $date_time . $string . "\n";
    }

    private function format_complex_data ( $complex_data ) {
        return json_encode($complex_data, JSON_HEX_QUOT | JSON_PRETTY_PRINT) . "\n";
    }

}
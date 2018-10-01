<?php
$wholeContents = '';
function json2xml($json, $isArray = false, $parent_key = "") {
    global $wholeContents;
    if( $isArray == true){
        foreach ($json as $value) {
            if( $wholeContents != "")
                $wholeContents .= "\n";
            $wholeContents .= "<" . $parent_key . ">";
            if( is_array($value)){
                json2xml($value, true, $parent_key);
            } else if( is_object($value)){
                json2xml($value, false);
            } else{
                $wholeContents .= "" . $value;
            }
            $wholeContents .= "</" . $parent_key . ">";
        }
    } else{
        foreach ($json as $key => $value) {
            if( is_array($value)){
                json2xml($value, true, $key);
            } else if( is_object($value)){
                if( $wholeContents != "")
                    $wholeContents .= "\n";
                $wholeContents .= "<" . $key . ">";
                json2xml($value, false);
                $wholeContents .= "</" . $key . ">";
            } else{
                if( $wholeContents != "")
                    $wholeContents .= "\n";
                $wholeContents .= "<" . $key . ">";
                if( $value === false)
                    $value = "false";
                if( $value === true)
                    $value = "true";
                $wholeContents .= "" . $value;
                $wholeContents .= "</" . $key . ">";
            }
        }
    }
}
    $contents = file_get_contents("json.json");
    $json = json_decode($contents);
    if( is_array($json)){
        $xml = json2xml($json, true, "array");
    }else if( is_object($json)){
        $xml = json2xml($json);
    }
    file_put_contents("json__.xml", $wholeContents);
?>
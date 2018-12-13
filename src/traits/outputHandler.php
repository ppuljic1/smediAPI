<?php

namespace Traits;

trait outputHandler 
{
    /**
     * $status -> boolean
     * $message -> string
     */
    function formatOutput($status, $message, $value=null) {
        return json_encode(array(
            'status'    =>  $status,
            'message'   =>  $message,
            'value'     =>  $value,
        ));
    }

    function readOutput($field, $output) {

        $return = json_decode($output);

        if( $field == 'status' ) {
            return $return->status;
        } else if( $field == 'name' ) {
            return $return->message;
        } else if( $field == 'value' ) {
            return $return->value;
        }
    }
}
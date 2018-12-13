<?php

namespace Traits;

trait apiCalls 
{
    
    function call($headers, $optArray) {
        // Get cURL resource
        $curl = curl_init();

        // Set cURL options array
        curl_setopt_array($curl, $optArray);

        if (!$result = curl_exec($curl)) {
            // Close cURL
            curl_close($curl);
            // cURL call failed, do something .....
            $message = 'cURL error string: "' . curl_error($curl) . '" <br> cURL error number: ' . curl_errno($curl);
            
            return array(
                'success'   =>  false,
                'message'   =>  $message,
            );

        } else {
            curl_close($curl);

            return array(
                'success'   =>  true,
                'message'   =>  'success',
            );

        }

    }

}
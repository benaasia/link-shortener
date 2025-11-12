<?php

/*
Plugin Name: Link Shortener Shortcode
Plugin URI: https://rutgon.com.vn
Description: Shorten links directly using [shorturl] shortcode
Version: 1.0
Author: Rút Gọn Link, Bọc Link
Author URI: https://rutgon.com.vn
*/

// This code simply registers the shortcode "shorturl". You can change it if you want something else 
add_shortcode("shorturl", "pus_shortcode_shorten_url");

// Function to send the request
function pus_shortcode_shorten_url($atts, $content){
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://rutgon.com.vn/api/url/add");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['url' => $content]));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer 60c34239f855a373e9379d825ef35e1b",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    if($object = json_decode($response)){
        if(isset($object->shorturl)){
            return $object->shorturl;
        }
    }

    return $content;
}
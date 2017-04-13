<?php
use Rethink\MediaConnection;

include_once __DIR__ .'/server_php/Rethink/autoloader.php';
$db = new MediaConnection();
if (key_exists('postId', $_GET)) {
    $id = $_GET['postId'];
    $ip = !empty($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR'];
    try {
        $code = $db->embeddedPost($id, $ip);
        if (isset($code)) {
            
            $data = file_get_contents(__DIR__ .'/app/embedded.html');
            
            echo str_ireplace("@embedded@", json_encode($code->post->model), $data);
        }
        
    } catch (Exception $e) {
        
    }
}

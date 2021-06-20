<?php

if(isset($_POST['emailSubmit'])){
    
    $email = $_POST['email'];
    if($email==''){
        $_SESSION['subscription_msg'] = '<div style="color:red;">Email id can\'t be blank.</div>';
    }else if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
        $_SESSION['subscription_msg'] = '<div style="color:red;">Email id is not valid.</div>';
    } else{
        $request = array();
        $request['tableName'] = 'subscribedEmails';
        $request['fields'] = array('email'=>$email);
        
        $request_json = json_encode($request);
        
        $api = API_URL.'insert_entity_into_table';

        $curl_obj = new curl($request_json,$api);

        $result = $curl_obj->exec_curl();
    
        $result_array_customer_info = json_decode($result,true);
        
        if($result_array_customer_info['message']==1){
            $_SESSION['subscription_msg'] = '<div style="color:green;">You have subscribed sucessfully. Please check your email for confirmation.</div>';
        }else{
            $_SESSION['subscription_msg'] = '<div style="color:red;">Failed to subscribe.</div>';
        }


        $email_template = file_get_contents('templates/contents/subscribedEmailTemplate.html');
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <admin@winon11.com>' . "\r\n";
        
        mail($email,'User subscription successful - WinOn11',$email_template,$headers);
    }
    
}

if(isset($_SESSION['subscription_msg'])){
    $subscription_message=$_SESSION['subscription_msg'];
    unset($_SESSION['subscription_msg']);
}else{
    $subscription_message='';
}
?>
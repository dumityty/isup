<?php 

function siteup($url=NULL) {
    if ($url == NULL) { 
        return FALSE;
    }

    $ch = curl_init($url);

    $options = array(
        CURLOPT_NOBODY => true,
        CURLOPT_FOLLOWLOCATION => true,

    );
    curl_setopt_array($ch, $options);
    
    curl_exec($ch);
    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    
    if ($retcode == 200) {
        $return = array(
            'status' => TRUE,
            'retcode' => $retcode,
            'error' => '',
        );
        return $return;
    } else {
        $return = array(
            'status' => FALSE,
            'retcode' => $retcode,
            'error' => curl_error($ch),
        );
        return $return;
    }
    curl_close($ch);
}

$date = date("d M Y G:i:s");
echo "Date: " . $date . "<br /><br />";

$urls = array(
    'c4u' => 'www.customs4u.com',
    'glam' => 'www.glamworship.com',
    'PN' => 'www.propertynetwork.net',
    'PN API' => 'www.propertynetworkapi.net',
);

foreach ($urls as $name => $url) {
    echo '<b>' . $name . ' (' . $url . ') </b>';
    echo "<br />";

    $siteup = siteup($url);
    if ($siteup['status']) {
        echo 'UP';
    }
    else{
        echo $siteup['retcode'] . '-' . $siteup['error'] . "<br />";

        echo 'DOWN';

        // site is DOWN - send an email
        $message = $name . ' - ' . $url;
        $message .= "\n\n";
        $message .= 'Site is down.';
        $message .= "\n\n";
        $message .= 'Return code:';
        $message .= "\n\n";
        $message .= $siteup['retcode'];
        $message .= "\n\n";
        $message .= 'Error:';
        $message .= "\n\n";
        $message .= $siteup['error'];

        $email = 'titi@zoocha.com';
        $subject = $name . ' - DOWN';
        $body = $message;
        $headers = "From: Zoocha Monitor <no-reply@zoocha.com>" . "\r\n" . "Reply-To: " . $email . "\r\n" . "X-Mailer: PHP/" . phpversion();

        // mail($email,$subject,$body,$headers);
    }
    echo "<br />";
    echo "<br />";
}
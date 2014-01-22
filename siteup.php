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
        return TRUE;
    } else {
        echo $retcode . '-' . curl_error($ch) . "<br />";
        return FALSE;
    }
    curl_close($ch);
}

$urls = array(
    'c4u' => 'www.customs4u.com',
    'glam' => 'www.glamworship.com',
    'PN' => 'www.propertynetwork.net',
);

foreach ($urls as $name => $url) {
    echo '<b>' . $name . ' (' . $url . ') </b>';
    echo "<br />";
    if (siteup($url)) {
        echo 'UP';
    }
    else{
        echo 'DOWN';
    }
    echo "<br />";
    echo "<br />";
}
<?php
function getNewsFromAPI($category = '') {
    $apiKey = 'd6b6b92fbed54ece9fba781ce8897157'; // Your API key
    $baseUrl = 'https://newsapi.org/v2/top-headlines';
    $country = 'us';

    // Build URL with parameters
    $url = $baseUrl . '?country=' . $country . '&apiKey=' . $apiKey;
    
    // Add category if specified
    if (!empty($category)) {
        $url .= '&category=' . urlencode($category);
    }

    // Initialize cURL
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'User-Agent: Your-App-Name'
        ]
    ]);

    // Execute cURL request
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return ['status' => 'error', 'message' => $err];
    }

    return json_decode($response, true);
}
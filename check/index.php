<?php
// verify-recaptcha.php
header('Content-Type: application/json');

// 允许跨域请求（如果前端和后端在不同域名下）
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 获取POST数据
    $input = json_decode(file_get_contents('php://input'), true);
    $recaptchaToken = $input['recaptchaToken'] ?? '';
    
    if (empty($recaptchaToken)) {
        echo json_encode(['success' => false, 'error' => '缺少reCAPTCHA token']);
        exit;
    }
    
    // 您的reCAPTCHA secret key
    $secretKey = "6LcdqvorAAAAADRZJnYxtBtdSGJCgjhUeB4jUgYM"; // 替换为您的实际secret key
    
    // 向Google验证
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secretKey,
        'response' => $recaptchaToken
    ];
    
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    if ($result === FALSE) {
        echo json_encode(['success' => false, 'error' => '无法连接到验证服务']);
        exit;
    }
    
    $response = json_decode($result, true);
    
    // 返回验证结果
    echo json_encode($response);
    
} else {
    echo json_encode(['success' => false, 'error' => '仅支持POST请求']);
}
?>

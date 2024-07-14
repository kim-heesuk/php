<?php
function fetch_stock_data($symbol, $start, $end) {
    $start_timestamp = strtotime($start);
    $end_timestamp = strtotime($end);
    
    // Yahoo Finance URL 구성
    $url = "https://finance.yahoo.com/quote/$symbol/history?period1=$start_timestamp&period2=$end_timestamp&interval=1d&filter=history&frequency=1d";

    // cURL 초기화
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36");

    // 요청 실행 및 응답 데이터 저장
    $response = curl_exec($ch);
    curl_close($ch);

    // DOMDocument 객체 생성 및 HTML 로드
    $dom = new DOMDocument;
    @$dom->loadHTML($response);

    // DOMXPath 객체 생성
    $xpath = new DOMXPath($dom);

    // 역사적 데이터 테이블 찾기
    $rows = $xpath->query('//table[contains(@class, "W(100%) M(0)")]//tr');

    // 데이터 추출 및 배열에 저장
    $data = [];
    foreach ($rows as $row) {
        $cols = $row->getElementsByTagName('td');
        if ($cols->length > 0) {
            $date = trim($cols->item(0)->nodeValue);
            $open = trim($cols->item(1)->nodeValue);
            $high = trim($cols->item(2)->nodeValue);
            $low = trim($cols->item(3)->nodeValue);
            $close = trim($cols->item(4)->nodeValue);
            $adj_close = trim($cols->item(5)->nodeValue);
            $volume = trim($cols->item(6)->nodeValue);

            $data[] = [
                'date' => $date,
                'open' => $open,
                'high' => $high,
                'low' => $low,
                'close' => $close,
                'adj_close' => $adj_close,
                'volume' => $volume
            ];
        }
    }

    return $data;
}

// 사용 예시
$symbol = 'AAPL';
$start = '2023-01-01';
$end = '2023-12-31';
$data = fetch_stock_data($symbol, $start, $end);

// 데이터 출력
print_r($data);
?>

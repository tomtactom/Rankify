<?php
// Download helper for Rankify history entries
include __DIR__.'/inc/lang.php';
include __DIR__.'/inc/validate.php';
if (!isset($_GET['index']) || !isset($_GET['format'])) {
    http_response_code(400);
    echo 'Missing parameters';
    exit;
}
$index  = (int)$_GET['index'];
$format = $_GET['format'];
$history = isset($_COOKIE['rankify_history']) ? json_decode($_COOKIE['rankify_history'], true) : [];
if (!is_array($history) || !isset($history[$index])) {
    http_response_code(404);
    echo 'Entry not found';
    exit;
}
$entry = $history[$index];
$set   = validate_set_path($entry['set']);
if (!$set) {
    http_response_code(400);
    echo 'Invalid set';
    exit;
}
$setName = preg_replace('/(_[a-z]{2})?\.csv$/','', basename($set));
$generated = isset($entry['time']) ? strtotime($entry['time']) : time();
$scores = $entry['scores'];
$file = __DIR__.'/data/'.$set;
if (!file_exists($file)) {
    http_response_code(404);
    echo 'Data file not found';
    exit;
}
$rows = array_map(function($l){ return str_getcsv($l, ';'); }, file($file));
array_shift($rows); // header
$cards = [];
foreach ($rows as $r) {
    if (count($r) < 3) continue;
    $cards[$r[0]] = ['id'=>$r[0],'title'=>$r[1],'subtitle'=>$r[2]];
}
// helper to create result text
function build_text($cards, $scores) {
    $lang = getLanguage();
    $parts = [];
    $rank = 1;
    foreach ($scores as $id => $score) {
        if (!isset($cards[$id])) continue;
        $c = $cards[$id];
        if ($lang === 'de')
            $parts[] = "$rank. {$c['title']} ({$c['subtitle']}) – {$score} Punkte";
        else
            $parts[] = "$rank. {$c['title']} ({$c['subtitle']}) – {$score} points";
        $rank++;
    }
    return t('apa_ranking_head') . ' ' . implode('; ', $parts) . '.';
}
$text = build_text($cards, $scores);
switch($format) {
    case 'json':
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="'.$setName.'_results.json"');
        echo json_encode(['set'=>$set,'scores'=>$scores,'generated'=>date('c')], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        break;
    case 'apa':
        header('Content-Type: text/plain; charset=utf-8');
        header('Content-Disposition: attachment; filename="'.$setName.'_results.txt"');
        echo $text;
        break;
    case 'png':
        $font      = 5; // built-in GD font (highest resolution)
        $fontH     = imagefontheight($font);
        $barHeight = $fontH + 4;
        $padding   = 20;
        $lineHeight = $barHeight + 18;
        $width  = 800;
        $headerLines = 3;
        $height = $lineHeight * count($scores) + $padding * 2 + ($fontH + 6) * $headerLines;
        $im = imagecreatetruecolor($width, $height);
        $bg = imagecolorallocate($im, 255, 255, 255);
        imagefill($im, 0, 0, $bg);
        $black = imagecolorallocate($im, 0, 0, 0);
        $barColor = imagecolorallocate($im, 40, 215, 174); // #28d7ae

        // Header
        imagestring($im, $font, $padding, $padding, utf8_decode(t('results')), $black);
        $y = $padding + $fontH + 6;
        imagestring($im, $font, $padding, $y, utf8_decode($setName), $black);
        $y += $fontH + 4;
        imagestring($im, $font, $padding, $y, date('Y-m-d H:i', $generated), $black);
        $y += 10;
        $maxScore = max($scores);
        $rank = 1;
        foreach ($scores as $id => $score) {
            if (!isset($cards[$id])) continue;
            $title = $cards[$id]['title'];
            $barWidth = $maxScore > 0 ? ($score / $maxScore) * ($width - 250) : 0;
            imagestring($im, $font, $padding, $y, utf8_decode($rank.'. '.$title), $black);
            imagefilledrectangle($im, 200, $y, 200 + $barWidth, $y + $barHeight, $barColor);
            imagestring($im, $font, 210 + $barWidth, $y, (string)$score, $black);
            $y += $lineHeight;
            $rank++;
        }
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="'.$setName.'_results.png"');
        imagepng($im);
        imagedestroy($im);
        break;
    case 'pdf':
        require_once(__DIR__.'/lib/fpdf.php');
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Helvetica','B',20);
        $pdf->Cell(0,10,'Rankify',0,1,'C');
        $pdf->SetFont('Helvetica','B',16);
        $pdf->Cell(0,8,iconv('UTF-8','CP1252//TRANSLIT',$setName),0,1,'C');
        $pdf->SetFont('Helvetica','',12);
        $pdf->Cell(0,6,date('Y-m-d H:i',$generated),0,1,'C');
        $pdf->Ln(5);

        $pdf->SetFont('Helvetica','B',12);
        $pdf->SetFillColor(224,235,255);
        $pdf->Cell(10,8,'#',1,0,'C',true);
        $pdf->Cell(140,8,'Item',1,0,'L',true);
        $pdf->Cell(20,8,'Score',1,1,'C',true);

        $pdf->SetFont('Helvetica','',12);
        $pdf->SetFillColor(245,245,245);
        $fill = false;
        $rank = 1;
        foreach ($scores as $id=>$score) {
            if (!isset($cards[$id])) continue;
            $pdf->Cell(10,8,$rank,1,0,'C',$fill);
            $pdf->Cell(140,8,iconv('UTF-8','CP1252//TRANSLIT',$cards[$id]['title']),1,0,'L',$fill);
            $pdf->Cell(20,8,$score,1,1,'C',$fill);
            $fill = !$fill;
            $rank++;
        }

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="'.$setName.'_results.pdf"');
        $pdf->Output('D', $setName.'_results.pdf');
        break;
    default:
        http_response_code(400);
        echo 'Invalid format';
}
?>

<?php
// Download helper for Rankify history entries
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
$set   = $entry['set'];
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
    $out = ""; $rank = 1;
    foreach ($scores as $id=>$score) {
        if (!isset($cards[$id])) continue;
        $c = $cards[$id];
        $out .= $rank.'. '.$c['title'].' ('.$c['subtitle'].') – '.$score."\n";
        $rank++;
    }
    return $out;
}
$text = build_text($cards, $scores);
switch($format) {
    case 'json':
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="rankify_results.json"');
        echo json_encode(['set'=>$set,'scores'=>$scores,'generated'=>date('c')], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        break;
    case 'apa':
        header('Content-Type: text/plain; charset=utf-8');
        header('Content-Disposition: attachment; filename="rankify_results.txt"');
        echo $text;
        break;
    case 'png':
        $im = imagecreatetruecolor(800, 20*(count($scores)+2));
        $bg = imagecolorallocate($im, 255,255,255); imagefill($im,0,0,$bg);
        $color = imagecolorallocate($im, 0,0,0);
        $y=20; imagefttext($im, 12,0,20,$y,$color,'/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf','Rankify Ergebnisse');
        $y+=20;
        foreach ($scores as $id=>$score) {
            if (!isset($cards[$id])) continue;
            $line = $cards[$id]['title'].' - '.$score;
            imagefttext($im, 10,0,20,$y,$color,'/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',$line);
            $y+=20;
        }
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="rankify_results.png"');
        imagepng($im);
        imagedestroy($im);
        break;
    case 'pdf':
        require_once(__DIR__.'/lib/fpdf.php');
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(0,10,'Rankify Ergebnisse',0,1);
        foreach ($scores as $id=>$score) {
            if (!isset($cards[$id])) continue;
            $line = $cards[$id]['title'].' - '.$score;
            $pdf->Cell(0,8,$line,0,1);
        }
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="rankify_results.pdf"');
        $pdf->Output('D','rankify_results.pdf');
        break;
    default:
        http_response_code(400);
        echo 'Invalid format';
}
?>

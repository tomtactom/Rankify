<?php
function validate_set_path($set) {
    $allowedDirs = ['punkte', 'thurstone', 'bradleyterry'];
    $set = str_replace('\\', '/', $set);
    if (strpos($set, '..') !== false) return null;
    $parts = explode('/', $set);
    if (count($parts) !== 2) return null;
    list($dir, $file) = $parts;
    if (!in_array($dir, $allowedDirs, true)) return null;
    $file = basename($file);
    if (pathinfo($file, PATHINFO_EXTENSION) !== 'csv') return null;
    return $dir.'/'.$file;
}
?>

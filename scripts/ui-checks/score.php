<?php
/**
 * Reads the copy-hidden hero renders and reports the worst contrast that
 * white text would have against what is actually painted behind it.
 *
 * "Worst" = the brightest pixel inside the copy's own bounding box, which is
 * the pixel that would make a glyph hardest to read. Measuring the rendered
 * PNG rather than modelling the CSS means this accounts for the photo, the
 * filter, both scrims, the mask and the decorative overlays at once.
 *
 * usage: php score.php manifest-local.json
 */

function srgbToLin(float $c): float
{
    return $c <= 0.03928 ? $c / 12.92 : (($c + 0.055) / 1.055) ** 2.4;
}

function contrastVsWhite(int $r, int $g, int $b): float
{
    $l = 0.2126 * srgbToLin($r / 255) + 0.7152 * srgbToLin($g / 255) + 0.0722 * srgbToLin($b / 255);

    return 1.05 / ($l + 0.05);
}

$manifest = json_decode(file_get_contents($argv[1]), true);
$fails = 0;

foreach ($manifest as $row) {
    $im = imagecreatefrompng(__DIR__ . '/' . $row['file']);
    $iw = imagesx($im);
    $ih = imagesy($im);

    $line = sprintf('%5dpx slide %d  ', $row['width'], $row['slide']);
    $parts = [];

    // AA threshold: 4.5:1 for body copy, 3:1 for the headline (it is >=24px
    // bold, which WCAG 1.4.3 classes as large-scale text). Held to 4.5 anyway
    // where possible, and reported either way.
    foreach ([['headline', 3.0], ['body', 4.5], ['eyebrow', 4.5]] as [$key, $threshold]) {
        $r = $row[$key] ?? null;
        if (! $r || $r['w'] <= 0 || $r['h'] <= 0) {
            continue;
        }

        $worst = 99.0;
        $x1 = min($iw - 1, $r['x'] + $r['w']);
        $y1 = min($ih - 1, $r['y'] + $r['h']);

        for ($y = max(0, $r['y']); $y < $y1; $y++) {
            for ($x = max(0, $r['x']); $x < $x1; $x++) {
                $c = imagecolorat($im, $x, $y);
                $cr = contrastVsWhite(($c >> 16) & 0xFF, ($c >> 8) & 0xFF, $c & 0xFF);
                if ($cr < $worst) {
                    $worst = $cr;
                }
            }
        }

        $ok = $worst >= $threshold;
        if (! $ok) {
            $fails++;
        }
        $parts[] = sprintf('%s %5.2f:1 %s', $key, $worst, $ok ? 'ok ' : 'FAIL');
    }

    echo $line . implode('   ', $parts) . "\n";
    imagedestroy($im);
}

echo $fails === 0 ? "\nAll regions pass.\n" : "\n{$fails} region(s) FAILED.\n";
exit($fails === 0 ? 0 : 1);

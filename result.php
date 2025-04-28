<?php
function buildTrapezoidPoints($sides) {
    $topBase = $sides[0];
    $rightSide = $sides[1];
    $bottomBase = $sides[2];
    $leftSide = $sides[3];
    if ($bottomBase > $topBase) {
        [$topBase, $bottomBase] = [$bottomBase, $topBase];
        [$leftSide, $rightSide] = [$rightSide, $leftSide];
    }
    $baseDifference = ($topBase - $bottomBase) / 2;
    return [
        ['x' => 0, 'y' => 0],
        ['x' => $topBase, 'y' => 0],
        ['x' => $topBase - $baseDifference, 'y' => $rightSide],
        ['x' => $baseDifference, 'y' => $leftSide],
    ];
}
function calculatePolygonArea($points) {
    $area = 0;
    $n = count($points);
    for ($i = 0; $i < $n; $i++) {
        $j = ($i + 1) % $n;
        $area += ($points[$i]['x'] * $points[$j]['y']) - ($points[$j]['x'] * $points[$i]['y']);
    }
    return abs($area) / 2;
}
function calculatePerimeter($sides) {
    return array_sum($sides);
}
$sides = $_POST['sides'] ?? [5, 10, 10, 10];
$points = buildTrapezoidPoints($sides);
$totalArea = calculatePolygonArea($points);
$totalPerimeter = calculatePerimeter($sides);
$svgLines = '';
for ($i = 0; $i < count($points); $i++) {
    $j = ($i + 1) % count($points);
    $svgLines .= "<line x1='{$points[$i]['x']}' y1='{$points[$i]['y']}' x2='{$points[$j]['x']}' y2='{$points[$j]['y']}' stroke='black' stroke-width='2'/>\n";
}
$xs = array_column($points, 'x');
$ys = array_column($points, 'y');
$minX = min($xs) - 10;
$maxX = max($xs) + 10;
$minY = min($ys) - 10;
$maxY = max($ys) + 10;
$w = $maxX - $minX;
$h = $maxY - $minY;
?>
<h2>Results</h2>
<p><strong>Total Area:</strong> <?= round($totalArea, 2) ?> m²</p>
<p><strong>Total Perimeter:</strong> <?= round($totalPerimeter, 2) ?> meters</p>
<h3>Area Calculation:</h3>
<p>Using the Shoelace formula:</p>
<pre>Area = 1/2 * | Σ (xi * yi+1 - xi+1 * yi) |</pre>
<h3>Perimeter Calculation:</h3>
<p>Sum of all sides:</p>
<pre>Perimeter = Σ (side lengths)</pre>
<h3>Land Shape:</h3>
<svg width="<?= $w ?>" height="<?= $h ?>" viewBox="<?= "$minX $minY $w $h" ?>" style="border:1px solid black;">
    <?= $svgLines ?>
</svg>

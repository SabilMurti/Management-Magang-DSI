<?php
/**
 * PWA Icon Generator Script
 *
 * This script generates PNG icons from base64 data for PWA.
 * Run with: php artisan tinker < generate-icons.php
 * Or simply: php generate-icons.php
 */

// Sizes needed for PWA
$sizes = [72, 96, 128, 144, 152, 192, 384, 512];

// Base64 encoded simple icon (violet graduation cap)
// This is a simple fallback - you can replace with custom icon later
$iconDir = __DIR__ . '/public/icons';

if (!is_dir($iconDir)) {
    mkdir($iconDir, 0755, true);
}

// Create a simple gradient icon using GD if available
if (extension_loaded('gd')) {
    foreach ($sizes as $size) {
        $image = imagecreatetruecolor($size, $size);

        // Enable alpha blending
        imagealphablending($image, true);
        imagesavealpha($image, true);

        // Colors
        $violet = imagecolorallocate($image, 139, 92, 246);
        $darkViolet = imagecolorallocate($image, 124, 58, 237);
        $white = imagecolorallocate($image, 255, 255, 255);
        $gold = imagecolorallocate($image, 251, 191, 36);

        // Draw rounded rectangle background
        imagefilledrectangle($image, 0, 0, $size, $size, $violet);

        // Draw graduation cap (simplified)
        $centerX = $size / 2;
        $centerY = $size / 2;
        $capSize = $size * 0.35;

        // Cap base (diamond shape)
        $points = [
            $centerX - $capSize, $centerY,
            $centerX, $centerY - $capSize * 0.5,
            $centerX + $capSize, $centerY,
            $centerX, $centerY + $capSize * 0.5
        ];
        imagefilledpolygon($image, $points, 4, $white);

        // Cap top (ellipse)
        imagefilledellipse($image, $centerX, $centerY - $size * 0.05, $capSize * 0.8, $capSize * 0.3, $white);

        // Tassel (line and circle)
        $tasselStartX = $centerX;
        $tasselStartY = $centerY - $size * 0.1;
        $tasselEndX = $centerX + $size * 0.2;
        $tasselEndY = $centerY + $size * 0.2;

        imagesetthickness($image, max(2, $size / 85));
        imageline($image, $tasselStartX, $tasselStartY, $tasselEndX, $tasselEndY, $gold);
        imagefilledellipse($image, $tasselEndX, $tasselEndY, $size * 0.08, $size * 0.08, $gold);

        // Save
        $filename = "{$iconDir}/icon-{$size}x{$size}.png";
        imagepng($image, $filename);
        imagedestroy($image);

        echo "Generated: icon-{$size}x{$size}.png\n";
    }

    echo "\nAll icons generated successfully!\n";
} else {
    // Fallback: create placeholder files
    echo "GD extension not available. Creating placeholder HTML notice...\n";

    $notice = "PWA icons need to be generated manually.\n";
    $notice .= "Please create PNG icons with sizes: " . implode(', ', $sizes) . " pixels\n";
    $notice .= "Place them in: public/icons/icon-{size}x{size}.png\n";

    file_put_contents($iconDir . '/README.txt', $notice);
    echo $notice;
}

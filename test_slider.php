<?php
require 'bootstrap/app.php';
$app = app();

$sliders = \App\Models\HeroSlider::where('is_active', true)->get();
echo "Total sliders: " . count($sliders) . "\n";

foreach ($sliders as $slider) {
    echo "ID: " . $slider->id . "\n";
    echo "Title: " . $slider->title . "\n";
    echo "Image: " . $slider->image . "\n";
    echo "Model: " . $slider->model . "\n";
    echo "Active: " . ($slider->is_active ? 'Yes' : 'No') . "\n";
    echo "---\n";
}
?>

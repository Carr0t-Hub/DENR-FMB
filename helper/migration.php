<?php
include('../Schema/Migration.php');
include('../Schema/Blueprint.php');
include('../functions/function.php');

$migration = new Migration();
$migration->createDatabase('engpproject');

$migration->create('engp', function (Blueprint $table) {
    $table->id();
    $table->string('category', 50);
    $table->string('year', 15);
    $table->integer('targetArea', 8);
    $table->integer('areaPlanted', 8);
    $table->integer('accomp', 5);
    $table->integer('seedlingPlanted', 10);
    $table->integer('jobsGenerated', 8);
    $table->integer('personsEmployed', 8);
    $table->timestamps();
});

for ($year = 2017; $year >= 1998; $year--) {
    $migration->insert('engp', [
        'category' => 'Grand Total',
        'year' => (string)$year,
        'targetArea' => rand(500, 1000),
        'areaPlanted' => rand(400, 900),
        'accomp' => rand(70, 80),
        'seedlingPlanted' => rand(3000, 6000),
        'jobsGenerated' => rand(100, 200),
        'personsEmployed' => rand(90, 150),
    ]);
}


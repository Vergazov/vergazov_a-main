<?php

$tanks = [
    [
        "name" => "ТП-41",
        "maxSpeed" => 80,
        "armorPiercing" => 10
    ],
    [
        "name" => "ТП-32",
        "maxSpeed" => 60,
        "armorPiercing" => 20
    ],
    [
        "name" => "ТШ-605",
        "maxSpeed" => 90,
        "armorPiercing" => 5
    ],
    [
        "name" => "ТШ-607",
        "maxSpeed" => 90,
        "armorPiercing" => 7
    ],
    [
        "name" => "ТТ-22",
        "maxSpeed" => 40,
        "armorPiercing" => 20
    ],
    [
        "name" => "ТТ-25",
        "maxSpeed" => 40,
        "armorPiercing" => 50
    ],
];

$aims = [2, 7, 5, 15, 30, 1, 54, 12, 61];

foreach ($aims as $aim) {
    $rightTanks = searchRight($aim, $tanks);
    $rightTanks = sortBySpeed($rightTanks);
    $messages[] = createMessage($rightTanks, $aim);
}

function searchRight($aim, $tanks)
{
    $rightTanks = [];
    foreach ($tanks as $tank) {
        if ($tank['armorPiercing'] > $aim) {
            $rightTanks[] = $tank;
        }
    }
    return $rightTanks;
}

function sortBySpeed($rightTanks)
{
    usort($rightTanks, fn($first, $second) => $first['maxSpeed'] <=> $second['maxSpeed']);
    return $rightTanks;
}

function createMessage($rightTanks, $aim)
{
    if (count($rightTanks) === 0) {
        return "Для пробития брони толщиной " . $aim . " мм подходящих танков не найдено";
    }
    if (count($rightTanks) === 1) {
        return "Чтобы пробить броню толщиной " . $aim . " мм нужен танк марки " . getTankName($rightTanks) .
            " со скоростью перемещения " . getTankSpeed($rightTanks);
    }
    if (count($rightTanks) > 1) {
        return "Чтобы пробить броню толщиной " . $aim . " мм подойдет любой из этих танков: " . getTanksProperties($rightTanks);
    }
}

function getTankName($rightTanks)
{
    return $rightTanks[0]['name'];
}

function getTankSpeed($rightTanks)
{
    return $rightTanks[0]['maxSpeed'] . ' км/ч';
}

function getTanksProperties($rightTanks)
{
    $preparedProperties = [];
    $properties = array_map('prepareProperties', $rightTanks);
    foreach ($properties as $property) {
        $preparedProperties[] = implode(' ', $property);
    }
    return implode(', ', $preparedProperties);
}

function prepareProperties($rightTanks)
{
    array_pop($rightTanks);
    $rightTanks['name'] = 'модель ' . $rightTanks['name'];
    $rightTanks['maxSpeed'] = ' (' . $rightTanks['maxSpeed'] . ' км/ч)';
    return $rightTanks;
}

?>

<ul>
    <?php foreach ($messages as $message) : ?>
        <li><?= $message ?></li>
    <?php endforeach; ?>
</ul>
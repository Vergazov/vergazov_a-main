<?php

$cranes = [
    [
        "name" => "КП-1550",
        "weight" => 50,
        "distance" => 12
    ],
    [
        "name" => "КП-0042",
        "weight" => 42,
        "distance" => 12
    ],
    [
        "name" => "КП-0070",
        "weight" => 70,
        "distance" => 8
    ],
    [
        "name" => "КПМ-0215",
        "weight" => 15,
        "distance" => 25
    ],
    [
        "name" => "КПМ-0315",
        "weight" => 15,
        "distance" => 26
    ],
    [
        "name" => "КПМ-0220",
        "weight" => 20,
        "distance" => 20
    ],
];

$cargoes = [
    [
        "weight" => 15,
        "distance" => 20
    ],
    [
        "weight" => 20,
        "distance" => 15
    ],
    [
        "weight" => mt_rand(10, 60),
        "distance" => mt_rand(10, 30)
    ],
    [
        "weight" => mt_rand(10, 60),
        "distance" => mt_rand(10, 30)
    ]
];


foreach ($cargoes as $cargo) {
    $rightCranes = searchCranes($cargo, $cranes);
    $messages[] =  createMessage($rightCranes, $cargo);
}


function searchCranes($cargo, $cranes)
{
    $rightCranes = [];
    foreach ($cranes as $crane) {
        if ($crane['weight'] >= $cargo['weight'] && $crane['distance'] >= $cargo['distance']) {
            $rightCranes[] = $crane;
        }
    }
    return $rightCranes;
}

function createMessage($rightCranes, $cargo)
{
    if (count($rightCranes) === 0) {
        return "Для передвижения груза массой " . $cargo['weight'] . " тонн на расстояние " . $cargo['distance'] .
            " подходящего крана не найдено";
    }
    if (count($rightCranes) === 1) {
        return "Чтобы передвинуть груз массой " . $cargo['weight'] . " на расстояние " . $cargo['distance'] .
            " нужен кран марки " . getCranesNames($rightCranes);
    }
    if (count($rightCranes) > 1) {
        return "Чтобы передвинуть груз массой " . $cargo['weight'] . " тонн на расстояние " . $cargo['distance'] .
            " подойдет любой из этих кранов: " . getCranesNames($rightCranes);
    }
}

function getCranesNames($rightCranes){
    $cranesNames = array_map('getCraneName',$rightCranes);
    return implode(', ', $cranesNames);
}

function getCraneName($rightCranes){
    return $rightCranes['name'];
}
?>


<ul>
    <?php foreach($messages as $message) : ?>
        <li><?= $message ?></li>
    <?php endforeach; ?>
</ul>
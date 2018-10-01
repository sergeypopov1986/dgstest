<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<h2>Текущее положение:</h2>
<table border="1" cellpadding="5">
    <tr>
        <td>Страна</td>
        <td><?=$arResult['GEODATA']["COUNTRY"]?></td>
    <tr>
    <tr>
        <td>Город</td>
        <td><?=$arResult['GEODATA']["CITY"]?></td>
    </tr>
    <tr>
        <td>Координаты</td>
        <td>
            (LAT:<?=$arResult['GEODATA']["COORDS"]["LAT"]?>),(LNG:<?=$arResult['GEODATA']["COORDS"]["LNG"]?>)
        </td>
    </tr>
</table>
<h2>Пользователи из одного города:</h2>
<table border="1">
    <thead>
    <th>№</th>
    <th>Страна</th>
    <th>Город</th>
    <th>Координаты</th>
    </thead>
    <tbody>
    <? foreach ($arResult['USERS'] as $k => $user):?>
    <tr>
        <td><?=$k?></td>
        <td><?=$user["COUNTRY"]?></td>
        <td><?=$user["CITY"]?></td>
        <td>
            (LAT:<?=$user["COORDS"]["LAT"]?>),(LNG:<?=$user["COORDS"]["LNG"]?>)
        </td>
    </tr>
    <?endforeach;?>
    </tbody>
</table>
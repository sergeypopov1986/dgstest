<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<table>
    <thead>
    <th>Страна</th>
    <th>Город</th>
    <th>Координаты</th>
    </thead>
    <tbody>
    <tr>
        <td><?=$arResult['GEODATA']["COUNTRY"]?></td>
        <td><?=$arResult['GEODATA']["CITY"]?></td>
        <td></td>
    </tr>
    </tbody>
</table>

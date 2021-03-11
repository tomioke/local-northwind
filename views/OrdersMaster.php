<?php

namespace PHPMaker2021\northwindapi;

// Table
$orders = Container("orders");
?>
<?php if ($orders->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_ordersmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($orders->OrderID->Visible) { // OrderID ?>
        <tr id="r_OrderID">
            <td class="<?= $orders->TableLeftColumnClass ?>"><?= $orders->OrderID->caption() ?></td>
            <td <?= $orders->OrderID->cellAttributes() ?>>
<span id="el_orders_OrderID">
<span<?= $orders->OrderID->viewAttributes() ?>>
<?= $orders->OrderID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($orders->CustomerID->Visible) { // CustomerID ?>
        <tr id="r_CustomerID">
            <td class="<?= $orders->TableLeftColumnClass ?>"><?= $orders->CustomerID->caption() ?></td>
            <td <?= $orders->CustomerID->cellAttributes() ?>>
<span id="el_orders_CustomerID">
<span<?= $orders->CustomerID->viewAttributes() ?>>
<?= $orders->CustomerID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($orders->EmployeeID->Visible) { // EmployeeID ?>
        <tr id="r_EmployeeID">
            <td class="<?= $orders->TableLeftColumnClass ?>"><?= $orders->EmployeeID->caption() ?></td>
            <td <?= $orders->EmployeeID->cellAttributes() ?>>
<span id="el_orders_EmployeeID">
<span<?= $orders->EmployeeID->viewAttributes() ?>>
<?= $orders->EmployeeID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($orders->OrderDate->Visible) { // OrderDate ?>
        <tr id="r_OrderDate">
            <td class="<?= $orders->TableLeftColumnClass ?>"><?= $orders->OrderDate->caption() ?></td>
            <td <?= $orders->OrderDate->cellAttributes() ?>>
<span id="el_orders_OrderDate">
<span<?= $orders->OrderDate->viewAttributes() ?>>
<?= $orders->OrderDate->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($orders->RequiredDate->Visible) { // RequiredDate ?>
        <tr id="r_RequiredDate">
            <td class="<?= $orders->TableLeftColumnClass ?>"><?= $orders->RequiredDate->caption() ?></td>
            <td <?= $orders->RequiredDate->cellAttributes() ?>>
<span id="el_orders_RequiredDate">
<span<?= $orders->RequiredDate->viewAttributes() ?>>
<?= $orders->RequiredDate->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($orders->ShippedDate->Visible) { // ShippedDate ?>
        <tr id="r_ShippedDate">
            <td class="<?= $orders->TableLeftColumnClass ?>"><?= $orders->ShippedDate->caption() ?></td>
            <td <?= $orders->ShippedDate->cellAttributes() ?>>
<span id="el_orders_ShippedDate">
<span<?= $orders->ShippedDate->viewAttributes() ?>>
<?= $orders->ShippedDate->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($orders->ShipperID->Visible) { // ShipperID ?>
        <tr id="r_ShipperID">
            <td class="<?= $orders->TableLeftColumnClass ?>"><?= $orders->ShipperID->caption() ?></td>
            <td <?= $orders->ShipperID->cellAttributes() ?>>
<span id="el_orders_ShipperID">
<span<?= $orders->ShipperID->viewAttributes() ?>>
<?= $orders->ShipperID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($orders->Freight->Visible) { // Freight ?>
        <tr id="r_Freight">
            <td class="<?= $orders->TableLeftColumnClass ?>"><?= $orders->Freight->caption() ?></td>
            <td <?= $orders->Freight->cellAttributes() ?>>
<span id="el_orders_Freight">
<span<?= $orders->Freight->viewAttributes() ?>>
<?= $orders->Freight->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($orders->ShipName->Visible) { // ShipName ?>
        <tr id="r_ShipName">
            <td class="<?= $orders->TableLeftColumnClass ?>"><?= $orders->ShipName->caption() ?></td>
            <td <?= $orders->ShipName->cellAttributes() ?>>
<span id="el_orders_ShipName">
<span<?= $orders->ShipName->viewAttributes() ?>>
<?= $orders->ShipName->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($orders->ShipAddress->Visible) { // ShipAddress ?>
        <tr id="r_ShipAddress">
            <td class="<?= $orders->TableLeftColumnClass ?>"><?= $orders->ShipAddress->caption() ?></td>
            <td <?= $orders->ShipAddress->cellAttributes() ?>>
<span id="el_orders_ShipAddress">
<span<?= $orders->ShipAddress->viewAttributes() ?>>
<?= $orders->ShipAddress->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($orders->ShipCity->Visible) { // ShipCity ?>
        <tr id="r_ShipCity">
            <td class="<?= $orders->TableLeftColumnClass ?>"><?= $orders->ShipCity->caption() ?></td>
            <td <?= $orders->ShipCity->cellAttributes() ?>>
<span id="el_orders_ShipCity">
<span<?= $orders->ShipCity->viewAttributes() ?>>
<?= $orders->ShipCity->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($orders->ShipRegion->Visible) { // ShipRegion ?>
        <tr id="r_ShipRegion">
            <td class="<?= $orders->TableLeftColumnClass ?>"><?= $orders->ShipRegion->caption() ?></td>
            <td <?= $orders->ShipRegion->cellAttributes() ?>>
<span id="el_orders_ShipRegion">
<span<?= $orders->ShipRegion->viewAttributes() ?>>
<?= $orders->ShipRegion->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($orders->ShipPostalCode->Visible) { // ShipPostalCode ?>
        <tr id="r_ShipPostalCode">
            <td class="<?= $orders->TableLeftColumnClass ?>"><?= $orders->ShipPostalCode->caption() ?></td>
            <td <?= $orders->ShipPostalCode->cellAttributes() ?>>
<span id="el_orders_ShipPostalCode">
<span<?= $orders->ShipPostalCode->viewAttributes() ?>>
<?= $orders->ShipPostalCode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($orders->ShipCountry->Visible) { // ShipCountry ?>
        <tr id="r_ShipCountry">
            <td class="<?= $orders->TableLeftColumnClass ?>"><?= $orders->ShipCountry->caption() ?></td>
            <td <?= $orders->ShipCountry->cellAttributes() ?>>
<span id="el_orders_ShipCountry">
<span<?= $orders->ShipCountry->viewAttributes() ?>>
<?= $orders->ShipCountry->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

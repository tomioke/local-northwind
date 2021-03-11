<?php

namespace PHPMaker2021\northwindapi;

// Table
$suppliers = Container("suppliers");
?>
<?php if ($suppliers->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_suppliersmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($suppliers->SupplierID->Visible) { // SupplierID ?>
        <tr id="r_SupplierID">
            <td class="<?= $suppliers->TableLeftColumnClass ?>"><?= $suppliers->SupplierID->caption() ?></td>
            <td <?= $suppliers->SupplierID->cellAttributes() ?>>
<span id="el_suppliers_SupplierID">
<span<?= $suppliers->SupplierID->viewAttributes() ?>>
<?= $suppliers->SupplierID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suppliers->CompanyName->Visible) { // CompanyName ?>
        <tr id="r_CompanyName">
            <td class="<?= $suppliers->TableLeftColumnClass ?>"><?= $suppliers->CompanyName->caption() ?></td>
            <td <?= $suppliers->CompanyName->cellAttributes() ?>>
<span id="el_suppliers_CompanyName">
<span<?= $suppliers->CompanyName->viewAttributes() ?>>
<?= $suppliers->CompanyName->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suppliers->ContactName->Visible) { // ContactName ?>
        <tr id="r_ContactName">
            <td class="<?= $suppliers->TableLeftColumnClass ?>"><?= $suppliers->ContactName->caption() ?></td>
            <td <?= $suppliers->ContactName->cellAttributes() ?>>
<span id="el_suppliers_ContactName">
<span<?= $suppliers->ContactName->viewAttributes() ?>>
<?= $suppliers->ContactName->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suppliers->ContactTitle->Visible) { // ContactTitle ?>
        <tr id="r_ContactTitle">
            <td class="<?= $suppliers->TableLeftColumnClass ?>"><?= $suppliers->ContactTitle->caption() ?></td>
            <td <?= $suppliers->ContactTitle->cellAttributes() ?>>
<span id="el_suppliers_ContactTitle">
<span<?= $suppliers->ContactTitle->viewAttributes() ?>>
<?= $suppliers->ContactTitle->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suppliers->Address->Visible) { // Address ?>
        <tr id="r_Address">
            <td class="<?= $suppliers->TableLeftColumnClass ?>"><?= $suppliers->Address->caption() ?></td>
            <td <?= $suppliers->Address->cellAttributes() ?>>
<span id="el_suppliers_Address">
<span<?= $suppliers->Address->viewAttributes() ?>>
<?= $suppliers->Address->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suppliers->City->Visible) { // City ?>
        <tr id="r_City">
            <td class="<?= $suppliers->TableLeftColumnClass ?>"><?= $suppliers->City->caption() ?></td>
            <td <?= $suppliers->City->cellAttributes() ?>>
<span id="el_suppliers_City">
<span<?= $suppliers->City->viewAttributes() ?>>
<?= $suppliers->City->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suppliers->Region->Visible) { // Region ?>
        <tr id="r_Region">
            <td class="<?= $suppliers->TableLeftColumnClass ?>"><?= $suppliers->Region->caption() ?></td>
            <td <?= $suppliers->Region->cellAttributes() ?>>
<span id="el_suppliers_Region">
<span<?= $suppliers->Region->viewAttributes() ?>>
<?= $suppliers->Region->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suppliers->PostalCode->Visible) { // PostalCode ?>
        <tr id="r_PostalCode">
            <td class="<?= $suppliers->TableLeftColumnClass ?>"><?= $suppliers->PostalCode->caption() ?></td>
            <td <?= $suppliers->PostalCode->cellAttributes() ?>>
<span id="el_suppliers_PostalCode">
<span<?= $suppliers->PostalCode->viewAttributes() ?>>
<?= $suppliers->PostalCode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suppliers->Country->Visible) { // Country ?>
        <tr id="r_Country">
            <td class="<?= $suppliers->TableLeftColumnClass ?>"><?= $suppliers->Country->caption() ?></td>
            <td <?= $suppliers->Country->cellAttributes() ?>>
<span id="el_suppliers_Country">
<span<?= $suppliers->Country->viewAttributes() ?>>
<?= $suppliers->Country->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suppliers->Phone->Visible) { // Phone ?>
        <tr id="r_Phone">
            <td class="<?= $suppliers->TableLeftColumnClass ?>"><?= $suppliers->Phone->caption() ?></td>
            <td <?= $suppliers->Phone->cellAttributes() ?>>
<span id="el_suppliers_Phone">
<span<?= $suppliers->Phone->viewAttributes() ?>>
<?= $suppliers->Phone->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suppliers->Fax->Visible) { // Fax ?>
        <tr id="r_Fax">
            <td class="<?= $suppliers->TableLeftColumnClass ?>"><?= $suppliers->Fax->caption() ?></td>
            <td <?= $suppliers->Fax->cellAttributes() ?>>
<span id="el_suppliers_Fax">
<span<?= $suppliers->Fax->viewAttributes() ?>>
<?= $suppliers->Fax->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suppliers->HomePage->Visible) { // HomePage ?>
        <tr id="r_HomePage">
            <td class="<?= $suppliers->TableLeftColumnClass ?>"><?= $suppliers->HomePage->caption() ?></td>
            <td <?= $suppliers->HomePage->cellAttributes() ?>>
<span id="el_suppliers_HomePage">
<span<?= $suppliers->HomePage->viewAttributes() ?>>
<?= $suppliers->HomePage->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

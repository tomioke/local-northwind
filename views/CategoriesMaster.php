<?php

namespace PHPMaker2021\northwindapi;

// Table
$categories = Container("categories");
?>
<?php if ($categories->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_categoriesmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($categories->CategoryName->Visible) { // CategoryName ?>
        <tr id="r_CategoryName">
            <td class="<?= $categories->TableLeftColumnClass ?>"><?= $categories->CategoryName->caption() ?></td>
            <td <?= $categories->CategoryName->cellAttributes() ?>>
<span id="el_categories_CategoryName">
<span<?= $categories->CategoryName->viewAttributes() ?>>
<?= $categories->CategoryName->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($categories->Description->Visible) { // Description ?>
        <tr id="r_Description">
            <td class="<?= $categories->TableLeftColumnClass ?>"><?= $categories->Description->caption() ?></td>
            <td <?= $categories->Description->cellAttributes() ?>>
<span id="el_categories_Description">
<span<?= $categories->Description->viewAttributes() ?>>
<?= $categories->Description->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($categories->Picture->Visible) { // Picture ?>
        <tr id="r_Picture">
            <td class="<?= $categories->TableLeftColumnClass ?>"><?= $categories->Picture->caption() ?></td>
            <td <?= $categories->Picture->cellAttributes() ?>>
<span id="el_categories_Picture">
<span>
<?= GetFileViewTag($categories->Picture, $categories->Picture->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

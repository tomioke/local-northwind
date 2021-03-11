<?php

namespace PHPMaker2021\northwindapi;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(12, "mci_Aktivitas", $MenuLanguage->MenuPhrase("12", "MenuText"), "", -1, "", true, false, true, "far fa-clipboard", "", false);
$sideMenu->addMenuItem(5, "mi_order_details", $MenuLanguage->MenuPhrase("5", "MenuText"), $MenuRelativePath . "OrderDetailsList?cmd=resetall", 12, "", true, false, false, "", "", false);
$sideMenu->addMenuItem(6, "mi_orders", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "OrdersList", 12, "", true, false, false, "", "", false);
$sideMenu->addMenuItem(13, "mci_Master_Data", $MenuLanguage->MenuPhrase("13", "MenuText"), "", -1, "", true, false, true, "fas fa-database", "", false);
$sideMenu->addMenuItem(2, "mi_customers", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "CustomersList", 13, "", true, false, false, "", "", false);
$sideMenu->addMenuItem(1, "mi_categories", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "CategoriesList", 13, "", true, false, false, "", "", false);
$sideMenu->addMenuItem(3, "mi_employees", $MenuLanguage->MenuPhrase("3", "MenuText"), $MenuRelativePath . "EmployeesList", 13, "", true, false, false, "", "", false);
$sideMenu->addMenuItem(4, "mi_employeeterritories", $MenuLanguage->MenuPhrase("4", "MenuText"), $MenuRelativePath . "EmployeeterritoriesList", 13, "", true, false, false, "", "", false);
$sideMenu->addMenuItem(7, "mi_products", $MenuLanguage->MenuPhrase("7", "MenuText"), $MenuRelativePath . "ProductsList", 13, "", true, false, false, "", "", false);
$sideMenu->addMenuItem(8, "mi_region", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "RegionList", 13, "", true, false, false, "", "", false);
$sideMenu->addMenuItem(11, "mi_territories", $MenuLanguage->MenuPhrase("11", "MenuText"), $MenuRelativePath . "TerritoriesList", 13, "", true, false, false, "", "", false);
$sideMenu->addMenuItem(9, "mi_shippers", $MenuLanguage->MenuPhrase("9", "MenuText"), $MenuRelativePath . "ShippersList", 13, "", true, false, false, "", "", false);
$sideMenu->addMenuItem(10, "mi_suppliers", $MenuLanguage->MenuPhrase("10", "MenuText"), $MenuRelativePath . "SuppliersList", 13, "", true, false, false, "", "", false);
echo $sideMenu->toScript();

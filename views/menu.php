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
$sideMenu->addMenuItem(12, "mci_Aktivitas_", $MenuLanguage->MenuPhrase("12", "MenuText"), "", -1, "", true, false, true, "far fa-clipboard", "", false);
$sideMenu->addMenuItem(5, "mi_order_details", $MenuLanguage->MenuPhrase("5", "MenuText"), $MenuRelativePath . "OrderDetailsList?cmd=resetall", 12, "", IsLoggedIn() || AllowListMenu('{BAB9C3E0-424D-4BD1-855B-3C91D7475FC2}order_details'), false, false, "", "", false);
$sideMenu->addMenuItem(6, "mi_orders", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "OrdersList", 12, "", IsLoggedIn() || AllowListMenu('{BAB9C3E0-424D-4BD1-855B-3C91D7475FC2}orders'), false, false, "", "", false);
$sideMenu->addMenuItem(13, "mci_Master_Data", $MenuLanguage->MenuPhrase("13", "MenuText"), "", -1, "", true, false, true, "fas fa-database", "", false);
$sideMenu->addMenuItem(2, "mi_customers", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "CustomersList", 13, "", IsLoggedIn() || AllowListMenu('{BAB9C3E0-424D-4BD1-855B-3C91D7475FC2}customers'), false, false, "", "", false);
$sideMenu->addMenuItem(1, "mi_categories", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "CategoriesList", 13, "", IsLoggedIn() || AllowListMenu('{BAB9C3E0-424D-4BD1-855B-3C91D7475FC2}categories'), false, false, "", "", false);
$sideMenu->addMenuItem(3, "mi_employees", $MenuLanguage->MenuPhrase("3", "MenuText"), $MenuRelativePath . "EmployeesList", 13, "", IsLoggedIn() || AllowListMenu('{BAB9C3E0-424D-4BD1-855B-3C91D7475FC2}employees'), false, false, "", "", false);
$sideMenu->addMenuItem(4, "mi_employeeterritories", $MenuLanguage->MenuPhrase("4", "MenuText"), $MenuRelativePath . "EmployeeterritoriesList?cmd=resetall", 13, "", IsLoggedIn() || AllowListMenu('{BAB9C3E0-424D-4BD1-855B-3C91D7475FC2}employeeterritories'), false, false, "", "", false);
$sideMenu->addMenuItem(8, "mi_region", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "RegionList", 13, "", IsLoggedIn() || AllowListMenu('{BAB9C3E0-424D-4BD1-855B-3C91D7475FC2}region'), false, false, "", "", false);
$sideMenu->addMenuItem(11, "mi_territories", $MenuLanguage->MenuPhrase("11", "MenuText"), $MenuRelativePath . "TerritoriesList", 13, "", IsLoggedIn() || AllowListMenu('{BAB9C3E0-424D-4BD1-855B-3C91D7475FC2}territories'), false, false, "", "", false);
$sideMenu->addMenuItem(9, "mi_shippers", $MenuLanguage->MenuPhrase("9", "MenuText"), $MenuRelativePath . "ShippersList", 13, "", IsLoggedIn() || AllowListMenu('{BAB9C3E0-424D-4BD1-855B-3C91D7475FC2}shippers'), false, false, "", "", false);
$sideMenu->addMenuItem(10, "mi_suppliers", $MenuLanguage->MenuPhrase("10", "MenuText"), $MenuRelativePath . "SuppliersList", 13, "", IsLoggedIn() || AllowListMenu('{BAB9C3E0-424D-4BD1-855B-3C91D7475FC2}suppliers'), false, false, "", "", false);
echo $sideMenu->toScript();

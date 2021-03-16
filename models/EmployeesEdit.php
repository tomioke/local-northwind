<?php

namespace PHPMaker2021\northwindapi;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class EmployeesEdit extends Employees
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'employees';

    // Page object name
    public $PageObjName = "EmployeesEdit";

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (employees)
        if (!isset($GLOBALS["employees"]) || get_class($GLOBALS["employees"]) == PROJECT_NAMESPACE . "employees") {
            $GLOBALS["employees"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'employees');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("employees"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "EmployeesView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['EmployeeID'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->EmployeeID->Visible = false;
        }
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->EmployeeID->setVisibility();
        $this->LastName->setVisibility();
        $this->FirstName->setVisibility();
        $this->Title->setVisibility();
        $this->TitleOfCourtesy->setVisibility();
        $this->BirthDate->setVisibility();
        $this->HireDate->setVisibility();
        $this->Address->setVisibility();
        $this->City->setVisibility();
        $this->Region->setVisibility();
        $this->PostalCode->setVisibility();
        $this->Country->setVisibility();
        $this->HomePhone->setVisibility();
        $this->Extension->setVisibility();
        $this->Photo->setVisibility();
        $this->Notes->setVisibility();
        $this->ReportsTo->setVisibility();
        $this->PhotoPath->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("EmployeeID") ?? Key(0) ?? Route(2)) !== null) {
                $this->EmployeeID->setQueryStringValue($keyValue);
                $this->EmployeeID->setOldValue($this->EmployeeID->QueryStringValue);
            } elseif (Post("EmployeeID") !== null) {
                $this->EmployeeID->setFormValue(Post("EmployeeID"));
                $this->EmployeeID->setOldValue($this->EmployeeID->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("EmployeeID") ?? Route("EmployeeID")) !== null) {
                    $this->EmployeeID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->EmployeeID->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values

            // Set up detail parameters
            $this->setupDetailParms();
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("EmployeesList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                if ($this->getCurrentDetailTable() != "") { // Master/detail edit
                    $returnUrl = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
                } else {
                    $returnUrl = $this->getReturnUrl();
                }
                if (GetPageName($returnUrl) == "EmployeesList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Rendering event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'EmployeeID' first before field var 'x_EmployeeID'
        $val = $CurrentForm->hasValue("EmployeeID") ? $CurrentForm->getValue("EmployeeID") : $CurrentForm->getValue("x_EmployeeID");
        if (!$this->EmployeeID->IsDetailKey) {
            $this->EmployeeID->setFormValue($val);
        }

        // Check field name 'LastName' first before field var 'x_LastName'
        $val = $CurrentForm->hasValue("LastName") ? $CurrentForm->getValue("LastName") : $CurrentForm->getValue("x_LastName");
        if (!$this->LastName->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LastName->Visible = false; // Disable update for API request
            } else {
                $this->LastName->setFormValue($val);
            }
        }

        // Check field name 'FirstName' first before field var 'x_FirstName'
        $val = $CurrentForm->hasValue("FirstName") ? $CurrentForm->getValue("FirstName") : $CurrentForm->getValue("x_FirstName");
        if (!$this->FirstName->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FirstName->Visible = false; // Disable update for API request
            } else {
                $this->FirstName->setFormValue($val);
            }
        }

        // Check field name 'Title' first before field var 'x_Title'
        $val = $CurrentForm->hasValue("Title") ? $CurrentForm->getValue("Title") : $CurrentForm->getValue("x_Title");
        if (!$this->Title->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Title->Visible = false; // Disable update for API request
            } else {
                $this->Title->setFormValue($val);
            }
        }

        // Check field name 'TitleOfCourtesy' first before field var 'x_TitleOfCourtesy'
        $val = $CurrentForm->hasValue("TitleOfCourtesy") ? $CurrentForm->getValue("TitleOfCourtesy") : $CurrentForm->getValue("x_TitleOfCourtesy");
        if (!$this->TitleOfCourtesy->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TitleOfCourtesy->Visible = false; // Disable update for API request
            } else {
                $this->TitleOfCourtesy->setFormValue($val);
            }
        }

        // Check field name 'BirthDate' first before field var 'x_BirthDate'
        $val = $CurrentForm->hasValue("BirthDate") ? $CurrentForm->getValue("BirthDate") : $CurrentForm->getValue("x_BirthDate");
        if (!$this->BirthDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BirthDate->Visible = false; // Disable update for API request
            } else {
                $this->BirthDate->setFormValue($val);
            }
        }

        // Check field name 'HireDate' first before field var 'x_HireDate'
        $val = $CurrentForm->hasValue("HireDate") ? $CurrentForm->getValue("HireDate") : $CurrentForm->getValue("x_HireDate");
        if (!$this->HireDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->HireDate->Visible = false; // Disable update for API request
            } else {
                $this->HireDate->setFormValue($val);
            }
        }

        // Check field name 'Address' first before field var 'x_Address'
        $val = $CurrentForm->hasValue("Address") ? $CurrentForm->getValue("Address") : $CurrentForm->getValue("x_Address");
        if (!$this->Address->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Address->Visible = false; // Disable update for API request
            } else {
                $this->Address->setFormValue($val);
            }
        }

        // Check field name 'City' first before field var 'x_City'
        $val = $CurrentForm->hasValue("City") ? $CurrentForm->getValue("City") : $CurrentForm->getValue("x_City");
        if (!$this->City->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->City->Visible = false; // Disable update for API request
            } else {
                $this->City->setFormValue($val);
            }
        }

        // Check field name 'Region' first before field var 'x_Region'
        $val = $CurrentForm->hasValue("Region") ? $CurrentForm->getValue("Region") : $CurrentForm->getValue("x_Region");
        if (!$this->Region->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Region->Visible = false; // Disable update for API request
            } else {
                $this->Region->setFormValue($val);
            }
        }

        // Check field name 'PostalCode' first before field var 'x_PostalCode'
        $val = $CurrentForm->hasValue("PostalCode") ? $CurrentForm->getValue("PostalCode") : $CurrentForm->getValue("x_PostalCode");
        if (!$this->PostalCode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PostalCode->Visible = false; // Disable update for API request
            } else {
                $this->PostalCode->setFormValue($val);
            }
        }

        // Check field name 'Country' first before field var 'x_Country'
        $val = $CurrentForm->hasValue("Country") ? $CurrentForm->getValue("Country") : $CurrentForm->getValue("x_Country");
        if (!$this->Country->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Country->Visible = false; // Disable update for API request
            } else {
                $this->Country->setFormValue($val);
            }
        }

        // Check field name 'HomePhone' first before field var 'x_HomePhone'
        $val = $CurrentForm->hasValue("HomePhone") ? $CurrentForm->getValue("HomePhone") : $CurrentForm->getValue("x_HomePhone");
        if (!$this->HomePhone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->HomePhone->Visible = false; // Disable update for API request
            } else {
                $this->HomePhone->setFormValue($val);
            }
        }

        // Check field name 'Extension' first before field var 'x_Extension'
        $val = $CurrentForm->hasValue("Extension") ? $CurrentForm->getValue("Extension") : $CurrentForm->getValue("x_Extension");
        if (!$this->Extension->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Extension->Visible = false; // Disable update for API request
            } else {
                $this->Extension->setFormValue($val);
            }
        }

        // Check field name 'Photo' first before field var 'x_Photo'
        $val = $CurrentForm->hasValue("Photo") ? $CurrentForm->getValue("Photo") : $CurrentForm->getValue("x_Photo");
        if (!$this->Photo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Photo->Visible = false; // Disable update for API request
            } else {
                $this->Photo->setFormValue($val);
            }
        }

        // Check field name 'Notes' first before field var 'x_Notes'
        $val = $CurrentForm->hasValue("Notes") ? $CurrentForm->getValue("Notes") : $CurrentForm->getValue("x_Notes");
        if (!$this->Notes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Notes->Visible = false; // Disable update for API request
            } else {
                $this->Notes->setFormValue($val);
            }
        }

        // Check field name 'ReportsTo' first before field var 'x_ReportsTo'
        $val = $CurrentForm->hasValue("ReportsTo") ? $CurrentForm->getValue("ReportsTo") : $CurrentForm->getValue("x_ReportsTo");
        if (!$this->ReportsTo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ReportsTo->Visible = false; // Disable update for API request
            } else {
                $this->ReportsTo->setFormValue($val);
            }
        }

        // Check field name 'PhotoPath' first before field var 'x_PhotoPath'
        $val = $CurrentForm->hasValue("PhotoPath") ? $CurrentForm->getValue("PhotoPath") : $CurrentForm->getValue("x_PhotoPath");
        if (!$this->PhotoPath->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PhotoPath->Visible = false; // Disable update for API request
            } else {
                $this->PhotoPath->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->EmployeeID->CurrentValue = $this->EmployeeID->FormValue;
        $this->LastName->CurrentValue = $this->LastName->FormValue;
        $this->FirstName->CurrentValue = $this->FirstName->FormValue;
        $this->Title->CurrentValue = $this->Title->FormValue;
        $this->TitleOfCourtesy->CurrentValue = $this->TitleOfCourtesy->FormValue;
        $this->BirthDate->CurrentValue = $this->BirthDate->FormValue;
        $this->HireDate->CurrentValue = $this->HireDate->FormValue;
        $this->Address->CurrentValue = $this->Address->FormValue;
        $this->City->CurrentValue = $this->City->FormValue;
        $this->Region->CurrentValue = $this->Region->FormValue;
        $this->PostalCode->CurrentValue = $this->PostalCode->FormValue;
        $this->Country->CurrentValue = $this->Country->FormValue;
        $this->HomePhone->CurrentValue = $this->HomePhone->FormValue;
        $this->Extension->CurrentValue = $this->Extension->FormValue;
        $this->Photo->CurrentValue = $this->Photo->FormValue;
        $this->Notes->CurrentValue = $this->Notes->FormValue;
        $this->ReportsTo->CurrentValue = $this->ReportsTo->FormValue;
        $this->PhotoPath->CurrentValue = $this->PhotoPath->FormValue;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->EmployeeID->setDbValue($row['EmployeeID']);
        $this->LastName->setDbValue($row['LastName']);
        $this->FirstName->setDbValue($row['FirstName']);
        $this->Title->setDbValue($row['Title']);
        $this->TitleOfCourtesy->setDbValue($row['TitleOfCourtesy']);
        $this->BirthDate->setDbValue($row['BirthDate']);
        $this->HireDate->setDbValue($row['HireDate']);
        $this->Address->setDbValue($row['Address']);
        $this->City->setDbValue($row['City']);
        $this->Region->setDbValue($row['Region']);
        $this->PostalCode->setDbValue($row['PostalCode']);
        $this->Country->setDbValue($row['Country']);
        $this->HomePhone->setDbValue($row['HomePhone']);
        $this->Extension->setDbValue($row['Extension']);
        $this->Photo->setDbValue($row['Photo']);
        $this->Notes->setDbValue($row['Notes']);
        $this->ReportsTo->setDbValue($row['ReportsTo']);
        $this->PhotoPath->setDbValue($row['PhotoPath']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['EmployeeID'] = null;
        $row['LastName'] = null;
        $row['FirstName'] = null;
        $row['Title'] = null;
        $row['TitleOfCourtesy'] = null;
        $row['BirthDate'] = null;
        $row['HireDate'] = null;
        $row['Address'] = null;
        $row['City'] = null;
        $row['Region'] = null;
        $row['PostalCode'] = null;
        $row['Country'] = null;
        $row['HomePhone'] = null;
        $row['Extension'] = null;
        $row['Photo'] = null;
        $row['Notes'] = null;
        $row['ReportsTo'] = null;
        $row['PhotoPath'] = null;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // EmployeeID

        // LastName

        // FirstName

        // Title

        // TitleOfCourtesy

        // BirthDate

        // HireDate

        // Address

        // City

        // Region

        // PostalCode

        // Country

        // HomePhone

        // Extension

        // Photo

        // Notes

        // ReportsTo

        // PhotoPath
        if ($this->RowType == ROWTYPE_VIEW) {
            // EmployeeID
            $this->EmployeeID->ViewValue = $this->EmployeeID->CurrentValue;
            $this->EmployeeID->ViewValue = FormatNumber($this->EmployeeID->ViewValue, 0, -2, -2, -2);
            $this->EmployeeID->ViewCustomAttributes = "";

            // LastName
            $this->LastName->ViewValue = $this->LastName->CurrentValue;
            $this->LastName->ViewCustomAttributes = "";

            // FirstName
            $this->FirstName->ViewValue = $this->FirstName->CurrentValue;
            $this->FirstName->ViewCustomAttributes = "";

            // Title
            $this->Title->ViewValue = $this->Title->CurrentValue;
            $this->Title->ViewCustomAttributes = "";

            // TitleOfCourtesy
            $this->TitleOfCourtesy->ViewValue = $this->TitleOfCourtesy->CurrentValue;
            $this->TitleOfCourtesy->ViewCustomAttributes = "";

            // BirthDate
            $this->BirthDate->ViewValue = $this->BirthDate->CurrentValue;
            $this->BirthDate->ViewCustomAttributes = "";

            // HireDate
            $this->HireDate->ViewValue = $this->HireDate->CurrentValue;
            $this->HireDate->ViewCustomAttributes = "";

            // Address
            $this->Address->ViewValue = $this->Address->CurrentValue;
            $this->Address->ViewCustomAttributes = "";

            // City
            $this->City->ViewValue = $this->City->CurrentValue;
            $this->City->ViewCustomAttributes = "";

            // Region
            $this->Region->ViewValue = $this->Region->CurrentValue;
            $this->Region->ViewCustomAttributes = "";

            // PostalCode
            $this->PostalCode->ViewValue = $this->PostalCode->CurrentValue;
            $this->PostalCode->ViewCustomAttributes = "";

            // Country
            $this->Country->ViewValue = $this->Country->CurrentValue;
            $this->Country->ViewCustomAttributes = "";

            // HomePhone
            $this->HomePhone->ViewValue = $this->HomePhone->CurrentValue;
            $this->HomePhone->ViewCustomAttributes = "";

            // Extension
            $this->Extension->ViewValue = $this->Extension->CurrentValue;
            $this->Extension->ViewCustomAttributes = "";

            // Photo
            $this->Photo->ViewValue = $this->Photo->CurrentValue;
            $this->Photo->ViewCustomAttributes = "";

            // Notes
            $this->Notes->ViewValue = $this->Notes->CurrentValue;
            $this->Notes->ViewCustomAttributes = "";

            // ReportsTo
            $this->ReportsTo->ViewValue = $this->ReportsTo->CurrentValue;
            $this->ReportsTo->ViewCustomAttributes = "";

            // PhotoPath
            $this->PhotoPath->ViewValue = $this->PhotoPath->CurrentValue;
            $this->PhotoPath->ViewCustomAttributes = "";

            // EmployeeID
            $this->EmployeeID->LinkCustomAttributes = "";
            $this->EmployeeID->HrefValue = "";
            $this->EmployeeID->TooltipValue = "";

            // LastName
            $this->LastName->LinkCustomAttributes = "";
            $this->LastName->HrefValue = "";
            $this->LastName->TooltipValue = "";

            // FirstName
            $this->FirstName->LinkCustomAttributes = "";
            $this->FirstName->HrefValue = "";
            $this->FirstName->TooltipValue = "";

            // Title
            $this->Title->LinkCustomAttributes = "";
            $this->Title->HrefValue = "";
            $this->Title->TooltipValue = "";

            // TitleOfCourtesy
            $this->TitleOfCourtesy->LinkCustomAttributes = "";
            $this->TitleOfCourtesy->HrefValue = "";
            $this->TitleOfCourtesy->TooltipValue = "";

            // BirthDate
            $this->BirthDate->LinkCustomAttributes = "";
            $this->BirthDate->HrefValue = "";
            $this->BirthDate->TooltipValue = "";

            // HireDate
            $this->HireDate->LinkCustomAttributes = "";
            $this->HireDate->HrefValue = "";
            $this->HireDate->TooltipValue = "";

            // Address
            $this->Address->LinkCustomAttributes = "";
            $this->Address->HrefValue = "";
            $this->Address->TooltipValue = "";

            // City
            $this->City->LinkCustomAttributes = "";
            $this->City->HrefValue = "";
            $this->City->TooltipValue = "";

            // Region
            $this->Region->LinkCustomAttributes = "";
            $this->Region->HrefValue = "";
            $this->Region->TooltipValue = "";

            // PostalCode
            $this->PostalCode->LinkCustomAttributes = "";
            $this->PostalCode->HrefValue = "";
            $this->PostalCode->TooltipValue = "";

            // Country
            $this->Country->LinkCustomAttributes = "";
            $this->Country->HrefValue = "";
            $this->Country->TooltipValue = "";

            // HomePhone
            $this->HomePhone->LinkCustomAttributes = "";
            $this->HomePhone->HrefValue = "";
            $this->HomePhone->TooltipValue = "";

            // Extension
            $this->Extension->LinkCustomAttributes = "";
            $this->Extension->HrefValue = "";
            $this->Extension->TooltipValue = "";

            // Photo
            $this->Photo->LinkCustomAttributes = "";
            $this->Photo->HrefValue = "";
            $this->Photo->TooltipValue = "";

            // Notes
            $this->Notes->LinkCustomAttributes = "";
            $this->Notes->HrefValue = "";
            $this->Notes->TooltipValue = "";

            // ReportsTo
            $this->ReportsTo->LinkCustomAttributes = "";
            $this->ReportsTo->HrefValue = "";
            $this->ReportsTo->TooltipValue = "";

            // PhotoPath
            $this->PhotoPath->LinkCustomAttributes = "";
            $this->PhotoPath->HrefValue = "";
            $this->PhotoPath->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // EmployeeID
            $this->EmployeeID->EditAttrs["class"] = "form-control";
            $this->EmployeeID->EditCustomAttributes = "";
            $this->EmployeeID->EditValue = $this->EmployeeID->CurrentValue;
            $this->EmployeeID->EditValue = FormatNumber($this->EmployeeID->EditValue, 0, -2, -2, -2);
            $this->EmployeeID->ViewCustomAttributes = "";

            // LastName
            $this->LastName->EditAttrs["class"] = "form-control";
            $this->LastName->EditCustomAttributes = "";
            if (!$this->LastName->Raw) {
                $this->LastName->CurrentValue = HtmlDecode($this->LastName->CurrentValue);
            }
            $this->LastName->EditValue = HtmlEncode($this->LastName->CurrentValue);
            $this->LastName->PlaceHolder = RemoveHtml($this->LastName->caption());

            // FirstName
            $this->FirstName->EditAttrs["class"] = "form-control";
            $this->FirstName->EditCustomAttributes = "";
            if (!$this->FirstName->Raw) {
                $this->FirstName->CurrentValue = HtmlDecode($this->FirstName->CurrentValue);
            }
            $this->FirstName->EditValue = HtmlEncode($this->FirstName->CurrentValue);
            $this->FirstName->PlaceHolder = RemoveHtml($this->FirstName->caption());

            // Title
            $this->Title->EditAttrs["class"] = "form-control";
            $this->Title->EditCustomAttributes = "";
            if (!$this->Title->Raw) {
                $this->Title->CurrentValue = HtmlDecode($this->Title->CurrentValue);
            }
            $this->Title->EditValue = HtmlEncode($this->Title->CurrentValue);
            $this->Title->PlaceHolder = RemoveHtml($this->Title->caption());

            // TitleOfCourtesy
            $this->TitleOfCourtesy->EditAttrs["class"] = "form-control";
            $this->TitleOfCourtesy->EditCustomAttributes = "";
            if (!$this->TitleOfCourtesy->Raw) {
                $this->TitleOfCourtesy->CurrentValue = HtmlDecode($this->TitleOfCourtesy->CurrentValue);
            }
            $this->TitleOfCourtesy->EditValue = HtmlEncode($this->TitleOfCourtesy->CurrentValue);
            $this->TitleOfCourtesy->PlaceHolder = RemoveHtml($this->TitleOfCourtesy->caption());

            // BirthDate
            $this->BirthDate->EditAttrs["class"] = "form-control";
            $this->BirthDate->EditCustomAttributes = "";
            if (!$this->BirthDate->Raw) {
                $this->BirthDate->CurrentValue = HtmlDecode($this->BirthDate->CurrentValue);
            }
            $this->BirthDate->EditValue = HtmlEncode($this->BirthDate->CurrentValue);
            $this->BirthDate->PlaceHolder = RemoveHtml($this->BirthDate->caption());

            // HireDate
            $this->HireDate->EditAttrs["class"] = "form-control";
            $this->HireDate->EditCustomAttributes = "";
            if (!$this->HireDate->Raw) {
                $this->HireDate->CurrentValue = HtmlDecode($this->HireDate->CurrentValue);
            }
            $this->HireDate->EditValue = HtmlEncode($this->HireDate->CurrentValue);
            $this->HireDate->PlaceHolder = RemoveHtml($this->HireDate->caption());

            // Address
            $this->Address->EditAttrs["class"] = "form-control";
            $this->Address->EditCustomAttributes = "";
            if (!$this->Address->Raw) {
                $this->Address->CurrentValue = HtmlDecode($this->Address->CurrentValue);
            }
            $this->Address->EditValue = HtmlEncode($this->Address->CurrentValue);
            $this->Address->PlaceHolder = RemoveHtml($this->Address->caption());

            // City
            $this->City->EditAttrs["class"] = "form-control";
            $this->City->EditCustomAttributes = "";
            if (!$this->City->Raw) {
                $this->City->CurrentValue = HtmlDecode($this->City->CurrentValue);
            }
            $this->City->EditValue = HtmlEncode($this->City->CurrentValue);
            $this->City->PlaceHolder = RemoveHtml($this->City->caption());

            // Region
            $this->Region->EditAttrs["class"] = "form-control";
            $this->Region->EditCustomAttributes = "";
            if (!$this->Region->Raw) {
                $this->Region->CurrentValue = HtmlDecode($this->Region->CurrentValue);
            }
            $this->Region->EditValue = HtmlEncode($this->Region->CurrentValue);
            $this->Region->PlaceHolder = RemoveHtml($this->Region->caption());

            // PostalCode
            $this->PostalCode->EditAttrs["class"] = "form-control";
            $this->PostalCode->EditCustomAttributes = "";
            if (!$this->PostalCode->Raw) {
                $this->PostalCode->CurrentValue = HtmlDecode($this->PostalCode->CurrentValue);
            }
            $this->PostalCode->EditValue = HtmlEncode($this->PostalCode->CurrentValue);
            $this->PostalCode->PlaceHolder = RemoveHtml($this->PostalCode->caption());

            // Country
            $this->Country->EditAttrs["class"] = "form-control";
            $this->Country->EditCustomAttributes = "";
            if (!$this->Country->Raw) {
                $this->Country->CurrentValue = HtmlDecode($this->Country->CurrentValue);
            }
            $this->Country->EditValue = HtmlEncode($this->Country->CurrentValue);
            $this->Country->PlaceHolder = RemoveHtml($this->Country->caption());

            // HomePhone
            $this->HomePhone->EditAttrs["class"] = "form-control";
            $this->HomePhone->EditCustomAttributes = "";
            if (!$this->HomePhone->Raw) {
                $this->HomePhone->CurrentValue = HtmlDecode($this->HomePhone->CurrentValue);
            }
            $this->HomePhone->EditValue = HtmlEncode($this->HomePhone->CurrentValue);
            $this->HomePhone->PlaceHolder = RemoveHtml($this->HomePhone->caption());

            // Extension
            $this->Extension->EditAttrs["class"] = "form-control";
            $this->Extension->EditCustomAttributes = "";
            if (!$this->Extension->Raw) {
                $this->Extension->CurrentValue = HtmlDecode($this->Extension->CurrentValue);
            }
            $this->Extension->EditValue = HtmlEncode($this->Extension->CurrentValue);
            $this->Extension->PlaceHolder = RemoveHtml($this->Extension->caption());

            // Photo
            $this->Photo->EditAttrs["class"] = "form-control";
            $this->Photo->EditCustomAttributes = "";
            if (!$this->Photo->Raw) {
                $this->Photo->CurrentValue = HtmlDecode($this->Photo->CurrentValue);
            }
            $this->Photo->EditValue = HtmlEncode($this->Photo->CurrentValue);
            $this->Photo->PlaceHolder = RemoveHtml($this->Photo->caption());

            // Notes
            $this->Notes->EditAttrs["class"] = "form-control";
            $this->Notes->EditCustomAttributes = "";
            if (!$this->Notes->Raw) {
                $this->Notes->CurrentValue = HtmlDecode($this->Notes->CurrentValue);
            }
            $this->Notes->EditValue = HtmlEncode($this->Notes->CurrentValue);
            $this->Notes->PlaceHolder = RemoveHtml($this->Notes->caption());

            // ReportsTo
            $this->ReportsTo->EditAttrs["class"] = "form-control";
            $this->ReportsTo->EditCustomAttributes = "";
            if (!$this->ReportsTo->Raw) {
                $this->ReportsTo->CurrentValue = HtmlDecode($this->ReportsTo->CurrentValue);
            }
            $this->ReportsTo->EditValue = HtmlEncode($this->ReportsTo->CurrentValue);
            $this->ReportsTo->PlaceHolder = RemoveHtml($this->ReportsTo->caption());

            // PhotoPath
            $this->PhotoPath->EditAttrs["class"] = "form-control";
            $this->PhotoPath->EditCustomAttributes = "";
            if (!$this->PhotoPath->Raw) {
                $this->PhotoPath->CurrentValue = HtmlDecode($this->PhotoPath->CurrentValue);
            }
            $this->PhotoPath->EditValue = HtmlEncode($this->PhotoPath->CurrentValue);
            $this->PhotoPath->PlaceHolder = RemoveHtml($this->PhotoPath->caption());

            // Edit refer script

            // EmployeeID
            $this->EmployeeID->LinkCustomAttributes = "";
            $this->EmployeeID->HrefValue = "";

            // LastName
            $this->LastName->LinkCustomAttributes = "";
            $this->LastName->HrefValue = "";

            // FirstName
            $this->FirstName->LinkCustomAttributes = "";
            $this->FirstName->HrefValue = "";

            // Title
            $this->Title->LinkCustomAttributes = "";
            $this->Title->HrefValue = "";

            // TitleOfCourtesy
            $this->TitleOfCourtesy->LinkCustomAttributes = "";
            $this->TitleOfCourtesy->HrefValue = "";

            // BirthDate
            $this->BirthDate->LinkCustomAttributes = "";
            $this->BirthDate->HrefValue = "";

            // HireDate
            $this->HireDate->LinkCustomAttributes = "";
            $this->HireDate->HrefValue = "";

            // Address
            $this->Address->LinkCustomAttributes = "";
            $this->Address->HrefValue = "";

            // City
            $this->City->LinkCustomAttributes = "";
            $this->City->HrefValue = "";

            // Region
            $this->Region->LinkCustomAttributes = "";
            $this->Region->HrefValue = "";

            // PostalCode
            $this->PostalCode->LinkCustomAttributes = "";
            $this->PostalCode->HrefValue = "";

            // Country
            $this->Country->LinkCustomAttributes = "";
            $this->Country->HrefValue = "";

            // HomePhone
            $this->HomePhone->LinkCustomAttributes = "";
            $this->HomePhone->HrefValue = "";

            // Extension
            $this->Extension->LinkCustomAttributes = "";
            $this->Extension->HrefValue = "";

            // Photo
            $this->Photo->LinkCustomAttributes = "";
            $this->Photo->HrefValue = "";

            // Notes
            $this->Notes->LinkCustomAttributes = "";
            $this->Notes->HrefValue = "";

            // ReportsTo
            $this->ReportsTo->LinkCustomAttributes = "";
            $this->ReportsTo->HrefValue = "";

            // PhotoPath
            $this->PhotoPath->LinkCustomAttributes = "";
            $this->PhotoPath->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->EmployeeID->Required) {
            if (!$this->EmployeeID->IsDetailKey && EmptyValue($this->EmployeeID->FormValue)) {
                $this->EmployeeID->addErrorMessage(str_replace("%s", $this->EmployeeID->caption(), $this->EmployeeID->RequiredErrorMessage));
            }
        }
        if ($this->LastName->Required) {
            if (!$this->LastName->IsDetailKey && EmptyValue($this->LastName->FormValue)) {
                $this->LastName->addErrorMessage(str_replace("%s", $this->LastName->caption(), $this->LastName->RequiredErrorMessage));
            }
        }
        if ($this->FirstName->Required) {
            if (!$this->FirstName->IsDetailKey && EmptyValue($this->FirstName->FormValue)) {
                $this->FirstName->addErrorMessage(str_replace("%s", $this->FirstName->caption(), $this->FirstName->RequiredErrorMessage));
            }
        }
        if ($this->Title->Required) {
            if (!$this->Title->IsDetailKey && EmptyValue($this->Title->FormValue)) {
                $this->Title->addErrorMessage(str_replace("%s", $this->Title->caption(), $this->Title->RequiredErrorMessage));
            }
        }
        if ($this->TitleOfCourtesy->Required) {
            if (!$this->TitleOfCourtesy->IsDetailKey && EmptyValue($this->TitleOfCourtesy->FormValue)) {
                $this->TitleOfCourtesy->addErrorMessage(str_replace("%s", $this->TitleOfCourtesy->caption(), $this->TitleOfCourtesy->RequiredErrorMessage));
            }
        }
        if ($this->BirthDate->Required) {
            if (!$this->BirthDate->IsDetailKey && EmptyValue($this->BirthDate->FormValue)) {
                $this->BirthDate->addErrorMessage(str_replace("%s", $this->BirthDate->caption(), $this->BirthDate->RequiredErrorMessage));
            }
        }
        if ($this->HireDate->Required) {
            if (!$this->HireDate->IsDetailKey && EmptyValue($this->HireDate->FormValue)) {
                $this->HireDate->addErrorMessage(str_replace("%s", $this->HireDate->caption(), $this->HireDate->RequiredErrorMessage));
            }
        }
        if ($this->Address->Required) {
            if (!$this->Address->IsDetailKey && EmptyValue($this->Address->FormValue)) {
                $this->Address->addErrorMessage(str_replace("%s", $this->Address->caption(), $this->Address->RequiredErrorMessage));
            }
        }
        if ($this->City->Required) {
            if (!$this->City->IsDetailKey && EmptyValue($this->City->FormValue)) {
                $this->City->addErrorMessage(str_replace("%s", $this->City->caption(), $this->City->RequiredErrorMessage));
            }
        }
        if ($this->Region->Required) {
            if (!$this->Region->IsDetailKey && EmptyValue($this->Region->FormValue)) {
                $this->Region->addErrorMessage(str_replace("%s", $this->Region->caption(), $this->Region->RequiredErrorMessage));
            }
        }
        if ($this->PostalCode->Required) {
            if (!$this->PostalCode->IsDetailKey && EmptyValue($this->PostalCode->FormValue)) {
                $this->PostalCode->addErrorMessage(str_replace("%s", $this->PostalCode->caption(), $this->PostalCode->RequiredErrorMessage));
            }
        }
        if ($this->Country->Required) {
            if (!$this->Country->IsDetailKey && EmptyValue($this->Country->FormValue)) {
                $this->Country->addErrorMessage(str_replace("%s", $this->Country->caption(), $this->Country->RequiredErrorMessage));
            }
        }
        if ($this->HomePhone->Required) {
            if (!$this->HomePhone->IsDetailKey && EmptyValue($this->HomePhone->FormValue)) {
                $this->HomePhone->addErrorMessage(str_replace("%s", $this->HomePhone->caption(), $this->HomePhone->RequiredErrorMessage));
            }
        }
        if ($this->Extension->Required) {
            if (!$this->Extension->IsDetailKey && EmptyValue($this->Extension->FormValue)) {
                $this->Extension->addErrorMessage(str_replace("%s", $this->Extension->caption(), $this->Extension->RequiredErrorMessage));
            }
        }
        if ($this->Photo->Required) {
            if (!$this->Photo->IsDetailKey && EmptyValue($this->Photo->FormValue)) {
                $this->Photo->addErrorMessage(str_replace("%s", $this->Photo->caption(), $this->Photo->RequiredErrorMessage));
            }
        }
        if ($this->Notes->Required) {
            if (!$this->Notes->IsDetailKey && EmptyValue($this->Notes->FormValue)) {
                $this->Notes->addErrorMessage(str_replace("%s", $this->Notes->caption(), $this->Notes->RequiredErrorMessage));
            }
        }
        if ($this->ReportsTo->Required) {
            if (!$this->ReportsTo->IsDetailKey && EmptyValue($this->ReportsTo->FormValue)) {
                $this->ReportsTo->addErrorMessage(str_replace("%s", $this->ReportsTo->caption(), $this->ReportsTo->RequiredErrorMessage));
            }
        }
        if ($this->PhotoPath->Required) {
            if (!$this->PhotoPath->IsDetailKey && EmptyValue($this->PhotoPath->FormValue)) {
                $this->PhotoPath->addErrorMessage(str_replace("%s", $this->PhotoPath->caption(), $this->PhotoPath->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("EmployeeterritoriesGrid");
        if (in_array("employeeterritories", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Begin transaction
            if ($this->getCurrentDetailTable() != "") {
                $conn->beginTransaction();
            }

            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // LastName
            $this->LastName->setDbValueDef($rsnew, $this->LastName->CurrentValue, null, $this->LastName->ReadOnly);

            // FirstName
            $this->FirstName->setDbValueDef($rsnew, $this->FirstName->CurrentValue, null, $this->FirstName->ReadOnly);

            // Title
            $this->Title->setDbValueDef($rsnew, $this->Title->CurrentValue, null, $this->Title->ReadOnly);

            // TitleOfCourtesy
            $this->TitleOfCourtesy->setDbValueDef($rsnew, $this->TitleOfCourtesy->CurrentValue, null, $this->TitleOfCourtesy->ReadOnly);

            // BirthDate
            $this->BirthDate->setDbValueDef($rsnew, $this->BirthDate->CurrentValue, null, $this->BirthDate->ReadOnly);

            // HireDate
            $this->HireDate->setDbValueDef($rsnew, $this->HireDate->CurrentValue, null, $this->HireDate->ReadOnly);

            // Address
            $this->Address->setDbValueDef($rsnew, $this->Address->CurrentValue, null, $this->Address->ReadOnly);

            // City
            $this->City->setDbValueDef($rsnew, $this->City->CurrentValue, null, $this->City->ReadOnly);

            // Region
            $this->Region->setDbValueDef($rsnew, $this->Region->CurrentValue, null, $this->Region->ReadOnly);

            // PostalCode
            $this->PostalCode->setDbValueDef($rsnew, $this->PostalCode->CurrentValue, null, $this->PostalCode->ReadOnly);

            // Country
            $this->Country->setDbValueDef($rsnew, $this->Country->CurrentValue, null, $this->Country->ReadOnly);

            // HomePhone
            $this->HomePhone->setDbValueDef($rsnew, $this->HomePhone->CurrentValue, null, $this->HomePhone->ReadOnly);

            // Extension
            $this->Extension->setDbValueDef($rsnew, $this->Extension->CurrentValue, null, $this->Extension->ReadOnly);

            // Photo
            $this->Photo->setDbValueDef($rsnew, $this->Photo->CurrentValue, null, $this->Photo->ReadOnly);

            // Notes
            $this->Notes->setDbValueDef($rsnew, $this->Notes->CurrentValue, null, $this->Notes->ReadOnly);

            // ReportsTo
            $this->ReportsTo->setDbValueDef($rsnew, $this->ReportsTo->CurrentValue, null, $this->ReportsTo->ReadOnly);

            // PhotoPath
            $this->PhotoPath->setDbValueDef($rsnew, $this->PhotoPath->CurrentValue, null, $this->PhotoPath->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }

                // Update detail records
                $detailTblVar = explode(",", $this->getCurrentDetailTable());
                if ($editRow) {
                    $detailPage = Container("EmployeeterritoriesGrid");
                    if (in_array("employeeterritories", $detailTblVar) && $detailPage->DetailEdit) {
                        $editRow = $detailPage->gridUpdate();
                    }
                }

                // Commit/Rollback transaction
                if ($this->getCurrentDetailTable() != "") {
                    if ($editRow) {
                        $conn->commit(); // Commit transaction
                    } else {
                        $conn->rollback(); // Rollback transaction
                    }
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("employeeterritories", $detailTblVar)) {
                $detailPageObj = Container("EmployeeterritoriesGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->EmployeeID->IsDetailKey = true;
                    $detailPageObj->EmployeeID->CurrentValue = $this->EmployeeID->CurrentValue;
                    $detailPageObj->EmployeeID->setSessionValue($detailPageObj->EmployeeID->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("EmployeesList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}

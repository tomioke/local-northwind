<?php

namespace PHPMaker2021\northwindapi;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for employees
 */
class Employees extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $EmployeeID;
    public $LastName;
    public $FirstName;
    public $Title;
    public $TitleOfCourtesy;
    public $BirthDate;
    public $HireDate;
    public $Address;
    public $City;
    public $Region;
    public $PostalCode;
    public $Country;
    public $HomePhone;
    public $Extension;
    public $Photo;
    public $Notes;
    public $ReportsTo;
    public $PhotoPath;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'employees';
        $this->TableName = 'employees';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`employees`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // EmployeeID
        $this->EmployeeID = new DbField('employees', 'employees', 'x_EmployeeID', 'EmployeeID', '`EmployeeID`', '`EmployeeID`', 3, 11, -1, false, '`EmployeeID`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->EmployeeID->IsAutoIncrement = true; // Autoincrement field
        $this->EmployeeID->IsPrimaryKey = true; // Primary key field
        $this->EmployeeID->IsForeignKey = true; // Foreign key field
        $this->EmployeeID->Sortable = true; // Allow sort
        $this->EmployeeID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->EmployeeID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EmployeeID->Param, "CustomMsg");
        $this->Fields['EmployeeID'] = &$this->EmployeeID;

        // LastName
        $this->LastName = new DbField('employees', 'employees', 'x_LastName', 'LastName', '`LastName`', '`LastName`', 200, 255, -1, false, '`LastName`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->LastName->Sortable = true; // Allow sort
        $this->LastName->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->LastName->Param, "CustomMsg");
        $this->Fields['LastName'] = &$this->LastName;

        // FirstName
        $this->FirstName = new DbField('employees', 'employees', 'x_FirstName', 'FirstName', '`FirstName`', '`FirstName`', 200, 255, -1, false, '`FirstName`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->FirstName->Sortable = true; // Allow sort
        $this->FirstName->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->FirstName->Param, "CustomMsg");
        $this->Fields['FirstName'] = &$this->FirstName;

        // Title
        $this->Title = new DbField('employees', 'employees', 'x_Title', 'Title', '`Title`', '`Title`', 200, 255, -1, false, '`Title`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Title->Sortable = true; // Allow sort
        $this->Title->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Title->Param, "CustomMsg");
        $this->Fields['Title'] = &$this->Title;

        // TitleOfCourtesy
        $this->TitleOfCourtesy = new DbField('employees', 'employees', 'x_TitleOfCourtesy', 'TitleOfCourtesy', '`TitleOfCourtesy`', '`TitleOfCourtesy`', 200, 255, -1, false, '`TitleOfCourtesy`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TitleOfCourtesy->Sortable = true; // Allow sort
        $this->TitleOfCourtesy->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TitleOfCourtesy->Param, "CustomMsg");
        $this->Fields['TitleOfCourtesy'] = &$this->TitleOfCourtesy;

        // BirthDate
        $this->BirthDate = new DbField('employees', 'employees', 'x_BirthDate', 'BirthDate', '`BirthDate`', '`BirthDate`', 200, 255, -1, false, '`BirthDate`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BirthDate->Sortable = true; // Allow sort
        $this->BirthDate->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BirthDate->Param, "CustomMsg");
        $this->Fields['BirthDate'] = &$this->BirthDate;

        // HireDate
        $this->HireDate = new DbField('employees', 'employees', 'x_HireDate', 'HireDate', '`HireDate`', '`HireDate`', 200, 255, -1, false, '`HireDate`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->HireDate->Sortable = true; // Allow sort
        $this->HireDate->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->HireDate->Param, "CustomMsg");
        $this->Fields['HireDate'] = &$this->HireDate;

        // Address
        $this->Address = new DbField('employees', 'employees', 'x_Address', 'Address', '`Address`', '`Address`', 200, 255, -1, false, '`Address`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Address->Sortable = true; // Allow sort
        $this->Address->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Address->Param, "CustomMsg");
        $this->Fields['Address'] = &$this->Address;

        // City
        $this->City = new DbField('employees', 'employees', 'x_City', 'City', '`City`', '`City`', 200, 255, -1, false, '`City`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->City->Sortable = true; // Allow sort
        $this->City->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->City->Param, "CustomMsg");
        $this->Fields['City'] = &$this->City;

        // Region
        $this->Region = new DbField('employees', 'employees', 'x_Region', 'Region', '`Region`', '`Region`', 200, 255, -1, false, '`Region`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Region->Sortable = true; // Allow sort
        $this->Region->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Region->Param, "CustomMsg");
        $this->Fields['Region'] = &$this->Region;

        // PostalCode
        $this->PostalCode = new DbField('employees', 'employees', 'x_PostalCode', 'PostalCode', '`PostalCode`', '`PostalCode`', 200, 255, -1, false, '`PostalCode`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PostalCode->Sortable = true; // Allow sort
        $this->PostalCode->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PostalCode->Param, "CustomMsg");
        $this->Fields['PostalCode'] = &$this->PostalCode;

        // Country
        $this->Country = new DbField('employees', 'employees', 'x_Country', 'Country', '`Country`', '`Country`', 200, 255, -1, false, '`Country`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Country->Sortable = true; // Allow sort
        $this->Country->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Country->Param, "CustomMsg");
        $this->Fields['Country'] = &$this->Country;

        // HomePhone
        $this->HomePhone = new DbField('employees', 'employees', 'x_HomePhone', 'HomePhone', '`HomePhone`', '`HomePhone`', 200, 255, -1, false, '`HomePhone`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->HomePhone->Sortable = true; // Allow sort
        $this->HomePhone->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->HomePhone->Param, "CustomMsg");
        $this->Fields['HomePhone'] = &$this->HomePhone;

        // Extension
        $this->Extension = new DbField('employees', 'employees', 'x_Extension', 'Extension', '`Extension`', '`Extension`', 200, 255, -1, false, '`Extension`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Extension->Sortable = true; // Allow sort
        $this->Extension->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Extension->Param, "CustomMsg");
        $this->Fields['Extension'] = &$this->Extension;

        // Photo
        $this->Photo = new DbField('employees', 'employees', 'x_Photo', 'Photo', '`Photo`', '`Photo`', 200, 255, -1, false, '`Photo`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Photo->Sortable = true; // Allow sort
        $this->Photo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Photo->Param, "CustomMsg");
        $this->Fields['Photo'] = &$this->Photo;

        // Notes
        $this->Notes = new DbField('employees', 'employees', 'x_Notes', 'Notes', '`Notes`', '`Notes`', 200, 255, -1, false, '`Notes`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Notes->Sortable = true; // Allow sort
        $this->Notes->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Notes->Param, "CustomMsg");
        $this->Fields['Notes'] = &$this->Notes;

        // ReportsTo
        $this->ReportsTo = new DbField('employees', 'employees', 'x_ReportsTo', 'ReportsTo', '`ReportsTo`', '`ReportsTo`', 200, 255, -1, false, '`ReportsTo`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ReportsTo->Sortable = true; // Allow sort
        $this->ReportsTo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ReportsTo->Param, "CustomMsg");
        $this->Fields['ReportsTo'] = &$this->ReportsTo;

        // PhotoPath
        $this->PhotoPath = new DbField('employees', 'employees', 'x_PhotoPath', 'PhotoPath', '`PhotoPath`', '`PhotoPath`', 200, 255, -1, false, '`PhotoPath`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PhotoPath->Sortable = true; // Allow sort
        $this->PhotoPath->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PhotoPath->Param, "CustomMsg");
        $this->Fields['PhotoPath'] = &$this->PhotoPath;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE"));
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "employeeterritories") {
            $detailUrl = Container("employeeterritories")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_EmployeeID", $this->EmployeeID->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "EmployeesList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`employees`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->EmployeeID->setDbValue($conn->lastInsertId());
            $rs['EmployeeID'] = $this->EmployeeID->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // Cascade Update detail table 'employeeterritories'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['EmployeeID']) && $rsold['EmployeeID'] != $rs['EmployeeID'])) { // Update detail field 'EmployeeID'
            $cascadeUpdate = true;
            $rscascade['EmployeeID'] = $rs['EmployeeID'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("employeeterritories")->loadRs("`EmployeeID` = " . QuotedValue($rsold['EmployeeID'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'EmployeeID';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $fldname = 'TerritoryID';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("employeeterritories")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("employeeterritories")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("employeeterritories")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('EmployeeID', $rs)) {
                AddFilter($where, QuotedName('EmployeeID', $this->Dbid) . '=' . QuotedValue($rs['EmployeeID'], $this->EmployeeID->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;

        // Cascade delete detail table 'employeeterritories'
        $dtlrows = Container("employeeterritories")->loadRs("`EmployeeID` = " . QuotedValue($rs['EmployeeID'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("employeeterritories")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("employeeterritories")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("employeeterritories")->rowDeleted($dtlrow);
            }
        }
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->EmployeeID->DbValue = $row['EmployeeID'];
        $this->LastName->DbValue = $row['LastName'];
        $this->FirstName->DbValue = $row['FirstName'];
        $this->Title->DbValue = $row['Title'];
        $this->TitleOfCourtesy->DbValue = $row['TitleOfCourtesy'];
        $this->BirthDate->DbValue = $row['BirthDate'];
        $this->HireDate->DbValue = $row['HireDate'];
        $this->Address->DbValue = $row['Address'];
        $this->City->DbValue = $row['City'];
        $this->Region->DbValue = $row['Region'];
        $this->PostalCode->DbValue = $row['PostalCode'];
        $this->Country->DbValue = $row['Country'];
        $this->HomePhone->DbValue = $row['HomePhone'];
        $this->Extension->DbValue = $row['Extension'];
        $this->Photo->DbValue = $row['Photo'];
        $this->Notes->DbValue = $row['Notes'];
        $this->ReportsTo->DbValue = $row['ReportsTo'];
        $this->PhotoPath->DbValue = $row['PhotoPath'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`EmployeeID` = @EmployeeID@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->EmployeeID->CurrentValue : $this->EmployeeID->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->EmployeeID->CurrentValue = $keys[0];
            } else {
                $this->EmployeeID->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('EmployeeID', $row) ? $row['EmployeeID'] : null;
        } else {
            $val = $this->EmployeeID->OldValue !== null ? $this->EmployeeID->OldValue : $this->EmployeeID->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@EmployeeID@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("EmployeesList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "EmployeesView") {
            return $Language->phrase("View");
        } elseif ($pageName == "EmployeesEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "EmployeesAdd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "EmployeesView";
            case Config("API_ADD_ACTION"):
                return "EmployeesAdd";
            case Config("API_EDIT_ACTION"):
                return "EmployeesEdit";
            case Config("API_DELETE_ACTION"):
                return "EmployeesDelete";
            case Config("API_LIST_ACTION"):
                return "EmployeesList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "EmployeesList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("EmployeesView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("EmployeesView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "EmployeesAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "EmployeesAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("EmployeesEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("EmployeesEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("EmployeesAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("EmployeesAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("EmployeesDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "EmployeeID:" . JsonEncode($this->EmployeeID->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->EmployeeID->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->EmployeeID->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("EmployeeID") ?? Route("EmployeeID")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->EmployeeID->CurrentValue = $key;
            } else {
                $this->EmployeeID->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
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

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

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
        $this->LastName->EditValue = $this->LastName->CurrentValue;
        $this->LastName->PlaceHolder = RemoveHtml($this->LastName->caption());

        // FirstName
        $this->FirstName->EditAttrs["class"] = "form-control";
        $this->FirstName->EditCustomAttributes = "";
        if (!$this->FirstName->Raw) {
            $this->FirstName->CurrentValue = HtmlDecode($this->FirstName->CurrentValue);
        }
        $this->FirstName->EditValue = $this->FirstName->CurrentValue;
        $this->FirstName->PlaceHolder = RemoveHtml($this->FirstName->caption());

        // Title
        $this->Title->EditAttrs["class"] = "form-control";
        $this->Title->EditCustomAttributes = "";
        if (!$this->Title->Raw) {
            $this->Title->CurrentValue = HtmlDecode($this->Title->CurrentValue);
        }
        $this->Title->EditValue = $this->Title->CurrentValue;
        $this->Title->PlaceHolder = RemoveHtml($this->Title->caption());

        // TitleOfCourtesy
        $this->TitleOfCourtesy->EditAttrs["class"] = "form-control";
        $this->TitleOfCourtesy->EditCustomAttributes = "";
        if (!$this->TitleOfCourtesy->Raw) {
            $this->TitleOfCourtesy->CurrentValue = HtmlDecode($this->TitleOfCourtesy->CurrentValue);
        }
        $this->TitleOfCourtesy->EditValue = $this->TitleOfCourtesy->CurrentValue;
        $this->TitleOfCourtesy->PlaceHolder = RemoveHtml($this->TitleOfCourtesy->caption());

        // BirthDate
        $this->BirthDate->EditAttrs["class"] = "form-control";
        $this->BirthDate->EditCustomAttributes = "";
        if (!$this->BirthDate->Raw) {
            $this->BirthDate->CurrentValue = HtmlDecode($this->BirthDate->CurrentValue);
        }
        $this->BirthDate->EditValue = $this->BirthDate->CurrentValue;
        $this->BirthDate->PlaceHolder = RemoveHtml($this->BirthDate->caption());

        // HireDate
        $this->HireDate->EditAttrs["class"] = "form-control";
        $this->HireDate->EditCustomAttributes = "";
        if (!$this->HireDate->Raw) {
            $this->HireDate->CurrentValue = HtmlDecode($this->HireDate->CurrentValue);
        }
        $this->HireDate->EditValue = $this->HireDate->CurrentValue;
        $this->HireDate->PlaceHolder = RemoveHtml($this->HireDate->caption());

        // Address
        $this->Address->EditAttrs["class"] = "form-control";
        $this->Address->EditCustomAttributes = "";
        if (!$this->Address->Raw) {
            $this->Address->CurrentValue = HtmlDecode($this->Address->CurrentValue);
        }
        $this->Address->EditValue = $this->Address->CurrentValue;
        $this->Address->PlaceHolder = RemoveHtml($this->Address->caption());

        // City
        $this->City->EditAttrs["class"] = "form-control";
        $this->City->EditCustomAttributes = "";
        if (!$this->City->Raw) {
            $this->City->CurrentValue = HtmlDecode($this->City->CurrentValue);
        }
        $this->City->EditValue = $this->City->CurrentValue;
        $this->City->PlaceHolder = RemoveHtml($this->City->caption());

        // Region
        $this->Region->EditAttrs["class"] = "form-control";
        $this->Region->EditCustomAttributes = "";
        if (!$this->Region->Raw) {
            $this->Region->CurrentValue = HtmlDecode($this->Region->CurrentValue);
        }
        $this->Region->EditValue = $this->Region->CurrentValue;
        $this->Region->PlaceHolder = RemoveHtml($this->Region->caption());

        // PostalCode
        $this->PostalCode->EditAttrs["class"] = "form-control";
        $this->PostalCode->EditCustomAttributes = "";
        if (!$this->PostalCode->Raw) {
            $this->PostalCode->CurrentValue = HtmlDecode($this->PostalCode->CurrentValue);
        }
        $this->PostalCode->EditValue = $this->PostalCode->CurrentValue;
        $this->PostalCode->PlaceHolder = RemoveHtml($this->PostalCode->caption());

        // Country
        $this->Country->EditAttrs["class"] = "form-control";
        $this->Country->EditCustomAttributes = "";
        if (!$this->Country->Raw) {
            $this->Country->CurrentValue = HtmlDecode($this->Country->CurrentValue);
        }
        $this->Country->EditValue = $this->Country->CurrentValue;
        $this->Country->PlaceHolder = RemoveHtml($this->Country->caption());

        // HomePhone
        $this->HomePhone->EditAttrs["class"] = "form-control";
        $this->HomePhone->EditCustomAttributes = "";
        if (!$this->HomePhone->Raw) {
            $this->HomePhone->CurrentValue = HtmlDecode($this->HomePhone->CurrentValue);
        }
        $this->HomePhone->EditValue = $this->HomePhone->CurrentValue;
        $this->HomePhone->PlaceHolder = RemoveHtml($this->HomePhone->caption());

        // Extension
        $this->Extension->EditAttrs["class"] = "form-control";
        $this->Extension->EditCustomAttributes = "";
        if (!$this->Extension->Raw) {
            $this->Extension->CurrentValue = HtmlDecode($this->Extension->CurrentValue);
        }
        $this->Extension->EditValue = $this->Extension->CurrentValue;
        $this->Extension->PlaceHolder = RemoveHtml($this->Extension->caption());

        // Photo
        $this->Photo->EditAttrs["class"] = "form-control";
        $this->Photo->EditCustomAttributes = "";
        if (!$this->Photo->Raw) {
            $this->Photo->CurrentValue = HtmlDecode($this->Photo->CurrentValue);
        }
        $this->Photo->EditValue = $this->Photo->CurrentValue;
        $this->Photo->PlaceHolder = RemoveHtml($this->Photo->caption());

        // Notes
        $this->Notes->EditAttrs["class"] = "form-control";
        $this->Notes->EditCustomAttributes = "";
        if (!$this->Notes->Raw) {
            $this->Notes->CurrentValue = HtmlDecode($this->Notes->CurrentValue);
        }
        $this->Notes->EditValue = $this->Notes->CurrentValue;
        $this->Notes->PlaceHolder = RemoveHtml($this->Notes->caption());

        // ReportsTo
        $this->ReportsTo->EditAttrs["class"] = "form-control";
        $this->ReportsTo->EditCustomAttributes = "";
        if (!$this->ReportsTo->Raw) {
            $this->ReportsTo->CurrentValue = HtmlDecode($this->ReportsTo->CurrentValue);
        }
        $this->ReportsTo->EditValue = $this->ReportsTo->CurrentValue;
        $this->ReportsTo->PlaceHolder = RemoveHtml($this->ReportsTo->caption());

        // PhotoPath
        $this->PhotoPath->EditAttrs["class"] = "form-control";
        $this->PhotoPath->EditCustomAttributes = "";
        if (!$this->PhotoPath->Raw) {
            $this->PhotoPath->CurrentValue = HtmlDecode($this->PhotoPath->CurrentValue);
        }
        $this->PhotoPath->EditValue = $this->PhotoPath->CurrentValue;
        $this->PhotoPath->PlaceHolder = RemoveHtml($this->PhotoPath->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->EmployeeID);
                    $doc->exportCaption($this->LastName);
                    $doc->exportCaption($this->FirstName);
                    $doc->exportCaption($this->Title);
                    $doc->exportCaption($this->TitleOfCourtesy);
                    $doc->exportCaption($this->BirthDate);
                    $doc->exportCaption($this->HireDate);
                    $doc->exportCaption($this->Address);
                    $doc->exportCaption($this->City);
                    $doc->exportCaption($this->Region);
                    $doc->exportCaption($this->PostalCode);
                    $doc->exportCaption($this->Country);
                    $doc->exportCaption($this->HomePhone);
                    $doc->exportCaption($this->Extension);
                    $doc->exportCaption($this->Photo);
                    $doc->exportCaption($this->Notes);
                    $doc->exportCaption($this->ReportsTo);
                    $doc->exportCaption($this->PhotoPath);
                } else {
                    $doc->exportCaption($this->EmployeeID);
                    $doc->exportCaption($this->LastName);
                    $doc->exportCaption($this->FirstName);
                    $doc->exportCaption($this->Title);
                    $doc->exportCaption($this->TitleOfCourtesy);
                    $doc->exportCaption($this->BirthDate);
                    $doc->exportCaption($this->HireDate);
                    $doc->exportCaption($this->Address);
                    $doc->exportCaption($this->City);
                    $doc->exportCaption($this->Region);
                    $doc->exportCaption($this->PostalCode);
                    $doc->exportCaption($this->Country);
                    $doc->exportCaption($this->HomePhone);
                    $doc->exportCaption($this->Extension);
                    $doc->exportCaption($this->Photo);
                    $doc->exportCaption($this->Notes);
                    $doc->exportCaption($this->ReportsTo);
                    $doc->exportCaption($this->PhotoPath);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->EmployeeID);
                        $doc->exportField($this->LastName);
                        $doc->exportField($this->FirstName);
                        $doc->exportField($this->Title);
                        $doc->exportField($this->TitleOfCourtesy);
                        $doc->exportField($this->BirthDate);
                        $doc->exportField($this->HireDate);
                        $doc->exportField($this->Address);
                        $doc->exportField($this->City);
                        $doc->exportField($this->Region);
                        $doc->exportField($this->PostalCode);
                        $doc->exportField($this->Country);
                        $doc->exportField($this->HomePhone);
                        $doc->exportField($this->Extension);
                        $doc->exportField($this->Photo);
                        $doc->exportField($this->Notes);
                        $doc->exportField($this->ReportsTo);
                        $doc->exportField($this->PhotoPath);
                    } else {
                        $doc->exportField($this->EmployeeID);
                        $doc->exportField($this->LastName);
                        $doc->exportField($this->FirstName);
                        $doc->exportField($this->Title);
                        $doc->exportField($this->TitleOfCourtesy);
                        $doc->exportField($this->BirthDate);
                        $doc->exportField($this->HireDate);
                        $doc->exportField($this->Address);
                        $doc->exportField($this->City);
                        $doc->exportField($this->Region);
                        $doc->exportField($this->PostalCode);
                        $doc->exportField($this->Country);
                        $doc->exportField($this->HomePhone);
                        $doc->exportField($this->Extension);
                        $doc->exportField($this->Photo);
                        $doc->exportField($this->Notes);
                        $doc->exportField($this->ReportsTo);
                        $doc->exportField($this->PhotoPath);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        // No binary fields
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}

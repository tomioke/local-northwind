<?php

namespace PHPMaker2021\northwindapi;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for orders
 */
class Orders extends DbTable
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
    public $OrderID;
    public $CustomerID;
    public $EmployeeID;
    public $OrderDate;
    public $RequiredDate;
    public $ShippedDate;
    public $ShipperID;
    public $Freight;
    public $ShipName;
    public $ShipAddress;
    public $ShipCity;
    public $ShipRegion;
    public $ShipPostalCode;
    public $ShipCountry;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'orders';
        $this->TableName = 'orders';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`orders`";
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

        // OrderID
        $this->OrderID = new DbField('orders', 'orders', 'x_OrderID', 'OrderID', '`OrderID`', '`OrderID`', 3, 11, -1, false, '`OrderID`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->OrderID->IsAutoIncrement = true; // Autoincrement field
        $this->OrderID->IsPrimaryKey = true; // Primary key field
        $this->OrderID->IsForeignKey = true; // Foreign key field
        $this->OrderID->Sortable = true; // Allow sort
        $this->OrderID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->OrderID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->OrderID->Param, "CustomMsg");
        $this->Fields['OrderID'] = &$this->OrderID;

        // CustomerID
        $this->CustomerID = new DbField('orders', 'orders', 'x_CustomerID', 'CustomerID', '`CustomerID`', '`CustomerID`', 200, 255, -1, false, '`CustomerID`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->CustomerID->Sortable = true; // Allow sort
        $this->CustomerID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->CustomerID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->CustomerID->Lookup = new Lookup('CustomerID', 'customers', false, 'CustomerID', ["ContactName","CompanyName","",""], [], [], [], [], [], [], '', '');
        $this->CustomerID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CustomerID->Param, "CustomMsg");
        $this->Fields['CustomerID'] = &$this->CustomerID;

        // EmployeeID
        $this->EmployeeID = new DbField('orders', 'orders', 'x_EmployeeID', 'EmployeeID', '`EmployeeID`', '`EmployeeID`', 3, 11, -1, false, '`EmployeeID`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->EmployeeID->Sortable = true; // Allow sort
        $this->EmployeeID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->EmployeeID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->EmployeeID->Lookup = new Lookup('EmployeeID', 'employees', false, 'EmployeeID', ["LastName","","",""], [], [], [], [], [], [], '', '');
        $this->EmployeeID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->EmployeeID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EmployeeID->Param, "CustomMsg");
        $this->Fields['EmployeeID'] = &$this->EmployeeID;

        // OrderDate
        $this->OrderDate = new DbField('orders', 'orders', 'x_OrderDate', 'OrderDate', '`OrderDate`', CastDateFieldForLike("`OrderDate`", 0, "DB"), 133, 10, 0, false, '`OrderDate`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->OrderDate->Sortable = true; // Allow sort
        $this->OrderDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->OrderDate->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->OrderDate->Param, "CustomMsg");
        $this->Fields['OrderDate'] = &$this->OrderDate;

        // RequiredDate
        $this->RequiredDate = new DbField('orders', 'orders', 'x_RequiredDate', 'RequiredDate', '`RequiredDate`', CastDateFieldForLike("`RequiredDate`", 7, "DB"), 133, 10, 7, false, '`RequiredDate`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RequiredDate->Sortable = true; // Allow sort
        $this->RequiredDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->RequiredDate->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RequiredDate->Param, "CustomMsg");
        $this->Fields['RequiredDate'] = &$this->RequiredDate;

        // ShippedDate
        $this->ShippedDate = new DbField('orders', 'orders', 'x_ShippedDate', 'ShippedDate', '`ShippedDate`', CastDateFieldForLike("`ShippedDate`", 0, "DB"), 133, 10, 0, false, '`ShippedDate`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ShippedDate->Sortable = true; // Allow sort
        $this->ShippedDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->ShippedDate->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ShippedDate->Param, "CustomMsg");
        $this->Fields['ShippedDate'] = &$this->ShippedDate;

        // ShipperID
        $this->ShipperID = new DbField('orders', 'orders', 'x_ShipperID', 'ShipperID', '`ShipperID`', '`ShipperID`', 3, 11, -1, false, '`ShipperID`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->ShipperID->Sortable = true; // Allow sort
        $this->ShipperID->Lookup = new Lookup('ShipperID', 'shippers', false, 'ShipperID', ["CompanyName","","",""], [], [], [], [], [], [], '', '');
        $this->ShipperID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ShipperID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ShipperID->Param, "CustomMsg");
        $this->Fields['ShipperID'] = &$this->ShipperID;

        // Freight
        $this->Freight = new DbField('orders', 'orders', 'x_Freight', 'Freight', '`Freight`', '`Freight`', 200, 255, -1, false, '`Freight`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Freight->Sortable = true; // Allow sort
        $this->Freight->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Freight->Param, "CustomMsg");
        $this->Fields['Freight'] = &$this->Freight;

        // ShipName
        $this->ShipName = new DbField('orders', 'orders', 'x_ShipName', 'ShipName', '`ShipName`', '`ShipName`', 200, 255, -1, false, '`ShipName`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ShipName->Sortable = true; // Allow sort
        $this->ShipName->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ShipName->Param, "CustomMsg");
        $this->Fields['ShipName'] = &$this->ShipName;

        // ShipAddress
        $this->ShipAddress = new DbField('orders', 'orders', 'x_ShipAddress', 'ShipAddress', '`ShipAddress`', '`ShipAddress`', 200, 255, -1, false, '`ShipAddress`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ShipAddress->Sortable = true; // Allow sort
        $this->ShipAddress->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ShipAddress->Param, "CustomMsg");
        $this->Fields['ShipAddress'] = &$this->ShipAddress;

        // ShipCity
        $this->ShipCity = new DbField('orders', 'orders', 'x_ShipCity', 'ShipCity', '`ShipCity`', '`ShipCity`', 200, 255, -1, false, '`ShipCity`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ShipCity->Sortable = true; // Allow sort
        $this->ShipCity->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ShipCity->Param, "CustomMsg");
        $this->Fields['ShipCity'] = &$this->ShipCity;

        // ShipRegion
        $this->ShipRegion = new DbField('orders', 'orders', 'x_ShipRegion', 'ShipRegion', '`ShipRegion`', '`ShipRegion`', 200, 255, -1, false, '`ShipRegion`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ShipRegion->Sortable = true; // Allow sort
        $this->ShipRegion->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ShipRegion->Param, "CustomMsg");
        $this->Fields['ShipRegion'] = &$this->ShipRegion;

        // ShipPostalCode
        $this->ShipPostalCode = new DbField('orders', 'orders', 'x_ShipPostalCode', 'ShipPostalCode', '`ShipPostalCode`', '`ShipPostalCode`', 200, 255, -1, false, '`ShipPostalCode`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ShipPostalCode->Sortable = true; // Allow sort
        $this->ShipPostalCode->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ShipPostalCode->Param, "CustomMsg");
        $this->Fields['ShipPostalCode'] = &$this->ShipPostalCode;

        // ShipCountry
        $this->ShipCountry = new DbField('orders', 'orders', 'x_ShipCountry', 'ShipCountry', '`ShipCountry`', '`ShipCountry`', 200, 255, -1, false, '`ShipCountry`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ShipCountry->Sortable = true; // Allow sort
        $this->ShipCountry->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ShipCountry->Param, "CustomMsg");
        $this->Fields['ShipCountry'] = &$this->ShipCountry;
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
        if ($this->getCurrentDetailTable() == "order_details") {
            $detailUrl = Container("order_details")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_OrderID", $this->OrderID->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "OrdersList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`orders`";
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
            $this->OrderID->setDbValue($conn->lastInsertId());
            $rs['OrderID'] = $this->OrderID->DbValue;
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
        // Cascade Update detail table 'order_details'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['OrderID']) && $rsold['OrderID'] != $rs['OrderID'])) { // Update detail field 'OrderID'
            $cascadeUpdate = true;
            $rscascade['OrderID'] = $rs['OrderID'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("order_details")->loadRs("`OrderID` = " . QuotedValue($rsold['OrderID'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'order_detail_id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("order_details")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("order_details")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("order_details")->rowUpdated($rsdtlold, $rsdtlnew);
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
            if (array_key_exists('OrderID', $rs)) {
                AddFilter($where, QuotedName('OrderID', $this->Dbid) . '=' . QuotedValue($rs['OrderID'], $this->OrderID->DataType, $this->Dbid));
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

        // Cascade delete detail table 'order_details'
        $dtlrows = Container("order_details")->loadRs("`OrderID` = " . QuotedValue($rs['OrderID'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("order_details")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("order_details")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("order_details")->rowDeleted($dtlrow);
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
        $this->OrderID->DbValue = $row['OrderID'];
        $this->CustomerID->DbValue = $row['CustomerID'];
        $this->EmployeeID->DbValue = $row['EmployeeID'];
        $this->OrderDate->DbValue = $row['OrderDate'];
        $this->RequiredDate->DbValue = $row['RequiredDate'];
        $this->ShippedDate->DbValue = $row['ShippedDate'];
        $this->ShipperID->DbValue = $row['ShipperID'];
        $this->Freight->DbValue = $row['Freight'];
        $this->ShipName->DbValue = $row['ShipName'];
        $this->ShipAddress->DbValue = $row['ShipAddress'];
        $this->ShipCity->DbValue = $row['ShipCity'];
        $this->ShipRegion->DbValue = $row['ShipRegion'];
        $this->ShipPostalCode->DbValue = $row['ShipPostalCode'];
        $this->ShipCountry->DbValue = $row['ShipCountry'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`OrderID` = @OrderID@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->OrderID->CurrentValue : $this->OrderID->OldValue;
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
                $this->OrderID->CurrentValue = $keys[0];
            } else {
                $this->OrderID->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('OrderID', $row) ? $row['OrderID'] : null;
        } else {
            $val = $this->OrderID->OldValue !== null ? $this->OrderID->OldValue : $this->OrderID->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@OrderID@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("OrdersList");
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
        if ($pageName == "OrdersView") {
            return $Language->phrase("View");
        } elseif ($pageName == "OrdersEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "OrdersAdd") {
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
                return "OrdersView";
            case Config("API_ADD_ACTION"):
                return "OrdersAdd";
            case Config("API_EDIT_ACTION"):
                return "OrdersEdit";
            case Config("API_DELETE_ACTION"):
                return "OrdersDelete";
            case Config("API_LIST_ACTION"):
                return "OrdersList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "OrdersList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("OrdersView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("OrdersView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "OrdersAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "OrdersAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("OrdersEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("OrdersEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("OrdersAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("OrdersAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("OrdersDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "OrderID:" . JsonEncode($this->OrderID->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->OrderID->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->OrderID->CurrentValue);
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
            if (($keyValue = Param("OrderID") ?? Route("OrderID")) !== null) {
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
                $this->OrderID->CurrentValue = $key;
            } else {
                $this->OrderID->OldValue = $key;
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
        $this->OrderID->setDbValue($row['OrderID']);
        $this->CustomerID->setDbValue($row['CustomerID']);
        $this->EmployeeID->setDbValue($row['EmployeeID']);
        $this->OrderDate->setDbValue($row['OrderDate']);
        $this->RequiredDate->setDbValue($row['RequiredDate']);
        $this->ShippedDate->setDbValue($row['ShippedDate']);
        $this->ShipperID->setDbValue($row['ShipperID']);
        $this->Freight->setDbValue($row['Freight']);
        $this->ShipName->setDbValue($row['ShipName']);
        $this->ShipAddress->setDbValue($row['ShipAddress']);
        $this->ShipCity->setDbValue($row['ShipCity']);
        $this->ShipRegion->setDbValue($row['ShipRegion']);
        $this->ShipPostalCode->setDbValue($row['ShipPostalCode']);
        $this->ShipCountry->setDbValue($row['ShipCountry']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // OrderID

        // CustomerID

        // EmployeeID

        // OrderDate

        // RequiredDate

        // ShippedDate

        // ShipperID

        // Freight

        // ShipName

        // ShipAddress

        // ShipCity

        // ShipRegion

        // ShipPostalCode

        // ShipCountry

        // OrderID
        $this->OrderID->ViewValue = $this->OrderID->CurrentValue;
        $this->OrderID->ViewValue = FormatNumber($this->OrderID->ViewValue, 0, -2, -2, -2);
        $this->OrderID->ViewCustomAttributes = "";

        // CustomerID
        $curVal = strval($this->CustomerID->CurrentValue);
        if ($curVal != "") {
            $this->CustomerID->ViewValue = $this->CustomerID->lookupCacheOption($curVal);
            if ($this->CustomerID->ViewValue === null) { // Lookup from database
                $filterWrk = "`CustomerID`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $sqlWrk = $this->CustomerID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->CustomerID->Lookup->renderViewRow($rswrk[0]);
                    $this->CustomerID->ViewValue = $this->CustomerID->displayValue($arwrk);
                } else {
                    $this->CustomerID->ViewValue = $this->CustomerID->CurrentValue;
                }
            }
        } else {
            $this->CustomerID->ViewValue = null;
        }
        $this->CustomerID->ViewCustomAttributes = "";

        // EmployeeID
        $curVal = strval($this->EmployeeID->CurrentValue);
        if ($curVal != "") {
            $this->EmployeeID->ViewValue = $this->EmployeeID->lookupCacheOption($curVal);
            if ($this->EmployeeID->ViewValue === null) { // Lookup from database
                $filterWrk = "`EmployeeID`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->EmployeeID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->EmployeeID->Lookup->renderViewRow($rswrk[0]);
                    $this->EmployeeID->ViewValue = $this->EmployeeID->displayValue($arwrk);
                } else {
                    $this->EmployeeID->ViewValue = $this->EmployeeID->CurrentValue;
                }
            }
        } else {
            $this->EmployeeID->ViewValue = null;
        }
        $this->EmployeeID->ViewCustomAttributes = "";

        // OrderDate
        $this->OrderDate->ViewValue = $this->OrderDate->CurrentValue;
        $this->OrderDate->ViewValue = FormatDateTime($this->OrderDate->ViewValue, 0);
        $this->OrderDate->ViewCustomAttributes = "";

        // RequiredDate
        $this->RequiredDate->ViewValue = $this->RequiredDate->CurrentValue;
        $this->RequiredDate->ViewValue = FormatDateTime($this->RequiredDate->ViewValue, 7);
        $this->RequiredDate->ViewCustomAttributes = "";

        // ShippedDate
        $this->ShippedDate->ViewValue = $this->ShippedDate->CurrentValue;
        $this->ShippedDate->ViewValue = FormatDateTime($this->ShippedDate->ViewValue, 0);
        $this->ShippedDate->ViewCustomAttributes = "";

        // ShipperID
        $curVal = strval($this->ShipperID->CurrentValue);
        if ($curVal != "") {
            $this->ShipperID->ViewValue = $this->ShipperID->lookupCacheOption($curVal);
            if ($this->ShipperID->ViewValue === null) { // Lookup from database
                $filterWrk = "`ShipperID`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->ShipperID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->ShipperID->Lookup->renderViewRow($rswrk[0]);
                    $this->ShipperID->ViewValue = $this->ShipperID->displayValue($arwrk);
                } else {
                    $this->ShipperID->ViewValue = $this->ShipperID->CurrentValue;
                }
            }
        } else {
            $this->ShipperID->ViewValue = null;
        }
        $this->ShipperID->ViewCustomAttributes = "";

        // Freight
        $this->Freight->ViewValue = $this->Freight->CurrentValue;
        $this->Freight->ViewCustomAttributes = "";

        // ShipName
        $this->ShipName->ViewValue = $this->ShipName->CurrentValue;
        $this->ShipName->ViewCustomAttributes = "";

        // ShipAddress
        $this->ShipAddress->ViewValue = $this->ShipAddress->CurrentValue;
        $this->ShipAddress->ViewCustomAttributes = "";

        // ShipCity
        $this->ShipCity->ViewValue = $this->ShipCity->CurrentValue;
        $this->ShipCity->ViewCustomAttributes = "";

        // ShipRegion
        $this->ShipRegion->ViewValue = $this->ShipRegion->CurrentValue;
        $this->ShipRegion->ViewCustomAttributes = "";

        // ShipPostalCode
        $this->ShipPostalCode->ViewValue = $this->ShipPostalCode->CurrentValue;
        $this->ShipPostalCode->ViewCustomAttributes = "";

        // ShipCountry
        $this->ShipCountry->ViewValue = $this->ShipCountry->CurrentValue;
        $this->ShipCountry->ViewCustomAttributes = "";

        // OrderID
        $this->OrderID->LinkCustomAttributes = "";
        $this->OrderID->HrefValue = "";
        $this->OrderID->TooltipValue = "";

        // CustomerID
        $this->CustomerID->LinkCustomAttributes = "";
        $this->CustomerID->HrefValue = "";
        $this->CustomerID->TooltipValue = "";

        // EmployeeID
        $this->EmployeeID->LinkCustomAttributes = "";
        $this->EmployeeID->HrefValue = "";
        $this->EmployeeID->TooltipValue = "";

        // OrderDate
        $this->OrderDate->LinkCustomAttributes = "";
        $this->OrderDate->HrefValue = "";
        $this->OrderDate->TooltipValue = "";

        // RequiredDate
        $this->RequiredDate->LinkCustomAttributes = "";
        $this->RequiredDate->HrefValue = "";
        $this->RequiredDate->TooltipValue = "";

        // ShippedDate
        $this->ShippedDate->LinkCustomAttributes = "";
        $this->ShippedDate->HrefValue = "";
        $this->ShippedDate->TooltipValue = "";

        // ShipperID
        $this->ShipperID->LinkCustomAttributes = "";
        $this->ShipperID->HrefValue = "";
        $this->ShipperID->TooltipValue = "";

        // Freight
        $this->Freight->LinkCustomAttributes = "";
        $this->Freight->HrefValue = "";
        $this->Freight->TooltipValue = "";

        // ShipName
        $this->ShipName->LinkCustomAttributes = "";
        $this->ShipName->HrefValue = "";
        $this->ShipName->TooltipValue = "";

        // ShipAddress
        $this->ShipAddress->LinkCustomAttributes = "";
        $this->ShipAddress->HrefValue = "";
        $this->ShipAddress->TooltipValue = "";

        // ShipCity
        $this->ShipCity->LinkCustomAttributes = "";
        $this->ShipCity->HrefValue = "";
        $this->ShipCity->TooltipValue = "";

        // ShipRegion
        $this->ShipRegion->LinkCustomAttributes = "";
        $this->ShipRegion->HrefValue = "";
        $this->ShipRegion->TooltipValue = "";

        // ShipPostalCode
        $this->ShipPostalCode->LinkCustomAttributes = "";
        $this->ShipPostalCode->HrefValue = "";
        $this->ShipPostalCode->TooltipValue = "";

        // ShipCountry
        $this->ShipCountry->LinkCustomAttributes = "";
        $this->ShipCountry->HrefValue = "";
        $this->ShipCountry->TooltipValue = "";

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

        // OrderID
        $this->OrderID->EditAttrs["class"] = "form-control";
        $this->OrderID->EditCustomAttributes = "";
        $this->OrderID->EditValue = $this->OrderID->CurrentValue;
        $this->OrderID->EditValue = FormatNumber($this->OrderID->EditValue, 0, -2, -2, -2);
        $this->OrderID->ViewCustomAttributes = "";

        // CustomerID
        $this->CustomerID->EditAttrs["class"] = "form-control";
        $this->CustomerID->EditCustomAttributes = "";
        $this->CustomerID->PlaceHolder = RemoveHtml($this->CustomerID->caption());

        // EmployeeID
        $this->EmployeeID->EditAttrs["class"] = "form-control";
        $this->EmployeeID->EditCustomAttributes = "";
        $this->EmployeeID->PlaceHolder = RemoveHtml($this->EmployeeID->caption());

        // OrderDate
        $this->OrderDate->EditAttrs["class"] = "form-control";
        $this->OrderDate->EditCustomAttributes = "";
        $this->OrderDate->EditValue = FormatDateTime($this->OrderDate->CurrentValue, 8);
        $this->OrderDate->PlaceHolder = RemoveHtml($this->OrderDate->caption());

        // RequiredDate
        $this->RequiredDate->EditAttrs["class"] = "form-control";
        $this->RequiredDate->EditCustomAttributes = "";
        $this->RequiredDate->EditValue = $this->RequiredDate->CurrentValue;
        $this->RequiredDate->EditValue = FormatDateTime($this->RequiredDate->EditValue, 7);
        $this->RequiredDate->ViewCustomAttributes = "";

        // ShippedDate
        $this->ShippedDate->EditAttrs["class"] = "form-control";
        $this->ShippedDate->EditCustomAttributes = "";
        $this->ShippedDate->EditValue = FormatDateTime($this->ShippedDate->CurrentValue, 8);
        $this->ShippedDate->PlaceHolder = RemoveHtml($this->ShippedDate->caption());

        // ShipperID
        $this->ShipperID->EditCustomAttributes = "";
        $this->ShipperID->PlaceHolder = RemoveHtml($this->ShipperID->caption());

        // Freight
        $this->Freight->EditAttrs["class"] = "form-control";
        $this->Freight->EditCustomAttributes = "";
        if (!$this->Freight->Raw) {
            $this->Freight->CurrentValue = HtmlDecode($this->Freight->CurrentValue);
        }
        $this->Freight->EditValue = $this->Freight->CurrentValue;
        $this->Freight->PlaceHolder = RemoveHtml($this->Freight->caption());

        // ShipName
        $this->ShipName->EditAttrs["class"] = "form-control";
        $this->ShipName->EditCustomAttributes = "";
        if (!$this->ShipName->Raw) {
            $this->ShipName->CurrentValue = HtmlDecode($this->ShipName->CurrentValue);
        }
        $this->ShipName->EditValue = $this->ShipName->CurrentValue;
        $this->ShipName->PlaceHolder = RemoveHtml($this->ShipName->caption());

        // ShipAddress
        $this->ShipAddress->EditAttrs["class"] = "form-control";
        $this->ShipAddress->EditCustomAttributes = "";
        if (!$this->ShipAddress->Raw) {
            $this->ShipAddress->CurrentValue = HtmlDecode($this->ShipAddress->CurrentValue);
        }
        $this->ShipAddress->EditValue = $this->ShipAddress->CurrentValue;
        $this->ShipAddress->PlaceHolder = RemoveHtml($this->ShipAddress->caption());

        // ShipCity
        $this->ShipCity->EditAttrs["class"] = "form-control";
        $this->ShipCity->EditCustomAttributes = "";
        if (!$this->ShipCity->Raw) {
            $this->ShipCity->CurrentValue = HtmlDecode($this->ShipCity->CurrentValue);
        }
        $this->ShipCity->EditValue = $this->ShipCity->CurrentValue;
        $this->ShipCity->PlaceHolder = RemoveHtml($this->ShipCity->caption());

        // ShipRegion
        $this->ShipRegion->EditAttrs["class"] = "form-control";
        $this->ShipRegion->EditCustomAttributes = "";
        if (!$this->ShipRegion->Raw) {
            $this->ShipRegion->CurrentValue = HtmlDecode($this->ShipRegion->CurrentValue);
        }
        $this->ShipRegion->EditValue = $this->ShipRegion->CurrentValue;
        $this->ShipRegion->PlaceHolder = RemoveHtml($this->ShipRegion->caption());

        // ShipPostalCode
        $this->ShipPostalCode->EditAttrs["class"] = "form-control";
        $this->ShipPostalCode->EditCustomAttributes = "";
        if (!$this->ShipPostalCode->Raw) {
            $this->ShipPostalCode->CurrentValue = HtmlDecode($this->ShipPostalCode->CurrentValue);
        }
        $this->ShipPostalCode->EditValue = $this->ShipPostalCode->CurrentValue;
        $this->ShipPostalCode->PlaceHolder = RemoveHtml($this->ShipPostalCode->caption());

        // ShipCountry
        $this->ShipCountry->EditAttrs["class"] = "form-control";
        $this->ShipCountry->EditCustomAttributes = "";
        if (!$this->ShipCountry->Raw) {
            $this->ShipCountry->CurrentValue = HtmlDecode($this->ShipCountry->CurrentValue);
        }
        $this->ShipCountry->EditValue = $this->ShipCountry->CurrentValue;
        $this->ShipCountry->PlaceHolder = RemoveHtml($this->ShipCountry->caption());

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
                    $doc->exportCaption($this->OrderID);
                    $doc->exportCaption($this->CustomerID);
                    $doc->exportCaption($this->EmployeeID);
                    $doc->exportCaption($this->OrderDate);
                    $doc->exportCaption($this->RequiredDate);
                    $doc->exportCaption($this->ShippedDate);
                    $doc->exportCaption($this->ShipperID);
                    $doc->exportCaption($this->Freight);
                    $doc->exportCaption($this->ShipName);
                    $doc->exportCaption($this->ShipAddress);
                    $doc->exportCaption($this->ShipCity);
                    $doc->exportCaption($this->ShipRegion);
                    $doc->exportCaption($this->ShipPostalCode);
                    $doc->exportCaption($this->ShipCountry);
                } else {
                    $doc->exportCaption($this->OrderID);
                    $doc->exportCaption($this->CustomerID);
                    $doc->exportCaption($this->EmployeeID);
                    $doc->exportCaption($this->OrderDate);
                    $doc->exportCaption($this->RequiredDate);
                    $doc->exportCaption($this->ShippedDate);
                    $doc->exportCaption($this->ShipperID);
                    $doc->exportCaption($this->Freight);
                    $doc->exportCaption($this->ShipName);
                    $doc->exportCaption($this->ShipAddress);
                    $doc->exportCaption($this->ShipCity);
                    $doc->exportCaption($this->ShipRegion);
                    $doc->exportCaption($this->ShipPostalCode);
                    $doc->exportCaption($this->ShipCountry);
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
                        $doc->exportField($this->OrderID);
                        $doc->exportField($this->CustomerID);
                        $doc->exportField($this->EmployeeID);
                        $doc->exportField($this->OrderDate);
                        $doc->exportField($this->RequiredDate);
                        $doc->exportField($this->ShippedDate);
                        $doc->exportField($this->ShipperID);
                        $doc->exportField($this->Freight);
                        $doc->exportField($this->ShipName);
                        $doc->exportField($this->ShipAddress);
                        $doc->exportField($this->ShipCity);
                        $doc->exportField($this->ShipRegion);
                        $doc->exportField($this->ShipPostalCode);
                        $doc->exportField($this->ShipCountry);
                    } else {
                        $doc->exportField($this->OrderID);
                        $doc->exportField($this->CustomerID);
                        $doc->exportField($this->EmployeeID);
                        $doc->exportField($this->OrderDate);
                        $doc->exportField($this->RequiredDate);
                        $doc->exportField($this->ShippedDate);
                        $doc->exportField($this->ShipperID);
                        $doc->exportField($this->Freight);
                        $doc->exportField($this->ShipName);
                        $doc->exportField($this->ShipAddress);
                        $doc->exportField($this->ShipCity);
                        $doc->exportField($this->ShipRegion);
                        $doc->exportField($this->ShipPostalCode);
                        $doc->exportField($this->ShipCountry);
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

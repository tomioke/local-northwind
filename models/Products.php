<?php

namespace PHPMaker2021\northwindapi;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for products
 */
class Products extends DbTable
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
    public $CategoryID;
    public $ProductID;
    public $ProductName;
    public $SupplierID;
    public $QuantityPerUnit;
    public $UnitPrice;
    public $UnitsInStock;
    public $UnitsOnOrder;
    public $ReorderLevel;
    public $Discontinued;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'products';
        $this->TableName = 'products';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`products`";
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

        // CategoryID
        $this->CategoryID = new DbField('products', 'products', 'x_CategoryID', 'CategoryID', '`CategoryID`', '`CategoryID`', 3, 11, -1, false, '`CategoryID`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->CategoryID->IsForeignKey = true; // Foreign key field
        $this->CategoryID->Nullable = false; // NOT NULL field
        $this->CategoryID->Required = true; // Required field
        $this->CategoryID->Sortable = true; // Allow sort
        $this->CategoryID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->CategoryID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->CategoryID->Lookup = new Lookup('CategoryID', 'categories', false, 'CategoryID', ["CategoryName","","",""], [], [], [], [], [], [], '', '');
        $this->CategoryID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CategoryID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CategoryID->Param, "CustomMsg");
        $this->Fields['CategoryID'] = &$this->CategoryID;

        // ProductID
        $this->ProductID = new DbField('products', 'products', 'x_ProductID', 'ProductID', '`ProductID`', '`ProductID`', 3, 11, -1, false, '`ProductID`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ProductID->IsAutoIncrement = true; // Autoincrement field
        $this->ProductID->IsPrimaryKey = true; // Primary key field
        $this->ProductID->IsForeignKey = true; // Foreign key field
        $this->ProductID->Sortable = true; // Allow sort
        $this->ProductID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ProductID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ProductID->Param, "CustomMsg");
        $this->Fields['ProductID'] = &$this->ProductID;

        // ProductName
        $this->ProductName = new DbField('products', 'products', 'x_ProductName', 'ProductName', '`ProductName`', '`ProductName`', 200, 255, -1, false, '`ProductName`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ProductName->Nullable = false; // NOT NULL field
        $this->ProductName->Required = true; // Required field
        $this->ProductName->Sortable = true; // Allow sort
        $this->ProductName->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ProductName->Param, "CustomMsg");
        $this->Fields['ProductName'] = &$this->ProductName;

        // SupplierID
        $this->SupplierID = new DbField('products', 'products', 'x_SupplierID', 'SupplierID', '`SupplierID`', '`SupplierID`', 3, 11, -1, false, '`SupplierID`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->SupplierID->Nullable = false; // NOT NULL field
        $this->SupplierID->Required = true; // Required field
        $this->SupplierID->Sortable = true; // Allow sort
        $this->SupplierID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->SupplierID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->SupplierID->Lookup = new Lookup('SupplierID', 'suppliers', false, 'SupplierID', ["CompanyName","","",""], [], [], [], [], [], [], '', '');
        $this->SupplierID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->SupplierID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SupplierID->Param, "CustomMsg");
        $this->Fields['SupplierID'] = &$this->SupplierID;

        // QuantityPerUnit
        $this->QuantityPerUnit = new DbField('products', 'products', 'x_QuantityPerUnit', 'QuantityPerUnit', '`QuantityPerUnit`', '`QuantityPerUnit`', 200, 255, -1, false, '`QuantityPerUnit`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->QuantityPerUnit->Nullable = false; // NOT NULL field
        $this->QuantityPerUnit->Required = true; // Required field
        $this->QuantityPerUnit->Sortable = true; // Allow sort
        $this->QuantityPerUnit->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->QuantityPerUnit->Param, "CustomMsg");
        $this->Fields['QuantityPerUnit'] = &$this->QuantityPerUnit;

        // UnitPrice
        $this->UnitPrice = new DbField('products', 'products', 'x_UnitPrice', 'UnitPrice', '`UnitPrice`', '`UnitPrice`', 131, 10, -1, false, '`UnitPrice`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->UnitPrice->Nullable = false; // NOT NULL field
        $this->UnitPrice->Required = true; // Required field
        $this->UnitPrice->Sortable = true; // Allow sort
        $this->UnitPrice->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->UnitPrice->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->UnitPrice->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->UnitPrice->Param, "CustomMsg");
        $this->Fields['UnitPrice'] = &$this->UnitPrice;

        // UnitsInStock
        $this->UnitsInStock = new DbField('products', 'products', 'x_UnitsInStock', 'UnitsInStock', '`UnitsInStock`', '`UnitsInStock`', 3, 11, -1, false, '`UnitsInStock`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->UnitsInStock->Nullable = false; // NOT NULL field
        $this->UnitsInStock->Required = true; // Required field
        $this->UnitsInStock->Sortable = true; // Allow sort
        $this->UnitsInStock->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->UnitsInStock->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->UnitsInStock->Param, "CustomMsg");
        $this->Fields['UnitsInStock'] = &$this->UnitsInStock;

        // UnitsOnOrder
        $this->UnitsOnOrder = new DbField('products', 'products', 'x_UnitsOnOrder', 'UnitsOnOrder', '`UnitsOnOrder`', '`UnitsOnOrder`', 3, 11, -1, false, '`UnitsOnOrder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->UnitsOnOrder->Nullable = false; // NOT NULL field
        $this->UnitsOnOrder->Required = true; // Required field
        $this->UnitsOnOrder->Sortable = true; // Allow sort
        $this->UnitsOnOrder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->UnitsOnOrder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->UnitsOnOrder->Param, "CustomMsg");
        $this->Fields['UnitsOnOrder'] = &$this->UnitsOnOrder;

        // ReorderLevel
        $this->ReorderLevel = new DbField('products', 'products', 'x_ReorderLevel', 'ReorderLevel', '`ReorderLevel`', '`ReorderLevel`', 200, 255, -1, false, '`ReorderLevel`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ReorderLevel->Sortable = true; // Allow sort
        $this->ReorderLevel->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ReorderLevel->Param, "CustomMsg");
        $this->Fields['ReorderLevel'] = &$this->ReorderLevel;

        // Discontinued
        $this->Discontinued = new DbField('products', 'products', 'x_Discontinued', 'Discontinued', '`Discontinued`', '`Discontinued`', 200, 255, -1, false, '`Discontinued`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->Discontinued->Sortable = true; // Allow sort
        $this->Discontinued->Lookup = new Lookup('Discontinued', 'products', false, '', ["","","",""], [], [], [], [], [], [], '', '');
        $this->Discontinued->OptionCount = 3;
        $this->Discontinued->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Discontinued->Param, "CustomMsg");
        $this->Fields['Discontinued'] = &$this->Discontinued;
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

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Session master WHERE clause
    public function getMasterFilter()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "categories") {
            if ($this->CategoryID->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`CategoryID`", $this->CategoryID->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Session detail WHERE clause
    public function getDetailFilter()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "categories") {
            if ($this->CategoryID->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`CategoryID`", $this->CategoryID->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_categories()
    {
        return "`CategoryID`=@CategoryID@";
    }
    // Detail filter
    public function sqlDetailFilter_categories()
    {
        return "`CategoryID`=@CategoryID@";
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
            $detailUrl .= "&" . GetForeignKeyUrl("fk_ProductID", $this->ProductID->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "ProductsList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`products`";
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
            $this->ProductID->setDbValue($conn->lastInsertId());
            $rs['ProductID'] = $this->ProductID->DbValue;
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
        if ($rsold && (isset($rs['ProductID']) && $rsold['ProductID'] != $rs['ProductID'])) { // Update detail field 'ProductID'
            $cascadeUpdate = true;
            $rscascade['ProductID'] = $rs['ProductID'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("order_details")->loadRs("`ProductID` = " . QuotedValue($rsold['ProductID'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
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
            if (array_key_exists('ProductID', $rs)) {
                AddFilter($where, QuotedName('ProductID', $this->Dbid) . '=' . QuotedValue($rs['ProductID'], $this->ProductID->DataType, $this->Dbid));
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
        $dtlrows = Container("order_details")->loadRs("`ProductID` = " . QuotedValue($rs['ProductID'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
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
        $this->CategoryID->DbValue = $row['CategoryID'];
        $this->ProductID->DbValue = $row['ProductID'];
        $this->ProductName->DbValue = $row['ProductName'];
        $this->SupplierID->DbValue = $row['SupplierID'];
        $this->QuantityPerUnit->DbValue = $row['QuantityPerUnit'];
        $this->UnitPrice->DbValue = $row['UnitPrice'];
        $this->UnitsInStock->DbValue = $row['UnitsInStock'];
        $this->UnitsOnOrder->DbValue = $row['UnitsOnOrder'];
        $this->ReorderLevel->DbValue = $row['ReorderLevel'];
        $this->Discontinued->DbValue = $row['Discontinued'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`ProductID` = @ProductID@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->ProductID->CurrentValue : $this->ProductID->OldValue;
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
                $this->ProductID->CurrentValue = $keys[0];
            } else {
                $this->ProductID->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('ProductID', $row) ? $row['ProductID'] : null;
        } else {
            $val = $this->ProductID->OldValue !== null ? $this->ProductID->OldValue : $this->ProductID->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@ProductID@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ProductsList");
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
        if ($pageName == "ProductsView") {
            return $Language->phrase("View");
        } elseif ($pageName == "ProductsEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "ProductsAdd") {
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
                return "ProductsView";
            case Config("API_ADD_ACTION"):
                return "ProductsAdd";
            case Config("API_EDIT_ACTION"):
                return "ProductsEdit";
            case Config("API_DELETE_ACTION"):
                return "ProductsDelete";
            case Config("API_LIST_ACTION"):
                return "ProductsList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "ProductsList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ProductsView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("ProductsView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ProductsAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "ProductsAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ProductsEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("ProductsEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("ProductsAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("ProductsAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("ProductsDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "categories" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_CategoryID", $this->CategoryID->CurrentValue ?? $this->CategoryID->getSessionValue());
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "ProductID:" . JsonEncode($this->ProductID->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->ProductID->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->ProductID->CurrentValue);
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
            if (($keyValue = Param("ProductID") ?? Route("ProductID")) !== null) {
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
                $this->ProductID->CurrentValue = $key;
            } else {
                $this->ProductID->OldValue = $key;
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
        $this->CategoryID->setDbValue($row['CategoryID']);
        $this->ProductID->setDbValue($row['ProductID']);
        $this->ProductName->setDbValue($row['ProductName']);
        $this->SupplierID->setDbValue($row['SupplierID']);
        $this->QuantityPerUnit->setDbValue($row['QuantityPerUnit']);
        $this->UnitPrice->setDbValue($row['UnitPrice']);
        $this->UnitsInStock->setDbValue($row['UnitsInStock']);
        $this->UnitsOnOrder->setDbValue($row['UnitsOnOrder']);
        $this->ReorderLevel->setDbValue($row['ReorderLevel']);
        $this->Discontinued->setDbValue($row['Discontinued']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // CategoryID

        // ProductID

        // ProductName

        // SupplierID

        // QuantityPerUnit

        // UnitPrice

        // UnitsInStock

        // UnitsOnOrder

        // ReorderLevel

        // Discontinued

        // CategoryID
        $curVal = strval($this->CategoryID->CurrentValue);
        if ($curVal != "") {
            $this->CategoryID->ViewValue = $this->CategoryID->lookupCacheOption($curVal);
            if ($this->CategoryID->ViewValue === null) { // Lookup from database
                $filterWrk = "`CategoryID`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->CategoryID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->CategoryID->Lookup->renderViewRow($rswrk[0]);
                    $this->CategoryID->ViewValue = $this->CategoryID->displayValue($arwrk);
                } else {
                    $this->CategoryID->ViewValue = $this->CategoryID->CurrentValue;
                }
            }
        } else {
            $this->CategoryID->ViewValue = null;
        }
        $this->CategoryID->ViewCustomAttributes = "";

        // ProductID
        $this->ProductID->ViewValue = $this->ProductID->CurrentValue;
        $this->ProductID->ViewValue = FormatNumber($this->ProductID->ViewValue, 0, -2, -2, -2);
        $this->ProductID->ViewCustomAttributes = "";

        // ProductName
        $this->ProductName->ViewValue = $this->ProductName->CurrentValue;
        $this->ProductName->ViewCustomAttributes = "";

        // SupplierID
        $curVal = strval($this->SupplierID->CurrentValue);
        if ($curVal != "") {
            $this->SupplierID->ViewValue = $this->SupplierID->lookupCacheOption($curVal);
            if ($this->SupplierID->ViewValue === null) { // Lookup from database
                $filterWrk = "`SupplierID`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->SupplierID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->SupplierID->Lookup->renderViewRow($rswrk[0]);
                    $this->SupplierID->ViewValue = $this->SupplierID->displayValue($arwrk);
                } else {
                    $this->SupplierID->ViewValue = $this->SupplierID->CurrentValue;
                }
            }
        } else {
            $this->SupplierID->ViewValue = null;
        }
        $this->SupplierID->ViewCustomAttributes = "";

        // QuantityPerUnit
        $this->QuantityPerUnit->ViewValue = $this->QuantityPerUnit->CurrentValue;
        $this->QuantityPerUnit->ViewCustomAttributes = "";

        // UnitPrice
        $this->UnitPrice->ViewValue = $this->UnitPrice->CurrentValue;
        $this->UnitPrice->ViewValue = FormatNumber($this->UnitPrice->ViewValue, 2, -2, -2, -2);
        $this->UnitPrice->ViewCustomAttributes = "";

        // UnitsInStock
        $this->UnitsInStock->ViewValue = $this->UnitsInStock->CurrentValue;
        $this->UnitsInStock->ViewValue = FormatNumber($this->UnitsInStock->ViewValue, 0, -2, -2, -2);
        $this->UnitsInStock->ViewCustomAttributes = "";

        // UnitsOnOrder
        $this->UnitsOnOrder->ViewValue = $this->UnitsOnOrder->CurrentValue;
        $this->UnitsOnOrder->ViewValue = FormatNumber($this->UnitsOnOrder->ViewValue, 0, -2, -2, -2);
        $this->UnitsOnOrder->ViewCustomAttributes = "";

        // ReorderLevel
        $this->ReorderLevel->ViewValue = $this->ReorderLevel->CurrentValue;
        $this->ReorderLevel->ViewCustomAttributes = "";

        // Discontinued
        if (strval($this->Discontinued->CurrentValue) != "") {
            $this->Discontinued->ViewValue = new OptionValues();
            $arwrk = explode(",", strval($this->Discontinued->CurrentValue));
            $cnt = count($arwrk);
            for ($ari = 0; $ari < $cnt; $ari++)
                $this->Discontinued->ViewValue->add($this->Discontinued->optionCaption(trim($arwrk[$ari])));
        } else {
            $this->Discontinued->ViewValue = null;
        }
        $this->Discontinued->ViewCustomAttributes = "";

        // CategoryID
        $this->CategoryID->LinkCustomAttributes = "";
        $this->CategoryID->HrefValue = "";
        $this->CategoryID->TooltipValue = "";

        // ProductID
        $this->ProductID->LinkCustomAttributes = "";
        $this->ProductID->HrefValue = "";
        $this->ProductID->TooltipValue = "";

        // ProductName
        $this->ProductName->LinkCustomAttributes = "";
        $this->ProductName->HrefValue = "";
        $this->ProductName->TooltipValue = "";

        // SupplierID
        $this->SupplierID->LinkCustomAttributes = "";
        $this->SupplierID->HrefValue = "";
        $this->SupplierID->TooltipValue = "";

        // QuantityPerUnit
        $this->QuantityPerUnit->LinkCustomAttributes = "";
        $this->QuantityPerUnit->HrefValue = "";
        $this->QuantityPerUnit->TooltipValue = "";

        // UnitPrice
        $this->UnitPrice->LinkCustomAttributes = "";
        $this->UnitPrice->HrefValue = "";
        $this->UnitPrice->TooltipValue = "";

        // UnitsInStock
        $this->UnitsInStock->LinkCustomAttributes = "";
        $this->UnitsInStock->HrefValue = "";
        $this->UnitsInStock->TooltipValue = "";

        // UnitsOnOrder
        $this->UnitsOnOrder->LinkCustomAttributes = "";
        $this->UnitsOnOrder->HrefValue = "";
        $this->UnitsOnOrder->TooltipValue = "";

        // ReorderLevel
        $this->ReorderLevel->LinkCustomAttributes = "";
        $this->ReorderLevel->HrefValue = "";
        $this->ReorderLevel->TooltipValue = "";

        // Discontinued
        $this->Discontinued->LinkCustomAttributes = "";
        $this->Discontinued->HrefValue = "";
        $this->Discontinued->TooltipValue = "";

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

        // CategoryID
        $this->CategoryID->EditAttrs["class"] = "form-control";
        $this->CategoryID->EditCustomAttributes = "";
        if ($this->CategoryID->getSessionValue() != "") {
            $this->CategoryID->CurrentValue = GetForeignKeyValue($this->CategoryID->getSessionValue());
            $curVal = strval($this->CategoryID->CurrentValue);
            if ($curVal != "") {
                $this->CategoryID->ViewValue = $this->CategoryID->lookupCacheOption($curVal);
                if ($this->CategoryID->ViewValue === null) { // Lookup from database
                    $filterWrk = "`CategoryID`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->CategoryID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CategoryID->Lookup->renderViewRow($rswrk[0]);
                        $this->CategoryID->ViewValue = $this->CategoryID->displayValue($arwrk);
                    } else {
                        $this->CategoryID->ViewValue = $this->CategoryID->CurrentValue;
                    }
                }
            } else {
                $this->CategoryID->ViewValue = null;
            }
            $this->CategoryID->ViewCustomAttributes = "";
        } else {
            $this->CategoryID->PlaceHolder = RemoveHtml($this->CategoryID->caption());
        }

        // ProductID
        $this->ProductID->EditAttrs["class"] = "form-control";
        $this->ProductID->EditCustomAttributes = "";
        $this->ProductID->EditValue = $this->ProductID->CurrentValue;
        $this->ProductID->EditValue = FormatNumber($this->ProductID->EditValue, 0, -2, -2, -2);
        $this->ProductID->ViewCustomAttributes = "";

        // ProductName
        $this->ProductName->EditAttrs["class"] = "form-control";
        $this->ProductName->EditCustomAttributes = "";
        if (!$this->ProductName->Raw) {
            $this->ProductName->CurrentValue = HtmlDecode($this->ProductName->CurrentValue);
        }
        $this->ProductName->EditValue = $this->ProductName->CurrentValue;
        $this->ProductName->PlaceHolder = RemoveHtml($this->ProductName->caption());

        // SupplierID
        $this->SupplierID->EditAttrs["class"] = "form-control";
        $this->SupplierID->EditCustomAttributes = "";
        $this->SupplierID->PlaceHolder = RemoveHtml($this->SupplierID->caption());

        // QuantityPerUnit
        $this->QuantityPerUnit->EditAttrs["class"] = "form-control";
        $this->QuantityPerUnit->EditCustomAttributes = "";
        if (!$this->QuantityPerUnit->Raw) {
            $this->QuantityPerUnit->CurrentValue = HtmlDecode($this->QuantityPerUnit->CurrentValue);
        }
        $this->QuantityPerUnit->EditValue = $this->QuantityPerUnit->CurrentValue;
        $this->QuantityPerUnit->PlaceHolder = RemoveHtml($this->QuantityPerUnit->caption());

        // UnitPrice
        $this->UnitPrice->EditAttrs["class"] = "form-control";
        $this->UnitPrice->EditCustomAttributes = "";
        $this->UnitPrice->EditValue = $this->UnitPrice->CurrentValue;
        $this->UnitPrice->PlaceHolder = RemoveHtml($this->UnitPrice->caption());
        if (strval($this->UnitPrice->EditValue) != "" && is_numeric($this->UnitPrice->EditValue)) {
            $this->UnitPrice->EditValue = FormatNumber($this->UnitPrice->EditValue, -2, -2, -2, -2);
        }

        // UnitsInStock
        $this->UnitsInStock->EditAttrs["class"] = "form-control";
        $this->UnitsInStock->EditCustomAttributes = "";
        $this->UnitsInStock->EditValue = $this->UnitsInStock->CurrentValue;
        $this->UnitsInStock->PlaceHolder = RemoveHtml($this->UnitsInStock->caption());

        // UnitsOnOrder
        $this->UnitsOnOrder->EditAttrs["class"] = "form-control";
        $this->UnitsOnOrder->EditCustomAttributes = "";
        $this->UnitsOnOrder->EditValue = $this->UnitsOnOrder->CurrentValue;
        $this->UnitsOnOrder->PlaceHolder = RemoveHtml($this->UnitsOnOrder->caption());

        // ReorderLevel
        $this->ReorderLevel->EditAttrs["class"] = "form-control";
        $this->ReorderLevel->EditCustomAttributes = "";
        if (!$this->ReorderLevel->Raw) {
            $this->ReorderLevel->CurrentValue = HtmlDecode($this->ReorderLevel->CurrentValue);
        }
        $this->ReorderLevel->EditValue = $this->ReorderLevel->CurrentValue;
        $this->ReorderLevel->PlaceHolder = RemoveHtml($this->ReorderLevel->caption());

        // Discontinued
        $this->Discontinued->EditCustomAttributes = "";
        $this->Discontinued->EditValue = $this->Discontinued->options(false);
        $this->Discontinued->PlaceHolder = RemoveHtml($this->Discontinued->caption());

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
                    $doc->exportCaption($this->CategoryID);
                    $doc->exportCaption($this->ProductID);
                    $doc->exportCaption($this->ProductName);
                    $doc->exportCaption($this->SupplierID);
                    $doc->exportCaption($this->QuantityPerUnit);
                    $doc->exportCaption($this->UnitPrice);
                    $doc->exportCaption($this->UnitsInStock);
                    $doc->exportCaption($this->UnitsOnOrder);
                    $doc->exportCaption($this->ReorderLevel);
                    $doc->exportCaption($this->Discontinued);
                } else {
                    $doc->exportCaption($this->CategoryID);
                    $doc->exportCaption($this->ProductID);
                    $doc->exportCaption($this->ProductName);
                    $doc->exportCaption($this->SupplierID);
                    $doc->exportCaption($this->QuantityPerUnit);
                    $doc->exportCaption($this->UnitPrice);
                    $doc->exportCaption($this->UnitsInStock);
                    $doc->exportCaption($this->UnitsOnOrder);
                    $doc->exportCaption($this->ReorderLevel);
                    $doc->exportCaption($this->Discontinued);
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
                        $doc->exportField($this->CategoryID);
                        $doc->exportField($this->ProductID);
                        $doc->exportField($this->ProductName);
                        $doc->exportField($this->SupplierID);
                        $doc->exportField($this->QuantityPerUnit);
                        $doc->exportField($this->UnitPrice);
                        $doc->exportField($this->UnitsInStock);
                        $doc->exportField($this->UnitsOnOrder);
                        $doc->exportField($this->ReorderLevel);
                        $doc->exportField($this->Discontinued);
                    } else {
                        $doc->exportField($this->CategoryID);
                        $doc->exportField($this->ProductID);
                        $doc->exportField($this->ProductName);
                        $doc->exportField($this->SupplierID);
                        $doc->exportField($this->QuantityPerUnit);
                        $doc->exportField($this->UnitPrice);
                        $doc->exportField($this->UnitsInStock);
                        $doc->exportField($this->UnitsOnOrder);
                        $doc->exportField($this->ReorderLevel);
                        $doc->exportField($this->Discontinued);
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

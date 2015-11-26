<?php

namespace Base;

use \Progetti as ChildProgetti;
use \ProgettiQuery as ChildProgettiQuery;
use \SpeseQuery as ChildSpeseQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\SpeseTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'spese' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Spese implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SpeseTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the idspesa field.
     *
     * @var        int
     */
    protected $idspesa;

    /**
     * The value for the progetti_idprogetto field.
     *
     * @var        int
     */
    protected $progetti_idprogetto;

    /**
     * The value for the dt_da field.
     *
     * @var        \DateTime
     */
    protected $dt_da;

    /**
     * The value for the dt_a field.
     *
     * @var        \DateTime
     */
    protected $dt_a;

    /**
     * The value for the spesa field.
     *
     * @var        string
     */
    protected $spesa;

    /**
     * The value for the tipologia field.
     *
     * @var        string
     */
    protected $tipologia;

    /**
     * The value for the reale_preventivo field.
     *
     * @var        string
     */
    protected $reale_preventivo;

    /**
     * @var        ChildProgetti
     */
    protected $aProgetti;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Base\Spese object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Spese</code> instance.  If
     * <code>obj</code> is an instance of <code>Spese</code>, delegates to
     * <code>equals(Spese)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Spese The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [idspesa] column value.
     *
     * @return int
     */
    public function getIdspesa()
    {
        return $this->idspesa;
    }

    /**
     * Get the [progetti_idprogetto] column value.
     *
     * @return int
     */
    public function getProgettiIdprogetto()
    {
        return $this->progetti_idprogetto;
    }

    /**
     * Get the [optionally formatted] temporal [dt_da] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDtDa($format = NULL)
    {
        if ($format === null) {
            return $this->dt_da;
        } else {
            return $this->dt_da instanceof \DateTime ? $this->dt_da->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [dt_a] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDtA($format = NULL)
    {
        if ($format === null) {
            return $this->dt_a;
        } else {
            return $this->dt_a instanceof \DateTime ? $this->dt_a->format($format) : null;
        }
    }

    /**
     * Get the [spesa] column value.
     *
     * @return string
     */
    public function getSpesa()
    {
        return $this->spesa;
    }

    /**
     * Get the [tipologia] column value.
     *
     * @return string
     */
    public function getTipologia()
    {
        return $this->tipologia;
    }

    /**
     * Get the [reale_preventivo] column value.
     *
     * @return string
     */
    public function getRealePreventivo()
    {
        return $this->reale_preventivo;
    }

    /**
     * Set the value of [idspesa] column.
     *
     * @param int $v new value
     * @return $this|\Spese The current object (for fluent API support)
     */
    public function setIdspesa($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->idspesa !== $v) {
            $this->idspesa = $v;
            $this->modifiedColumns[SpeseTableMap::COL_IDSPESA] = true;
        }

        return $this;
    } // setIdspesa()

    /**
     * Set the value of [progetti_idprogetto] column.
     *
     * @param int $v new value
     * @return $this|\Spese The current object (for fluent API support)
     */
    public function setProgettiIdprogetto($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->progetti_idprogetto !== $v) {
            $this->progetti_idprogetto = $v;
            $this->modifiedColumns[SpeseTableMap::COL_PROGETTI_IDPROGETTO] = true;
        }

        if ($this->aProgetti !== null && $this->aProgetti->getIdprogetto() !== $v) {
            $this->aProgetti = null;
        }

        return $this;
    } // setProgettiIdprogetto()

    /**
     * Sets the value of [dt_da] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Spese The current object (for fluent API support)
     */
    public function setDtDa($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->dt_da !== null || $dt !== null) {
            if ($this->dt_da === null || $dt === null || $dt->format("Y-m-d") !== $this->dt_da->format("Y-m-d")) {
                $this->dt_da = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SpeseTableMap::COL_DT_DA] = true;
            }
        } // if either are not null

        return $this;
    } // setDtDa()

    /**
     * Sets the value of [dt_a] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Spese The current object (for fluent API support)
     */
    public function setDtA($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->dt_a !== null || $dt !== null) {
            if ($this->dt_a === null || $dt === null || $dt->format("Y-m-d") !== $this->dt_a->format("Y-m-d")) {
                $this->dt_a = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SpeseTableMap::COL_DT_A] = true;
            }
        } // if either are not null

        return $this;
    } // setDtA()

    /**
     * Set the value of [spesa] column.
     *
     * @param string $v new value
     * @return $this|\Spese The current object (for fluent API support)
     */
    public function setSpesa($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->spesa !== $v) {
            $this->spesa = $v;
            $this->modifiedColumns[SpeseTableMap::COL_SPESA] = true;
        }

        return $this;
    } // setSpesa()

    /**
     * Set the value of [tipologia] column.
     *
     * @param string $v new value
     * @return $this|\Spese The current object (for fluent API support)
     */
    public function setTipologia($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tipologia !== $v) {
            $this->tipologia = $v;
            $this->modifiedColumns[SpeseTableMap::COL_TIPOLOGIA] = true;
        }

        return $this;
    } // setTipologia()

    /**
     * Set the value of [reale_preventivo] column.
     *
     * @param string $v new value
     * @return $this|\Spese The current object (for fluent API support)
     */
    public function setRealePreventivo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->reale_preventivo !== $v) {
            $this->reale_preventivo = $v;
            $this->modifiedColumns[SpeseTableMap::COL_REALE_PREVENTIVO] = true;
        }

        return $this;
    } // setRealePreventivo()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SpeseTableMap::translateFieldName('Idspesa', TableMap::TYPE_PHPNAME, $indexType)];
            $this->idspesa = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SpeseTableMap::translateFieldName('ProgettiIdprogetto', TableMap::TYPE_PHPNAME, $indexType)];
            $this->progetti_idprogetto = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SpeseTableMap::translateFieldName('DtDa', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->dt_da = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SpeseTableMap::translateFieldName('DtA', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->dt_a = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SpeseTableMap::translateFieldName('Spesa', TableMap::TYPE_PHPNAME, $indexType)];
            $this->spesa = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SpeseTableMap::translateFieldName('Tipologia', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tipologia = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SpeseTableMap::translateFieldName('RealePreventivo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->reale_preventivo = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = SpeseTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Spese'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aProgetti !== null && $this->progetti_idprogetto !== $this->aProgetti->getIdprogetto()) {
            $this->aProgetti = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SpeseTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSpeseQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aProgetti = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Spese::setDeleted()
     * @see Spese::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SpeseTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSpeseQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SpeseTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                SpeseTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aProgetti !== null) {
                if ($this->aProgetti->isModified() || $this->aProgetti->isNew()) {
                    $affectedRows += $this->aProgetti->save($con);
                }
                $this->setProgetti($this->aProgetti);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[SpeseTableMap::COL_IDSPESA] = true;
        if (null !== $this->idspesa) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SpeseTableMap::COL_IDSPESA . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SpeseTableMap::COL_IDSPESA)) {
            $modifiedColumns[':p' . $index++]  = 'idspesa';
        }
        if ($this->isColumnModified(SpeseTableMap::COL_PROGETTI_IDPROGETTO)) {
            $modifiedColumns[':p' . $index++]  = 'progetti_idprogetto';
        }
        if ($this->isColumnModified(SpeseTableMap::COL_DT_DA)) {
            $modifiedColumns[':p' . $index++]  = 'dt_da';
        }
        if ($this->isColumnModified(SpeseTableMap::COL_DT_A)) {
            $modifiedColumns[':p' . $index++]  = 'dt_a';
        }
        if ($this->isColumnModified(SpeseTableMap::COL_SPESA)) {
            $modifiedColumns[':p' . $index++]  = 'spesa';
        }
        if ($this->isColumnModified(SpeseTableMap::COL_TIPOLOGIA)) {
            $modifiedColumns[':p' . $index++]  = 'tipologia';
        }
        if ($this->isColumnModified(SpeseTableMap::COL_REALE_PREVENTIVO)) {
            $modifiedColumns[':p' . $index++]  = 'reale_preventivo';
        }

        $sql = sprintf(
            'INSERT INTO spese (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'idspesa':
                        $stmt->bindValue($identifier, $this->idspesa, PDO::PARAM_INT);
                        break;
                    case 'progetti_idprogetto':
                        $stmt->bindValue($identifier, $this->progetti_idprogetto, PDO::PARAM_INT);
                        break;
                    case 'dt_da':
                        $stmt->bindValue($identifier, $this->dt_da ? $this->dt_da->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'dt_a':
                        $stmt->bindValue($identifier, $this->dt_a ? $this->dt_a->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'spesa':
                        $stmt->bindValue($identifier, $this->spesa, PDO::PARAM_STR);
                        break;
                    case 'tipologia':
                        $stmt->bindValue($identifier, $this->tipologia, PDO::PARAM_STR);
                        break;
                    case 'reale_preventivo':
                        $stmt->bindValue($identifier, $this->reale_preventivo, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setIdspesa($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SpeseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getIdspesa();
                break;
            case 1:
                return $this->getProgettiIdprogetto();
                break;
            case 2:
                return $this->getDtDa();
                break;
            case 3:
                return $this->getDtA();
                break;
            case 4:
                return $this->getSpesa();
                break;
            case 5:
                return $this->getTipologia();
                break;
            case 6:
                return $this->getRealePreventivo();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Spese'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Spese'][$this->hashCode()] = true;
        $keys = SpeseTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdspesa(),
            $keys[1] => $this->getProgettiIdprogetto(),
            $keys[2] => $this->getDtDa(),
            $keys[3] => $this->getDtA(),
            $keys[4] => $this->getSpesa(),
            $keys[5] => $this->getTipologia(),
            $keys[6] => $this->getRealePreventivo(),
        );
        if ($result[$keys[2]] instanceof \DateTime) {
            $result[$keys[2]] = $result[$keys[2]]->format('c');
        }

        if ($result[$keys[3]] instanceof \DateTime) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aProgetti) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'progetti';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'progetti';
                        break;
                    default:
                        $key = 'Progetti';
                }

                $result[$key] = $this->aProgetti->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Spese
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SpeseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Spese
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdspesa($value);
                break;
            case 1:
                $this->setProgettiIdprogetto($value);
                break;
            case 2:
                $this->setDtDa($value);
                break;
            case 3:
                $this->setDtA($value);
                break;
            case 4:
                $this->setSpesa($value);
                break;
            case 5:
                $this->setTipologia($value);
                break;
            case 6:
                $this->setRealePreventivo($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = SpeseTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdspesa($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setProgettiIdprogetto($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDtDa($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDtA($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setSpesa($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setTipologia($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setRealePreventivo($arr[$keys[6]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Spese The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(SpeseTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SpeseTableMap::COL_IDSPESA)) {
            $criteria->add(SpeseTableMap::COL_IDSPESA, $this->idspesa);
        }
        if ($this->isColumnModified(SpeseTableMap::COL_PROGETTI_IDPROGETTO)) {
            $criteria->add(SpeseTableMap::COL_PROGETTI_IDPROGETTO, $this->progetti_idprogetto);
        }
        if ($this->isColumnModified(SpeseTableMap::COL_DT_DA)) {
            $criteria->add(SpeseTableMap::COL_DT_DA, $this->dt_da);
        }
        if ($this->isColumnModified(SpeseTableMap::COL_DT_A)) {
            $criteria->add(SpeseTableMap::COL_DT_A, $this->dt_a);
        }
        if ($this->isColumnModified(SpeseTableMap::COL_SPESA)) {
            $criteria->add(SpeseTableMap::COL_SPESA, $this->spesa);
        }
        if ($this->isColumnModified(SpeseTableMap::COL_TIPOLOGIA)) {
            $criteria->add(SpeseTableMap::COL_TIPOLOGIA, $this->tipologia);
        }
        if ($this->isColumnModified(SpeseTableMap::COL_REALE_PREVENTIVO)) {
            $criteria->add(SpeseTableMap::COL_REALE_PREVENTIVO, $this->reale_preventivo);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildSpeseQuery::create();
        $criteria->add(SpeseTableMap::COL_IDSPESA, $this->idspesa);
        $criteria->add(SpeseTableMap::COL_PROGETTI_IDPROGETTO, $this->progetti_idprogetto);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getIdspesa() &&
            null !== $this->getProgettiIdprogetto();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation fk_spese_progetti1 to table progetti
        if ($this->aProgetti && $hash = spl_object_hash($this->aProgetti)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getIdspesa();
        $pks[1] = $this->getProgettiIdprogetto();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setIdspesa($keys[0]);
        $this->setProgettiIdprogetto($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getIdspesa()) && (null === $this->getProgettiIdprogetto());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Spese (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setProgettiIdprogetto($this->getProgettiIdprogetto());
        $copyObj->setDtDa($this->getDtDa());
        $copyObj->setDtA($this->getDtA());
        $copyObj->setSpesa($this->getSpesa());
        $copyObj->setTipologia($this->getTipologia());
        $copyObj->setRealePreventivo($this->getRealePreventivo());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdspesa(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Spese Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildProgetti object.
     *
     * @param  ChildProgetti $v
     * @return $this|\Spese The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProgetti(ChildProgetti $v = null)
    {
        if ($v === null) {
            $this->setProgettiIdprogetto(NULL);
        } else {
            $this->setProgettiIdprogetto($v->getIdprogetto());
        }

        $this->aProgetti = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildProgetti object, it will not be re-added.
        if ($v !== null) {
            $v->addSpese($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildProgetti object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildProgetti The associated ChildProgetti object.
     * @throws PropelException
     */
    public function getProgetti(ConnectionInterface $con = null)
    {
        if ($this->aProgetti === null && ($this->progetti_idprogetto !== null)) {
            $this->aProgetti = ChildProgettiQuery::create()->findPk($this->progetti_idprogetto, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProgetti->addSpeses($this);
             */
        }

        return $this->aProgetti;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aProgetti) {
            $this->aProgetti->removeSpese($this);
        }
        $this->idspesa = null;
        $this->progetti_idprogetto = null;
        $this->dt_da = null;
        $this->dt_a = null;
        $this->spesa = null;
        $this->tipologia = null;
        $this->reale_preventivo = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

        $this->aProgetti = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SpeseTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}

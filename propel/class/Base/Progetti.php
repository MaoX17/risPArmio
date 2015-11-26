<?php

namespace Base;

use \Documenti as ChildDocumenti;
use \DocumentiQuery as ChildDocumentiQuery;
use \Progetti as ChildProgetti;
use \ProgettiQuery as ChildProgettiQuery;
use \Spese as ChildSpese;
use \SpeseQuery as ChildSpeseQuery;
use \Exception;
use \PDO;
use Map\ProgettiTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'progetti' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Progetti implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ProgettiTableMap';


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
     * The value for the idprogetto field.
     *
     * @var        int
     */
    protected $idprogetto;

    /**
     * The value for the progetto field.
     *
     * @var        string
     */
    protected $progetto;

    /**
     * The value for the descrizione field.
     *
     * @var        string
     */
    protected $descrizione;

    /**
     * @var        ObjectCollection|ChildDocumenti[] Collection to store aggregation of ChildDocumenti objects.
     */
    protected $collDocumentis;
    protected $collDocumentisPartial;

    /**
     * @var        ObjectCollection|ChildSpese[] Collection to store aggregation of ChildSpese objects.
     */
    protected $collSpeses;
    protected $collSpesesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDocumenti[]
     */
    protected $documentisScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSpese[]
     */
    protected $spesesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Progetti object.
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
     * Compares this with another <code>Progetti</code> instance.  If
     * <code>obj</code> is an instance of <code>Progetti</code>, delegates to
     * <code>equals(Progetti)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Progetti The current object, for fluid interface
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
     * Get the [idprogetto] column value.
     *
     * @return int
     */
    public function getIdprogetto()
    {
        return $this->idprogetto;
    }

    /**
     * Get the [progetto] column value.
     *
     * @return string
     */
    public function getProgetto()
    {
        return $this->progetto;
    }

    /**
     * Get the [descrizione] column value.
     *
     * @return string
     */
    public function getDescrizione()
    {
        return $this->descrizione;
    }

    /**
     * Set the value of [idprogetto] column.
     *
     * @param int $v new value
     * @return $this|\Progetti The current object (for fluent API support)
     */
    public function setIdprogetto($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->idprogetto !== $v) {
            $this->idprogetto = $v;
            $this->modifiedColumns[ProgettiTableMap::COL_IDPROGETTO] = true;
        }

        return $this;
    } // setIdprogetto()

    /**
     * Set the value of [progetto] column.
     *
     * @param string $v new value
     * @return $this|\Progetti The current object (for fluent API support)
     */
    public function setProgetto($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->progetto !== $v) {
            $this->progetto = $v;
            $this->modifiedColumns[ProgettiTableMap::COL_PROGETTO] = true;
        }

        return $this;
    } // setProgetto()

    /**
     * Set the value of [descrizione] column.
     *
     * @param string $v new value
     * @return $this|\Progetti The current object (for fluent API support)
     */
    public function setDescrizione($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->descrizione !== $v) {
            $this->descrizione = $v;
            $this->modifiedColumns[ProgettiTableMap::COL_DESCRIZIONE] = true;
        }

        return $this;
    } // setDescrizione()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ProgettiTableMap::translateFieldName('Idprogetto', TableMap::TYPE_PHPNAME, $indexType)];
            $this->idprogetto = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ProgettiTableMap::translateFieldName('Progetto', TableMap::TYPE_PHPNAME, $indexType)];
            $this->progetto = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ProgettiTableMap::translateFieldName('Descrizione', TableMap::TYPE_PHPNAME, $indexType)];
            $this->descrizione = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = ProgettiTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Progetti'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ProgettiTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildProgettiQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collDocumentis = null;

            $this->collSpeses = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Progetti::setDeleted()
     * @see Progetti::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProgettiTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildProgettiQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProgettiTableMap::DATABASE_NAME);
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
                ProgettiTableMap::addInstanceToPool($this);
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

            if ($this->documentisScheduledForDeletion !== null) {
                if (!$this->documentisScheduledForDeletion->isEmpty()) {
                    \DocumentiQuery::create()
                        ->filterByPrimaryKeys($this->documentisScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->documentisScheduledForDeletion = null;
                }
            }

            if ($this->collDocumentis !== null) {
                foreach ($this->collDocumentis as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->spesesScheduledForDeletion !== null) {
                if (!$this->spesesScheduledForDeletion->isEmpty()) {
                    \SpeseQuery::create()
                        ->filterByPrimaryKeys($this->spesesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->spesesScheduledForDeletion = null;
                }
            }

            if ($this->collSpeses !== null) {
                foreach ($this->collSpeses as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

        $this->modifiedColumns[ProgettiTableMap::COL_IDPROGETTO] = true;
        if (null !== $this->idprogetto) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProgettiTableMap::COL_IDPROGETTO . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProgettiTableMap::COL_IDPROGETTO)) {
            $modifiedColumns[':p' . $index++]  = 'idprogetto';
        }
        if ($this->isColumnModified(ProgettiTableMap::COL_PROGETTO)) {
            $modifiedColumns[':p' . $index++]  = 'progetto';
        }
        if ($this->isColumnModified(ProgettiTableMap::COL_DESCRIZIONE)) {
            $modifiedColumns[':p' . $index++]  = 'descrizione';
        }

        $sql = sprintf(
            'INSERT INTO progetti (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'idprogetto':
                        $stmt->bindValue($identifier, $this->idprogetto, PDO::PARAM_INT);
                        break;
                    case 'progetto':
                        $stmt->bindValue($identifier, $this->progetto, PDO::PARAM_STR);
                        break;
                    case 'descrizione':
                        $stmt->bindValue($identifier, $this->descrizione, PDO::PARAM_STR);
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
        $this->setIdprogetto($pk);

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
        $pos = ProgettiTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdprogetto();
                break;
            case 1:
                return $this->getProgetto();
                break;
            case 2:
                return $this->getDescrizione();
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

        if (isset($alreadyDumpedObjects['Progetti'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Progetti'][$this->hashCode()] = true;
        $keys = ProgettiTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdprogetto(),
            $keys[1] => $this->getProgetto(),
            $keys[2] => $this->getDescrizione(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collDocumentis) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'documentis';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'documentis';
                        break;
                    default:
                        $key = 'Documentis';
                }

                $result[$key] = $this->collDocumentis->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSpeses) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'speses';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'speses';
                        break;
                    default:
                        $key = 'Speses';
                }

                $result[$key] = $this->collSpeses->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Progetti
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ProgettiTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Progetti
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdprogetto($value);
                break;
            case 1:
                $this->setProgetto($value);
                break;
            case 2:
                $this->setDescrizione($value);
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
        $keys = ProgettiTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdprogetto($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setProgetto($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDescrizione($arr[$keys[2]]);
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
     * @return $this|\Progetti The current object, for fluid interface
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
        $criteria = new Criteria(ProgettiTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ProgettiTableMap::COL_IDPROGETTO)) {
            $criteria->add(ProgettiTableMap::COL_IDPROGETTO, $this->idprogetto);
        }
        if ($this->isColumnModified(ProgettiTableMap::COL_PROGETTO)) {
            $criteria->add(ProgettiTableMap::COL_PROGETTO, $this->progetto);
        }
        if ($this->isColumnModified(ProgettiTableMap::COL_DESCRIZIONE)) {
            $criteria->add(ProgettiTableMap::COL_DESCRIZIONE, $this->descrizione);
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
        $criteria = ChildProgettiQuery::create();
        $criteria->add(ProgettiTableMap::COL_IDPROGETTO, $this->idprogetto);

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
        $validPk = null !== $this->getIdprogetto();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdprogetto();
    }

    /**
     * Generic method to set the primary key (idprogetto column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdprogetto($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdprogetto();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Progetti (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setProgetto($this->getProgetto());
        $copyObj->setDescrizione($this->getDescrizione());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getDocumentis() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDocumenti($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSpeses() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSpese($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdprogetto(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Progetti Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Documenti' == $relationName) {
            return $this->initDocumentis();
        }
        if ('Spese' == $relationName) {
            return $this->initSpeses();
        }
    }

    /**
     * Clears out the collDocumentis collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDocumentis()
     */
    public function clearDocumentis()
    {
        $this->collDocumentis = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDocumentis collection loaded partially.
     */
    public function resetPartialDocumentis($v = true)
    {
        $this->collDocumentisPartial = $v;
    }

    /**
     * Initializes the collDocumentis collection.
     *
     * By default this just sets the collDocumentis collection to an empty array (like clearcollDocumentis());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDocumentis($overrideExisting = true)
    {
        if (null !== $this->collDocumentis && !$overrideExisting) {
            return;
        }
        $this->collDocumentis = new ObjectCollection();
        $this->collDocumentis->setModel('\Documenti');
    }

    /**
     * Gets an array of ChildDocumenti objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProgetti is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDocumenti[] List of ChildDocumenti objects
     * @throws PropelException
     */
    public function getDocumentis(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDocumentisPartial && !$this->isNew();
        if (null === $this->collDocumentis || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDocumentis) {
                // return empty collection
                $this->initDocumentis();
            } else {
                $collDocumentis = ChildDocumentiQuery::create(null, $criteria)
                    ->filterByProgetti($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDocumentisPartial && count($collDocumentis)) {
                        $this->initDocumentis(false);

                        foreach ($collDocumentis as $obj) {
                            if (false == $this->collDocumentis->contains($obj)) {
                                $this->collDocumentis->append($obj);
                            }
                        }

                        $this->collDocumentisPartial = true;
                    }

                    return $collDocumentis;
                }

                if ($partial && $this->collDocumentis) {
                    foreach ($this->collDocumentis as $obj) {
                        if ($obj->isNew()) {
                            $collDocumentis[] = $obj;
                        }
                    }
                }

                $this->collDocumentis = $collDocumentis;
                $this->collDocumentisPartial = false;
            }
        }

        return $this->collDocumentis;
    }

    /**
     * Sets a collection of ChildDocumenti objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $documentis A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildProgetti The current object (for fluent API support)
     */
    public function setDocumentis(Collection $documentis, ConnectionInterface $con = null)
    {
        /** @var ChildDocumenti[] $documentisToDelete */
        $documentisToDelete = $this->getDocumentis(new Criteria(), $con)->diff($documentis);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->documentisScheduledForDeletion = clone $documentisToDelete;

        foreach ($documentisToDelete as $documentiRemoved) {
            $documentiRemoved->setProgetti(null);
        }

        $this->collDocumentis = null;
        foreach ($documentis as $documenti) {
            $this->addDocumenti($documenti);
        }

        $this->collDocumentis = $documentis;
        $this->collDocumentisPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Documenti objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Documenti objects.
     * @throws PropelException
     */
    public function countDocumentis(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDocumentisPartial && !$this->isNew();
        if (null === $this->collDocumentis || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDocumentis) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDocumentis());
            }

            $query = ChildDocumentiQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProgetti($this)
                ->count($con);
        }

        return count($this->collDocumentis);
    }

    /**
     * Method called to associate a ChildDocumenti object to this object
     * through the ChildDocumenti foreign key attribute.
     *
     * @param  ChildDocumenti $l ChildDocumenti
     * @return $this|\Progetti The current object (for fluent API support)
     */
    public function addDocumenti(ChildDocumenti $l)
    {
        if ($this->collDocumentis === null) {
            $this->initDocumentis();
            $this->collDocumentisPartial = true;
        }

        if (!$this->collDocumentis->contains($l)) {
            $this->doAddDocumenti($l);
        }

        return $this;
    }

    /**
     * @param ChildDocumenti $documenti The ChildDocumenti object to add.
     */
    protected function doAddDocumenti(ChildDocumenti $documenti)
    {
        $this->collDocumentis[]= $documenti;
        $documenti->setProgetti($this);
    }

    /**
     * @param  ChildDocumenti $documenti The ChildDocumenti object to remove.
     * @return $this|ChildProgetti The current object (for fluent API support)
     */
    public function removeDocumenti(ChildDocumenti $documenti)
    {
        if ($this->getDocumentis()->contains($documenti)) {
            $pos = $this->collDocumentis->search($documenti);
            $this->collDocumentis->remove($pos);
            if (null === $this->documentisScheduledForDeletion) {
                $this->documentisScheduledForDeletion = clone $this->collDocumentis;
                $this->documentisScheduledForDeletion->clear();
            }
            $this->documentisScheduledForDeletion[]= clone $documenti;
            $documenti->setProgetti(null);
        }

        return $this;
    }

    /**
     * Clears out the collSpeses collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSpeses()
     */
    public function clearSpeses()
    {
        $this->collSpeses = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSpeses collection loaded partially.
     */
    public function resetPartialSpeses($v = true)
    {
        $this->collSpesesPartial = $v;
    }

    /**
     * Initializes the collSpeses collection.
     *
     * By default this just sets the collSpeses collection to an empty array (like clearcollSpeses());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSpeses($overrideExisting = true)
    {
        if (null !== $this->collSpeses && !$overrideExisting) {
            return;
        }
        $this->collSpeses = new ObjectCollection();
        $this->collSpeses->setModel('\Spese');
    }

    /**
     * Gets an array of ChildSpese objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProgetti is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSpese[] List of ChildSpese objects
     * @throws PropelException
     */
    public function getSpeses(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSpesesPartial && !$this->isNew();
        if (null === $this->collSpeses || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSpeses) {
                // return empty collection
                $this->initSpeses();
            } else {
                $collSpeses = ChildSpeseQuery::create(null, $criteria)
                    ->filterByProgetti($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSpesesPartial && count($collSpeses)) {
                        $this->initSpeses(false);

                        foreach ($collSpeses as $obj) {
                            if (false == $this->collSpeses->contains($obj)) {
                                $this->collSpeses->append($obj);
                            }
                        }

                        $this->collSpesesPartial = true;
                    }

                    return $collSpeses;
                }

                if ($partial && $this->collSpeses) {
                    foreach ($this->collSpeses as $obj) {
                        if ($obj->isNew()) {
                            $collSpeses[] = $obj;
                        }
                    }
                }

                $this->collSpeses = $collSpeses;
                $this->collSpesesPartial = false;
            }
        }

        return $this->collSpeses;
    }

    /**
     * Sets a collection of ChildSpese objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $speses A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildProgetti The current object (for fluent API support)
     */
    public function setSpeses(Collection $speses, ConnectionInterface $con = null)
    {
        /** @var ChildSpese[] $spesesToDelete */
        $spesesToDelete = $this->getSpeses(new Criteria(), $con)->diff($speses);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->spesesScheduledForDeletion = clone $spesesToDelete;

        foreach ($spesesToDelete as $speseRemoved) {
            $speseRemoved->setProgetti(null);
        }

        $this->collSpeses = null;
        foreach ($speses as $spese) {
            $this->addSpese($spese);
        }

        $this->collSpeses = $speses;
        $this->collSpesesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Spese objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Spese objects.
     * @throws PropelException
     */
    public function countSpeses(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSpesesPartial && !$this->isNew();
        if (null === $this->collSpeses || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSpeses) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSpeses());
            }

            $query = ChildSpeseQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProgetti($this)
                ->count($con);
        }

        return count($this->collSpeses);
    }

    /**
     * Method called to associate a ChildSpese object to this object
     * through the ChildSpese foreign key attribute.
     *
     * @param  ChildSpese $l ChildSpese
     * @return $this|\Progetti The current object (for fluent API support)
     */
    public function addSpese(ChildSpese $l)
    {
        if ($this->collSpeses === null) {
            $this->initSpeses();
            $this->collSpesesPartial = true;
        }

        if (!$this->collSpeses->contains($l)) {
            $this->doAddSpese($l);
        }

        return $this;
    }

    /**
     * @param ChildSpese $spese The ChildSpese object to add.
     */
    protected function doAddSpese(ChildSpese $spese)
    {
        $this->collSpeses[]= $spese;
        $spese->setProgetti($this);
    }

    /**
     * @param  ChildSpese $spese The ChildSpese object to remove.
     * @return $this|ChildProgetti The current object (for fluent API support)
     */
    public function removeSpese(ChildSpese $spese)
    {
        if ($this->getSpeses()->contains($spese)) {
            $pos = $this->collSpeses->search($spese);
            $this->collSpeses->remove($pos);
            if (null === $this->spesesScheduledForDeletion) {
                $this->spesesScheduledForDeletion = clone $this->collSpeses;
                $this->spesesScheduledForDeletion->clear();
            }
            $this->spesesScheduledForDeletion[]= clone $spese;
            $spese->setProgetti(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->idprogetto = null;
        $this->progetto = null;
        $this->descrizione = null;
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
            if ($this->collDocumentis) {
                foreach ($this->collDocumentis as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSpeses) {
                foreach ($this->collSpeses as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collDocumentis = null;
        $this->collSpeses = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProgettiTableMap::DEFAULT_STRING_FORMAT);
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

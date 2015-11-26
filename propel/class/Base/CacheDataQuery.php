<?php

namespace Base;

use \CacheData as ChildCacheData;
use \CacheDataQuery as ChildCacheDataQuery;
use \Exception;
use \PDO;
use Map\CacheDataTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'cache_data' table.
 *
 *
 *
 * @method     ChildCacheDataQuery orderByIdCacheData($order = Criteria::ASC) Order by the id_cache_data column
 * @method     ChildCacheDataQuery orderByDt($order = Criteria::ASC) Order by the dt column
 * @method     ChildCacheDataQuery orderByTot($order = Criteria::ASC) Order by the tot column
 *
 * @method     ChildCacheDataQuery groupByIdCacheData() Group by the id_cache_data column
 * @method     ChildCacheDataQuery groupByDt() Group by the dt column
 * @method     ChildCacheDataQuery groupByTot() Group by the tot column
 *
 * @method     ChildCacheDataQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCacheDataQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCacheDataQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCacheDataQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCacheDataQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCacheDataQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCacheData findOne(ConnectionInterface $con = null) Return the first ChildCacheData matching the query
 * @method     ChildCacheData findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCacheData matching the query, or a new ChildCacheData object populated from the query conditions when no match is found
 *
 * @method     ChildCacheData findOneByIdCacheData(int $id_cache_data) Return the first ChildCacheData filtered by the id_cache_data column
 * @method     ChildCacheData findOneByDt(string $dt) Return the first ChildCacheData filtered by the dt column
 * @method     ChildCacheData findOneByTot(string $tot) Return the first ChildCacheData filtered by the tot column *

 * @method     ChildCacheData requirePk($key, ConnectionInterface $con = null) Return the ChildCacheData by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCacheData requireOne(ConnectionInterface $con = null) Return the first ChildCacheData matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCacheData requireOneByIdCacheData(int $id_cache_data) Return the first ChildCacheData filtered by the id_cache_data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCacheData requireOneByDt(string $dt) Return the first ChildCacheData filtered by the dt column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCacheData requireOneByTot(string $tot) Return the first ChildCacheData filtered by the tot column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCacheData[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCacheData objects based on current ModelCriteria
 * @method     ChildCacheData[]|ObjectCollection findByIdCacheData(int $id_cache_data) Return ChildCacheData objects filtered by the id_cache_data column
 * @method     ChildCacheData[]|ObjectCollection findByDt(string $dt) Return ChildCacheData objects filtered by the dt column
 * @method     ChildCacheData[]|ObjectCollection findByTot(string $tot) Return ChildCacheData objects filtered by the tot column
 * @method     ChildCacheData[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CacheDataQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CacheDataQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\CacheData', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCacheDataQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCacheDataQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCacheDataQuery) {
            return $criteria;
        }
        $query = new ChildCacheDataQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCacheData|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CacheDataTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CacheDataTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCacheData A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_cache_data, dt, tot FROM cache_data WHERE id_cache_data = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCacheData $obj */
            $obj = new ChildCacheData();
            $obj->hydrate($row);
            CacheDataTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildCacheData|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildCacheDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CacheDataTableMap::COL_ID_CACHE_DATA, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCacheDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CacheDataTableMap::COL_ID_CACHE_DATA, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_cache_data column
     *
     * Example usage:
     * <code>
     * $query->filterByIdCacheData(1234); // WHERE id_cache_data = 1234
     * $query->filterByIdCacheData(array(12, 34)); // WHERE id_cache_data IN (12, 34)
     * $query->filterByIdCacheData(array('min' => 12)); // WHERE id_cache_data > 12
     * </code>
     *
     * @param     mixed $idCacheData The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCacheDataQuery The current query, for fluid interface
     */
    public function filterByIdCacheData($idCacheData = null, $comparison = null)
    {
        if (is_array($idCacheData)) {
            $useMinMax = false;
            if (isset($idCacheData['min'])) {
                $this->addUsingAlias(CacheDataTableMap::COL_ID_CACHE_DATA, $idCacheData['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCacheData['max'])) {
                $this->addUsingAlias(CacheDataTableMap::COL_ID_CACHE_DATA, $idCacheData['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CacheDataTableMap::COL_ID_CACHE_DATA, $idCacheData, $comparison);
    }

    /**
     * Filter the query on the dt column
     *
     * Example usage:
     * <code>
     * $query->filterByDt('2011-03-14'); // WHERE dt = '2011-03-14'
     * $query->filterByDt('now'); // WHERE dt = '2011-03-14'
     * $query->filterByDt(array('max' => 'yesterday')); // WHERE dt > '2011-03-13'
     * </code>
     *
     * @param     mixed $dt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCacheDataQuery The current query, for fluid interface
     */
    public function filterByDt($dt = null, $comparison = null)
    {
        if (is_array($dt)) {
            $useMinMax = false;
            if (isset($dt['min'])) {
                $this->addUsingAlias(CacheDataTableMap::COL_DT, $dt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dt['max'])) {
                $this->addUsingAlias(CacheDataTableMap::COL_DT, $dt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CacheDataTableMap::COL_DT, $dt, $comparison);
    }

    /**
     * Filter the query on the tot column
     *
     * Example usage:
     * <code>
     * $query->filterByTot(1234); // WHERE tot = 1234
     * $query->filterByTot(array(12, 34)); // WHERE tot IN (12, 34)
     * $query->filterByTot(array('min' => 12)); // WHERE tot > 12
     * </code>
     *
     * @param     mixed $tot The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCacheDataQuery The current query, for fluid interface
     */
    public function filterByTot($tot = null, $comparison = null)
    {
        if (is_array($tot)) {
            $useMinMax = false;
            if (isset($tot['min'])) {
                $this->addUsingAlias(CacheDataTableMap::COL_TOT, $tot['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($tot['max'])) {
                $this->addUsingAlias(CacheDataTableMap::COL_TOT, $tot['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CacheDataTableMap::COL_TOT, $tot, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCacheData $cacheData Object to remove from the list of results
     *
     * @return $this|ChildCacheDataQuery The current query, for fluid interface
     */
    public function prune($cacheData = null)
    {
        if ($cacheData) {
            $this->addUsingAlias(CacheDataTableMap::COL_ID_CACHE_DATA, $cacheData->getIdCacheData(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the cache_data table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CacheDataTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CacheDataTableMap::clearInstancePool();
            CacheDataTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CacheDataTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CacheDataTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CacheDataTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CacheDataTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CacheDataQuery

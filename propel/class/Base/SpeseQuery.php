<?php

namespace Base;

use \Spese as ChildSpese;
use \SpeseQuery as ChildSpeseQuery;
use \Exception;
use \PDO;
use Map\SpeseTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'spese' table.
 *
 *
 *
 * @method     ChildSpeseQuery orderByIdspesa($order = Criteria::ASC) Order by the idspesa column
 * @method     ChildSpeseQuery orderByProgettiIdprogetto($order = Criteria::ASC) Order by the progetti_idprogetto column
 * @method     ChildSpeseQuery orderByDtDa($order = Criteria::ASC) Order by the dt_da column
 * @method     ChildSpeseQuery orderByDtA($order = Criteria::ASC) Order by the dt_a column
 * @method     ChildSpeseQuery orderBySpesa($order = Criteria::ASC) Order by the spesa column
 * @method     ChildSpeseQuery orderByTipologia($order = Criteria::ASC) Order by the tipologia column
 * @method     ChildSpeseQuery orderByRealePreventivo($order = Criteria::ASC) Order by the reale_preventivo column
 *
 * @method     ChildSpeseQuery groupByIdspesa() Group by the idspesa column
 * @method     ChildSpeseQuery groupByProgettiIdprogetto() Group by the progetti_idprogetto column
 * @method     ChildSpeseQuery groupByDtDa() Group by the dt_da column
 * @method     ChildSpeseQuery groupByDtA() Group by the dt_a column
 * @method     ChildSpeseQuery groupBySpesa() Group by the spesa column
 * @method     ChildSpeseQuery groupByTipologia() Group by the tipologia column
 * @method     ChildSpeseQuery groupByRealePreventivo() Group by the reale_preventivo column
 *
 * @method     ChildSpeseQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSpeseQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSpeseQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSpeseQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSpeseQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSpeseQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSpeseQuery leftJoinProgetti($relationAlias = null) Adds a LEFT JOIN clause to the query using the Progetti relation
 * @method     ChildSpeseQuery rightJoinProgetti($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Progetti relation
 * @method     ChildSpeseQuery innerJoinProgetti($relationAlias = null) Adds a INNER JOIN clause to the query using the Progetti relation
 *
 * @method     ChildSpeseQuery joinWithProgetti($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Progetti relation
 *
 * @method     ChildSpeseQuery leftJoinWithProgetti() Adds a LEFT JOIN clause and with to the query using the Progetti relation
 * @method     ChildSpeseQuery rightJoinWithProgetti() Adds a RIGHT JOIN clause and with to the query using the Progetti relation
 * @method     ChildSpeseQuery innerJoinWithProgetti() Adds a INNER JOIN clause and with to the query using the Progetti relation
 *
 * @method     \ProgettiQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSpese findOne(ConnectionInterface $con = null) Return the first ChildSpese matching the query
 * @method     ChildSpese findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSpese matching the query, or a new ChildSpese object populated from the query conditions when no match is found
 *
 * @method     ChildSpese findOneByIdspesa(int $idspesa) Return the first ChildSpese filtered by the idspesa column
 * @method     ChildSpese findOneByProgettiIdprogetto(int $progetti_idprogetto) Return the first ChildSpese filtered by the progetti_idprogetto column
 * @method     ChildSpese findOneByDtDa(string $dt_da) Return the first ChildSpese filtered by the dt_da column
 * @method     ChildSpese findOneByDtA(string $dt_a) Return the first ChildSpese filtered by the dt_a column
 * @method     ChildSpese findOneBySpesa(string $spesa) Return the first ChildSpese filtered by the spesa column
 * @method     ChildSpese findOneByTipologia(string $tipologia) Return the first ChildSpese filtered by the tipologia column
 * @method     ChildSpese findOneByRealePreventivo(string $reale_preventivo) Return the first ChildSpese filtered by the reale_preventivo column *

 * @method     ChildSpese requirePk($key, ConnectionInterface $con = null) Return the ChildSpese by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSpese requireOne(ConnectionInterface $con = null) Return the first ChildSpese matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSpese requireOneByIdspesa(int $idspesa) Return the first ChildSpese filtered by the idspesa column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSpese requireOneByProgettiIdprogetto(int $progetti_idprogetto) Return the first ChildSpese filtered by the progetti_idprogetto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSpese requireOneByDtDa(string $dt_da) Return the first ChildSpese filtered by the dt_da column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSpese requireOneByDtA(string $dt_a) Return the first ChildSpese filtered by the dt_a column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSpese requireOneBySpesa(string $spesa) Return the first ChildSpese filtered by the spesa column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSpese requireOneByTipologia(string $tipologia) Return the first ChildSpese filtered by the tipologia column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSpese requireOneByRealePreventivo(string $reale_preventivo) Return the first ChildSpese filtered by the reale_preventivo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSpese[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSpese objects based on current ModelCriteria
 * @method     ChildSpese[]|ObjectCollection findByIdspesa(int $idspesa) Return ChildSpese objects filtered by the idspesa column
 * @method     ChildSpese[]|ObjectCollection findByProgettiIdprogetto(int $progetti_idprogetto) Return ChildSpese objects filtered by the progetti_idprogetto column
 * @method     ChildSpese[]|ObjectCollection findByDtDa(string $dt_da) Return ChildSpese objects filtered by the dt_da column
 * @method     ChildSpese[]|ObjectCollection findByDtA(string $dt_a) Return ChildSpese objects filtered by the dt_a column
 * @method     ChildSpese[]|ObjectCollection findBySpesa(string $spesa) Return ChildSpese objects filtered by the spesa column
 * @method     ChildSpese[]|ObjectCollection findByTipologia(string $tipologia) Return ChildSpese objects filtered by the tipologia column
 * @method     ChildSpese[]|ObjectCollection findByRealePreventivo(string $reale_preventivo) Return ChildSpese objects filtered by the reale_preventivo column
 * @method     ChildSpese[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SpeseQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SpeseQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Spese', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSpeseQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSpeseQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSpeseQuery) {
            return $criteria;
        }
        $query = new ChildSpeseQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$idspesa, $progetti_idprogetto] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSpese|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SpeseTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SpeseTableMap::DATABASE_NAME);
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
     * @return ChildSpese A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idspesa, progetti_idprogetto, dt_da, dt_a, spesa, tipologia, reale_preventivo FROM spese WHERE idspesa = :p0 AND progetti_idprogetto = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSpese $obj */
            $obj = new ChildSpese();
            $obj->hydrate($row);
            SpeseTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildSpese|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildSpeseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(SpeseTableMap::COL_IDSPESA, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(SpeseTableMap::COL_PROGETTI_IDPROGETTO, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSpeseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(SpeseTableMap::COL_IDSPESA, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(SpeseTableMap::COL_PROGETTI_IDPROGETTO, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the idspesa column
     *
     * Example usage:
     * <code>
     * $query->filterByIdspesa(1234); // WHERE idspesa = 1234
     * $query->filterByIdspesa(array(12, 34)); // WHERE idspesa IN (12, 34)
     * $query->filterByIdspesa(array('min' => 12)); // WHERE idspesa > 12
     * </code>
     *
     * @param     mixed $idspesa The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSpeseQuery The current query, for fluid interface
     */
    public function filterByIdspesa($idspesa = null, $comparison = null)
    {
        if (is_array($idspesa)) {
            $useMinMax = false;
            if (isset($idspesa['min'])) {
                $this->addUsingAlias(SpeseTableMap::COL_IDSPESA, $idspesa['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idspesa['max'])) {
                $this->addUsingAlias(SpeseTableMap::COL_IDSPESA, $idspesa['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SpeseTableMap::COL_IDSPESA, $idspesa, $comparison);
    }

    /**
     * Filter the query on the progetti_idprogetto column
     *
     * Example usage:
     * <code>
     * $query->filterByProgettiIdprogetto(1234); // WHERE progetti_idprogetto = 1234
     * $query->filterByProgettiIdprogetto(array(12, 34)); // WHERE progetti_idprogetto IN (12, 34)
     * $query->filterByProgettiIdprogetto(array('min' => 12)); // WHERE progetti_idprogetto > 12
     * </code>
     *
     * @see       filterByProgetti()
     *
     * @param     mixed $progettiIdprogetto The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSpeseQuery The current query, for fluid interface
     */
    public function filterByProgettiIdprogetto($progettiIdprogetto = null, $comparison = null)
    {
        if (is_array($progettiIdprogetto)) {
            $useMinMax = false;
            if (isset($progettiIdprogetto['min'])) {
                $this->addUsingAlias(SpeseTableMap::COL_PROGETTI_IDPROGETTO, $progettiIdprogetto['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($progettiIdprogetto['max'])) {
                $this->addUsingAlias(SpeseTableMap::COL_PROGETTI_IDPROGETTO, $progettiIdprogetto['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SpeseTableMap::COL_PROGETTI_IDPROGETTO, $progettiIdprogetto, $comparison);
    }

    /**
     * Filter the query on the dt_da column
     *
     * Example usage:
     * <code>
     * $query->filterByDtDa('2011-03-14'); // WHERE dt_da = '2011-03-14'
     * $query->filterByDtDa('now'); // WHERE dt_da = '2011-03-14'
     * $query->filterByDtDa(array('max' => 'yesterday')); // WHERE dt_da > '2011-03-13'
     * </code>
     *
     * @param     mixed $dtDa The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSpeseQuery The current query, for fluid interface
     */
    public function filterByDtDa($dtDa = null, $comparison = null)
    {
        if (is_array($dtDa)) {
            $useMinMax = false;
            if (isset($dtDa['min'])) {
                $this->addUsingAlias(SpeseTableMap::COL_DT_DA, $dtDa['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dtDa['max'])) {
                $this->addUsingAlias(SpeseTableMap::COL_DT_DA, $dtDa['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SpeseTableMap::COL_DT_DA, $dtDa, $comparison);
    }

    /**
     * Filter the query on the dt_a column
     *
     * Example usage:
     * <code>
     * $query->filterByDtA('2011-03-14'); // WHERE dt_a = '2011-03-14'
     * $query->filterByDtA('now'); // WHERE dt_a = '2011-03-14'
     * $query->filterByDtA(array('max' => 'yesterday')); // WHERE dt_a > '2011-03-13'
     * </code>
     *
     * @param     mixed $dtA The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSpeseQuery The current query, for fluid interface
     */
    public function filterByDtA($dtA = null, $comparison = null)
    {
        if (is_array($dtA)) {
            $useMinMax = false;
            if (isset($dtA['min'])) {
                $this->addUsingAlias(SpeseTableMap::COL_DT_A, $dtA['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dtA['max'])) {
                $this->addUsingAlias(SpeseTableMap::COL_DT_A, $dtA['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SpeseTableMap::COL_DT_A, $dtA, $comparison);
    }

    /**
     * Filter the query on the spesa column
     *
     * Example usage:
     * <code>
     * $query->filterBySpesa(1234); // WHERE spesa = 1234
     * $query->filterBySpesa(array(12, 34)); // WHERE spesa IN (12, 34)
     * $query->filterBySpesa(array('min' => 12)); // WHERE spesa > 12
     * </code>
     *
     * @param     mixed $spesa The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSpeseQuery The current query, for fluid interface
     */
    public function filterBySpesa($spesa = null, $comparison = null)
    {
        if (is_array($spesa)) {
            $useMinMax = false;
            if (isset($spesa['min'])) {
                $this->addUsingAlias(SpeseTableMap::COL_SPESA, $spesa['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($spesa['max'])) {
                $this->addUsingAlias(SpeseTableMap::COL_SPESA, $spesa['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SpeseTableMap::COL_SPESA, $spesa, $comparison);
    }

    /**
     * Filter the query on the tipologia column
     *
     * Example usage:
     * <code>
     * $query->filterByTipologia('fooValue');   // WHERE tipologia = 'fooValue'
     * $query->filterByTipologia('%fooValue%'); // WHERE tipologia LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tipologia The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSpeseQuery The current query, for fluid interface
     */
    public function filterByTipologia($tipologia = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tipologia)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tipologia)) {
                $tipologia = str_replace('*', '%', $tipologia);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SpeseTableMap::COL_TIPOLOGIA, $tipologia, $comparison);
    }

    /**
     * Filter the query on the reale_preventivo column
     *
     * Example usage:
     * <code>
     * $query->filterByRealePreventivo('fooValue');   // WHERE reale_preventivo = 'fooValue'
     * $query->filterByRealePreventivo('%fooValue%'); // WHERE reale_preventivo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $realePreventivo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSpeseQuery The current query, for fluid interface
     */
    public function filterByRealePreventivo($realePreventivo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($realePreventivo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $realePreventivo)) {
                $realePreventivo = str_replace('*', '%', $realePreventivo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SpeseTableMap::COL_REALE_PREVENTIVO, $realePreventivo, $comparison);
    }

    /**
     * Filter the query by a related \Progetti object
     *
     * @param \Progetti|ObjectCollection $progetti The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSpeseQuery The current query, for fluid interface
     */
    public function filterByProgetti($progetti, $comparison = null)
    {
        if ($progetti instanceof \Progetti) {
            return $this
                ->addUsingAlias(SpeseTableMap::COL_PROGETTI_IDPROGETTO, $progetti->getIdprogetto(), $comparison);
        } elseif ($progetti instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SpeseTableMap::COL_PROGETTI_IDPROGETTO, $progetti->toKeyValue('PrimaryKey', 'Idprogetto'), $comparison);
        } else {
            throw new PropelException('filterByProgetti() only accepts arguments of type \Progetti or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Progetti relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSpeseQuery The current query, for fluid interface
     */
    public function joinProgetti($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Progetti');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Progetti');
        }

        return $this;
    }

    /**
     * Use the Progetti relation Progetti object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProgettiQuery A secondary query class using the current class as primary query
     */
    public function useProgettiQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProgetti($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Progetti', '\ProgettiQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSpese $spese Object to remove from the list of results
     *
     * @return $this|ChildSpeseQuery The current query, for fluid interface
     */
    public function prune($spese = null)
    {
        if ($spese) {
            $this->addCond('pruneCond0', $this->getAliasedColName(SpeseTableMap::COL_IDSPESA), $spese->getIdspesa(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(SpeseTableMap::COL_PROGETTI_IDPROGETTO), $spese->getProgettiIdprogetto(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the spese table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SpeseTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SpeseTableMap::clearInstancePool();
            SpeseTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SpeseTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SpeseTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SpeseTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SpeseTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SpeseQuery

<?php

namespace Base;

use \Documenti as ChildDocumenti;
use \DocumentiQuery as ChildDocumentiQuery;
use \Exception;
use \PDO;
use Map\DocumentiTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'documenti' table.
 *
 *
 *
 * @method     ChildDocumentiQuery orderByIddocumento($order = Criteria::ASC) Order by the iddocumento column
 * @method     ChildDocumentiQuery orderByProgettiIdprogetto($order = Criteria::ASC) Order by the progetti_idprogetto column
 * @method     ChildDocumentiQuery orderByDocumento($order = Criteria::ASC) Order by the documento column
 * @method     ChildDocumentiQuery orderByDescrizione($order = Criteria::ASC) Order by the descrizione column
 *
 * @method     ChildDocumentiQuery groupByIddocumento() Group by the iddocumento column
 * @method     ChildDocumentiQuery groupByProgettiIdprogetto() Group by the progetti_idprogetto column
 * @method     ChildDocumentiQuery groupByDocumento() Group by the documento column
 * @method     ChildDocumentiQuery groupByDescrizione() Group by the descrizione column
 *
 * @method     ChildDocumentiQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDocumentiQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDocumentiQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDocumentiQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDocumentiQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDocumentiQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDocumentiQuery leftJoinProgetti($relationAlias = null) Adds a LEFT JOIN clause to the query using the Progetti relation
 * @method     ChildDocumentiQuery rightJoinProgetti($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Progetti relation
 * @method     ChildDocumentiQuery innerJoinProgetti($relationAlias = null) Adds a INNER JOIN clause to the query using the Progetti relation
 *
 * @method     ChildDocumentiQuery joinWithProgetti($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Progetti relation
 *
 * @method     ChildDocumentiQuery leftJoinWithProgetti() Adds a LEFT JOIN clause and with to the query using the Progetti relation
 * @method     ChildDocumentiQuery rightJoinWithProgetti() Adds a RIGHT JOIN clause and with to the query using the Progetti relation
 * @method     ChildDocumentiQuery innerJoinWithProgetti() Adds a INNER JOIN clause and with to the query using the Progetti relation
 *
 * @method     \ProgettiQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDocumenti findOne(ConnectionInterface $con = null) Return the first ChildDocumenti matching the query
 * @method     ChildDocumenti findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDocumenti matching the query, or a new ChildDocumenti object populated from the query conditions when no match is found
 *
 * @method     ChildDocumenti findOneByIddocumento(int $iddocumento) Return the first ChildDocumenti filtered by the iddocumento column
 * @method     ChildDocumenti findOneByProgettiIdprogetto(int $progetti_idprogetto) Return the first ChildDocumenti filtered by the progetti_idprogetto column
 * @method     ChildDocumenti findOneByDocumento(string $documento) Return the first ChildDocumenti filtered by the documento column
 * @method     ChildDocumenti findOneByDescrizione(string $descrizione) Return the first ChildDocumenti filtered by the descrizione column *

 * @method     ChildDocumenti requirePk($key, ConnectionInterface $con = null) Return the ChildDocumenti by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumenti requireOne(ConnectionInterface $con = null) Return the first ChildDocumenti matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDocumenti requireOneByIddocumento(int $iddocumento) Return the first ChildDocumenti filtered by the iddocumento column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumenti requireOneByProgettiIdprogetto(int $progetti_idprogetto) Return the first ChildDocumenti filtered by the progetti_idprogetto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumenti requireOneByDocumento(string $documento) Return the first ChildDocumenti filtered by the documento column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumenti requireOneByDescrizione(string $descrizione) Return the first ChildDocumenti filtered by the descrizione column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDocumenti[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDocumenti objects based on current ModelCriteria
 * @method     ChildDocumenti[]|ObjectCollection findByIddocumento(int $iddocumento) Return ChildDocumenti objects filtered by the iddocumento column
 * @method     ChildDocumenti[]|ObjectCollection findByProgettiIdprogetto(int $progetti_idprogetto) Return ChildDocumenti objects filtered by the progetti_idprogetto column
 * @method     ChildDocumenti[]|ObjectCollection findByDocumento(string $documento) Return ChildDocumenti objects filtered by the documento column
 * @method     ChildDocumenti[]|ObjectCollection findByDescrizione(string $descrizione) Return ChildDocumenti objects filtered by the descrizione column
 * @method     ChildDocumenti[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DocumentiQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DocumentiQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Documenti', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDocumentiQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDocumentiQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDocumentiQuery) {
            return $criteria;
        }
        $query = new ChildDocumentiQuery();
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
     * @param array[$iddocumento, $progetti_idprogetto] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildDocumenti|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DocumentiTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DocumentiTableMap::DATABASE_NAME);
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
     * @return ChildDocumenti A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT iddocumento, progetti_idprogetto, documento, descrizione FROM documenti WHERE iddocumento = :p0 AND progetti_idprogetto = :p1';
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
            /** @var ChildDocumenti $obj */
            $obj = new ChildDocumenti();
            $obj->hydrate($row);
            DocumentiTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildDocumenti|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDocumentiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(DocumentiTableMap::COL_IDDOCUMENTO, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(DocumentiTableMap::COL_PROGETTI_IDPROGETTO, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDocumentiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(DocumentiTableMap::COL_IDDOCUMENTO, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(DocumentiTableMap::COL_PROGETTI_IDPROGETTO, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the iddocumento column
     *
     * Example usage:
     * <code>
     * $query->filterByIddocumento(1234); // WHERE iddocumento = 1234
     * $query->filterByIddocumento(array(12, 34)); // WHERE iddocumento IN (12, 34)
     * $query->filterByIddocumento(array('min' => 12)); // WHERE iddocumento > 12
     * </code>
     *
     * @param     mixed $iddocumento The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentiQuery The current query, for fluid interface
     */
    public function filterByIddocumento($iddocumento = null, $comparison = null)
    {
        if (is_array($iddocumento)) {
            $useMinMax = false;
            if (isset($iddocumento['min'])) {
                $this->addUsingAlias(DocumentiTableMap::COL_IDDOCUMENTO, $iddocumento['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iddocumento['max'])) {
                $this->addUsingAlias(DocumentiTableMap::COL_IDDOCUMENTO, $iddocumento['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentiTableMap::COL_IDDOCUMENTO, $iddocumento, $comparison);
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
     * @return $this|ChildDocumentiQuery The current query, for fluid interface
     */
    public function filterByProgettiIdprogetto($progettiIdprogetto = null, $comparison = null)
    {
        if (is_array($progettiIdprogetto)) {
            $useMinMax = false;
            if (isset($progettiIdprogetto['min'])) {
                $this->addUsingAlias(DocumentiTableMap::COL_PROGETTI_IDPROGETTO, $progettiIdprogetto['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($progettiIdprogetto['max'])) {
                $this->addUsingAlias(DocumentiTableMap::COL_PROGETTI_IDPROGETTO, $progettiIdprogetto['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentiTableMap::COL_PROGETTI_IDPROGETTO, $progettiIdprogetto, $comparison);
    }

    /**
     * Filter the query on the documento column
     *
     * Example usage:
     * <code>
     * $query->filterByDocumento('fooValue');   // WHERE documento = 'fooValue'
     * $query->filterByDocumento('%fooValue%'); // WHERE documento LIKE '%fooValue%'
     * </code>
     *
     * @param     string $documento The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentiQuery The current query, for fluid interface
     */
    public function filterByDocumento($documento = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($documento)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $documento)) {
                $documento = str_replace('*', '%', $documento);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DocumentiTableMap::COL_DOCUMENTO, $documento, $comparison);
    }

    /**
     * Filter the query on the descrizione column
     *
     * Example usage:
     * <code>
     * $query->filterByDescrizione('fooValue');   // WHERE descrizione = 'fooValue'
     * $query->filterByDescrizione('%fooValue%'); // WHERE descrizione LIKE '%fooValue%'
     * </code>
     *
     * @param     string $descrizione The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentiQuery The current query, for fluid interface
     */
    public function filterByDescrizione($descrizione = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($descrizione)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $descrizione)) {
                $descrizione = str_replace('*', '%', $descrizione);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DocumentiTableMap::COL_DESCRIZIONE, $descrizione, $comparison);
    }

    /**
     * Filter the query by a related \Progetti object
     *
     * @param \Progetti|ObjectCollection $progetti The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDocumentiQuery The current query, for fluid interface
     */
    public function filterByProgetti($progetti, $comparison = null)
    {
        if ($progetti instanceof \Progetti) {
            return $this
                ->addUsingAlias(DocumentiTableMap::COL_PROGETTI_IDPROGETTO, $progetti->getIdprogetto(), $comparison);
        } elseif ($progetti instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DocumentiTableMap::COL_PROGETTI_IDPROGETTO, $progetti->toKeyValue('PrimaryKey', 'Idprogetto'), $comparison);
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
     * @return $this|ChildDocumentiQuery The current query, for fluid interface
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
     * @param   ChildDocumenti $documenti Object to remove from the list of results
     *
     * @return $this|ChildDocumentiQuery The current query, for fluid interface
     */
    public function prune($documenti = null)
    {
        if ($documenti) {
            $this->addCond('pruneCond0', $this->getAliasedColName(DocumentiTableMap::COL_IDDOCUMENTO), $documenti->getIddocumento(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(DocumentiTableMap::COL_PROGETTI_IDPROGETTO), $documenti->getProgettiIdprogetto(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the documenti table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DocumentiTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DocumentiTableMap::clearInstancePool();
            DocumentiTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DocumentiTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DocumentiTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DocumentiTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DocumentiTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DocumentiQuery

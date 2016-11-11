<?php

namespace Engine\Base;

use \Exception;
use \PDO;
use Engine\Feeds as ChildFeeds;
use Engine\FeedsQuery as ChildFeedsQuery;
use Engine\Map\FeedsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'feeds' table.
 *
 *
 *
 * @method     ChildFeedsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildFeedsQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildFeedsQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildFeedsQuery orderByAuthor($order = Criteria::ASC) Order by the author column
 * @method     ChildFeedsQuery orderByPubDate($order = Criteria::ASC) Order by the pub_date column
 * @method     ChildFeedsQuery orderByPubTime($order = Criteria::ASC) Order by the pub_time column
 * @method     ChildFeedsQuery orderByThumbnail($order = Criteria::ASC) Order by the thumbnail column
 * @method     ChildFeedsQuery orderBySource($order = Criteria::ASC) Order by the source column
 *
 * @method     ChildFeedsQuery groupById() Group by the id column
 * @method     ChildFeedsQuery groupByTitle() Group by the title column
 * @method     ChildFeedsQuery groupByDescription() Group by the description column
 * @method     ChildFeedsQuery groupByAuthor() Group by the author column
 * @method     ChildFeedsQuery groupByPubDate() Group by the pub_date column
 * @method     ChildFeedsQuery groupByPubTime() Group by the pub_time column
 * @method     ChildFeedsQuery groupByThumbnail() Group by the thumbnail column
 * @method     ChildFeedsQuery groupBySource() Group by the source column
 *
 * @method     ChildFeedsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFeedsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFeedsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFeeds findOne(ConnectionInterface $con = null) Return the first ChildFeeds matching the query
 * @method     ChildFeeds findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFeeds matching the query, or a new ChildFeeds object populated from the query conditions when no match is found
 *
 * @method     ChildFeeds findOneById(int $id) Return the first ChildFeeds filtered by the id column
 * @method     ChildFeeds findOneByTitle(string $title) Return the first ChildFeeds filtered by the title column
 * @method     ChildFeeds findOneByDescription(string $description) Return the first ChildFeeds filtered by the description column
 * @method     ChildFeeds findOneByAuthor(string $author) Return the first ChildFeeds filtered by the author column
 * @method     ChildFeeds findOneByPubDate(string $pub_date) Return the first ChildFeeds filtered by the pub_date column
 * @method     ChildFeeds findOneByPubTime(string $pub_time) Return the first ChildFeeds filtered by the pub_time column
 * @method     ChildFeeds findOneByThumbnail(string $thumbnail) Return the first ChildFeeds filtered by the thumbnail column
 * @method     ChildFeeds findOneBySource(string $source) Return the first ChildFeeds filtered by the source column *

 * @method     ChildFeeds requirePk($key, ConnectionInterface $con = null) Return the ChildFeeds by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFeeds requireOne(ConnectionInterface $con = null) Return the first ChildFeeds matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFeeds requireOneById(int $id) Return the first ChildFeeds filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFeeds requireOneByTitle(string $title) Return the first ChildFeeds filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFeeds requireOneByDescription(string $description) Return the first ChildFeeds filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFeeds requireOneByAuthor(string $author) Return the first ChildFeeds filtered by the author column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFeeds requireOneByPubDate(string $pub_date) Return the first ChildFeeds filtered by the pub_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFeeds requireOneByPubTime(string $pub_time) Return the first ChildFeeds filtered by the pub_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFeeds requireOneByThumbnail(string $thumbnail) Return the first ChildFeeds filtered by the thumbnail column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFeeds requireOneBySource(string $source) Return the first ChildFeeds filtered by the source column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFeeds[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildFeeds objects based on current ModelCriteria
 * @method     ChildFeeds[]|ObjectCollection findById(int $id) Return ChildFeeds objects filtered by the id column
 * @method     ChildFeeds[]|ObjectCollection findByTitle(string $title) Return ChildFeeds objects filtered by the title column
 * @method     ChildFeeds[]|ObjectCollection findByDescription(string $description) Return ChildFeeds objects filtered by the description column
 * @method     ChildFeeds[]|ObjectCollection findByAuthor(string $author) Return ChildFeeds objects filtered by the author column
 * @method     ChildFeeds[]|ObjectCollection findByPubDate(string $pub_date) Return ChildFeeds objects filtered by the pub_date column
 * @method     ChildFeeds[]|ObjectCollection findByPubTime(string $pub_time) Return ChildFeeds objects filtered by the pub_time column
 * @method     ChildFeeds[]|ObjectCollection findByThumbnail(string $thumbnail) Return ChildFeeds objects filtered by the thumbnail column
 * @method     ChildFeeds[]|ObjectCollection findBySource(string $source) Return ChildFeeds objects filtered by the source column
 * @method     ChildFeeds[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FeedsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Engine\Base\FeedsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'engine', $modelName = '\\Engine\\Feeds', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFeedsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFeedsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFeedsQuery) {
            return $criteria;
        }
        $query = new ChildFeedsQuery();
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
     * @return ChildFeeds|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FeedsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FeedsTableMap::DATABASE_NAME);
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
     * @return ChildFeeds A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, title, description, author, pub_date, pub_time, thumbnail, source FROM feeds WHERE id = :p0';
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
            /** @var ChildFeeds $obj */
            $obj = new ChildFeeds();
            $obj->hydrate($row);
            FeedsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildFeeds|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildFeedsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FeedsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFeedsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FeedsTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFeedsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FeedsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FeedsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeedsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFeedsQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FeedsTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFeedsQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FeedsTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the author column
     *
     * Example usage:
     * <code>
     * $query->filterByAuthor('fooValue');   // WHERE author = 'fooValue'
     * $query->filterByAuthor('%fooValue%'); // WHERE author LIKE '%fooValue%'
     * </code>
     *
     * @param     string $author The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFeedsQuery The current query, for fluid interface
     */
    public function filterByAuthor($author = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($author)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $author)) {
                $author = str_replace('*', '%', $author);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FeedsTableMap::COL_AUTHOR, $author, $comparison);
    }

    /**
     * Filter the query on the pub_date column
     *
     * Example usage:
     * <code>
     * $query->filterByPubDate('2011-03-14'); // WHERE pub_date = '2011-03-14'
     * $query->filterByPubDate('now'); // WHERE pub_date = '2011-03-14'
     * $query->filterByPubDate(array('max' => 'yesterday')); // WHERE pub_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $pubDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFeedsQuery The current query, for fluid interface
     */
    public function filterByPubDate($pubDate = null, $comparison = null)
    {
        if (is_array($pubDate)) {
            $useMinMax = false;
            if (isset($pubDate['min'])) {
                $this->addUsingAlias(FeedsTableMap::COL_PUB_DATE, $pubDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pubDate['max'])) {
                $this->addUsingAlias(FeedsTableMap::COL_PUB_DATE, $pubDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeedsTableMap::COL_PUB_DATE, $pubDate, $comparison);
    }

    /**
     * Filter the query on the pub_time column
     *
     * Example usage:
     * <code>
     * $query->filterByPubTime('2011-03-14'); // WHERE pub_time = '2011-03-14'
     * $query->filterByPubTime('now'); // WHERE pub_time = '2011-03-14'
     * $query->filterByPubTime(array('max' => 'yesterday')); // WHERE pub_time > '2011-03-13'
     * </code>
     *
     * @param     mixed $pubTime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFeedsQuery The current query, for fluid interface
     */
    public function filterByPubTime($pubTime = null, $comparison = null)
    {
        if (is_array($pubTime)) {
            $useMinMax = false;
            if (isset($pubTime['min'])) {
                $this->addUsingAlias(FeedsTableMap::COL_PUB_TIME, $pubTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pubTime['max'])) {
                $this->addUsingAlias(FeedsTableMap::COL_PUB_TIME, $pubTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeedsTableMap::COL_PUB_TIME, $pubTime, $comparison);
    }

    /**
     * Filter the query on the thumbnail column
     *
     * Example usage:
     * <code>
     * $query->filterByThumbnail('fooValue');   // WHERE thumbnail = 'fooValue'
     * $query->filterByThumbnail('%fooValue%'); // WHERE thumbnail LIKE '%fooValue%'
     * </code>
     *
     * @param     string $thumbnail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFeedsQuery The current query, for fluid interface
     */
    public function filterByThumbnail($thumbnail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($thumbnail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $thumbnail)) {
                $thumbnail = str_replace('*', '%', $thumbnail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FeedsTableMap::COL_THUMBNAIL, $thumbnail, $comparison);
    }

    /**
     * Filter the query on the source column
     *
     * Example usage:
     * <code>
     * $query->filterBySource('fooValue');   // WHERE source = 'fooValue'
     * $query->filterBySource('%fooValue%'); // WHERE source LIKE '%fooValue%'
     * </code>
     *
     * @param     string $source The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFeedsQuery The current query, for fluid interface
     */
    public function filterBySource($source = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($source)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $source)) {
                $source = str_replace('*', '%', $source);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FeedsTableMap::COL_SOURCE, $source, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFeeds $feeds Object to remove from the list of results
     *
     * @return $this|ChildFeedsQuery The current query, for fluid interface
     */
    public function prune($feeds = null)
    {
        if ($feeds) {
            $this->addUsingAlias(FeedsTableMap::COL_ID, $feeds->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the feeds table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FeedsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FeedsTableMap::clearInstancePool();
            FeedsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(FeedsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FeedsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FeedsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            FeedsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // FeedsQuery

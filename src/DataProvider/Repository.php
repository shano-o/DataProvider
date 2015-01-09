<?php
namespace Psc\DataProvider;

use Psc\DataProvider\Model\ModelInterface as Model;
use Psc\DataProvider\Adapter\AdapterInterface as Adapter;
use Psc\DataProvider\ResultSetInterface as ResultSet;

class Repository implements RepositoryInterface
{
    use EventManagerAwareTrait;

    protected $eventIdentifiers = __CLASS__;

    /**
     * @var     Model
     */
    protected $model = null;

    /**
     * @var     Adapter
     */
    protected $adapter = null;

    /**
     * @var     ResultSet
     */
    protected $resultSet = null;

    /**
     * Set DataProvider Model
     *
     * @param    Model $model
     * @return   Repository
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Get Data model
     *
     * Usage:
     *      $person->getAggregate('contact')->loadAll()->lessThan('createDate', (microtime(true) - (3600*24*7)));
     *      $person->loadAll()->greatThan('create_date');
     *      $person->limit(10)->offset(0);
     *      $sqlRepo->execute($person); | $person->execute();
     *
     * @param    void
     * @return   Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set DataProvider Adapter
     *
     * @param    Adapter $adapter
     * @return   Repository
     */
    public function setAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Set ResultSet
     *
     * @param    ResultSet $rs
     * @return   Repository
     */
    public function setResultSet(ResultSet $rs)
    {
        $this->resultSet = $rs;
        return $this;
    }

    /**
     * Lazy-load ResultSet
     *
     * @param    void
     * @return   ResultSet
     */
    public function getResultSet()
    {
        if (NULL === $this->resultSet) {
            $this->setResultSet(new ResultSet);
        }
        return $this->resultSet;
    }

    public function createResultSet($result)
    {
        $resultSet = $this->getResultSet();
        $resultSet->initialize($result);

        return $resultSet;
    }

    public function create(Model $model = null)
    {
        $model = $model ? : $this->getModel();
        if (!$model instanceof Model) {
            throw new Exception\InvalidArgumentException(sprintf(
                "Model must be instance of Model, %s given",
                is_object($model) ? get_class($model) : gettype($model)
            ));
        }

        $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this);

        $result = $this->getAdapter()->create($model);

        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this);

        return $result;
    }

    public function load(Model $model)
    {
        $model = $model ? : $this->getModel();
        if (!$model instanceof Model) {
            throw new Exception\InvalidArgumentException(sprintf(
                "Model must be instance of Model, %s given",
                is_object($model) ? get_class($model) : gettype($model)
            ));
        }

        $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this);

        $resultSet = $this->getAdapter()->load($model);

        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this);

        return $resultSet;
    }

    public function update(Model $model)
    {
        $model = $model ? : $this->getModel();
        if (!$model instanceof Model) {
            throw new Exception\InvalidArgumentException(sprintf(
                "Model must be instance of Model, %s given",
                is_object($model) ? get_class($model) : gettype($model)
            ));
        }

        $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this);

        $result = $this->getAdapter()->load($model);

        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this);

        return $result;
    }

    public function delete(Model $model)
    {
        $model = $model ? : $this->getModel();
        if (!$model instanceof Model) {
            throw new Exception\InvalidArgumentException(sprintf(
                "Model must be instance of Model, %s given",
                is_object($model) ? get_class($model) : gettype($model)
            ));
        }

        $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this);

        $result = $this->getAdapter()->delete($model);

        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this);

        return $result;
    }
}
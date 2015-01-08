<?php
namespace Psc\DataProvider;

class Repository implements RepositoryInterface
{
    public function setModel(Model $model)
    {
        $model->setRepository($this);
        $model->setFilter($this->getAdapter()->getFilter());

        $this->model = $model;
        return $this;
    }

    /**
     * Get Data model
     *
     * Usage:
     *      $person->getAggregate('contact')->lessThan('createDate', (microtime(true) - (3600*24*7)));
     *      $person->greatThan('create_date');
     *      $person->limit(10)->offset(0);
     *      $sqlRepo->load($person); | $person->load();
     *
     * @param    
     * @return   
     */
    public function getModel()
    {
        return $this->model;
    }

    public function setAdapter(Adapter $adapter)
    {
        $adapter->setRepository($this);
        $this->adapter = $adapter;
        return $this;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    public function setResultSet(ResultSet $rs)
    {
        $this->resultSet = $rs;
        return $this;
    }

    public function getResultSet()
    {
        if (NULL === $this->resultSet) {
            $rs = $this->resultSetClass;
            $this->setResultSet(new $rs);
        }
        return $this->resultSet;
    }

    public function createResultSet($result)
    {}

    public function create(Model $model)
    {}

    public function load(Model $model)
    {}

    public function update(Model $model)
    {}

    public function delete(Model $model)
    {}
}
<?php
namespace Psc\DataProvider;

use Zend\EventManager\EventManagerAwareInterface;

interface RepositoryInterface extends EventManagerAwareInterface
{
    public function setModel(Model $model);

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
    public function getModel();

    public function setAdapter(Adapter $adapter);

    public function getAdapter();

    public function getResultSet();

    public function createResultSet($result);

    public function create(Model $model);

    public function load(Model $model);

    public function update(Model $model);

    public function delete(Model $model);
}
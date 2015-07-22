<?php

namespace PhalconRest\Controllers;

use Phalcon\Http\Request as Request;
use PhalconRest\Exceptions\HTTPException as HTTPException;
use PhalconRest\Models\Checklist;
use PhalconRest\Models\ChecklistRessource;
use PhalconRest\Models\Ressource;

class RessourceController extends RESTController {

    protected $allowedFields = array(
        'search' => array('category_id', 'name'),
        'partials' => array('category_id', 'name')
    );

    public function get() {
        $results = Ressource::find();
        return $this->respond($this->search($this->genericGet($results)));
    }

    public function getOne($id) {
        $results = Ressource::find($id);
        if (count($results) !== 1) {
            throw new HTTPException(
            'Bad Request', 400, array(
        'dev' => 'Aucune ressource trouvée',
        'internalCode' => 'SpiritErrorRessourceControllerGetOne',
        'more' => '$id == ' . $id
            )
            );
        }
        return $this->respond($this->search($this->genericGet($results)));
    }

    private function genericGet($results) {
        $data = array();
        foreach ($results as $result) {
            $data[] = array(
                'id' => $result->id,
                'name' => $result->name,
                'category_id' => $result->category_id,
            );
        }
        return $data;
    }

    public function put($id) {
        $request = new Request();
        $datas = $request->getJsonRawBody();
        //$checklist = Checklist::findFirst($id);
        $ress = new Ressource();
        $clist = new Checklist();
        $clistRess = new ChecklistRessource();

        //Gestion des erreurs
        if (!isset($datas->ressource_name)) {
            throw new HTTPException(
            'Bad Request', 400, array(
        'dev' => 'Aucun ressource_name',
        'internalCode' => 'SpiritErrorChecklistControllerPut',
        'more' => 'datats->ressource_name = ' . $datas->ressource_name
            )
            );
        }
        if (!$id) {
            if (isset($datas->event_id)) {
                //Insertion Checklist
                $clist->setEventId($datas->event_id);
                $clist->create();
            } else {
                throw new HTTPException(
                'Bad Request', 400, array(
            'dev' => 'Aucun event_id ',
            'internalCode' => 'SpiritErrorChecklistControllerPut',
            'more' => 'checklist_id = ' . $id
                )
                );
            }
        }

        //Insertion Ressource
        $ress->setName($datas->ressource_name);
        $ress->setCategoryId(1);
        $ress->create();

        //Insertion ChecklistRessource
        $clistRess->setChecklistId($id);
        $clistRess->setRessourceId($ress->getId());
        $clistRess->create();
        
        return array('Put / stub');
    }

    public function search($data) {
        $results = array();
        foreach ($data as $record) {
            $match = true;
            if (is_array($this->searchFields) || is_object($this->searchFields)) {
                foreach ($this->searchFields as $field => $value) {
                    if (!(strpos($record[$field], $value) !== FALSE)) {
                        $match = false;
                    }
                }
            }
            if ($match) {
                $results[] = $record;
            }
        }
        return $results;
    }

    public function respond($results) {
        if ($this->isPartial) {
            $newResults = array();
            $remove = array_diff(array_keys($this->exampleRecords[0]), $this->partialFields);
            foreach ($results as $record) {
                $newResults[] = $this->array_remove_keys($record, $remove);
            }
            $results = $newResults;
        }
        if ($this->offset) {
            $results = array_slice($results, $this->offset);
        }
        if ($this->limit) {
            $results = array_slice($results, 0, $this->limit);
        }
        return $results;
    }

    private function array_remove_keys($array, $keys = array()) {

        // If array is empty or not an array at all, don't bother
        // doing anything else.
        if (empty($array) || (!is_array($array))) {
            return $array;
        }

        // At this point if $keys is not an array, we can't do anything with it.
        if (!is_array($keys)) {
            return $array;
        }

        // array_diff_key() expected an associative array.
        $assocKeys = array();
        foreach ($keys as $key) {
            $assocKeys[$key] = true;
        }

        return array_diff_key($array, $assocKeys);
    }

}

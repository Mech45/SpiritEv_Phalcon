<?php

namespace PhalconRest\Controllers;

use Phalcon\Http\Request as Request;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
use PhalconRest\Exceptions\HTTPException as HTTPException;
use PhalconRest\Models\Checklist;
use PhalconRest\Models\ChecklistRessource;
use PhalconRest\Models\Event;
use PhalconRest\Models\Ressource;

class ChecklistController extends RESTController {

    /**
     * Sets which fields may be searched against, and which fields are allowed to be returned in
     * partial responses.
     * @var array
     */
//    private $baseLocation = "/var/www/public/img/";
//    private $baseUrl = "http://clemgeek1.xyz/img/";

//    
//   protected $allowedFields = array (
//           'search' => array('name', 'firstname', 'username', "civility"),
//           'partials' => array('name', 'firstname', 'username', "civility")
//   );

    public function get() {
        $results = Checklist::find();
        return $this->respond($this->search($this->genericGet($results)));
    }

    public function getOne($id) {
        $results = Event::find($id);
        if (count($results) !== 1) {
            throw new HTTPException(
            'Bad Request', 400, array(
        'dev' => 'Aucun evenement trouvé',
        'internalCode' => 'SpiritErrorEventControllerGetOne',
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
                "name" => $result->name,
                "event_id" => $result->event_id,
            );
        }
        return $data;
    }

    public function put() {
        
        $request = new Request();
        $transactionManager = new TransactionManager();
        $datas = $request->getJsonRawBody();
        // Création d'une transaction, il faut setter l'objet transaction à chaque entité
        $transaction = $transactionManager->get();
        try {
            // Récupération de l'événement
            if (isset($datas->event_id)) {
                $event = Event::findFirst("id = " . $datas->event_id);
                if (!$event) {
                    throw new HTTPException(
                        'Bad Request', 400, array(
                            'dev' => 'Aucun evenement trouvé',
                            'internalCode' => 'SpiritErrorEventControllerPut',
                            'more' => 'event_id == ' . $datas->event_id
                        )
                    );
                }
            }else {
                throw new HTTPException(
                    'Bad Request', 400, array(
                        'dev' => 'Aucun evenement renseigné',
                        'internalCode' => 'SpiritErrorEventControllerPut',
                        'more' => 'event_id == '. $datas->event_id
                    )
                );
            }
            
            // Si la checklist n'existe pas, on la créer
            if (isset($datas->checklist_id)) {

                $checklist = Checklist::findFirst("id = " . $datas->checklist_id);
                if (!$checklist) {
                    throw new HTTPException(
                        'Bad Request', 400, array(
                            'dev' => 'Aucune checklist trouvée',
                            'internalCode' => 'SpiritErrorChecklistControllerPut',
                            'more' => 'checklist_id == ' . $datas->checklist_id
                        )
                    );
                }
            }else {
                $checklist = new Checklist();
                $checklist->setTransaction($transaction);
                $checklist->setEventId($datas->event_id);
                if (isset($datas->name)) {
                    $checklist->setName($datas->name);
                }
                if ($checklist->save() == false) {
                    $transaction->rollback("Can't save checklist");
                }
            }

            if (isset($datas->items)) {
                $items = $datas->items;

                //S'il y a des données correspondantes à la checklist dans la table , on les supprime
                if (isset($datas->checklist_id)) {
                    $resultsRessources = ChecklistRessource::find("checklist_id = " . $datas->checklist_id);
                    if ($resultsRessources->count() != 0) {
                        foreach ($resultsRessources as $res) {
                            $res->setTransaction($transaction);
                            if ($res->delete() == false) {
                                $transaction->rollback("Can't delete checklist ressource");
                            }
                        }
                    }
                }

                foreach($items as $item){

                    // Récupération de la ressource
                    $ressource = Ressource::findFirst("id = " . $item->ressource_id);
                    if (!$ressource) {
                        throw new HTTPException(
                            'Bad Request', 400, array(
                                'dev' => 'Aucune ressource trouvée',
                                'internalCode' => 'SpiritErrorChecklistControllerPut',
                                'more' => 'ressource_id == ' . $item->ressource_id
                            )
                        );
                    }else {

                        if (isset($item->quantity)) {

                            $checklistRessource = new ChecklistRessource();
                            $checklistRessource->setTransaction($transaction);
                            $checklistRessource->setChecklistId($checklist->getId());
                            $checklistRessource->setRessourceId($ressource->getId());
                            $checklistRessource->setQuantity($item->quantity);

                            if ($checklistRessource->save() == false) {
                                $transaction->rollback("Can't save checklist ressource");
                            }
                        }
                    }
                }
            }else {
                throw new HTTPException(
                    'Bad Request', 400, array(
                        'dev' => 'Aucun items!',
                        'internalCode' => 'SpiritErrorChecklistControllerPut',
                        'more' => 'checklist_id == ' . $datas->checklist_id
                    )
                );
            }
            $transaction->commit();
        } catch (Phalcon\Mvc\Model\Transaction\Failed $e) {
            echo 'Failed, reason: ', $e->getMessage();
        }

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

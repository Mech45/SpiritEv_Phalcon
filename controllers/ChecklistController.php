<?php

namespace PhalconRest\Controllers;

use Phalcon\Http\Request as Request;
use PhalconRest\Exceptions\HTTPException as HTTPException;
use PhalconRest\Models\Checklist;
use PhalconRest\Models\Event;
use PhalconRest\Models\Ressource;

class ChecklistController extends RESTController {

    /**
     * Sets which fields may be searched against, and which fields are allowed to be returned in
     * partial responses.
     * @var array
     */
    private $baseLocation = "/var/www/public/img/";
    private $baseUrl = "http://clemgeek1.xyz/img/";

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

    public function put($id) {
        $request = new Request();
        $datas = $request->getJsonRawBody();

        $event = Event::findFirst("id = " . $id);
        if (!$event) {
            throw new HTTPException(
                'Bad Request', 400, array(
                    'dev' => 'Aucun evenement trouvé',
                    'internalCode' => 'SpiritErrorEventControllerPut',
                    'more' => '$id == ' . $id
                )
            );
        }
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
            $checklist->setEventId($id);
            if (isset($datas->name)) {
                $checklist->setName($datas->name);
            }
            if ($checklist->save() == false) {
                throw new HTTPException(
                    'Bad Request', 400, array(
                        'dev' => 'Champ(s) vide',
                        'internalCode' => 'SpiritErrorSaveFirstStep',
                        'more' => 'there is no more here sorry'
                    )
                );
            }
        }
        
//        if (isset($datas->items)) {
//            $items = $datas->items;
//            foreach($items as $item){
//            
//                $ressource = Ressource::findFirst("id = " . $item->ressource_id);
//                if (!$ressource) {
//                    throw new HTTPException(
//                        'Bad Request', 400, array(
//                            'dev' => 'Aucune ressource trouvée',
//                            'internalCode' => 'SpiritErrorChecklistControllerPut',
//                            'more' => 'ressource_id == ' . $item->ressource_id
//                        )
//                    );
//                }else {
//                    
//                    $checklist->setRessource($ressource);
//                    
//                    if ($checklist->save() == false) {
//                        echo'ko';exit;
//                        throw new HTTPException(
//                            'Bad Request', 400, array(
//                                'dev' => 'Champ(s) vide',
//                                'internalCode' => 'SpiritErrorSaveFirstStep',
//                                'more' => 'there is no more here sorry'
//                            )
//                        );
//                    }else {
//                        echo'ok';exit;
//                    }
//                }
//            }
//            
//        }
//        
        exit;
        
        
//        foreach($items as $item){
//            
//            $ressource = Ressource::findFirst("id = " . $datas->checklist_id);
//            if (!$checklist) {
//                throw new HTTPException(
//                    'Bad Request', 400, array(
//                        'dev' => 'Aucune checklist trouvée',
//                        'internalCode' => 'SpiritErrorChecklistControllerPut',
//                        'more' => 'checklist_id == ' . $datas->checklist_id
//                    )
//                );
//            } else
//                $idChecklist = $checklist->getId();
//            
//        }
//        

//        var_dump($idChecklist);
        
//        if (isset($datas->name)) {
//            $profil->setName($datas->name);
//        } if (isset($datas->firstname)) {
//            $profil->setFirstname($datas->firstname);
//        } if (isset($datas->username)) {
//            $user = User::findFirst("profile_id=" . $id);
//            if (!$user) {
//                throw new HTTPException(
//                    'Bad Request',
//                    400,
//                    array (
//                        'dev' => 'Aucun utilisateur trouvé',
//                        'internalCode' => 'SpiritErrorProfilControllerPut',
//                        'more' => '$profile_id == ' . $id
//                    )
//                );
//            }
//            $user->username = $datas->username;
//            $user->update();
//        } if (isset($datas->email)) {
//            $user = User::findFirst("profile_id=" . $id);
//            if (!$user) {
//                throw new HTTPException(
//                    'Bad Request',
//                    400,
//                    array (
//                        'dev' => 'Aucun utilisateur trouvé',
//                        'internalCode' => 'SpiritErrorProfilControllerPut',
//                        'more' => '$profile_id == ' . $id
//                    )
//                );
//            }
//            $user->email = $datas->email;
//            $user->update();
//        } if (isset($datas->civility)) {
//            $civility = Civility::findFirstByName($datas->civility);
//            if (!$civility) {
//                throw new HTTPException (
//                    'Bad Request',
//                    400,
//                    array (
//                        'dev' => 'Aucune civility trouvée',
//                        'internalCode' => 'SpiritErrorProfilControllerPut',
//                        'more' => '$civility_id == ' . $id
//                    )
//                );
//            }
//            $profil->civility_id = $civility->id;
//        } if (isset($datas->birthday)) {
//            $profil->setBirthday($datas->birthday);
//        } if (isset($datas->language)) {
//            $language = Language::findFirstByCode($datas->language);
//            if (!$language) {
//                throw new HTTPException (
//                    'Bad Request',
//                    400,
//                    array (
//                        'dev' => 'Aucune civility trouvée',
//                        'internalCode' => 'SpiritErrorProfilControllerPut',
//                        'more' => '$civility_id == ' . $id
//                    )
//                );
//            }
//            $profil->language_id = $language->id;
//        } if (isset($datas->password) && isset($datas->newpassword) && isset($datas->renewpassword)) {
//            $this->setNewPassword($id, $datas->password, $datas->newpassword, $datas->renewpassword);
//        }
//        $profil->update();
//        return array('Put / stub');
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

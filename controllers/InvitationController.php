<?php

namespace PhalconRest\Controllers;

use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
use Phalcon\Http\Request as Request;
use PhalconRest\Exceptions\HTTPException;
use PhalconRest\Models\Event;
use PhalconRest\Models\Invitation;

class InvitationController extends RESTController {
    /**
    * Sets which fields may be searched against, and which fields are allowed to be returned in
    * partial responses.
    * @var array
    */
//    
//   protected $allowedFields = array (
//           'search' => array('name', 'firstname', 'username', "civility"),
//           'partials' => array('name', 'firstname', 'username', "civility")
//   );
    
    public function get() {
        
        $results = Invitation::find();
        return $this->respond($this->search($this->genericGet($results)));
    }

    public function getOne($id) {
        $results = Invitation::find($id);
        if(count($results) !== 1) {
            throw new HTTPException(
                'Bad Request',
                400,
                array (
                    'dev' => 'Aucune invitation trouvée',
                    'internalCode' => 'SpiritErrorInvitationControllerGetOne',
                    'more' => '$id == ' . $id
                )
            );
        }
        return $this->respond($this->search($this->genericGet($results)));
    }
    
    private function genericGet($results) {
        $data = array();
        foreach ($results as $result) {
            $data[] = array (
                "profile_id" => $result->profile_id,
                "guest_id" => $result->guest_id,
                "email" => $result->email,
                "invitation_date" => $result->invitation_date,
                "relanch_invitation_date" => $result->relanch_invitation_date,
                "validation_invitation_date" => $result->validation_invitation_date,
                "invitation_date" => $result->invitation_date,
            );
        }
        return $data;
    }

    public function createInvitations() {
        
        $request = new Request();
        $datas = $request->getJsonRawBody();
        $transactionManager = new TransactionManager();
        $transaction = $transactionManager->get();
        
        if (isset($datas->event_id)) {
            $event = Event::findFirst("id = " . $datas->event_id);
            if (!$event) {
                throw new HTTPException(
                    'Bad Request',
                    400,
                    array (
                        'dev' => 'Aucun event trouvé',
                        'internalCode' => 'SpiritErrorInvitationControllerPut',
                        'more' => '$id == ' . $datas->event_id
                    )
                );
            }
        }else {
            throw new HTTPException(
                'Bad Request',
                400,
                array (
                    'dev' => 'Aucun event renseigné',
                    'internalCode' => 'SpiritErrorInvitationControllerPut',
                    'more' => '$id == ' . $datas->event_id
                )
            );
        }
        
        try {
            if (isset($datas->guests)) {
                foreach ($datas->guests as $guest){
                    $invitation = new Invitation();
                    $invitation->setTransaction($transaction);
                    
                    if (isset($datas->profile_id)) {

                        $invitation->setProfileId($datas->profile_id);
                        
                        if (isset($guest->guest_id))
                            $invitation->setGuestId($guest->guest_id);
                        
                        if (isset($guest->email))
                            $invitation->setEmail($guest->email);
                        
                        if (isset($guest->invitation_date))
                            $invitation->setInvitationDate($guest->invitation_date);
                        
                        if ($invitation->save() == false) {
//                            echo "Umh, We can't store robots right now: \n";
//                            foreach ($invitation->getMessages() as $message) {
//                                echo $message, "\n";
//                            }
                            $transaction->rollback("Can't save checklist");
                        }

                        unset($invitation);
                    }else {
                        throw new HTTPException(
                            'Bad Request',
                            400,
                            array (
                                'dev' => 'Aucun profile_id renseigné',
                                'internalCode' => 'SpiritErrorInvitationControllerPut',
                                'more' => '$id == ' . $datas->profile_id
                            )
                        );
                    }
                }
            }else {
                throw new HTTPException(
                    'Bad Request',
                    400,
                    array (
                        'dev' => 'Aucun invités renseigné',
                        'internalCode' => 'SpiritErrorInvitationControllerPut',
                        'more' => '$id == ' . $datas->event_id
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
        foreach($data as $record) {
            $match = true;
            if (is_array($this->searchFields) || is_object($this->searchFields)) {
                foreach ($this->searchFields as $field => $value) {
                    if(!(strpos($record[$field], $value) !== FALSE)) {
                            $match = false;
                    }
                }
            }
            if($match) {
                    $results[] = $record;
            }
        }
        return $results;
    }

    public function respond($results){
        if($this->isPartial){
                $newResults = array();
                $remove = array_diff(array_keys($this->exampleRecords[0]), $this->partialFields);
                foreach($results as $record){
                        $newResults[] = $this->array_remove_keys($record, $remove);
                }
                $results = $newResults;
        }
        if($this->offset){
                $results = array_slice($results, $this->offset);
        }
        if($this->limit){
                $results = array_slice($results, 0, $this->limit);
        }
        return $results;
    }

    private function array_remove_keys($array, $keys = array()) {

        // If array is empty or not an array at all, don't bother
        // doing anything else.
        if(empty($array) || (! is_array($array))) {
            return $array;
        }

        // At this point if $keys is not an array, we can't do anything with it.
        if(! is_array($keys)) {
            return $array;
        }

        // array_diff_key() expected an associative array.
        $assocKeys = array();
        foreach($keys as $key) {
            $assocKeys[$key] = true;
        }

        return array_diff_key($array, $assocKeys);
    }
}
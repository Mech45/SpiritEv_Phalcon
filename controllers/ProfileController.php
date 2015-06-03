<?php
namespace PhalconRest\Controllers;
use \PhalconRest\Exceptions\HTTPException;
use PhalconRest\Models\Profile;

class ProfileController extends RESTController {
    
    /**
    * Sets which fields may be searched against, and which fields are allowed to be returned in
    * partial responses.
    * @var array
    */
   protected $allowedFields = array (
           'search' => array('name', 'firstname'),
           'partials' => array('name', 'firstname')
   );
    
    public function get() {
        $results = Profile::find();
        $data = array();
        foreach ($results as $result) {
            $data[] = array(
                "name" => $result->name,
                "firstname" => $result->firstname,
            );
        }
        return $this->respond($this->search($data));
    }

    public function getOne($id){
        $results = Profile::find($id);
        $data = array();
        foreach ($results as $result) {
            $data[] = array(
                "name" => $result->name,
                "firstname" => $result->firstname,
            );
        }
        return $this->respond($this->search($data));
    }

    public function post(){
        return array('Post / stub');
    }

    public function delete($id){
        return array('Delete / stub');
    }

    public function put($id){
        return array('Put / stub');
    }

    public function patch($id) {
        return array('Patch / stub');
    }

    public function search($data) {
        $results = array();
        foreach($data as $record) {
                $match = true;
                foreach ($this->searchFields as $field => $value) {
                        if(!(strpos($record[$field], $value) !== FALSE)) {
                                $match = false;
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
<?php
namespace PhalconRest\Controllers;
use \PhalconRest\Exceptions\HTTPException as HTTPException;
use \Phalcon\Http\Request as Request;
use PhalconRest\Models\User;
use PhalconRest\Models\Profile;
use PhalconRest\Models\Civility;
use PhalconRest\Models\Language;
use PhalconRest\Models\Media;
use PhalconRest\Models\Groupe;

class GroupController extends RESTController {
    
    private $hash_front_lenght = 40;
    /**
    * Sets which fields may be searched against, and which fields are allowed to be returned in
    * partial responses.
    * @var array
    */
   protected $allowedFields = array (
           'search' => array('name'),
           'partials' => null
   );
    
    public function get() {
        $results = Groupe::find();
        return $this->respond($this->search($this->genericGet($results)));
    }

    public function getOne($id) {
        $results = Groupe::find($id);
        if(count($results) !== 1) {
            throw new HTTPException(
                'Bad Request',
                400,
                array (
                    'dev' => 'Aucun groupe trouvé',
                    'internalCode' => 'SpiritErrorProfilControllerGetOne',
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
                "name" => $result->name
                
//                "picture" => array (
//                                "name" => Media::findFirst("profile_id=" . $result->id)->name,
//                                "path" => Media::findFirst("profile_id=" . $result->id)->path,
//                                "date_import" => Media::findFirst("profile_id=" . $result->id)->date_import
//                )
            );
        }
        return $data;
    }

    public function put($id) {
        $request = new Request();
        $datas = $request->getJsonRawBody();
        $group = Groupe::findFirst("id = " . $id);
        if (!$group) {
            throw new HTTPException(
                'Bad Request',
                400,
                array (
                    'dev' => 'Aucun groupe trouvé',
                    'internalCode' => 'SpiritErrorProfilControllerPut',
                    'more' => '$id == ' . $id
                )
            );
        }
        if (isset($datas->name)) {
            $group->setName($datas->name);
        }  
        // Make for picture
        $group->update();
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
<?php
namespace PhalconRest\Controllers;
use \PhalconRest\Exceptions\HTTPException as HTTPException;
use \Phalcon\Http\Request as Request;
use PhalconRest\Models\User;
use PhalconRest\Models\Profile;
use PhalconRest\Models\Civility;
use PhalconRest\Models\Language;
use PhalconRest\Models\Media;
use PhalconRest\Models\ProfileHasProfile;
use PhalconRest\Models\Invitation;

class FriendController extends RESTController {
    /**
    * Sets which fields may be searched against, and which fields are allowed to be returned in
    * partial responses.
    * @var array
    */
    // private $baseLocation = "/var/www/public/img/";
    // private $baseUrl = "http://clemgeek1.xyz/img/";

   protected $allowedFields = array (
           'search' => array('name', 'firstname', 'username', "civility"),
           'partials' => array('name', 'firstname', 'username', "civility")
   );

    public function getOne($owner_id) {
        return $this->respond($this->search($this->genericGet($owner_id)));
    }


    private function genericGet($owner_id) {
        $array_to_merge = [];
        $conditions_pending_local = "profile_id = :id: AND token IS NULL AND validation_invitation_date IS NULL";
        $parameters_local = array(
                        "id" => $owner_id
                    );
        $conditions_pending_ext = "profile_id = :id: AND token IS NOT NULL AND validation_invitation_date IS NULL";
        $parameters_ext = array(
                        "id" => $owner_id
                    );
        $results_confirmed_byprofile = ProfileHasProfile::find("profile_id=" . $owner_id);
        $results_confirmed_byguest = ProfileHasProfile::find("profile_friend_id1=" . $owner_id);
        $results_pending_local = Invitation::find(array(
                                                    $conditions_pending_local,
                                                    "bind" => $parameters_local
                                                ));
        $results_pending_ext = Invitation::find(array(
                                                    $conditions_pending_ext,
                                                    "bind" => $parameters_ext
                                                ));
        if (isset($results_confirmed_byprofile))// != NULL)
        {
          $data_confirmed_byprofile = $this->fetch_data_to_array($results_confirmed_byprofile, 0);
          $array_to_merge[0] = $data_confirmed_byprofile;
        }
        if (isset($results_confirmed_byprofile))// != NULL)
        {
          $data_confirmed_byguest = $this->fetch_data_to_array($results_confirmed_byguest, 1);
          $array_to_merge[1] = $data_confirmed_byguest;
        }
        if (isset($results_pending_local))// != NULL)
        {
          $data_pending_local = $this->fetch_data_to_array($results_pending_local, 2);
          $array_to_merge[2] = $data_pending_local;
        }
        if (isset($results_pending_ext))// != NULL)
        {
          $data_pending_ext = $this->fetch_data_to_array($results_pending_ext, 3);
          $array_to_merge[3] = $data_pending_ext;
        }
        return ($this->merging_array($array_to_merge));
    }


    private function merging_array($array_to_merge)
    {
      $trigger_array = 0;
      $array_merged = [];
      foreach ($array_to_merge as $key => $array)
      {
        if ($trigger_array == 0)
        {
          if (isset($array))
          {
            $array_merged = $array;
            $trigger_array = 1;
          }
        }
        elseif ($trigger_array == 1 && (isset($array)))
        {
          $array_merged = array_merge($array_merged, $array);
        }
      }
      return ($array_merged);
    }


    private function fetch_data_to_array($results, $trigger)
    {
      $status = "Status confirmé";
      if ($trigger == 0)
        $id_to_use = "profile_friend_id1";
      elseif ($trigger == 1)
        $id_to_use = "profile_id";
      elseif ($trigger == 2)
      {
        $id_to_use = "guest_id";
        $status = "Demande en cours";
      }
      elseif ($trigger == 3)
      {
        foreach ($results as $result) {
            $data[] = array (
                "mail" => $result->email,
                "used_trigger" => "guest_id",
                "status" => "Demande en cours"
            );
          }
      }
      if ($trigger != 3)
      {
        foreach ($results as $result) {
            $data[] = array (
                "name" => Profile::findFirst($result->$id_to_use)->name,
                "firstname" => Profile::findFirst($result->$id_to_use)->firstname,
                "used_trigger" => $id_to_use,
                "username" => User::findFirst("profile_id=" . ($result->$id_to_use))->username,
                "status" => $status,
                "picture" => array (
                                "name" => Media::findFirst("profile_id=" . $result->$id_to_use)->name,
                                "path" => Media::findFirst("profile_id=" . $result->$id_to_use)->path,
                                "date_import" => Media::findFirst("profile_id=" . $result->$id_to_use)->date_import
                )
            );
        }
      }
      return $data;
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

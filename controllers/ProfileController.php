<?php
namespace PhalconRest\Controllers;
use \PhalconRest\Exceptions\HTTPException as HTTPException;
use \Phalcon\Http\Request as Request;
use PhalconRest\Models\User;
use PhalconRest\Models\Profile;
use PhalconRest\Models\Civility;
use PhalconRest\Models\Language;
use PhalconRest\Models\Media;

class ProfileController extends RESTController {
    
    private $hash_front_lenght = 40;
    /**
    * Sets which fields may be searched against, and which fields are allowed to be returned in
    * partial responses.
    * @var array
    */
   protected $allowedFields = array (
           'search' => array('name', 'firstname', 'username', "civility"),
           'partials' => array('name', 'firstname', 'username', "civility")
   );
    
    public function get() {
        $results = Profile::find();
        return $this->respond($this->search($this->genericGet($results)));
    }

    public function getOne($id) {
        $results = Profile::find($id);
        if(count($results) !== 1) {
            throw new HTTPException(
                'Bad Request',
                400,
                array (
                    'dev' => 'Aucun profil trouvé',
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
                "name" => $result->name,
                "firstname" => $result->firstname,
                "username" => User::findFirst("profile_id=" . $result->id)->username,
                "email" => User::findFirst("profile_id=" . $result->id)->email,
                "civility" => Civility::findFirst($result->civility_id)->name,
                "birthday" => $result->birthday,
                "language" => array (
                                "name" => Language::findFirst($result->language_id)->name,
                                "code" => Language::findFirst($result->language_id)->code
                ),
                "picture" => array (
                                "name" => Media::findFirst("profile_id=" . $result->id)->name,
                                "path" => Media::findFirst("profile_id=" . $result->id)->path,
                                "date_import" => Media::findFirst("profile_id=" . $result->id)->date_import
                )
            );
        }
        return $data;
    }

    public function put($id) {
        $request = new Request();
        $datas = $request->getJsonRawBody();
        $profil = Profile::findFirst("id = " . $id);
        if (!$profil) {
            throw new HTTPException(
                'Bad Request',
                400,
                array (
                    'dev' => 'Aucun profil trouvé',
                    'internalCode' => 'SpiritErrorProfilControllerPut',
                    'more' => '$id == ' . $id
                )
            );
        }
        if (isset($datas->name)) {
            $profil->setName($datas->name);
        } if (isset($datas->firstname)) {
            $profil->setFirstname($datas->firstname);
        } if (isset($datas->username)) {
            $user = User::findFirst("profile_id=" . $id);
            if (!$user) {
                throw new HTTPException(
                    'Bad Request',
                    400,
                    array (
                        'dev' => 'Aucun utilisateur trouvé',
                        'internalCode' => 'SpiritErrorProfilControllerPut',
                        'more' => '$profile_id == ' . $id
                    )
                );
            }
            $user->username = $datas->username;
            $user->update();
        } if (isset($datas->email)) {
            $user = User::findFirst("profile_id=" . $id);
            if (!$user) {
                throw new HTTPException(
                    'Bad Request',
                    400,
                    array (
                        'dev' => 'Aucun utilisateur trouvé',
                        'internalCode' => 'SpiritErrorProfilControllerPut',
                        'more' => '$profile_id == ' . $id
                    )
                );
            }
            $user->email = $datas->email;
            $user->update();
        } if (isset($datas->civility)) {
            $civility = Civility::findFirstByName($datas->civility);
            if (!$civility) {
                throw new HTTPException (
                    'Bad Request',
                    400,
                    array (
                        'dev' => 'Aucune civility trouvée',
                        'internalCode' => 'SpiritErrorProfilControllerPut',
                        'more' => '$civility_id == ' . $id
                    )
                );
            }
            $profil->civility_id = $civility->id;
        } if (isset($datas->birthday)) {
            $profil->setBirthday($datas->birthday);
        } if (isset($datas->language)) {
            $language = Language::findFirstByCode($datas->language);
            if (!$language) {
                throw new HTTPException (
                    'Bad Request',
                    400,
                    array (
                        'dev' => 'Aucune civility trouvée',
                        'internalCode' => 'SpiritErrorProfilControllerPut',
                        'more' => '$civility_id == ' . $id
                    )
                );
            }
            $profil->language_id = $language->id;
        } if (isset($datas->password) && isset($datas->newpassword) && isset($datas->renewpassword)) {
            $this->setNewPassword($id, $datas->password, $datas->newpassword, $datas->renewpassword);
        }
        $profil->update();
        return array('Put / stub');
    }

    private function setNewPassword($id, $password, $newpassword, $renewpassword) {
        $user = User::findFirst("profile_id=" . $id);
        if (!$user) {
            throw new HTTPException(
                'Bad Request',
                400,
                array (
                    'dev' => 'Aucun utilisateur trouvé',
                    'internalCode' => 'SpiritErrorProfilControllerSetNewPassword',
                    'more' => '$id == ' . $id
                )
            );
        }
        if ((strlen($password) == $this->hash_front_lenght) && (strlen($newpassword) == $this->hash_front_lenght) && 
                ($newpassword === $renewpassword)) {
            if (!(sha1($password . $user->salt) == $user->password)) {
                throw new HTTPException(
                    'Bad Request',
                    400,
                    array (
                        'dev' => 'Mot de passe erronés',
                        'internalCode' => 'SpiritErrorProfilControllerSetNewPassword',
                        'more' => 'there is no more here sorry'
                    )
                );
            }
            $salt = $this->generateSaltDot();
            $user->salt = $salt;
            $user->password = sha1($newpassword . $salt);
            $user->update();
        }
        else {
            throw new HTTPException(
                'Bad Request',
                400,
                array (
                    'dev' => 'Mot de passe erronés',
                    'internalCode' => 'SpiritErrorProfilControllerSetNewPassword',
                    'more' => 'the is no more here sorry'
                )
            );
        }
    }
    
    private function generateSaltDot() {
        $salt_dot = "";
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for ($i = 0; $i < 40; $i++) {
            $salt_dot .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $salt_dot;
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
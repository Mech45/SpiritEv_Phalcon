<?php

namespace PhalconRest\Controllers;

use Phalcon\Http\Request as Request;
use PhalconRest\Exceptions\HTTPException as HTTPException;
use PhalconRest\Models\Event;
use PhalconRest\Models\Media;
use PhalconRest\Models\ProfileHasProfile;
use PhalconRest\Models\User;
use PhalconRest\Responses\Response;

class EventController extends RESTController {

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
        $results = Event::find();
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
                'date_create' => $result->date_create,
                'date_update' => $result->date_update,
                'description' => $result->description,
                "name" => $result->name,
                'location' => $result->location,
                'actif' => $result->actif,
                'hour_begin' => $result->hour_begin,
                'hour_end' => $result->hour_end,
            );
        }
        return $data;
    }

    public function post() {
        
    }

    public function saveFirstStep() {

        $event = new Event();
        $request = new Request();

        if ($request->isPost() == true) {

            $name = $this->request->getPost("name");
            $location = $this->request->getPost("location");
            $hour_begin = $this->request->getPost("hour_begin");
            $hour_end = $this->request->getPost("hour_end");

            if ($name)
                $event->setName($name);
            if ($location)
                $event->setLocation($location);
            
            if (strtotime($hour_begin) >= strtotime($hour_end)){
                throw new HTTPException(
                    'Bad Request', 400, array(
                    'dev' => 'La date de fin doit être supérieur à la date de début !',
                    'internalCode' => 'SpiritErrorSaveFirstStep',
                    'more' => 'there is no more here sorry'
                    )
                );
            }else{
                if ($hour_begin)
                    $event->setHourBegin($hour_begin);
                if ($hour_end)
                    $event->setHourEnd($hour_end);
            }

            $event->setDateCreate(date('Y-m-d H:i:s'));
            $event->setActif(0);

            if ($event->save() == false) {
                throw new HTTPException(
                    'Bad Request', 400, array(
                    'dev' => 'Champ(s) vide',
                    'internalCode' => 'SpiritErrorSaveFirstStep',
                    'more' => 'there is no more here sorry'
                    )
                );
            } else {
                return array(
                    'id' => $event->getId());
            }
        }

    }

    public function put($id) {
//        $request = new Request();
//        $datas = $request->getJsonRawBody();
//        $event = event::findFirst("id = " . $id);
//        if (!$event) {
//            throw new HTTPException(
//                'Bad Request',
//                400,
//                array (
//                    'dev' => 'Aucun evenement trouvé',
//                    'internalCode' => 'SpiritErrorEventControllerPut',
//                    'more' => '$id == ' . $id
//                )
//            );
//        }
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

    public function putPhoto($id) {
        $profil = Profile::findFirst("id = " . $id);
        if (!$profil) {
            throw new HTTPException(
            'Bad Request', 400, array(
        'dev' => 'Aucun profil trouvé',
        'internalCode' => 'SpiritErrorProfilControllerPutPhoto',
        'more' => '$id == ' . $id
            )
            );
        }
        $request = new Request();
        if ($request->hasFiles() == true) {
            // Print the real file names and sizes
            foreach ($request->getUploadedFiles() as $file) {
                $media = Media::findFirstByProfile_id($id);
                if (!$media) {
                    throw new HTTPException(
                    'Bad Request', 400, array(
                'dev' => 'média non trouvé',
                'internalCode' => 'SpiritErrorProfilControllerPutPhoto',
                'more' => '$id == ' . $id
                    )
                    );
                }
                $name = $this->uploadNewProfilPicture($file);
                if (!$name) {
                    throw new HTTPException(
                    'Bad Request', 400, array(
                'dev' => 'Erreur dans l\'upload de la photo',
                'internalCode' => 'SpiritErrorProfilControllerPutPhoto',
                'more' => '$id == ' . $id
                    )
                    );
                }
                if (!unlink($this->baseLocation . $media->name)) {
                    throw new HTTPException(
                    'Bad Request', 400, array(
                'dev' => 'Erreur dans l\'upload de la photo',
                'internalCode' => 'SpiritErrorProfilControllerPutPhoto',
                'more' => '$id == ' . $id
                    )
                    );
                }
                $media->name = $name;
                $media->path = $this->baseUrl . $name;
                $media->date_import = date('Y-m-d H:i:s');
                $media->update();
            }
        } else {
            throw new HTTPException(
            'Bad Request', 400, array(
        'dev' => 'Il n\' a pas d\'image',
        'internalCode' => 'SpiritErrorProfilControllerPutPhoto',
        'more' => '$id == ' . $id
            )
            );
        }
        return array('Put / stub');
    }

    private function uploadNewProfilPicture($picture) {
        $uploadfile = sha1($this->generateSaltDot()) . basename($picture->getName());
        $size = filesize($picture->getTempName());
        if ($size > 2 * 1024 * 1024) {
            throw new HTTPException(
            'Bad Request', 400, array(
        'dev' => 'This file is too big. Upload lesser than 2MB',
        'internalCode' => 'SpiritErrorProfilControllerPutPhoto',
        'more' => 'there is no more here sorry'
            )
            );
        }
        $image_size = getimagesize($picture->getTempName());
        if ($image_size == false) {
            throw new HTTPException(
            'Bad Request', 400, array(
        'dev' => 'This is not an image, Nice Try!',
        'internalCode' => 'SpiritErrorProfilControllerPutPhoto',
        'more' => 'there is no more here sorry'
            )
            );
        } else if ($image_size[0] !== $image_size[1]) {
            throw new HTTPException(
            'Bad Request', 400, array(
        'dev' => 'witdh != height',
        'internalCode' => 'SpiritErrorProfilControllerPutPhoto',
        'more' => "$image_size[0] !== $image_size[1]"
            )
            );
        }
        $image_type = exif_imagetype($picture->getTempName());
        if ($image_type != IMAGETYPE_JPEG && $image_type != IMAGETYPE_PNG) {
            throw new HTTPException(
            'Bad Request', 400, array(
        'dev' => 'Only Jpg and png image ar autorised',
        'internalCode' => 'SpiritErrorProfilControllerPutPhoto',
        'more' => 'there is no more here sorry'
            )
            );
        }
        return (move_uploaded_file($picture->getTempName(), $this->baseLocation . $uploadfile)) ? $uploadfile : null;
    }

    private function setNewPassword($id, $password, $newpassword, $renewpassword) {
        $user = User::findFirst("profile_id=" . $id);
        if (!$user) {
            throw new HTTPException(
            'Bad Request', 400, array(
        'dev' => 'Aucun utilisateur trouvé',
        'internalCode' => 'SpiritErrorProfilControllerSetNewPassword',
        'more' => '$id == ' . $id
            )
            );
        }
        if (($newpassword === $renewpassword) &&
                (strlen($newpassword) >= 8) &&
                (!(ctype_digit($newpassword) || ctype_alpha($newpassword)))) {
            if (!(sha1($password . $user->salt) == $user->password)) {
                throw new HTTPException(
                'Bad Request', 400, array(
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
        } else {
            throw new HTTPException(
            'Bad Request', 400, array(
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

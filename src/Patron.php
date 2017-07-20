<?php
    class Patron
    {
        private $patron_name;
        private $id;

        function __construct($patron_name, $id = null)
        {
            $this->patron_name = $patron_name;
            $this->id = $id;
        }

        function getPatronName()
        {
            return $this->patron_name;
        }

        function setPatronName($new_patron_name)
        {
            $this->patron_name = (string) $new_patron_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO patrons (patron_name) VALUES ('{$this->getPatronName()}');");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        static function getAll()
        {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons;");
            $patrons = array();
            foreach ($returned_patrons as $patron) {
                $patron_name = $patron['patron_name'];
                $id = $patron['id'];
                $new_patron = new Patron($patron_name, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        static function deleteAll()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM patrons;");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        static function find($search_id)
        {
            $found_patron = null;
            $returned_patrons = $GLOBALS['DB']->prepare("SELECT * FROM patrons WHERE id = :id");
            $returned_patrons->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_patrons->execute();
            foreach($returned_patrons as $patron) {
                $patron_name = $patron['patron_name'];
                $id = $patron['id'];
                if ($id == $search_id) {
                    $found_patron = new Patron($patron_name, $id);
                }
            }
            return $found_patron;
        }

        function update($new_patron_name)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE patrons SET patron_name = '{$new_patron_name}' WHERE id = {$this->getId()};");
            if ($executed) {
                $this->setPatronName($new_patron_name);
                return true;
            } else {
                return false;
            }
        }

        function delete()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }
    }
?>

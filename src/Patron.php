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
            $this->new_patron_name = (string) $new_patron_name;
        }

        function getId()
        {
            return $this->id;
        }
    }
?>

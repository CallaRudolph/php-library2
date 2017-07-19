<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Author.php";
    require_once "src/Patron.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class PatronTest extends PHPUnit_Framework_TestCase
    {
        function testGetPatronName()
        {
            // Arrange
            $patron_name = 'Fifi';
            $test_patron = new Patron($patron_name);

            // Act
            $result = $test_patron->getPatronName();

            // Assert
            $this->assertEquals($patron_name, $result);
        }
    }
?>

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
        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
            Patron::deleteAll();
        }

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

        function testSetPatronName()
        {
            // Arrange
            $patron_name = 'Fifi';
            $test_patron = new Patron($patron_name);

            $new_patron_name = 'Shaquifa';

            // Act
            $test_patron->setPatronName($new_patron_name);
            $result = $test_patron->getPatronName();

            // Assert
            $this->assertEquals($new_patron_name, $result);
        }

        function testGetId()
        {
            // Arrange
            $patron_name = 'Beats Me';
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            // Act
            $result = $test_patron->getId();

            // Assert
            $this->assertTrue(is_numeric($result));
        }

        function testSave()
        {
            //Arrange
            $patron_name = "Ollie";
            $test_patron= new Patron($patron_name);

            //Act
            $executed = $test_patron->save();

            // Assert
            $this->assertTrue($executed, "Patron not successfully saved to database");
        }

        function testGetAll()
        {
            $patron_name = 'Jimmy';
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $patron_name2 = 'Sally';
            $test_patron2 = new Patron($patron_name2);
            $test_patron2->save();

            $result = Patron::getAll();

            $this->assertEquals([$test_patron, $test_patron2], $result);
        }

        function testDeleteAll()
        {
            $patron_name = 'Frankie';
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $patron_name2 = 'Brokeback Al';
            $test_patron2 = new Patron($patron_name2);
            $test_patron2->save();

            Patron::deleteAll();
            $result = Patron::getAll();

            $this->assertEquals([], $result);
        }

        function testFind()
        {
            $patron_name = 'Jaqualda';
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $patron_name2 = 'Maximus Baximus';
            $test_patron2 = new Patron($patron_name2);
            $test_patron2->save();

            $result = Patron::find($test_patron->getId());

            $this->assertEquals($test_patron, $result);
        }

        function testUpdate()
        {
            $patron_name = 'Julia';
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $new_patron_name = "Juliette";

            $test_patron->update($new_patron_name);

            $this->assertEquals("Juliette", $test_patron->getPatronName());
        }

        function testDelete()
        {
            $patron_name = 'Fernando';
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $patron_name_2 = 'Shamalama';
            $test_patron_2 = new Patron($patron_name_2);
            $test_patron_2->save();

            $test_patron->delete();

            $this->assertEquals([$test_patron_2], Patron::getAll());
        }
    }
?>

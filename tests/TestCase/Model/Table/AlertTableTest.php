<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AlertTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AlertTable Test Case
 */
class AlertTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AlertTable
     */
    protected $Alert;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Alert',
        'app.User',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Alert') ? [] : ['className' => AlertTable::class];
        $this->Alert = $this->getTableLocator()->get('Alert', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Alert);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AlertTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'country' => 'España',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche',
        ]);

        $hasErrors=$alerta->hasErrors();
        $this->assertFalse($hasErrors);       
    }
    // //User_id
    public function testValidationUserIDInteger(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 'uno',
            'country' => 'España',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche',]);

        $error = $alerta->getErrors();
        $expected = "El identificador del usuario es un número.";
        $this->assertTrue($expected==$error["user_id"]["integer"]);
    }


    //País
    public function testValidationCountryRequired(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche',
        ]);

        $error = $alerta->getErrors();
        $expected = "El campo país es requerido.";
        $this->assertTrue($expected==$error["country"]["_required"]);
    }

    public function testValidationCountryEmpty(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'country' => '',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche',
        ]);

        $error = $alerta->getErrors();
        $expected = "El país no puede ser vacío.";
        $this->assertTrue($expected==$error["country"]["_empty"]);
    }


    public function testValidationCountryMin(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'country' => 'a',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche',
        ]);

        $error = $alerta->getErrors();
        $expected = "El país debe tener mínimo 3 caracteres.";
        $this->assertTrue($expected==$error["country"]["minLength"]);
    }

    public function testValidationCountryMax(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'country' => 'LoreLoremodolor sit ametLorem ipsum dolor sit ametLorem ipsum dolor sit ametLorem ipsum dolor sit ametLorem ipsum dolor sit ametLorem ipsum dolor sit ametLorem ipsum dolor sit ametLorem ipsum dolor sit ametLorem ipsum dolor sit ametLorem ipsum dolor sit ametLorem ipsum dolor sit ametLorem ipsum dolor sit ametLorem ipsum dolor sit ametLorem ipsum dolor sit ametLorem ipsum dolor sit ametLorem ipsum dolor sit ametLorem ipsum dolor sit ametm',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche',
        ]);

        $error = $alerta->getErrors();
        $expected = "El país debe tener máximo 100 caracteres.";
        $this->assertTrue($expected==$error["country"]["maxLength"]);
    }

    public function testValidationCountryAlfabetico(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'country' => 'Es%&paña',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche',
        ]);

        $error = $alerta->getErrors();
        $expected = "El país debe contener solo caracteres alfabéticos y espacios.";
        $this->assertTrue($error["country"]["regex"]==$expected);
    }


    //Provincia
    public function testValidationProvinceRequired(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'country' => 'España',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche',
        ]);

        $error = $alerta->getErrors();
        $expected = "El campo provincia es requerido.";
        $this->assertTrue($expected==$error["province"]["_required"]);
    }

    public function testValidationProvinceMax(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'country' => 'España',
            'province' => 'jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche',
        ]);

        $error = $alerta->getErrors();
        $expected = "La provincia debe tener máximo 30 caracteres.";
        $this->assertTrue($expected==$error["province"]["maxLength"]);
    }

    public function testValidationProvinceAlfabetico(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'country' => 'España',
            'province' => 'Pont%evedra',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche',
        ]);

        $error = $alerta->getErrors();
        $expected = "La provincia debe contener solo caracteres alfabéticos y espacios.";
        $this->assertTrue($error["province"]["regex"]==$expected);
    }


    //Especie
    public function testValidationSpecieRequired(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'country' => 'España',
            'province' => 'Pontevedra',
            'race' => 'Caniche',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche']);

        $error = $alerta->getErrors();
        $expected = "El campo especie es requerido.";
        $this->assertTrue($expected==$error["specie"]["_required"]);
    }


    public function testValidationSpecieInList(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'country' => 'España',
            'province' => 'Pontevedra',
            'specie' => 'elefante',
            'race' => 'Caniche',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche',]);

        $error = $alerta->getErrors();
        $expected = "La especie debe ser una de las existentes.";
        $this->assertTrue($expected==$error["specie"]["inList"]);
    }

    //Raza
    public function testValidationRaceRequired(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'country' => 'España',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche',]);

        $error = $alerta->getErrors();
        $expected = "El campo raza es requerido.";
        $this->assertTrue($expected==$error["race"]["_required"]);
    }
    public function testValidationRaceAlfabetico(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'country' => 'España',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'Canich&/e',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche',]);

        $error = $alerta->getErrors();
        $expected = "Introduce una raza con caracteres alfabéticos y espacios.";
        $this->assertTrue($error["race"]["regex"]==$expected);
    }

    public function testValidationRaceMax(): void
    {
     
        $alerta = $this->Alert->newEntity([

            'user_id' => 1,
            'country' => 'España',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'perroperroperroperroperroperroperroperroperroperroperroperroperroperroperroperroperroperroperroperroperro',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche',
        ]);

        $error = $alerta->getErrors();
        $expected = "La raza debe tener máximo 100 caracteres.";
        $this->assertTrue($expected==$error["race"]["maxLength"]);
    }

    //Creation-Date
    public function testValidationCreationDateRequired(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 'uno',
            'country' => 'España',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'Caniche',
            'active' => 'yes',
            'title' => 'Alerta caniche',
        ]);

        $error = $alerta->getErrors();
        $expected = "El campo fecha de creación es requerido.";
        $this->assertTrue($expected==$error["creation_date"]["_required"]);
    }

    public function testValidationCreationDateEmpty(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 'uno',
            'country' => 'España',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '',
            'active' => 'yes',
            'title' => 'Alerta caniche',
        ]);

        $error = $alerta->getErrors();
        $expected = "La fecha no puede ser vacía.";
        $this->assertTrue($expected==$error["creation_date"]["_empty"]);
    }

    public function testValidationCreationDateTime(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 'uno',
            'country' => 'España',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '2023-03 22:17:48',
            'active' => 'yes',
            'title' => 'Alerta caniche',
        ]);

        $error = $alerta->getErrors();
        $expected = "La fecha introducida debe seguir un formato de fecha y hora correcto.";
        $this->assertTrue($expected==$error["creation_date"]["dateTime"]);
    }

    public function testValidationCreationDateBetweenValid(): void
    {
     
        $alerta = $this->Alert->newEntity([

            'user_id' => 'uno',
            'country' => 'España',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '2051-11-11 21:59:41',
            'active' => 'yes',
            'title' => 'Alerta caniche',
        ]);

        $error = $alerta->getErrors();
        $expected = "La fecha debe ser entre 2022 y 2050.";
        $this->assertTrue($error["creation_date"]["custom"]==$expected);
    }

    //Activado
    public function testValidationActiveRequired(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'country' => 'España',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '2023-03-02 22:17:48',
            'title' => 'Alerta caniche',]);

        $error = $alerta->getErrors();
        $expected = "Se requiere la presencia del campo activo.";
        $this->assertTrue($expected==$error["active"]["_required"]);
    }

    public function testValidationActiveEmpty(): void
    {
     
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'country' => 'España',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => '',
            'title' => 'Alerta caniche',]);

        $error = $alerta->getErrors();
        $expected = "El campo activo no puede ser vacío.";
        $this->assertTrue($expected==$error["active"]["_empty"]);
    }


    public function testValidationActiveInList(): void
    {
        $alerta = $this->Alert->newEntity([
            'user_id' => 1,
            'country' => 'España',
            'province' => 'Pontevedra',
            'specie' => 'dog',
            'race' => 'Caniche',
            'creation_date' => '2023-03-02 22:17:48',
            'active' => 'puede',
            'title' => 'Alerta caniche',]);

        $error = $alerta->getErrors();
        $expected = "Activo debe ser sí o no.";
        $this->assertTrue($expected==$error["active"]["inList"]);
    }


}

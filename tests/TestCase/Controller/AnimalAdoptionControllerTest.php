<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\AnimalAdoptionController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\AnimalAdoptionController Test Case
 *
 * @uses \App\Controller\AnimalAdoptionController
 */
class AnimalAdoptionControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.AnimalAdoption',
        'app.User',
        'app.Animal',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::index()
     */
    //Prueba listar
    public function testIndex(): void
    {
        //loigin
        $this->session([
            'Auth' => [
                    'id' => 1,
                    'DNI_CIF' => '22175395Z',
                    'name' => 'Prueba',
                    'lastname' => 'Prueba Prueba',
                    'username' => 'Pruebatesting',
                    'password' => 'prueba',
                    'email' => 'prueba@gmail.com',
                    'phone' => '639087621',
                    'birth_date' => '1999-12-14',
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);

        $this->get('/animal-adoption');
        $this->assertResponseOk();    //accesible
    }
    
    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::index()
     */
    //Prueba para listar adopciones hay que logearse
    public function testIndexUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('animal-adoption/index');
        $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login

    }
    
    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::index()
     */
    //prueba buscar
    public function testSearch(): void
    {
        //login
        $this->session([
            'Auth' => [
                    'id' => 1,
                    'DNI_CIF' => '22175395Z',
                    'name' => 'Prueba',
                    'lastname' => 'Prueba Prueba',
                    'username' => 'Pruebatesting',
                    'password' => 'prueba',
                    'email' => 'prueba@gmail.com',
                    'phone' => '639087621',
                    'birth_date' => '1999-12-14',
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('/animal-adoption?keyAnimal=Lorem&keyUsuario=');
        $this->assertResponseOk();//accesible
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::index()
     */
    //Prueba para buscar hay que logearse
    public function testSearchUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('/animal-adoption?keyAnimal=Lorem&keyUsuario=');
        $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login

    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::view()
     */
    //Prueba ver (logeado)
    public function testView(): void
    {
        //login
        $this->session([
            'Auth' => [
                    'id' => 1,
                    'DNI_CIF' => '22175395Z',
                    'name' => 'Prueba',
                    'lastname' => 'Prueba Prueba',
                    'username' => 'Pruebatesting',
                    'password' => 'prueba',
                    'email' => 'prueba@gmail.com',
                    'phone' => '639087621',
                    'birth_date' => '1999-12-14',
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);

        $this->get('animal-adoption/view/1');
        $this->assertResponseOk();//accesible
        $this->assertResponseContains('Lorem');   //comprueba dato 
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::view()
     */
    //Prueba para ver adopcion hay que logearse
    public function testViewUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('/animal-adoption/view/1');
        $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login

    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::add()
     */
    public function testAdd(): void
    {
        //login
        $this->session([
            'Auth' => [
                    'id' => 1,
                    'DNI_CIF' => '22175395Z',
                    'name' => 'Prueba',
                    'lastname' => 'Prueba Prueba',
                    'username' => 'Pruebatesting',
                    'password' => 'prueba',
                    'email' => 'prueba@gmail.com',
                    'phone' => '639087621',
                    'birth_date' => '1999-12-14',
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('animal-adoption/add');

        $this->assertResponseOk();//accesible

        $data=[
            'start_date' => '2022-11-02 20:45:51',
            'end_date' => '2022-11-03 20:00:51',
            'user_id' => 1,
            'animal_id' => 1
        ];
        $this->enableCsrfToken();
        $this->post('animal-adoption/add',$data);
        $this->assertRedirect(['controller' => 'AnimalAdoption', 'action' => 'index']);//como es correcto redirige

        $animaladoption = TableRegistry::get('AnimalAdoption');
        $query = $animaladoption->find()->where(['end_date' => $data['end_date']]);
        $this->assertEquals(1,$query->count());//se añadio
    }


    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::add()
     */
    //Para añadir hay que logearse
    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('animal-adoption/add');
        $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::edit()
     */
    //prueba editar bien
    public function testEdit(): void
    {

        $this->session([
            'Auth' => [
                    'id' => 1,
                    'DNI_CIF' => '22175395Z',
                    'name' => 'Prueba',
                    'lastname' => 'Prueba Prueba',
                    'username' => 'Pruebatesting',
                    'password' => 'prueba',
                    'email' => 'prueba@gmail.com',
                    'phone' => '639087621',
                    'birth_date' => '1999-12-14',
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('animal-adoption/edit/1');
        $this->assertResponseOk();//accesible

        $data=[

            'start_date' => '2022-11-02 20:45:51',
            'end_date' => '2023-11-04 09:48:38',
            'user_id' => 1,
            'animal_id' => 1
        ];
        $this->enableCsrfToken();
        $this->post('animal-adoption/edit/1',$data);
        $this->assertRedirect(['controller' => 'AnimalAdoption', 'action' => 'index']);//como es correcto se redirige

        $animaladoption = TableRegistry::get('AnimalAdoption');
        $query = $animaladoption->find()->where(['end_date' => $data['end_date']]);
        $this->assertEquals(1,$query->count());//se editto

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::edit()
     */
    //Para editar hay que logearse
    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('animal-adoption/edit/1');
        $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::delete()
     */
    //ELiminar correctamente
    public function testDelete(): void
    {

        //login
        $this->session([
            'Auth' => [
                    'id' => 1,
                    'DNI_CIF' => '22175395Z',
                    'name' => 'Prueba',
                    'lastname' => 'Prueba Prueba',
                    'username' => 'Pruebatesting',
                    'password' => 'prueba',
                    'email' => 'prueba@gmail.com',
                    'phone' => '639087621',
                    'birth_date' => '1999-12-14',
                    'role' => 'admin',
                    'addres_id' => 1
            ]
        ]);
        $this->enableCsrfToken();
        $this->post('/animal-adoption/delete/1');
        $this->assertRedirect(['controller' => 'AnimalAdoption', 'action' => 'index']);//como es correcto redirige

        $animaladoption = TableRegistry::get('AnimalAdoption');
        $data = $animaladoption->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());//see elimino
     }
     
    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::delete()
     */
    //Prueba para eliminar hay que logearse
     public function testDeleteUnauthenticatedFail(): void
     {
         $this->enableCsrfToken();
         $this->delete('/animal-adoption/delete/1');
         $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login
 
     }
 }

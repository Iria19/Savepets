<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\FosterListController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\FosterListController Test Case
 *
 * @uses \App\Controller\FosterListController
 */
class FosterListControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FosterList',
        'app.User',
        'app.FosterListUser',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\FosterListController::index()
     */
    //Prueba listar
    public function testIndex(): void
    {
        $this->get('/foster-list');
        $this->assertResponseOk();  //accesible  
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\FosterListController::index()
     */
    //Prueba buscar
    public function testSearch(): void
    {
        $this->get('/foster-list?keyCiudad=vigo&keyProvincia=&keyPais=');
        $this->assertResponseOk();//accesible
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\FosterListController::add()
     */
    //prueba añadir (logeado)
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
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('foster-list/add');
        $this->assertResponseOk();//accesible

        $data=[
            'user_id' => 2
        ];
        $this->enableCsrfToken();
        $this->post('foster-list/add',$data);
        $this->assertRedirect(['controller' => 'FosterList', 'action' => 'index']);//como es correcto redirige

        $fosterlist = TableRegistry::get('FosterList');
        $query = $fosterlist->find()->where(['user_id' => $data['user_id']]);
        $this->assertEquals(1,$query->count());//se añadio

    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\FosterListController::add()
     */
    //prueba para añadir hace falta estar logedo
    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('foster-list/add');
        $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\FosterListController::delete()
     */
    //prueba eliminar (logeado)
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
                    'role' => 'admin',
                    'addres_id' => 1
            ]
        ]);
        $this->enableCsrfToken();
        $this->post('/foster-list/delete/1');

        $this->assertRedirect(['controller' => 'FosterList', 'action' => 'index']);//redirige porque es correcto

        $fosterlist = TableRegistry::get('FosterList');
        $data = $fosterlist->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());//se elimino

        $fosterlistuser = TableRegistry::get('FosterListUser');
        $data = $fosterlistuser->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());//se elimino usuarios apuntados

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\FosterListController::delete()
     */
    //prueba eliminar se necesita estar logeado
    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/foster-list/delete/1');
        $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login

    }
}

<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\FosterListUserController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\FosterListUserController Test Case
 *
 * @uses \App\Controller\FosterListUserController
 */
class FosterListUserControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FosterListUser',
        'app.FosterList',
        'app.User'
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::index()
     */
    //Prueba listar  usuario delistas de acogida
    public function testIndex(): void
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
    
        $this->get('/foster-list-user');
        $this->assertResponseOk();   //accesible
    }
    
    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::index()
     */
    //prueba para lista los usuarios de lista de acogida hay que estar logeado
    public function testIndexUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('/foster-list-user');
        $this->assertRedirectContains('/user/login');//como hay que estar logeado redirige al usuairo para que se logee

    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::index()
     */
    //prueba para buscar los usuarios de lista de acogida
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
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);

        $this->get('/foster-list-user?keyEspecie=a');
        $this->assertResponseOk();//accesible
    }
    
    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::index()
     */
    //prueba para buscar los usuarios de lista de acogida hace falta estar logeado
    public function testSearchUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('/foster-list-user?keyEspecie=a');
        $this->assertRedirectContains('/user/login');//redirige a login porque hace falta estar logeado

    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::view()
     */
    //prueba a ver usuarios lista de acogida logeandose
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
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);

        $this->get('foster-list-user/view/1');
        $this->assertResponseOk();//accesible
        $this->assertResponseContains('cat');  //muestra dato  
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::view()
     */
    //prueba a ver usuarios lista de acogida hace falta estar logeado
    public function testViewUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('/foster-list-user/view/1');
        $this->assertRedirectContains('/user/login');//redirige a login porque se necesita estar logeado

    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::add()
     */
    //prueaba unirse a lista de acogida logeado
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
        $this->get('foster-list-user/add/2');

        $this->assertResponseOk();//accesible

        $data=[
            'foster_list_id' => 1,
            'user_id' => 2,
            'specie' => 'cat',
            'foster_date' => '2022-11-16 17:41:20'
        ];
        $this->enableCsrfToken();
        $this->post('foster-list-user/add/2',$data);
        $this->assertRedirect(['controller' => 'FosterListUser', 'action' => 'index']);//correcto por eso redirige

        $fosterlistuser = TableRegistry::get('FosterListUser');

        $query = $fosterlistuser->find()->where(['foster_date' => $data['foster_date']]);

        $this->assertEquals(1,$query->count());//se unio

    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::add()
     */
    //prueaba para unirse a lista de acogida hace falta estar
    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('foster-list-user/add');
        $this->assertRedirectContains('/user/login');//como hace falta estar logeado redirige a login

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::edit()
     */
    //prueba editar estando logeado
    public function testEdit(): void
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
        $this->get('foster-list-user/edit/1');

        $this->assertResponseOk();//accesible

        $data=[
            'foster_list_id' => 1,
            'user_id' => 1,
            'specie' => 'cat',
            'foster_date' => '2022-11-16 19:41:20'
        ];
        $this->enableCsrfToken();
        $this->post('foster-list-user/edit/1',$data);
        $this->assertRedirect(['controller' => 'FosterListUser', 'action' => 'index']);//redirige porque es correcto

        $fosterlistuser = TableRegistry::get('FosterListUser');
        $query = $fosterlistuser->find()->where(['foster_date' => $data['foster_date']]);
        $this->assertEquals(1,$query->count());//se edito

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::edit()
     */
    //prueba para editar hace falta estar logeado
    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('foster-list-user/edit/1');
        $this->assertRedirectContains('/user/login');//redirige a login porque hace falta estar logeado

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::delete()
     */
    //Prueba para desapuntarse (logeado)
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
        $this->post('/foster-list-user/delete/1');

        $this->assertRedirect(['controller' => 'FosterListUser', 'action' => 'index']);//como es correcto redirige

        $fosterlistuser = TableRegistry::get('FosterListUser');
        $data = $fosterlistuser->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());//se elimino

    }

   /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::delete()
     */
    //Prueba no se puede desapuntarse sin estar logeado
    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/foster-list-user/delete/1');
        $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login

    }
}

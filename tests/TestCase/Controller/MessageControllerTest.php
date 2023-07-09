<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\MessageController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\MessageController Test Case
 *
 * @uses \App\Controller\MessageController
 */
class MessageControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Message',
        'app.User',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\MessageController::index()
     */
    //Prueba listar logeado
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
                    'birth_date' => '1999-12-14',
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);

        $this->get('/message');
        $this->assertResponseOk();    //accesible
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\MessageController::index()
     */
    //prueba que para listar mensajes hay que estar logeado
    public function testIndexUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('/message');
        $this->assertRedirectContains('/user/login');//como no se puedeporque hay que estar logeado redirige a login

    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\MessageController::view()
     */
    //prueba listar bien (logeado)
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

        $this->get('message/view/1');
        $this->assertResponseOk();//accesible
        $this->assertResponseContains('Lorem');    //se vmuetra dato
    }
    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\MessageController::view()
     */
    //Prueba para ver mensaje hay que estar logeado
    public function testViewUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('message/view/1');
        $this->assertRedirectContains('/user/login');//como no se puedeporque hay que estar logeado redirige a login


    }
    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\MessageController::add()
     */
    //Prueba enviar mensaje bien (logeado)
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
        $this->get('message/add');

        $this->assertResponseOk();//accesible
        $data=[
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'Loremmesageadd',
            'content' => 'Lorem ipsum dolor sit amet',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes'
        ];
        $this->enableCsrfToken();
        $this->post('message/add',$data);
        $this->assertRedirect(['controller' => 'Message', 'action' => 'index']);//como es correcto redirige

        $message = TableRegistry::get('Message');
        $query = $message->find()->where(['title' => $data['title']]);
        $this->assertEquals(1,$query->count());//se envio/añadio

    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\MessageController::add()
     */
    //Prueba enviar mensaje se necesita estar logeado
    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('message/add');
        $this->assertRedirectContains('/user/login');//como no se puede pide que se logee

    }

}

<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\CommentController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\CommentController Test Case
 *
 * @uses \App\Controller\CommentController
 */
class CommentControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Comment',
        'app.User',
        'app.Publication',
        'app.PublicationHelp',
        'app.PublicationAdoption',
        'app.PublicationStray',

    ];

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\CommentController::add()
     */
    //Prueba añadir correctamente (login)
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
        $this->get('comment/add/1/1/Help');
        $this->assertResponseOk();//accesible

        $data=[
            'comment_date' => '2022-11-09 21:13:02',
            'message' => 'Loremcomment ipsum dolor sit amet',
            'publication_id' => 1,
            'user_id' => 1
        ];
        $this->enableCsrfToken();
        $this->post('comment/add/1/1/Help',$data);
        $this->assertRedirect(['controller' => 'PublicationHelp',1, 'action' => 'view',]);//como es correcto redirige

        $animal = TableRegistry::get('Comment');
        $query = $animal->find()->where(['message' => $data['message']]);
        $this->assertEquals(1,$query->count());//se añadio

    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\CommentController::add()
     */
    //Prueba añadir necesita logearse
    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('comment/add/1/1/Help');
        $this->assertRedirectContains('/user/login');//como necesita logearse redirige a login

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\CommentController::edit()
     */
    //Prueba editar correctamente
   public function edit($id = null)
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
        $this->get('comment/edit/1/1/1/Help');

        $this->assertResponseOk();//accesible
        $data=[
            'comment_date' => '2022-11-09 21:13:02',
            'message' => 'Loremeditcomment ipsum dolor sit amet',
            'publication_id' => 1,
            'user_id' => 1
        ];
        $this->enableCsrfToken();
        $this->post('comment/edit/1/1/1/Help',$data);
        $this->assertRedirect(['controller' => 'PublicationHelp',1, 'action' => 'view',]);//como es correcto redirige

        $animal = TableRegistry::get('Comment');

        $query = $animal->find()->where(['message' => $data['message']]);

        $this->assertEquals(1,$query->count());//se edito


    }
    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\CommentController::edit()
     */
    //Prueba editar requiere estar logeado
    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('comment/edit/1/1/1/Help');
        $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\CommentController::delete()
     */
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
        $this->post('/comment/delete/1/1/1/Help');
        $this->assertRedirect(['controller' => 'PublicationHelp',1, 'action' => 'view',]);//como es correcto se redirige

        $comment = TableRegistry::get('Comment');
        $data = $comment->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());//se elimino
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\CommentController::delete()
     */
    //Eliminar necesita estar logeado
    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/comment/delete/1');
        $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login

    }
}

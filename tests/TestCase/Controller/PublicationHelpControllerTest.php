<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PublicationHelpController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\PublicationHelpController Test Case
 *
 * @uses \App\Controller\PublicationHelpController
 */
class PublicationHelpControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PublicationHelp',
        'app.Publication',
        'app.User',
        'app.Comment',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PublicationHelpController::index()
     */
    //Prueba listar 
    public function testIndex(): void
    {
        $this->get('/publication-help');
        $this->assertResponseOk();    //accesible
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PublicationHelpController::index()
     */
    //Prueba buscar 
    public function testSearch(): void
    {
        $this->get('/publication-help/?keyCategoria=Textile');
        $this->assertResponseOk();//accesible
    }
    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\PublicationHelpController::view()
     */
    //Prueba ver publicacion ayuda
    public function testView(): void
    {
        $this->get('publication-help/view/1');
        $this->assertResponseOk();//accesible
        $this->assertResponseContains('textile');    //se ve dato
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationHelpController::add()
     */
    //Prueba añadir correctamente
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
        $this->get('publication-help/add');
        $this->assertResponseOk();//accesible

        $data=[
            'categorie' => 'food',
            'user_id' => 1,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionAdd',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-help/add',$data);
        $this->assertRedirect(['controller' => 'PublicationHelp', 'action' => 'index']);//Como es correcto redirige

        $publicationhelp = TableRegistry::get('PublicationHelp');
        $query = $publicationhelp->find()->where(['categorie' => $data['categorie']]);
        $this->assertEquals(1,$query->count());//se añadio


        $publication = TableRegistry::get('Publication');
        $query = $publication->find()->where(['title' => $data['publication']['title']]);
        $this->assertEquals(1,$query->count());//publicacion se añadio
    }
    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationHelpController::add()
     */
    //Para añadir hace falta estar logeado
    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-help/add');
        $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login

    }


    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationHelpController::edit()
     */
    //Prueba editar correcta
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
                    'birth_date' => '1999-12-14',
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('publication-help/edit/1');
        $this->assertResponseOk();//accesible

        $data=[
            'categorie' => 'other',
            'user_id' => 1,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionEdit',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-help/edit/1',$data);
        $this->assertRedirect(['controller' => 'PublicationHelp', 'action' => 'index']);//como es correcto redirige

        $publicationhelp = TableRegistry::get('PublicationHelp');
        $query = $publicationhelp->find()->where(['categorie' => $data['categorie']]);
        $this->assertEquals(1,$query->count());//se edito

        $publication = TableRegistry::get('Publication');
        $query = $publication->find()->where(['title' => $data['publication']['title']]);
        $this->assertEquals(1,$query->count());//publicacion editada

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationHelpController::edit()
     */
    //Prueba para editar se necesita estar logeado
    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-help/edit/1');
        $this->assertRedirectContains('/user/login');//como se necesita star logeado redirige

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PublicationHelpController::delete()
     */
    //prueba eliminar correctamente
    public function testDelete(): void
    {
        //Datos comprobar
        $publicationhelp = TableRegistry::get('PublicationHelp');
        $publicationtoDelete = $publicationhelp->find()->where(['id' => 1])->select('publication_id')->first();
        $publicationtoDeleteID=$publicationtoDelete['publication_id'];
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
        $this->post('/publication-help/delete/1');
        $this->assertRedirect(['controller' => 'PublicationHelp', 'action' => 'index']);//como es correcto redirige

        $data = $publicationhelp->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());//se elimino

        $publication = TableRegistry::get('Publication');
        $data = $publication->find()->where(['id' => $publicationtoDeleteID]);
        $this->assertEquals(0,$data->count());//se elimino publicacion        
    }
    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PublicationHelpController::delete()
     */
    //Para eliminar se necesita estar logeado
    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/publication-help/delete/1');
        $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login

    }
}

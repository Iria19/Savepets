<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PublicationAdoptionController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\PublicationAdoptionController Test Case
 *
 * @uses \App\Controller\PublicationAdoptionController
 */
class PublicationAdoptionControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PublicationAdoption',
        'app.Publication',
        'app.Animal',
        'app.User',
        'app.Address',

    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PublicationAdoptionController::index()
     */
    //Prueba listar
    public function testIndex(): void
    {
        $this->get('/publication-adoption');
        $this->assertResponseOk(); //accesible      
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PublicationAdoptionController::index()
     */
    //Prueba a buscar
    public function testSearch(): void
    {
        $this->get('/publication-adoption?keyUrgente=yes');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\PublicationAdoptionController::view()
     */
    //Prueba de ver
    public function testView(): void
    {
        $this->get('publication-adoption/view/1');
        $this->assertResponseOk();//accesible
        $this->assertResponseContains('yes');   //se muestra dato  
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationAdoptionController::add()
     */
    //Se añade correctamente
    public function testAdd(): void
    {
        //logeo
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
        $this->get('publication-adoption/add');
        $this->assertResponseOk();//accesible

        $data=[
            'animal_id' => 1,
            'urgent' => 'no',
            'user_id' => 1,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionAdopAdd',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-adoption/add',$data);
        $this->assertRedirect(['controller' => 'PublicationAdoption', 'action' => 'index']);//Como es correcto redirige 

        $publicationadoption = TableRegistry::get('PublicationAdoption');
        $query = $publicationadoption->find()->where(['urgent' => $data['urgent']]);
        $this->assertEquals(1,$query->count());//se añadio


        $publication = TableRegistry::get('Publication');
        $query = $publication->find()->where(['title' => $data['publication']['title']]);
        $this->assertEquals(1,$query->count());//se añadio publicacion
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationAdoptionController::add()
     */
    //Prueba de que para añadir se necesita estar logeado
    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-adoption/add');
        $this->assertRedirectContains('/user/login');//como no se puede redirige a login

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationAdoptionController::edit()
     */
    //Prueba de editar correcta
    public function testEdit(): void
    {
        //logeo
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
        $this->get('publication-adoption/edit/1');
        $this->assertResponseOk();//accesible

        $data=[
            'animal_id' => 1,
            'urgent' => 'no',
            'user_id' => 2,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionAdopEdit',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-adoption/edit/1',$data);
        $this->assertRedirect(['controller' => 'PublicationAdoption', 'action' => 'index']);//como es correcto redirijo

        $publicationadoption = TableRegistry::get('PublicationAdoption');
        $query = $publicationadoption->find()->where(['user_id' => $data['user_id']]);
        $this->assertEquals(1,$query->count());//se edito

        $publication = TableRegistry::get('Publication');
        $query = $publication->find()->where(['title' => $data['publication']['title']]);
        $this->assertEquals(1,$query->count());//se edito publicacion

    }


    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationAdoptionController::edit()
     */
    //Para editar hay que estar logeado
    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-adoption/edit/1');
        $this->assertRedirectContains('/user/login');//como para editar hay que estar logeado redirige a login

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PublicationAdoptionController::delete()
     */
    //Eliminar bien
    public function testDelete(): void
    {
        //DAtos para verificar que se elimina
        $publicationadoption = TableRegistry::get('PublicationAdoption');
        $publicationtoDelete = $publicationadoption->find()->where(['id' => 1])->select('publication_id')->first();
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
        $this->post('/publication-adoption/delete/1');
        $this->assertRedirect(['controller' => 'PublicationAdoption', 'action' => 'index']);//COmo es correcto redirige

        $data = $publicationadoption->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());//Se elimino

        $publication = TableRegistry::get('Publication');
        $data = $publication->find()->where(['id' => $publicationtoDeleteID]);
        $this->assertEquals(0,$data->count());//se elimino publicacion        
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PublicationAdoptionController::delete()
     */
    //Para eliminar hace falta estar logeado
    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/publication-adoption/delete/1');
        $this->assertRedirectContains('/user/login');//como hace falta estar logeado redirige a login

    }
}

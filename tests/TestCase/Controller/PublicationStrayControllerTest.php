<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PublicationStrayController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\PublicationStrayController Test Case
 *
 * @uses \App\Controller\PublicationStrayController
 */
class PublicationStrayControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PublicationStray',
        'app.Address',
        'app.PublicationStrayAddress',
        'app.Publication',
        'app.User',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::index()
     */
    //Prueba de listar
    public function testIndex(): void
    {
        $this->get('/publication-stray');
        $this->assertResponseOk(); //accesible
    }
    
    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::index()
     */
    //Prueba de buscar
    public function testSearch(): void
    {
        $this->get('/publication-stray?keyUrgente=yes&keyCiudad=&keyProvincia=Pontevedra&keyPais=');
        $this->assertResponseOk();//accesible
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::view()
     */
    //Prueba de ver publicacion
    public function testView(): void
    {
        $this->get('publication-stray/view/1');
        $this->assertResponseOk();//accesible
        $this->assertResponseContains('no'); //contiene datos
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::add()
     */
    //Prueba añadir (sin img)
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
                    'birth_date' => '1999-12-14',

                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('publication-stray/add');

        $this->assertResponseOk();//Accesible

        $data=[
            'image' => '',
            'urgent' => 'yes',
            'user_id' => 1,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionStrayAdd',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray/add',$data);
        $this->assertRedirect(['controller' => 'PublicationStray', 'action' => 'index']);

        $publicationstray = TableRegistry::get('PublicationStray');

        $query = $publicationstray->find()->where(['urgent' => $data['urgent']]);

        $this->assertEquals(1,$query->count());//Se añadio


        $publication = TableRegistry::get('Publication');

        $query = $publication->find()->where(['title' => $data['publication']['title']]);

        $this->assertEquals(1,$query->count());//Se añadio publicacion
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::add()
     */
    //Prueba de que no se puede añadir con imagen mal
    public function testAddImgMal(): void
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
                    'birth_date' => '1999-12-14',

                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('publication-stray/add');

        $this->assertResponseOk();//Accesible

        $data=[
            'image_file' => new \Laminas\Diactoros\UploadedFile(
                '/tmp/testprueba.tmp',
                123,
                \UPLOAD_ERR_OK,
                'about.txt',
                'text/text'
                ),  
            'urgent' => 'yes',
            'user_id' => 1,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionStrayAdd',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray/add',$data);
        $this->assertNoRedirect();//Como es incorrecto no redirige 

    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::add()
     */
    //Prueba añadir con imagen bien
    public function testAddImgBien(): void
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
                    'birth_date' => '1999-12-14',

                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('publication-stray/add');

        $this->assertResponseOk();//accesible

        $data=[
            'image_file' => new \Laminas\Diactoros\UploadedFile(
                '/var/www/html/savepets/webroot/img/testimagen.jpg',
                123,
                \UPLOAD_ERR_OK,
                'testimagen.png',
                'image/jpg'
                ), 
            'urgent' => 'yes',
            'user_id' => 1,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionStrayAdd',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray/add',$data);
        $this->assertRedirect(['controller' => 'PublicationStray', 'action' => 'index']);//Como es correcto redirige

        $publicationstray = TableRegistry::get('PublicationStray');

        $query = $publicationstray->find()->where(['urgent' => $data['urgent']]);

        $this->assertEquals(1,$query->count());//Se añadio

        $publication = TableRegistry::get('Publication');

        $query = $publication->find()->where(['title' => $data['publication']['title']]);

        $this->assertEquals(1,$query->count());//Se añadio publicacion
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::add()
     */
    //Para añadir publicacion de perdidos hay que estar logeado
    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-stray/add');
        $this->assertRedirectContains('/user/login');//no se puede acceder porque usuario necesita logearse, rdirige a login

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::edit()
     */
    //Prueba de editar con datos bien (sin img)
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
        $this->get('publication-stray/edit/1');
        $this->assertResponseOk();//accesible

        $data=[
            'image' => '',
            'urgent' => 'yes',
            'user_id' => 2,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionEdit',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray/edit/1',$data);
        $this->assertRedirect(['controller' => 'PublicationStray', 'action' => 'index']);//Como es correcto redirige

        $publicationstray = TableRegistry::get('PublicationStray');
        $query = $publicationstray->find()->where(['user_id' => $data['user_id']]);
        $this->assertEquals(1,$query->count());//se edito

        $publication = TableRegistry::get('Publication');
        $query = $publication->find()->where(['title' => $data['publication']['title']]);
        $this->assertEquals(1,$query->count());//edito publicacion

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::edit()
     */
    //Se puede editar con la imagen bien
    public function testEditImgBien(): void
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
        $this->get('publication-stray/edit/1');
        $this->assertResponseOk();//accesible

        $data=[
            'change_image' => new \Laminas\Diactoros\UploadedFile(
                '/var/www/html/savepets/webroot/img/testimagen.jpg',
                123,
                \UPLOAD_ERR_OK,
                'testimagen.png',
                'image/jpg'
                ),             
            'urgent' => 'yes',
            'user_id' => 2,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionEdit',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray/edit/1',$data);
        $this->assertRedirect(['controller' => 'PublicationStray', 'action' => 'index']);//Como es correcto redirige

        $publicationstray = TableRegistry::get('PublicationStray');

        $query = $publicationstray->find()->where(['user_id' => $data['user_id']]);

        $this->assertEquals(1,$query->count());//se edito

        $publication = TableRegistry::get('Publication');
        $query = $publication->find()->where(['title' => $data['publication']['title']]);
        $this->assertEquals(1,$query->count());//COmo es correcto se edito la publicacion

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::edit()
     */
    //Prueba de editar con imagen mal
    public function testEditImgMal(): void
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
        $this->get('publication-stray/edit/1');
        $this->assertResponseOk();//acesible

        $data=[
            'change_image' => new \Laminas\Diactoros\UploadedFile(
                '/tmp/testprueba.tmp',
                123,
                \UPLOAD_ERR_OK,
                'about.txt',
                'text/text'
                ),              'urgent' => 'yes',
            'user_id' => 2,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionEdit',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray/edit/1',$data);
        $this->assertNoRedirect();//Como los datos son incorrectos no hay redireccion

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::edit()
     */
    //Prueba que para editar se tiene que estar logeado
    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-stray/edit/1');
        $this->assertRedirectContains('/user/login');//no se puede acceder porque usuario necesita logearse, rdirige a login

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::delete()
     */
    //Prueba eliminar publiccacion de perdido  
    public function testDelete(): void
    {
        $publicationstray = TableRegistry::get('PublicationStray');
        $publicationtoDelete = $publicationstray->find()->where(['id' => 1])->select('publication_id')->first();
        $publicationtoDeleteID=$publicationtoDelete['publication_id'];

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
        $this->enableCsrfToken();
        $this->post('/publication-stray/delete/1');
        $this->assertRedirect(['controller' => 'PublicationStray', 'action' => 'index']);

        $data = $publicationstray->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());//Se elimino la publicacion de animal perdido

        $publication = TableRegistry::get('Publication');
        $data = $publication->find()->where(['id' =>  $publicationtoDeleteID]);
        $this->assertEquals(0,$data->count());//Se elimino la publicacion


        $publicationstrayaddress = TableRegistry::get('PublicationStrayAddress');

        $data = $publicationstrayaddress->find()->where(['publication_stray_id' => $publicationtoDeleteID]);
        $this->assertEquals(0,$data->count());//Se elimino las publicaciones de dirección de la publicacion de perdidos
        
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::delete()
     */
    //Verifico que para eliminar se tiene que estar logeado
    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/publication-stray/delete/1');
        $this->assertRedirectContains('/user/login');

    }
}

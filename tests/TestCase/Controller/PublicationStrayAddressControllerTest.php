<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PublicationStrayAddressController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\PublicationStrayAddressController Test Case
 *
 * @uses \App\Controller\PublicationStrayAddressController
 */
class PublicationStrayAddressControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PublicationStrayAddress',
        'app.PublicationStray',
        'app.Publication',
        'app.Address',
        'app.User',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::index()
     */
    //Prueba de listar
    public function testIndex(): void
    {
        $this->get('/publication-stray-address/index/1');
        $this->assertResponseOk();    //accesible   
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::view()
     */
    public function testView(): void
    {
        $this->get('publication-stray-address/view/1');
        $this->assertResponseOk();//accesible
        $this->assertResponseContains('Pontevedra'); //Contiene datos
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::add()
      */
    //Se añade publicacion (Sin img)
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
        $this->get('publication-stray-address/add/1');

        $this->assertResponseOk();//accesible

        $data=[
            'publication_stray_id' => 1,
            'user_id' => 1,
            'publication_date' => '2022-12-12 11:24:05',
            'image' => '',
            'addres' => [
                'province' => 'Ourense',
                'postal_code' => 35004,
                'country' => 'Loremmmmaddstray',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray-address/add/1',$data);
        $this->assertRedirect(['controller' => 'PublicationStrayAddress', 1,'action' => 'index']);//Correcto por eso redirige

        $publicationstrayaddress = TableRegistry::get('PublicationStrayAddress');
        $query = $publicationstrayaddress->find()->where(['publication_date' => $data['publication_date']]);
        $this->assertEquals(1,$query->count());//existe

        $addres = TableRegistry::get('Address');
        $query = $addres->find()->where(['country' => $data['addres']['country']]);
        $this->assertEquals(1,$query->count());//se añadio direccion
    }


    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::add()
      */
    //Prueba añadir con img bien
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
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('publication-stray-address/add/1');

        $this->assertResponseOk();//accesible

        $data=[
            'publication_stray_id' => 1,
            'user_id' => 1,
            'publication_date' => '2022-12-12 11:24:05',
            'image_file' => new \Laminas\Diactoros\UploadedFile(
                '/var/www/html/savepets/webroot/img/testimagen.jpg',
                123,
                \UPLOAD_ERR_OK,
                'testimagen.png',
                'image/jpg'
                ), 
            'addres' => [
                'province' => 'Ourense',
                'postal_code' => 35004,
                'country' => 'Loremmmmaddstray',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray-address/add/1',$data);
        $this->assertRedirect(['controller' => 'PublicationStrayAddress', 1,'action' => 'index']);//Redirige porque es correcto

        $publicationstrayaddress = TableRegistry::get('PublicationStrayAddress');
        $query = $publicationstrayaddress->find()->where(['publication_date' => $data['publication_date']]);
        $this->assertEquals(1,$query->count());///Se añadio

        $addres = TableRegistry::get('Address');
        $query = $addres->find()->where(['country' => $data['addres']['country']]);
        $this->assertEquals(1,$query->count());//Direccion añadida
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::add()
      */
      //Prueba que con img mal no se añade
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
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('publication-stray-address/add/1');

        $this->assertResponseOk();//accesible

        $data=[
            'publication_stray_id' => 1,
            'user_id' => 1,
            'publication_date' => '2022-12-12 11:24:05',
            'image_file' => new \Laminas\Diactoros\UploadedFile(
                '/tmp/testprueba.tmp',
                123,
                \UPLOAD_ERR_OK,
                'about.txt',
                'text/text'
                ),  
            'addres' => [
                'province' => 'Ourense',
                'postal_code' => 35004,
                'country' => 'Loremmmmaddstray',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray-address/add/1',$data);
        $this->assertNoRedirect();//No redirige porque es incorrecta la img

    }


    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::add()
      */
      //Prueba de que para añadir hay que estar logeado
    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-stray-address/add/1');
        $this->assertRedirectContains('/user/login');//se necesita estar logeado por eso redirige a login

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::edit()
     */
    //Prueba editar sin img
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
        $this->get('publication-stray-address/edit/1');

        $this->assertResponseOk();//accesible
        $data=[
            'publication_stray_id' => 1,
            'user_id' => 1,
            'publication_date' => '2022-12-12 11:44:09',
            'image' => '',
            'addres' => [
                'province' => 'Ourense',
                'postal_code' => 35004,
                'country' => 'Loremmmmeditstray',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray-address/edit/1',$data);
        $this->assertRedirect(['controller' => 'PublicationStrayAddress', 1,'action' => 'index']);//redirige porque es correcto

        $publicationstrayaddress = TableRegistry::get('PublicationStrayAddress');

        $query = $publicationstrayaddress->find()->where(['publication_date' => $data['publication_date']]);

        $this->assertEquals(1,$query->count());//se edito


        $addres = TableRegistry::get('Address');
        $query = $addres->find()->where(['country' => $data['addres']['country']]);
        $this->assertEquals(1,$query->count());//se edito direccion
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::edit()
     */
    //Prueba editar con img bien
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
        $this->get('publication-stray-address/edit/1');

        $this->assertResponseOk();//accesible
        $data=[
            'publication_stray_id' => 1,
            'user_id' => 1,
            'publication_date' => '2022-12-12 11:44:09',
            'change_image' => new \Laminas\Diactoros\UploadedFile(
                '/var/www/html/savepets/webroot/img/testimagen.jpg',
                123,
                \UPLOAD_ERR_OK,
                'testimagen.png',
                'image/jpg'
                ), 
            'addres' => [
                'province' => 'Ourense',
                'postal_code' => 35004,
                'country' => 'Loremmmmeditstray',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray-address/edit/1',$data);
        $this->assertRedirect(['controller' => 'PublicationStrayAddress', 1,'action' => 'index']);//redirige porque esta bien

        $publicationstrayaddress = TableRegistry::get('PublicationStrayAddress');
        $query = $publicationstrayaddress->find()->where(['publication_date' => $data['publication_date']]);
        $this->assertEquals(1,$query->count());//se edito


        $addres = TableRegistry::get('Address');
        $query = $addres->find()->where(['country' => $data['addres']['country']]);
        $this->assertEquals(1,$query->count());//sse edito direccion
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::edit()
     */
    //Prueba editar con img mal no se puede
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
        $this->get('publication-stray-address/edit/1');

        $this->assertResponseOk();//accesible
        $data=[
            'publication_stray_id' => 1,
            'user_id' => 1,
            'publication_date' => '2022-12-12 11:44:09',
            'change_image' => new \Laminas\Diactoros\UploadedFile(
                '/tmp/testprueba.tmp',
                123,
                \UPLOAD_ERR_OK,
                'about.txt',
                'text/text'
                ),  
            'addres' => [
                'province' => 'Ourense',
                'postal_code' => 35004,
                'country' => 'Loremmmmeditstray',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray-address/edit/1',$data);
        $this->assertNoRedirect();//No redirige porque es incorrecto

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::edit()
     */
    //Prueba de que no se puede editar sin logearse
    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-stray-address/edit/1');
        $this->assertRedirectContains('/user/login');//se necesita estar logeado por eso redirige a login

    }


    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::delete()
     */
    //Prueba de eliminar
    public function testDelete(): void
    {
        $publicationstrayaddress = TableRegistry::get('PublicationStrayAddress');

        //Datos para verificar que se elimino
        $publicationstrayaddresstoDelete = $publicationstrayaddress->find()->where(['id' => 1])->select('addres_id')->first();
        $publicationstrayaddresstoDeleteID=$publicationstrayaddresstoDelete['addres_id'];
        $publicationstraypublicationtoDelete = $publicationstrayaddress->find()->where(['id' => 1])->select('publication_stray_id')->first();
        $publicationstraypublicationtoDeleteID=$publicationstraypublicationtoDelete['publication_stray_id'];

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
        $this->post('/publication-stray-address/delete/1');
        $this->assertRedirect(['controller' => 'PublicationStrayAddress', 'action' => 'index',$publicationstraypublicationtoDeleteID]);//Redirige porque es correcto

        $data = $publicationstrayaddress->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());//Ya no existe

        $addres = TableRegistry::get('Address');
        $data = $addres->find()->where(['id' => $publicationstrayaddresstoDeleteID]);
        $this->assertEquals(0,$data->count());//Se borro direccion

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::delete()
     */
    //Prueba que para eliminar direccion de publicacion de perdidos se necesita estar logeado
    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/publication-stray-address/delete/1');
        $this->assertRedirectContains('/user/login');//se necesita estar logeado por eso redirige a login

    }
}

<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\AnimalController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;
/**
 * App\Controller\AnimalController Test Case
 *
 * @uses \App\Controller\AnimalController
 */
class AnimalControllerTest extends TestCase
{
    use IntegrationTestTrait;
    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Animal',
        'app.AnimalShelter',
        'app.User',
        'app.Message',

    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\AnimalController::index()
     */
    //Prueba listar
    public function testIndex(): void
    {
        $this->get('/animal');
        $this->assertResponseOk();//accesible
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\AnimalController::index()
     */
    //Prueba buscar
    public function testSearch(): void
    {
        $this->get('/animal?keyEspecie=dog&keyRaza=&keySexo=');
        $this->assertResponseOk();//accesible
    }


    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\AnimalController::view()
     */
    //Prueba ver
    public function testView(): void
    {
        $this->get('animal/view/1');
        $this->assertResponseOk();//accesible
        $this->assertResponseContains('Lorem');//muestra dato
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\AnimalController::add()
     */
    //Añadir correctamente (sin img)
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
        $this->get('animal/add');

        $this->assertResponseOk();//accesible

        $data=[
            'name' => 'AñadirAnimal',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es un animal.',
            'state' => 'sick',
            'animal_shelter' => [
                'start_date' => '2022-11-03 10:47:38',
                'end_date' => '2023-05-03 10:47:38',
                'user_id' => 1,
                'animal_id' => 1
            ]
        ];
        $this->enableCsrfToken();
        $this->post('animal/add',$data);
        $this->assertRedirect(['controller' => 'Animal', 'action' => 'index']);//como es correcto redirige

        $animal = TableRegistry::get('Animal');
        $query = $animal->find()->where(['name' => $data['name']]);
        $this->assertEquals(1,$query->count());//se añadio

        $animalshelter = TableRegistry::get('AnimalShelter');
        $query = $animalshelter->find()->where(['end_date' => $data['animal_shelter']['end_date']]);
        $this->assertEquals(1,$query->count());//se añadio estancia
    }


    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\AnimalController::add()
     */
    //Prueba con la img mal no añade
    public function testAddTypeimgMal(): void
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
        $this->get('animal/add');
        $this->assertResponseOk();//accesible


        $data=[
            
            'name' => 'AñadirAnimal',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es un animal.',
            'image_file' => new \Laminas\Diactoros\UploadedFile(
                '/tmp/hfz6dbn.tmp',
                123,
                \UPLOAD_ERR_OK,
                'attachment.txt',
                'text/plain'
                ),
            'state' => 'sick',
            'animal_shelter' => [
                'start_date' => '2022-11-03 10:47:38',
                'end_date' => '2023-05-03 10:47:38',
                'user_id' => 1,
                'animal_id' => 1
            ]
        ];
        $this->enableCsrfToken();
        $this->post('animal/add',$data);
        $this->assertNoRedirect();//Como es incorrecto no redirige 

    }


    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\AnimalController::add()
     */
    //Prueba con img bien
    public function testAddTypeimgBien(): void
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
        $this->get('animal/add');
        $this->assertResponseOk();//accesible


        $data=[
            
            'name' => 'AñadirAnimal',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es un animal.',
            'image_file' => new \Laminas\Diactoros\UploadedFile(
                '/var/www/html/savepets/webroot/img/testimagen.jpg',
                123,
                \UPLOAD_ERR_OK,
                'testimagen.jpg',
                'image/jpg'
                ),
            'state' => 'sick',
            'animal_shelter' => [
                'start_date' => '2022-11-03 10:47:38',
                'end_date' => '2023-05-03 10:47:38',
                'user_id' => 1,
                'animal_id' => 1
            ]
        ];
        $this->enableCsrfToken();
        $this->post('animal/add',$data);
        $this->assertRedirect(['controller' => 'Animal', 'action' => 'index']);//como es correcto redirige
   
        $animal = TableRegistry::get('Animal');
        $query = $animal->find()->where(['name' => $data['name']]);
        $this->assertEquals(1,$query->count());//se añadio

        $animalshelter = TableRegistry::get('AnimalShelter');
        $query = $animalshelter->find()->where(['end_date' => $data['animal_shelter']['end_date']]);
        $this->assertEquals(1,$query->count());//se añadio estancia
    }


    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\AnimalController::add()
     */
    //Se necesita estar logeado para añadir
    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('animal/add');
        $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login

    }

    /**
     * Test addFile method
     *
     * @return void
     * @uses \App\Controller\AnimalController::addfile()
     */
    //Añadir con file de tipo text (no valido)
    public function testAddFileTXT(): void
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
        $this->get('animal/addfile');
        $this->assertResponseOk();//accesible

        $data=[
            'fichero' => new \Laminas\Diactoros\UploadedFile(
                '/tmp/hfz6dbn.tmp',
                123,
                \UPLOAD_ERR_OK,
                'attachment.txt',
                'text/plain'
                ),            
            'animal_shelter' => [
                'user_id' => 1
            ]
        ];
        $this->enableCsrfToken();
        $this->post('animal/addfile',$data);
        $this->assertNoRedirect();//Como es incorrecto no redirige
    }

    /**
     * Test addFile method
     *
     * @return void
     * @uses \App\Controller\AnimalController::add()
     */
    //Fallo por campos json
    public function testAddFileJSONCampos(): void
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
        $this->get('animal/addfile');

        $this->assertResponseOk();//accesible

        $data=[
            'fichero' => new \Laminas\Diactoros\UploadedFile(
                '/var/www/html/savepets/webroot/jsonexamplecamposmal.json',
                123,
                \UPLOAD_ERR_OK,
                'jsonexamplecamposmal.json',
                'application/json'
                ),            
            'animal_shelter' => [
                'user_id' => 1
            ]
        ];
        $this->enableCsrfToken();
        $this->post('animal/addfile',$data);
        $this->assertNoRedirect();//como no es correcto no redirige
    }

    /**
     * Test addFile method
     *
     * @return void
     * @uses \App\Controller\AnimalController::addfile()
     */
    //Fallo por JSON campos
    public function testAddFileJSONCamposAnimalShelter(): void
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
        $this->get('animal/addfile');

        $this->assertResponseOk();//accesible

        $data=[
            'fichero' => new \Laminas\Diactoros\UploadedFile(
                '/var/www/html/savepets/webroot/jsonexamplecamposmalanimalsheleter.json',
                123,
                \UPLOAD_ERR_OK,
                'jsonexamplecamposmalanimalsheleter.json',
                'application/json'
                ),            
            'animal_shelter' => [
                'user_id' => 1
            ]
        ];
        $this->enableCsrfToken();
        $this->post('animal/addfile',$data);
        $this->assertNoRedirect();//Como es incorrecto no redirigw
    }

    /**
     * Test addFile method
     *
     * @return void
     * @uses \App\Controller\AnimalController::addfile()
     */
    //Fallo por coma
    public function testAddFileComa(): void
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
        $this->get('animal/addfile');

        $this->assertResponseOk();//accesible

        $data=[
            'fichero' => new \Laminas\Diactoros\UploadedFile(
                '/var/www/html/savepets/webroot/csvexamplecoma.csv',
                123,
                \UPLOAD_ERR_OK,
                'csvexamplecoma.csv',
                'text/csv'
                ),            
            'animal_shelter' => [
                'user_id' => 1
            ]
        ];
        $this->enableCsrfToken();
        $this->post('animal/addfile',$data);
        $this->assertNoRedirect();//como es incorrecto no redirige
    }

    /**
     * Test addFile method
     *
     * @return void
     * @uses \App\Controller\AnimalController::addfile()
     */
    //Addfile bien
    public function testAddFileBien(): void
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
        $this->get('animal/addfile');

        $this->assertResponseOk();//accesible

        $data=[
            'fichero' => new \Laminas\Diactoros\UploadedFile(
                '/var/www/html/savepets/webroot/csvexample.csv',
                123,
                \UPLOAD_ERR_OK,
                'csvexample.csv',
                'text/csv'
                ),            
            'animal_shelter' => [
                'user_id' => 1
            ]
        ];
        $this->enableCsrfToken();
        $this->post('animal/addfile',$data);
        $this->assertRedirect(['controller' => 'Animal', 'action' => 'index']);//como es incorrecto redirige

        $animal = TableRegistry::get('Animal');
        $query = $animal->find()->where(['name' => 'Lily']);
        $this->assertEquals(1,$query->count());//se añadio

        $idlily = $animal->find()->where(['name' => 'Lily'])->select('id')->first();
        $animalshelter = TableRegistry::get('AnimalShelter');
        $query = $animalshelter->find()->where(['animal_id' =>$idlily['id']]);
        $this->assertEquals(1,$query->count());//se añadio estancia
    }
    /**
     * Test addFile method
     *
     * @return void
     * @uses \App\Controller\AnimalController::addfile()
     */
    //Json bien
    public function testAddFileBienJson(): void
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
        $this->get('animal/addfile');

        $this->assertResponseOk();//accesible

        $data=[
            'fichero' => new \Laminas\Diactoros\UploadedFile(
                '/var/www/html/savepets/webroot/jsonexample.json',
                123,
                \UPLOAD_ERR_OK,
                'jsonexample.json',
                'application/json'
                ),            
            'animal_shelter' => [
                'user_id' => 1
            ]
        ];
        $this->enableCsrfToken();
        $this->post('animal/addfile',$data);
        $this->assertRedirect(['controller' => 'Animal', 'action' => 'index']);//como es correcto redirige

        $animal = TableRegistry::get('Animal');
        $query = $animal->find()->where(['name' => 'Cocoo']);
        $this->assertEquals(1,$query->count());//se añadio

        $idcoco = $animal->find()->where(['name' => 'Cocoo'])->select('id')->first();
        $animalshelter = TableRegistry::get('AnimalShelter');
        $query = $animalshelter->find()->where(['animal_id' =>$idcoco['id']])->all();
        $this->assertEquals(1,$query->count());//se añadio estancia
    }


    /**
     * Test addFile method
     *
     * @return void
     * @uses \App\Controller\AnimalController::add()
     */
    //Para importar se necesita estar logeado
     public function testAddFileUnauthenticatedFail(): void
     {
         $this->enableCsrfToken();
         $this->get('animal/addaddfile');
         $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login
 
     }

     /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\AnimalController::edit()
     */
    //prueba editar bien (sin img)
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
        $this->get('animal/edit/1');

        $this->assertResponseOk();//accesible

        $data=[
            'name' => 'EditAnimal',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es un animal.',
            'state' => 'sick',
            'animal_shelter' => [
                'start_date' => '2022-11-03 10:47:38',
                'end_date' => '2023-11-03 11:48:38',
                'user_id' => 1,
                'animal_id' => 1
            ]
        ];
        $this->enableCsrfToken();
        $this->post('animal/edit/1',$data);
        $this->assertRedirect(['controller' => 'Animal', 'action' => 'index']);//como es correcto redirige

        $animal = TableRegistry::get('Animal');
        $query = $animal->find()->where(['name' => $data['name']]);
        $this->assertEquals(1,$query->count());//se edito animal

        $animalshelter = TableRegistry::get('AnimalShelter');
        $query = $animalshelter->find()->where(['end_date' => $data['animal_shelter']['end_date']]);
        $this->assertEquals(1,$query->count());//se edito estancia

    }


     /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\AnimalController::edit()
     */
    //editar con img bien
    public function testEditImgBien(): void
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
        $this->get('animal/edit/1');

        $this->assertResponseOk();//accesible

        $data=[
            'name' => 'EditAnimal',
            'change_image' => new \Laminas\Diactoros\UploadedFile(
                '/var/www/html/savepets/webroot/img/testimagen.jpg',
                123,
                \UPLOAD_ERR_OK,
                'testimagen.png',
                'image/jpg'
                ),            
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es un animal.',
            'state' => 'sick',
            'animal_shelter' => [
                'start_date' => '2022-11-03 10:47:38',
                'end_date' => '2023-11-03 11:48:38',
                'user_id' => 1,
                'animal_id' => 1
            ]
        ];
        $this->enableCsrfToken();
        $this->post('animal/edit/1',$data);
        $this->assertRedirect(['controller' => 'Animal', 'action' => 'index']);//como es correcto redirige

        $animal = TableRegistry::get('Animal');
        $query = $animal->find()->where(['name' => $data['name']]);
        $this->assertEquals(1,$query->count());//se edito

        $animalshelter = TableRegistry::get('AnimalShelter');
        $query = $animalshelter->find()->where(['end_date' => $data['animal_shelter']['end_date']]);
        $this->assertEquals(1,$query->count());//se edito estancia

    }

     /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\AnimalController::edit()
     */
    //Cn img mal no se edita
    public function testEditImgMal(): void
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
        $this->get('animal/edit/1');

        $this->assertResponseOk();//accesible

        $data=[
            'name' => 'EditAnimal',
            'change_image' => new \Laminas\Diactoros\UploadedFile(
                '/tmp/testprueba.tmp',
                123,
                \UPLOAD_ERR_OK,
                'about.txt',
                'text/text'
                ),    
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es un animal.',
            'state' => 'sick',
            'animal_shelter' => [
                'start_date' => '2022-11-03 10:47:38',
                'end_date' => '2023-11-03 11:48:38',
                'user_id' => 1,
                'animal_id' => 1
            ]
        ];
        $this->enableCsrfToken();
        $this->post('animal/edit/1',$data);
        $this->assertNoRedirect();//Como es incorrecto no redirige

    }

     /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\AnimalController::edit()
     */
    //Prueba que para editar hay que logearse
    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('animal/edit/1');
        $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\AnimalController::delete()
     */
    //eliminar bien(login)
    public function testDelete(): void
    {
        //Datos verificar
        $animalshelter = TableRegistry::get('AnimalShelter');
        $animalsheltertoDelete = $animalshelter->find()->where(['animal_id' => 1])->select('id')->first();
        $animalsheltertoDeleteID=$animalsheltertoDelete['id'];
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
        $this->post('/animal/delete/1');

        $this->assertRedirect(['controller' => 'Animal', 'action' => 'index']);//como es correcto redirige

        $animal = TableRegistry::get('Animal');
        $data = $animal->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());//se elimino

        $data = $animalshelter->find()->where(['id' => $animalsheltertoDeleteID]);
        $this->assertEquals(0,$data->count());//elimino estancia
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\AnimalController::delete()
     */
    //Para eliminar se necesita estar logeado
    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/animal/delete/1');
        $this->assertRedirectContains('/user/login');//como se necesita estar logeado redirige a login

    }
  }

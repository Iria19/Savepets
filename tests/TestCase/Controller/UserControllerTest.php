<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\UserController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\UserController Test Case
 *
 * @uses \App\Controller\UserController
 */
class UserControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.User',
        'app.Address',
        'app.Feature',
        'app.FeatureUser',

    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\UserController::index()
     */
    //Prueba de listar usuario
    public function testIndex(): void
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
        $this->get('/user');
        $this->assertResponseOk();//accesible
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\UserController::index()
     */
    //Prueba de busar usuario
    public function testSearch(): void
    {
        $this->get('/user?key=&keyRole=admin');
        $this->assertResponseOk();//accesible
    }

    // /**
    //  * Test view method
    //  *
    //  * @return void
    //  * @uses \App\Controller\UserController::view()
    //  */
    //Pruebo ver un usuario con datos bien
    public function testView(): void
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
        $this->get('user/view/1');
        $this->assertResponseOk();//accesible
        $this->assertResponseContains('22175395Z');//contiene datos
    }

    // /**
    //  * Test view method
    //  *
    //  * @return void
    //  * @uses \App\Controller\UserController::view()
    //  */
    //Para ver usuario hace falta estar logeado
    public function testViewUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('user/view/1');
        $this->assertRedirectContains('/user/login');//no se puede acceder porque usuario necesita logearse, rdirige a login

    }
 
    // /**
    //  * Test add method
    //  *
    //  * @return void
    //  * @uses \App\Controller\UserController::add()
    //  */
    //Pruebo a añadir
    public function testAdd(): void
    {
        //creo sesion
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
        $this->get('user/add');

        $this->assertResponseOk();//accesible

        $data=[
            'DNI_CIF' => '35728482Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Nuevouser',
            'password' => 'prueba',
            'email' => 'nuevouser@gmail.com',
            'phone' => '639087691',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres' => [
                'province' => 'Ourense',
                'postal_code' => 35004,
                'country' => 'Loremadd',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ],
            'feature_user' => [
                0 => ['value' => 'enfermera',
                     'feature_id' =>1
                    ],
                1 => ['value' => 'enfermeria',
                    'feature_id' =>2
                    ],
                2 => ['value' => 'single',
                   'feature_id' =>3
                    ],
                3 => ['value' => 2,
                  'feature_id' =>4
                    ],
                4 => ['value' => 'flat',
                    'feature_id' =>5
                    ],
                5 => ['value' => 'dog',
                    'feature_id' =>6
                    ],
                6 => ['value' => 2,
                    'feature_id' =>7
                    ],
                7 => ['value' => 'female',
                    'feature_id' =>8
                    ],
                
            ]
        ];
        $this->enableCsrfToken();
        $this->post('user/add', $data);
        $this->assertRedirect(['controller' => 'User', 'action' => 'login']); //redirige porque se añadío el usuario

        $user = TableRegistry::get('User');
        $query = $user->find()->where(['DNI_CIF' => $data['DNI_CIF']]);
        $this->assertEquals(1,$query->count());//se añadio

        $addres = TableRegistry::get('Address');
        $query = $addres->find()->where(['country' => $data['addres']['country']]);
        $this->assertEquals(1,$query->count());//se añadió su dirección

        $featureuser = TableRegistry::get('FeatureUser');
        $query = $featureuser->find()->where(['value' => $data['feature_user'][1]['value']]);
        $this->assertEquals(1,$query->count());//se añadió su dirección
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\UserController::edit()
     */
    //Pruebo editar
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
                    'birth_date' => '1999-12-14',
                    'phone' => '639087621',
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('user/edit/1');

        $this->assertResponseOk();//accesible
        $data=[
            'DNI_CIF' => '35728482Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Nuevouser',
            'password' => 'prueba',
            'email' => 'nuevouseredit@gmail.com',
            'phone' => '639087691',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres' => [
                'province' => 'Ourense',
                'postal_code' => 35004,
                'country' => 'Loremmmedit',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ],
            'feature_user' => [
                0 => ['value' => 'enfermera',
                     'feature_id' =>1
                    ],
                1 => ['value' => 'esteticista',
                    'feature_id' =>2
                    ],
                2 => ['value' => 'single',
                   'feature_id' =>3
                    ],
                3 => ['value' => 2,
                  'feature_id' =>4
                    ],
                4 => ['value' => 'flat',
                    'feature_id' =>5
                    ],
                5 => ['value' => 'snake',
                    'feature_id' =>6
                    ],
                6 => ['value' => 2,
                    'feature_id' =>7
                    ],
                7 => ['value' => 'female',
                    'feature_id' =>8
                    ],
                
            ]
        ];
        $this->enableCsrfToken();
        $this->post('user/edit/1',$data);
        $this->assertRedirect(['controller' => 'User', 'action' => 'index']);//como es correcto redirige

        $user = TableRegistry::get('User');
        $query = $user->find()->where(['email' => $data['email']]);
        $this->assertEquals(1,$query->count());//compruebo que hay un usuario con ese email

        $addres = TableRegistry::get('Address');
        $query = $addres->find()->where(['country' => $data['addres']['country']]);
        $this->assertEquals(1,$query->count());//compruebo que se añadio direccion

        $featureuser = TableRegistry::get('FeatureUser');
        $query = $featureuser->find()->where(['value' => $data['feature_user'][1]['value']]);
        $this->assertEquals(1,$query->count());//se añadió su caracteristica
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\UserController::edit()
     */
    //Pruebo que para editar hay que estar logeado
    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('user/edit/1');
        $this->assertRedirectContains('/user/login');//no se puede acceder porque usuario necesita logearse, rdirige a login

    }
    // /**
    //  * Test login method
    //  *
    //  * @return void
    //  * @uses \App\Controller\UserController::login()
    //  */
    //Pruebo login
    public function testLogin(): void
    {
        //Añado un usuario 
        $data=[
            'DNI_CIF' => '94802477L',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Nuevouser',
            'password' => 'prueba',
            'email' => 'nuevouserlog@gmail.com',
            'phone' => '639087771',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres' => [
                'province' => 'Ourense',
                'postal_code' => 35004,
                'country' => 'Loremadd',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ],
            'feature_user' => [
                0 => ['value' => 'enfermera',
                     'feature_id' =>1
                    ],
                1 => ['value' => 'enfermeria',
                    'feature_id' =>2
                    ],
                2 => ['value' => 'single',
                   'feature_id' =>3
                    ],
                3 => ['value' => 2,
                  'feature_id' =>4
                    ],
                4 => ['value' => 'flat',
                    'feature_id' =>5
                    ],
                5 => ['value' => 'snake',
                    'feature_id' =>6
                    ],
                6 => ['value' => 2,
                    'feature_id' =>7
                    ],
                7 => ['value' => 'female',
                    'feature_id' =>8
                    ],
                
            ]
        ];
        $this->enableCsrfToken();
        $this->post('user/add', $data);
        $this->assertRedirect(['controller' => 'User', 'action' => 'login']);//Como se añadio correctamente el usuario le lleva a que se logee

        $user = TableRegistry::get('User'); //Compruebo que efectivamente ese usuario existe
        $query = $user->find()->where(['DNI_CIF' => '94802477L']);
        $this->assertEquals(1,$query->count());//se añadio y por tanto existe

        //Logeo
        $this->enableSecurityToken();
        $this->enableCsrfToken();

        $this->get('/user/login');
        $this->assertResponseOk();//accesible

        $this->post('/user/login', [
            'DNI_CIF' => '94802477L',
            'password' => 'prueba' ]
        );
        $this->assertRedirect(['controller' => 'Pages', 'action' => 'index']);//Como se logeo correctamente lleva a inicio
        $this->assertSession(3,'Auth.id');//Existe sesion
    }

    // /**
    //  * Test logout method
    //  *
    //  * @return void
    //  * @uses \App\Controller\UserController::logout()
    //  */
    //Pruebo a cerrar sesion
    public function testLogout(): void
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

        $this->enableCsrfToken();
        $this->post('/user/logout');
        $this->assertSession(null, 'Auth.id');//Compruebo que ya no hay sesion
        $this->assertRedirect(['controller' => 'User', 'action' => 'login']);//Como se deslogeo pide que se logee

    }

    // /**
    //  * Test delete method
    //  *
    //  * @return void
    //  * @uses \App\Controller\UserController::delete()
    //  */
    //Pruebo que se elimina un usuario
    public function testDelete(): void
    {
        $user = TableRegistry::get('User');

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
        $this->post('/user/delete/1');
        $user = TableRegistry::get('User');
        $data = $user->find()->where(['or'=>[['username'=>'Anonimo1'],['username'=>'Anonymous1']]]);
        $this->assertEquals(1,$data->count());//Compruebo que el nombre de usuario se anonimizo

    }

    // /**
    //  * Test delete method
    //  *
    //  * @return void
    //  * @uses \App\Controller\UserController::delete()
    //  */
    //Compruebo que eliminar necesita login
    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/user/delete/1');
        $this->assertRedirectContains('/user/login');//no se puede acceder porque usuario necesita logearse, rdirige a login

    }

}

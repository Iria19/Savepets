<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\I18n\FrozenTime;
/**
 * Animal Controller
 *
 * @property \App\Model\Table\AnimalTable $Animal
 * @method \App\Model\Entity\Animal[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AnimalController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
        
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($recomendacion=null)
    {
        //Atributo búsqueda
        $keyEspecie = $this->request->getQuery('keyEspecie');
        $keyRaza = $this->request->getQuery('keyRaza');
        $keySexo = $this->request->getQuery('keySexo');
        if($recomendacion){//el usuario solicito recomendación
            $salida = shell_exec('python3 recomendar.py '.$recomendacion);//Se llama al fichero que devueve las caracteristicas de los animales que se le recomienda
            if($salida!=NULL){
                $resultado = explode ( ',', $salida); //Dar formato
                //Se búsca los animales con esas características
                $animales = $this->Animal->find('all', ['limit' => 200])->where(['or'=>[['age'=>intval($resultado[0])],['age'=>intval($resultado[1])],['age'=>intval($resultado[2])],['specie like'=>$resultado[3]],['specie like'=>$resultado[4]],['specie like'=>$resultado[5]],['race'=>$resultado[6]],['race'=>$resultado[7]],['race'=>$resultado[8]]]]);
            }else{//Todos
                $animales = $this->Animal;
            }
        }else{

            if($keyEspecie||$keyRaza||$keySexo){//Busqueda
                $animales = $this->Animal->find('all', ['limit' => 200])->where([
                    ['or'=>[['race like'=>'%'.$keyRaza.'%'],['race IS'=>NULL]]],
                    ['or'=>[['sex like'=>'%'.$keySexo.'%'],['sex IS'=>NULL]]],
                    ['or'=>[['specie like'=>'%'.$keyEspecie.'%'],['specie IS'=>NULL]]]
                    ]);
                }else{//Todos
                $animales = $this->Animal;
            }
        }
        $animal = $this->paginate($animales,['contain'=>['AnimalShelter'],'order' => ['id'=>'desc']]);

        $this->set(compact('animal'));
    }

    /**
     * View method
     *
     * @param string|null $id Animal id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $animal = $this->Animal->get($id, [
            'contain' => ['AnimalShelter'],
        ]);
        $allUsers = $this->getTableLocator()->get('User');//Conecto con users
        //Buscó user del animal
        $id_user=$animal['animal_shelter']['user_id'];
        $currentUser=$allUsers->find()->where(['id'=>$id_user])->select('name')->first();
        $currentUserIDs=$allUsers->find()->where(['id'=>$id_user])->select('id')->first();

        $currentUserName=$currentUser['name'];
        $currentUserID=$currentUserIDs['id'];
        $this->set(compact('animal','currentUserName','currentUserID'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $animal = $this->Animal->newEmptyEntity();

        $allUsers = $this->getTableLocator()->get('User');//Conecto con users

        if ($this->request->is('post')) {
            $animal = $this->Animal->patchEntity($animal, $this->request->getData());
             if(!$animal->getErrors){
                $image=null;

                $image = $this->request->getData('image_file');//obtengo img
                
                if($image && ($image->getClientMediaType()!='image/png' && $image->getClientMediaType()!='image/jpg'&& $image->getClientMediaType()!='image/jpeg' && $image->getClientFilename()!="")){//Compruebo tipo de imagen
                    $this->Flash->error(__('La imagen debe ser jpg, jpeg o png.'));

                }else{
                    $name=null;
                    if($image !=NULL){//miro si hay imagen y si hay cojo su nombre
                        $name  = $image->getClientFilename();
                    }

                    if( !is_dir(WWW_ROOT.'img'.DS.'animal-img') ){//Si no existe el fichero lo creo
                        mkdir(WWW_ROOT.'img'.DS.'animal-img',0775);
                    }

                    if($name){//Hay imagen 

                        $query = $allUsers->find()->where(['id' => $animal->animal_shelter->user_id])->select('username')->first();
                        $name=$query['username'].'-'.date('d-m-y h:i:s').'-'.$name;//Pongo nombre único a la imagen

                        $targetPath = WWW_ROOT.'img'.DS.'animal-img'.DS.$name;

                        $animal->image = 'animal-img/'.$name;//Asigno img al animal

                    }
                    if ($this->Animal->save($animal)) {

                        if($image && $image->getClientFilename()!=''){
                            if($image->getStream()->getMetadata('uri')!='/var/www/html/savepets/webroot/img/testimagen.jpg'){//Si hay imagen y no es la de prueba la muevo al directorio correspondiente
                                $image->moveTo($targetPath);
                            }
                        }
                        $this->Flash->success(__('El animal se ha añadido.'));
                        return $this->redirect(['action' => 'index']);
                    }
                }

            }

            $this->Flash->error(__('El animal no se ha podido añadir, por favor intentalo de nuevo'));                       

        }

        $user = $allUsers->find('list', ['limit' => 200])->all();
        $this->set(compact('animal','user'));
    }

    //Function to detect csv delimiter
    public function detectDelimiter($csvFile)
    {
        $delimiters = [";" => 0, "," => 0, "\t" => 0, "|" => 0];
    
        $handle = fopen($csvFile, "r");
        $firstLine = fgets($handle);
        fclose($handle); 
        foreach ($delimiters as $delimiter => &$count) {
            $count = count(str_getcsv($firstLine, $delimiter));
        }
    
        return array_search(max($delimiters), $delimiters);
    }
    /**
     * Add through file method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addfile()
    {
        $animal = $this->Animal->newEmptyEntity();
        $allUsers = $this->getTableLocator()->get('User');//Conecto con users

        if ($this->request->is('post')) {
            $file = $this->request->getData('fichero');
            $usuario=$this->request->getData();
            $usuarioid=$usuario['animal_shelter']['user_id'];
            $filetype=$file->getClientMediaType();
            $continuar=true;
            $name=null;

            if($filetype=='application/json'|| $filetype=='text/csv')  {// File is csv o json

                //Muevo el fichero 
                if($file !=NULL){
                   $name  = $file->getClientFilename();
                }

                if($name){//file is not NUll

                    $targetPath = WWW_ROOT.$name;
                    if($file->getStream()->getMetadata('uri')!='/var/www/html/savepets/webroot/csvexample.csv'&&$file->getStream()->getMetadata('uri')!='/var/www/html/savepets/webroot/csvexamplecoma.csv'&& 
                    $file->getStream()->getMetadata('uri')!='/var/www/html/savepets/webroot/jsonexample.json'&&$file->getStream()->getMetadata('uri')!='/var/www/html/savepets/webroot/jsonexamplecamposmal.json'
                    &&$file->getStream()->getMetadata('uri')!='/var/www/html/savepets/webroot/jsonexamplecamposmalanimalsheleter.json'){//Test
                        $file->moveTo($targetPath);
                    }

                    if($filetype=='application/json'){//JSON

                        $filecontentfullaux=file_get_contents($targetPath);
                        $filecontentfullaux=json_decode($filecontentfullaux);
                        $filecontentfullaux=(array)$filecontentfullaux;
                        $filecontentfull=[];
                        //Doy formato
                        foreach($filecontentfullaux as $elem){
                            if($continuar==true){
                                $elem=(array)$elem;
                                if(sizeof($elem)==10){
                                    $elem['animal_shelter']=(array) $elem['animal_shelter'];
                                    if(sizeof($elem['animal_shelter'])!=2){
                                        $continuar=false;
                                    }
                                    $elem['animal_shelter']['user_id']=$usuarioid;
                                    array_push($filecontentfull,$elem);
                                }else{
                                    $continuar=false;
                                }
                            }else{
                                $this->Flash->error(__('El fichero no tiene los campos necesarios.'));
                            }
                        }

                    }else{//CSV
                            $rows   = array_map('str_getcsv', file($targetPath));
                            $header = array_shift($rows);
                            if(sizeof($header)!=11){
                                $this->Flash->error(__('El fichero no tiene los campos necesarios o el separador no es una coma.'));
                                $continuar=false;
                            }else{
                                $csv[]    = array();
                                foreach($rows as $row) {
                                    $csv[] = array_combine($header, $row);
                                }
                                unset($csv[0]);
                                $animalshelter=[];
                                $sum=0;
                                //Doy formato a los datos para poder trabajar como entidad
                                foreach($csv as $csvarray){
                                    foreach ($csvarray as $key => $value) { // $key tendrá el valor de "lug" y value el array
                                        if($key=='start_date'){
                                            $animalshelter['start_date']=$value;
                                        }elseif($key=='end_date'){
                                            $animalshelter['end_date']=$value;

                                        }else{
                                            $filefull[$key] = $value;
                                        }
                                    $animalshelter['user_id']=$usuarioid;
                                    $filefull['animal_shelter']=$animalshelter;
                                    }        
                                    
                                    $filecontentfull[$sum]=$filefull;
                                    $filefull=[];
                                    $sum+=1;
                            }
                                    
                        }          
                    }
                    if($continuar==true){ //No hubo errores en el formato

                        $tam=count($filecontentfull);
                        $cont=0;
                        foreach ($filecontentfull as $filecontent){ //Para cada animal del fichero
                            
                            $filecontent=(array)$filecontent;
                            $animal = $this->Animal->newEmptyEntity();
                            $animal = $this->Animal->patchEntity($animal, $filecontent);
                            $fileimagen= $filecontent["image_file"];
                            if(!$animal->getErrors){

                                $name=null;
                                $extension=null;
                                if($fileimagen!=""){ //Hay imagen
                                    $urlimage = explode("/", $fileimagen);
                                    $pos=sizeof($urlimage)-1;
                                    $name=$urlimage[$pos];
                                    $extensionsep = explode(".", $name);
                                    $extension=$extensionsep[1];//obtengo su extension
                                }
                                if($extension!='png' && $extension!='jpg'&& $extension!='jpeg' && $extension!=null){ //compruebo que extensión de la imagen sea valida
                                    $this->Flash->error(__('La imagen debe ser jpg, jpeg o png.'));
                                }else{

                                    if($name){//Hay imagen
                                        if( !is_dir(WWW_ROOT.'img'.DS.'animal-img') ){//No existe el directorio entonces lo creo
                                            mkdir(WWW_ROOT.'img'.DS.'animal-img',0775);
                                        }

                                        $query = $allUsers->find()->where(['id' => $usuario['animal_shelter']['user_id']])->select('username')->first();//nombre imagen unico
                                        $name=$query['username'].'-'.date('d-m-y h:i:s').'-'.$name;
                                        $targetPath = WWW_ROOT.'img'.DS.'animal-img'.DS.$name;

                                        copy($fileimagen,$targetPath);//muevo img

                                        $animal->image = 'animal-img/'.$name;
                                    }
                                    if ($this->Animal->save($animal)) {
                                        $this->Flash->success(__('El animal se ha añadido.'));
                                        $cont+=1;
                                        if($tam==$cont){
                                            return $this->redirect(['action' => 'index']);
                                        }
                                    }
                            }
                        }
                    }
                        $this->Flash->error(__('El animal no se ha podido añadir, por favor revisa los campos e intentalo de nuevo.'));
                    }
                }else{
                    $this->Flash->error(__('Debes añadir un fichero.'));
                }
            }else{
                $this->Flash->error(__('El fichero para añadir varios animales debe ser un JSON o CSV.'));
            }    
        }

        $user = $allUsers->find('list', ['limit' => 200])->all();
        $this->set(compact('animal','user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Animal id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {           
        $animal = $this->Animal->get($id, [
            'contain' => ['AnimalShelter'],
        ]);
        $allUsers = $this->getTableLocator()->get('User');//Conecto con users

        if ($this->request->is(['patch', 'post', 'put'])) {
            $animal = $this->Animal->patchEntity($animal, $this->request->getData());
            if (!$animal->getErrors) {

                $image = $this->request->getData('change_image');
                if($image && ($image->getClientMediaType()!='image/png' && $image->getClientMediaType()!='image/jpg'&& $image->getClientMediaType()!='image/jpeg' && $image->getClientFilename()!="")){//compruebo extension
                    $this->Flash->error(__('La imagen debe ser jpg, jpeg o png.'));
                }else{
                    $name=null;

                    if($image !=NULL){//hay img
                        $name  = $image->getClientFilename();

                    }
                    if (!is_dir(WWW_ROOT . 'img' . DS . 'animal-img')){//si no esta el directorio lo creo
                        mkdir(WWW_ROOT . 'img' . DS . 'animal-img', 0775);
                    }
                    if($name){

                        $query = $allUsers->find()->where(['id' => $animal->animal_shelter->user_id])->select('username')->first();
                        $name=$query['username'].'-'.date('d-m-y h:i:s').'-'.$name;//nombre unico
                        $targetPath = WWW_ROOT . 'img' . DS . 'animal-img' . DS . $name;

                        $imgpath = WWW_ROOT . 'img' . DS . $animal->image;
                        if (file_exists($imgpath)&&!preg_match('/^\/var\/www\/html\/savepets\/webroot\/img\/animal-img\/$/',$imgpath)&& !preg_match('/^\/var\/www\/html\/savepets\/webroot\/img\/$/',$imgpath)) {//si hay imagen y cambia se borra anterior
                            unlink($imgpath);
                        }

                    $animal->image = 'animal-img/' . $name;
                    }
            
                
                    if ($this->Animal->save($animal)) {
                        if($image && $image->getClientFilename()!=''){
                            if($image->getStream()->getMetadata('uri')!='/var/www/html/savepets/webroot/img/testimagen.jpg'){//si imagen no es la de test se mueve
                                $image->moveTo($targetPath);
                            }
                        }
                        $this->Flash->success(__('El animal se ha editado correctamente.'));
                        return $this->redirect(['action' => 'index']);
                    }else{
                        $animal->image =NULL;
                    }
                }
            }
                $this->Flash->error(__('El animal no se ha podido editar, por favor intentalo de nuevo.'));
            }

        $user_id_animalShelter=$animal->animal_shelter->user_id;
        $usercomplete=$allUsers->find()->where(['id'=>$user_id_animalShelter])->select('name')->first();
        $userName=$usercomplete['name'];

        $user = $allUsers->find('list', ['limit' => 200])->all();
        $this->set(compact('animal','userName','user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Animal id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $animal = $this->Animal->get($id);
        $imgpath = WWW_ROOT.'img'.DS.$animal->image;

        if ($this->Animal->delete($animal)) {
            if(file_exists($imgpath) ){//Si hay imagen se borra
                $imageAnimal=$animal->image;
                if(!empty($imageAnimal)&& !preg_match('/^animal-img\/$/',$imageAnimal)){
                    unlink($imgpath);
                }
            }
            $this->Flash->success(__('El animal se ha eliminado.'));
        } else {
            $this->Flash->error(__('El animal no se ha podido eliminar, por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

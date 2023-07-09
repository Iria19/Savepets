<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->loadHelper('Authentication.Identity');

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

   <!-- ======= Breadcrumbs ======= -->
   <div class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?= __('Consultar') ?></h2>
          <ol>
            <aside class="column">
                <div class="side-nav">
                <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?> 
                <?php 
                    if($this->Identity->isLoggedIn()){
                      $currentuser = $this->request->getAttribute('identity');
                      $currentuserRol=$currentuser->role;
                      $currentuserUsername=$currentuser->username;

                        if($currentuserRol=="admin" || $currentuserUsername==$user->username){ ?>
                         / <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>  / 
                          <?= $this->Html->link(__('Ver'), ['action' => 'view', $user->id], ['class' => 'side-nav-item']) ?>  / 

                          <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete','controller' => 'User', $user->id], 
                                    ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar el usuario {0}?', $user->username)],['escape' => false]) ?> 
                <?php }
              }?>
                </div>
            </aside>
          </ol>
        </div>

      </div>
    </div><!-- End Breadcrumbs -->
     <!-- ======= Individual Section ======= -->
 <section id="individual" class="individual">
  <div class="container" data-aos="fade-up">

    <div class="section-header">
      <h2><?= __('Análisis de vistas de los animales') ?></h2>
      <p><?= __('de') ?> <span><?= h($user->username) ?></span>!!</p>
    </div>


      <div class="d-flex align-items-center reservation-form-bg">
        <form action="forms/individual.php" method="post" role="form" class="php-email-form especie" data-aos="fade-up" data-aos-delay="100">
          <h3 id="titlegraphicespecie"><?= __('Gráfíco de especies')?></h3>  
          <div class="especiesgraphic">
            <canvas id="ChartSpecies"></canvas>

              <div id="epecielistgraphics">
               
                <div class="row">
                  <div class="col"> <p id="especiesgraphicdog"> <?= __('Perro: ') ?> <?php echo($array[0]); ?></p></div>
                  <div class="col"><p id="especiesgraphiccat"> <?= __('Gato: ') ?> <?php echo($array[1]); ?></p></div>
                </div>
                <div class="row">
                  <div class="col"><p id="especiesgraphicbunny"> <?= __('Conejo: ') ?> <?php echo($array[2]); ?></p></div>
                  <div class="col"><p id="especiesgraphichamster"> <?= __('Hamster: ') ?> <?php echo($array[3]); ?></p></div>
                </div>
                <div class="row">
                  <div class="col"><p id="especiesgraphicsnake"> <?= __('Serpiente: ') ?> <?php echo($array[4]); ?></p></div>
                  <div class="col"><p id="especiesgraphicturthe"> <?= __('Tortuga: ') ?> <?php echo($array[5]); ?></p></div>
                </div>
                <div class="row">
                  <div class="col"><p id="especiesgraphicother"> <?= __('Otro: ') ?> <?php echo($array[6]); ?></p></div>
                </div>
            </div>
            </div>
            <br><br>  
            <h3 id="titlegraphicgenero"><?= __('Gráfíco de género')?></h3>  
            <div class="gendergraphic">
              <canvas id="ChartGender"></canvas>

                <div id="genderlistgraphics">
                
                  <div class="row">
                    <div class="col"> <p id="gendergraphichombre"> <?= __('Hombre: ') ?> <?php echo($array[7]); ?></p></div>
                    <div class="col"><p id="gendergraphicmujer"> <?= __('Mujer: ') ?> <?php echo($array[8]); ?></p></div>
                  </div>
                  <div class="row">
                    <div class="col"><p id="gendergraphicnobinario"> <?= __('No binario: ') ?> <?php echo($array[9]); ?></p></div>
                    <div class="col"><p id="gendergraphicotro"> <?= __('Otro: ') ?> <?php echo($array[10]); ?></p></div>
                  </div>
                </div>
              </div>

            <br><br>  
            <h3 id="titlegraphicage"><?= __('Gráfíco de edades')?></h3>  
            <div class="agegraphic">
              <canvas id="ChartAge"></canvas>

                <div id="agelistgraphics">
                
                  <div class="row">
                    <div class="col"> <p id="edadgraphicmenostreinta"> <?= __('Menos de 30: ') ?> <?php echo($array[11]); ?></p></div>
                    <div class="col"><p id="edadgraphictreintasesenta"> <?= __('Entre 30-60: ') ?> <?php echo($array[12]); ?></p></div>
                  </div>
                  <div class="row">
                    <div class="col"><p id="edadgraphicmenosmassesenta"> <?= __('Más de 60: ') ?> <?php echo($array[13]); ?></p></div>
                  </div>
                </div>
            </div>
            <br><br>  
            <h3 id="titlegraphicchildren"><?= __('Gráfíco de hijos')?></h3>  
            <div class="childrengraphic">
              <canvas id="ChartChildren" style="width:100%;max-width:600px"></canvas>

                <div id="childrenlistgraphics">
                
                  <div class="row">
                    <div class="col"> <p id="hijosgraphicno"> <?= __('Sin hijos: ') ?> <?php echo($array[14]); ?></p></div>
                    <div class="col"><p id="hijosgraphicuno"> <?= __('1 hijo: ') ?> <?php echo($array[15]); ?></p></div>
                  </div>
                  <div class="row">
                    <div class="col"><p id="hijosgraphicdos"> <?= __('2 hijos: ') ?> <?php echo($array[16]); ?></p></div>
                    <div class="col"><p id="hijosgraphicmasdos"> <?= __('Más de 2 hijos: ') ?> <?php echo($array[17]); ?></p></div>

                  </div>
                </div>
            </div>
        </form>
      </div><!-- End Form -->
      <div>    
  </div>
 </div>
</div>
 <br>
<br>
</section>
<?= $this->Html->script(['mycharts']) ?>

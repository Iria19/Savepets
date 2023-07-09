<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Alert $alert
 * @var \Cake\Collection\CollectionInterface|string[] $user
 */
?>

   <!-- ======= Breadcrumbs ======= -->
   <div class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?= __('Añadir') ?></h2>
          <ol>
            <aside class="column">
                <div class="side-nav">
                    <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?> 
                </div>
            </aside>
          </ol>
        </div>

      </div>
    </div><!-- End Breadcrumbs -->
    <!-- ======= Form Section ======= -->
    <section id="formsec" class="formsec">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <p><?= __('Realizar una ') ?> <span><?= __('alerta') ?></span></p>
        </div>
        <div class="section-content-form">

          <img src="/img/about-2.jpg" class="img-fluid" alt="">

          <?= $this->Form->create($alert,['class'=>'php-email-form p-3 p-md-4']) ?>
            <div class="row">
              <div class="alertform-group">
                   <?php echo $this->Form->control('title',['class'=>'form-control','label'=> __('Titulo')]); ?>
              </div>        
            </div>
            <div class="row">
                <div class="alertform-group">
                    <?php echo $this->Form->control('country',['class'=>'form-control','label'=> __('País')]); ?>
                </div>
            </div>
            <div class="row">
                <div class="alertform-group">
                    <?php echo $this->Form->control('province',['class'=>'form-control','label'=> __('Provincia')]); ?>
                </div>
            </div>

            <div class="row">
                <div class="alertform-group">
                    <?php 
                    $opcionesEspecie=[''=>null,'dog'=>__('Perro'),'cat'=>__('Gato'),'bunny'=>__('Conejo'),'hamster'=>__('Hamster'),'snake'=>__('Serpiente'),'turtles'=>__('Tortuga'),'other'=>__('Otro')];
                    echo $this->Form->control('specie',['class'=>'form-control','label'=> __('Especie'),'options'=>$opcionesEspecie]); 
                    ?> 
                </div>
            </div>
            <div class="row">
                <div class="alertform-group">
                    <?php echo $this->Form->control('race',['class'=>'form-control' ,'label'=> __('Raza')]); ?>
                </div>
            </div>
            <div class="row">
                <div class="alertform-group">
                    <?php 
                    $opcionesActivate=['yes'=>__('Sí'),'no'=>__('No')];
                    echo $this->Form->control('active',['class'=>'form-control','label'=> __('Activa'),'options'=>$opcionesActivate]); ?>
                </div>
            </div>
            <?php 
              $this->loadHelper('Authentication.Identity');
              if($this->Identity->isLoggedIn()){
                $currentuser = $this->request->getAttribute('identity');
                $currentuserID=$currentuser->id;
                echo $this->Form->control('user_id',['type'=>'text','class'=>'form-control elemoculto', 'label' =>'', 'value'=>$currentuserID]); 
              }

              $actualdate=date('Y-m-d H:i:s');
              echo $this->Form->control('creation_date',['type'=>'text','class'=>'form-control elemoculto', 'label' =>'','value'=>$actualdate]); 
            ?>
            <div class="text-center"><?= $this->Form->button(__('Añadir')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Animal $animal
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
          <p><?= __('Añadir nuevo') ?> <span><?= __('animal') ?></span>: CSV/JSON</p>
        </div>
        <div class="section-content-form">

          <img src="/img/animalabout.png" class="img-fluid" alt="">

          <?= $this->Form->create($animal,['class'=>'php-email-form p-3 p-md-4','type'=>'file']) ?>
            <div class="row">
                <?php echo $this->Form->file('fichero'); ?>
            </div> 
            <br>
            <?php 
              $currentUser = $this->request->getAttribute('identity');
              $currentuserRol=$currentUser->role;
                if($currentuserRol=='admin'){?>
                  <div class="row select">
                    
                    <?php 

                    echo $this->Form->control('animal_shelter.user_id',['options' => $user,'label'=> __('Usuario')]); ?>
                  </div> 
                  <br>
              <?php
                }else{
                  $currentuserID=$currentUser->id;
                  echo $this->Form->control('animal_shelter.user_id',['value'=>$currentuserID,'type'=>'text','class'=>'form-control elemoculto', 'label' =>'']); 
                }
              ?>
            <div class="text-center"><?= $this->Form->button(__('Añadir')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->

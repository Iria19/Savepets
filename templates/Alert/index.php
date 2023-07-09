<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Alert> $alert
 */
?>


<div class="publicationAdoption index content">
    <!-- ======= Objetivos Section ======= -->
    <section id="objetiv list" class="objetiv section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
            <h2><?= __('MIS') ?></h2>
            <p> <span><?= __('ALERTAS') ?></span></p>
                <div>
                    <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("addnew.png", ["alt" => "Nuevo"])), ['action' => 'add'],['escape' => false]) ?></button>                                    
                </div>
        </div>

        <div class="row gy-4">

        <table>
            <tbody>
                <?php foreach ($alert as $alert): ?>
                    
                <tr>        
                <div class=" d-flex align-items-stretch publication view" data-aos="fade-up" data-aos-delay="100">
                    <?php 
                    if($alert->active =='no'){ ?>
                        <div class="objetivo-member alert noaciva">
                    <?php }else{ ?>
                        <div class="objetivo-member alert activa ">
                    <?php } ?>
                    <div class="member-info">
                        <div class='member-info head alert'>
                            <h5 class="titlealert"><?= h($alert->title) ?></h5>
                        </div>
                        <div class="contentmember-info-alert">
                            <div class="alertcontent-info">
                            <?php 
                                $this->loadHelper('Authentication.Identity');
                                if($this->Identity->isLoggedIn()){
                                $user = $this->request->getAttribute('identity');
                                $currentuserRol=$user->role;
                                if($currentuserRol=="admin" ){?>
                                    <p class="titulocentrado"><b><?= __('Alias usuario: ') ?></b><?= h($alert->user->username) ?></p> 
                            <?php }
                                } ?>
                                <p class="titulocentrado"><b><?= __('País: ') ?></b><?= h($alert->country) ?></p> 
                                <p class="titulocentrado"><b><?= __('Provincia: ') ?></b><?= h($alert->province) ?></p> 
                                <p class="titulocentrado"><b><?= __('Especie: ') ?></b><?= h($alert->specie) ?></p> 
                                <p class="titulocentrado"><b><?= __('Raza: ') ?></b><?= h($alert->race) ?></p>
                             </div>    
                            </div>
                    <div class="text-centerlist">
                    <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("pencil.png", ["alt" => "View"])), ['action' => 'edit', $alert->id],['escape' => false]) ?></button>
                    <button type="submit" class="listbtn">
                        <?= $this->Form->postLink(__($this->Html->image("trash.png", ["alt" => "Delete Publication"] )), ['action' => 'delete', $alert->id], 
                           ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar la alerta {0}?', $alert->title)],['escape' => false]) ?> </button>
                    </div>
                            <br>
                        </div>
                        </div>

                    </div><!-- End Objetivo -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
      </div>
      <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('primera')) ?>
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('siguiente') . ' >') ?>
            <?= $this->Paginator->last(__('última') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrandese {{current}} de {{count}}.')) ?></p>
    </div>
    </section><!-- End objetiv Section -->

  </main><!-- End #main -->

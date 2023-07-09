<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PublicationStray $publicationStray
 */

 use Cake\I18n\I18n;

$this->loadHelper('Authentication.Identity');

if($this->Identity->isLoggedIn()){
  $currentuser = $this->request->getAttribute('identity');
  $currentuserRol=$currentuser->role;
  $currentuserID=$currentuser->id;
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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

                    if($currentuserRol=="admin" || $currentuserID==$publicationStray->user_id){ ?>
                      / <?= $this->Html->link(__('Editar'), ['action' => 'edit', $publicationStray->id], ['class' => 'side-nav-item']) ?>  / 

                       <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $publicationStray->id], 
                            ['confirm' => __('Estas seguro de querer eliminar la publicación {0}?', $publicationStray->publication->title)],['escape' => false]);
                    }
                  } ?>
                </div>
            </aside>
          </ol>
        </div>

      </div>
    </div><!-- End Breadcrumbs -->
     <!-- ======= Individual Section ======= -->

     <div class=" d-flex align-items-stretch publication view" data-aos="fade-up" data-aos-delay="100">
        <div class="objetivo-member publication view">
          <div class="member-info">
            <div class='member-info head'>
              <?php if($publicationStray->user->role=='admin'){ ?>
                <img src="/img/logo.jpg" class="img-perfil" alt="Admin icon">
              <?php } elseif($publicationStray->user->role=='shelter'){ ?>
                <img src="/img/shelterrol.png" class="img-perfil" alt="Shelter icon">
              <?php }else{ ?>
                <img src="/img/useronly.png" class="img-perfil" alt="Standar icon">
              <?php } 
              if($this->Identity->isLoggedIn() && ($currentuserRol=="admin" || $publicationStray->user->role =="shelter" ||$currentuserID==$publicationStray->user_id)){

                ?>
                  <h3> <?= $publicationStray->has('user') ? $this->Html->link($publicationStray->user->username, ['controller' => 'User', 'action' => 'view', $publicationStray->user->id]) : '' ?></h3> 
              <?php 
              }else{ ?>
                  <h3><b><?= h($publicationStray->user->username) ?></b></h3>
                <?php } 
              ?>
              <h5 class="fechaformatocolor"><span><?php $fecha=$publicationStray->publication->publication_date;
              echo $fecha->format('d/m/Y H:i:s'); ?></span></h5> 
            </div>
          </div>
          <div id="invoice">
            <h2 class="titulocentrado"id="titulocentrado"><?= h($publicationStray->publication->title) ?></h2> 
              <?php
                if(!empty($publicationStray->image)&& !preg_match('/^strayanimal-img\/$/',$publicationStray->image)){ 
                  $dir='/img/'.$publicationStray->image;
              ?>
                <img src="<?php echo $dir ?>" class="img-fluid index publicacionfotoanimalview" id= "publicacionfotoanimalview" alt="imagen animal ">
                <div class="esjuntop" id="esjuntop"><?= __('Urgente') ?>:
                <div hidden> <?= $urgente=$publicationStray->urgent?> </div> 
                  <?php
                  switch($urgente){
                      case "yes":
                          echo  __('Sí');
                          break;
                      case "no":
                          echo  __('No');
                          break;
                      default:
                          echo  __(' ');
                          break;
                      }?>               
              
                    </div> 
                    <p class="publication adopcion" id="esjuntoo"><?= h($publicationStray->publication->message) ?></p> 
              <?php
                }else{ ?>
                <div class="esjuntop" id="esjuntop"><?= __('Urgente') ?>:
                <div hidden> <?= $urgente=$publicationStray->urgent?> </div> 
                  <?php
                  switch($urgente){
                      case "yes":
                          echo  __('Sí');
                          break;
                      case "no":
                          echo  __('No');
                          break;
                      default:
                          echo  __(' ');
                          break;
                      }?>               
              
                    </div>
                  <p class="publication adopcion" id="esjuntoo"><?= h($publicationStray->publication->message) ?></p> 

              <?php } 
                $CurrentPublicationStray_id=$publicationStray->id;
              ?>
            </div>
            <div class="sharemedialinkssavepet">
                      <?php if (I18n::getLocale() !== 'en_US'){ ?>      
                      <a href="http://twitter.com/share?url=http://localhost:8765/publication-stray/view/<?= $publicationStray->id ?> &text=<?= $publicationStray->publication->title ?>. Para más información accede al siguiente enlace:&via=Savepetstw&hashtags=savepets" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="25" height="25"  fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16"><path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/></svg>
                      </a>
                      <a href="http://reddit.com/submit?url=http://localhost:8765/publication-stray/view/<?= $publicationStray->id ?>&title=<?= $publicationStray->publication->title ?> " target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="25" height="25" fill="currentColor" class="bi bi-reddit" viewBox="0 0 16 16"><path d="M6.167 8a.831.831 0 0 0-.83.83c0 .459.372.84.83.831a.831.831 0 0 0 0-1.661zm1.843 3.647c.315 0 1.403-.038 1.976-.611a.232.232 0 0 0 0-.306.213.213 0 0 0-.306 0c-.353.363-1.126.487-1.67.487-.545 0-1.308-.124-1.671-.487a.213.213 0 0 0-.306 0 .213.213 0 0 0 0 .306c.564.563 1.652.61 1.977.61zm.992-2.807c0 .458.373.83.831.83.458 0 .83-.381.83-.83a.831.831 0 0 0-1.66 0z"/><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.828-1.165c-.315 0-.602.124-.812.325-.801-.573-1.9-.945-3.121-.993l.534-2.501 1.738.372a.83.83 0 1 0 .83-.869.83.83 0 0 0-.744.468l-1.938-.41a.203.203 0 0 0-.153.028.186.186 0 0 0-.086.134l-.592 2.788c-1.24.038-2.358.41-3.17.992-.21-.2-.496-.324-.81-.324a1.163 1.163 0 0 0-.478 2.224c-.02.115-.029.23-.029.353 0 1.795 2.091 3.256 4.669 3.256 2.577 0 4.668-1.451 4.668-3.256 0-.114-.01-.238-.029-.353.401-.181.688-.592.688-1.069 0-.65-.525-1.165-1.165-1.165z"/></svg>
                      </a>  
                      <a href="https://api.whatsapp.com/send?text=<?= $publicationStray->publication->title ?>. Para más información accede al siguiente enlace: http://localhost:8765/publication-stray/view/<?= $publicationStray->id ?>" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16"> <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg>
                      </a>
                      <br>
                    <?php }else{ ?> 
                      <a href="http://twitter.com/share?url=http://localhost:8765/publication-stray/view/<?= $publicationStray->id ?> &text=<?= $publicationStray->publication->title ?>. For more information, access the following link: &via=Savepetstw&hashtags=savepets" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="25" height="25"  fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16"><path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/></svg>
                      </a>
                      <a href="http://reddit.com/submit?url=http://localhost:8765/publication-stray/view/<?= $publicationStray->id ?>&title=<?= $publicationStray->publication->title ?> " target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="25" height="25" fill="currentColor" class="bi bi-reddit" viewBox="0 0 16 16"><path d="M6.167 8a.831.831 0 0 0-.83.83c0 .459.372.84.83.831a.831.831 0 0 0 0-1.661zm1.843 3.647c.315 0 1.403-.038 1.976-.611a.232.232 0 0 0 0-.306.213.213 0 0 0-.306 0c-.353.363-1.126.487-1.67.487-.545 0-1.308-.124-1.671-.487a.213.213 0 0 0-.306 0 .213.213 0 0 0 0 .306c.564.563 1.652.61 1.977.61zm.992-2.807c0 .458.373.83.831.83.458 0 .83-.381.83-.83a.831.831 0 0 0-1.66 0z"/><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.828-1.165c-.315 0-.602.124-.812.325-.801-.573-1.9-.945-3.121-.993l.534-2.501 1.738.372a.83.83 0 1 0 .83-.869.83.83 0 0 0-.744.468l-1.938-.41a.203.203 0 0 0-.153.028.186.186 0 0 0-.086.134l-.592 2.788c-1.24.038-2.358.41-3.17.992-.21-.2-.496-.324-.81-.324a1.163 1.163 0 0 0-.478 2.224c-.02.115-.029.23-.029.353 0 1.795 2.091 3.256 4.669 3.256 2.577 0 4.668-1.451 4.668-3.256 0-.114-.01-.238-.029-.353.401-.181.688-.592.688-1.069 0-.65-.525-1.165-1.165-1.165z"/></svg>
                      </a>  
                      <a href="https://api.whatsapp.com/send?text=<?= $publicationStray->publication->title ?>. For more information, access the following link: http://localhost:8765/publication-stray/view/<?= $publicationStray->id ?>" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16"> <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg>
                      </a>
                      <br>
                    <?php } ?>   
                  </div>
            <button id="download-button" class="listbtn verdirecciones">PDF</button>
            <button type="submit" class="listbtn verdirecciones"><?= $this->Html->link(__('Ver Direcciones'), ['action' => 'index','controller'=>'PublicationStrayAddress',$CurrentPublicationStray_id]) ?></button>

          <br>
        </div>
      </div>

    </div><!-- End Objetivo -->

<!-- Comentarios -->
<div class="comentarioshead">

<h3><?= __('Comentarios') ?></h3>

    <?php 

    if($this->Identity->isLoggedIn()){ ?>
        <div>
        <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("addnew.png", ["alt" => "Nuevo"])), ['controller' => 'Comment', 'action' => 'add', $publicationStray->publication_id,$publicationStray->id,'Stray'],['escape' => false]) ?></button>                                    
        </div>
<?php } 
?>
</div>

<div class="row gy-4">
    <table>
        <tbody>
            <?php foreach ($publicationStray->comment as $publicationcomments): 
              ?>
            <tr>        
            <div class=" d-flex align-items-stretch publication view comment" data-aos="fade-up" data-aos-delay="100">
              <div class="objetivo-member publication view comment">
                <div class="member-info">
                  <div class='member-info head'>
                                <?php 
                                    if($publicationcomments->user->role=='admin'){ ?>
                                        <img src="/img/logo.jpg" class="img-perfil" alt="Admin icon">
                                <?php } elseif($publicationcomments->user->role=='shelter'){ ?>
                                    <img src="/img/shelterrol.png" class="img-perfil" alt="Shelter icon">
                                <?php }else{ ?>
                                    <img src="/img/useronly.png" class="img-perfil" alt="Standar icon">
                                <?php  } 
                                    if($this->Identity->isLoggedIn() && ($currentuserRol=="admin" || $publicationcomments->user->role =="shelter" ||$currentuserID==$publicationcomments->user->user_id)){
                                ?>
                                        <h3> <?= $publicationcomments->has('user') ? $this->Html->link($publicationcomments->user->username, ['controller' => 'User', 'action' => 'view', $publicationcomments->user->id, $publicationcomments->id,$publicationStray->publication_id,$publicationStray->id,'Stray']) : '' ?></h3> 
                                <?php  }else{?>
                                        <h3><b><?= h($publicationcomments->user->username) ?></b></h3>
                                    <?php 
                                    } 
                               
                                ?>                                
                                <h5 class="fechaformatocolor"><span><?php $fecha=$publicationcomments->comment_date;
                                    echo $fecha->format('d/m/Y H:i:s'); ?></span>
                                </h5>
                            </div>
                        </div>
                        <p class="indexpublication"><?= h($publicationcomments->message) ?></p> 

                        <div class="text-centerlist">

                            <?php 
                                if($this->Identity->isLoggedIn()){
                                  if($currentuserRol=="admin"){ ?>                                    
                                    <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("pencil.png", ["alt" => "View"])), ['controller' => 'Comment','action' => 'edit', $publicationcomments->id,$publicationStray->publication_id,$publicationStray->id,'Stray'],['escape' => false]) ?></button>
                                    <button type="submit" class="listbtn">
                                    <?= $this->Form->postLink(__($this->Html->image("trash.png", ["alt" => "Delete Comment"] )), ['controller' => 'Comment','action' => 'delete', $publicationcomments->id,$publicationStray->publication_id,$publicationStray->id,'Stray'], 
                                    ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar el comentario ?')],['escape' => false]) ?> </button>
                            <?php  } 
                            }?>
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

<?= $this->Html->script(['generatepdf']) ?>


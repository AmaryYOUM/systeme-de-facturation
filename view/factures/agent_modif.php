<div class="bloc-content">
    <div class="container-fluid" style="margin-left: 10px; background-color: white;">
        <form action="<?php echo Router::url('agent/factures/modif/'.$id); ?>" method="post">
                <h1><?php echo 'Facture-N°'.$id ?></h1>
                <div class="input-box">
                    <?php echo $this->Form->input('id','hidden'); ?>
                </div> 
                <div class="input-box">
                    <?php echo $this->Form->input('num','hidden'); ?>
                </div>
                <div class="input-box">
                    <?php echo $this->Form->input('date_creation','hidden'); ?>
                </div>
                <div class="input-box">
                    <input type="hidden" name="user_id" value = <?php echo $agent_id ?>>
                </div>
            
                <div class="input-box">
                    <?php echo $this->Form->input('patient_id','hidden'); ?>
                </div> 

                <div class="input-box">
                    <?php echo $this->Form->input('prestation_id','hidden'); ?>
                </div> 

                <div class="input-box">
                    <?php echo $this->Form->input('montant_global','hidden'); ?>
                </div>
                <label for="modifier">Veuillez-cocher la case pour signaler à l'administrateur de supprimer cette facture</label>
                <div class="input-box">
                    <?php echo $this->Form->input('modifier','corriger',array('type'=>'checkbox')); ?>
                </div>    
            <div class="actions">
                <input type="submit" class="btn primary" value="Signaler">
            </div>
        </form>
    </div>
</div>
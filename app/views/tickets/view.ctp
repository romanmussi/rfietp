
<div class="anios form">
    <p>
        <cite>
            <?php
            echo $this->data['User']['nombre']." ".$this->data['User']['apellido'];
            ?>
        </cite>
    </p>
    <hr />
    <p style="height:95px;">
        <?php
        echo $this->data['Ticket']['observacion'];
        ?>
    </p>
    <div >
        <span style="float:left;">
            Alta: <?php echo date('d-m-Y',strtotime($this->data['Ticket']['created'])); ?>
        </span>
        <span style="float:right;">
            Modificacion: <?php echo date('d-m-Y',strtotime($this->data['Ticket']['modified'])); ?>
        </span>
    </div>
</div>
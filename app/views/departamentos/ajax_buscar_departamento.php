
 <ul>
	  <?php foreach($deptos as $d): ?>
	   <li><b><?php echo $d['Departamento']['name']; ?></b>(<?php echo $d['Jurisdiccion']['name'];?>)</li>
	  <?php endforeach; ?>
 </ul>


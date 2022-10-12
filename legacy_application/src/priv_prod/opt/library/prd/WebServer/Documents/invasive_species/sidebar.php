<div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large"
  onclick="w3_close()">Close &times;</button>
  <a href="<?php echo 'home.php'; ?>" class="w3-bar-item w3-button">Home</a>
  <a href="<?php echo 'perscriptions'; ?>" class="w3-bar-item w3-button">Perscriptions (Rx)</a>
  <a href="<?php echo 'treatments'; ?>" class="w3-bar-item w3-button">Treatments (Tx)</a>
  <a href="<?php echo 'herbicide'; ?>" class="w3-bar-item w3-button">Herbicide Requests</a>
  <a href="<?php echo 'resources_view.php'; ?>" class="w3-bar-item w3-button">Resources</a>
</div>

<div>
<button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
<div>

<?php

$database="invasive_species";
//user validation for admin level links

?>



<script>
function w3_open() {
  document.getElementById("main").style.marginLeft = "0%";
  document.getElementById("mySidebar").style.width = "20%";
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("openNav").style.display = 'none';
}
function w3_close() {
  document.getElementById("main").style.marginLeft = "0%";
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("openNav").style.display = "inline-block";
}
</script>
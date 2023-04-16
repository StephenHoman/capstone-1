 
function size(){
  if (window.innerWidth < 768) {
    document.getElementById("profile").style.width = "75px";
    
  }}

 
  function deleteItem(itemName) {
    if (confirm("Are you sure you want to delete this item?")) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "php_deleteItem.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          alert(xhr.responseText);
        }
      };
      xhr.send("itemName=" + itemName);
    }
  }
 
  
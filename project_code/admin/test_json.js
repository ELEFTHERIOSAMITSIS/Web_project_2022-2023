const fileSelector = document.getElementById("myfile");
const my_div = document.getElementById("option_div");
var file_ready = false;
let jsonData = null;

fileSelector.addEventListener('change', (event) => {
  const fileList = event.target.files;
  console.log(fileList);
  for (const file of fileList) {
    const name = file.name ? file.name : 'NOT SUPPORTED';
    console.log(name);
    const reader = new FileReader();
    reader.addEventListener('load', (event) => {
      const fileContents = event.target.result

      try {
        console.log('1');
        jsonData = JSON.parse(fileContents);
        file_ready = true;
        console.log(jsonData);
      } catch (error) {
        console.log('2');
        console.log(error);
        const paragraph = document.createElement('p'); 
        paragraph.textContent="This is not a JSON file!";
        paragraph.style="font-size=18px;color:red";
        my_div.appendChild(paragraph);
      }
    });
    reader.readAsText(file); 
  }
});


const sub_button=document.getElementById("submit_prod");
var jsonProduct=null;
sub_button.addEventListener('click',function(){
    if(file_ready){
      var products = new XMLHttpRequest();
      products.open("POST", "uploadtodb.php", true);
      products.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
  
      // Convert the jsonData to a JSON string
      const jsonDataString = JSON.stringify(jsonData);
  
      products.send(jsonDataString);
      const paragraph = document.createElement('p'); 
      paragraph.textContent="You have successfully sumbited the products!";
      paragraph.style="font-size=18px;color:blue";
      my_div.appendChild(paragraph);
    }
    else{
        const paragraph = document.createElement('p'); 
        paragraph.textContent="You cannot submit this file!";
        paragraph.style="font-size=18px;color:red";
        my_div.appendChild(paragraph);
    }
});
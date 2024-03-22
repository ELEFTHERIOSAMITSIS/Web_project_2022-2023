const fileSelector2 = document.getElementById("myfile2");
const my_div2 = document.getElementById("option_div");
var file_ready2 = false;
let jsonData2 = null;

fileSelector2.addEventListener('change', (event) => {
  const fileList2 = event.target.files;
  console.log(fileList2);
  for (const file2 of fileList2) {
    const name2 = file2.name ? file2.name : 'NOT SUPPORTED';
    console.log(name2);
    const reader2 = new FileReader();
    reader2.addEventListener('load', (event) => {
      const fileContents2 = event.target.result

      try {
        console.log('1');
        jsonData2 = JSON.parse(fileContents2);
        file_ready2 = true;
        console.log(jsonData2);
      } catch (error) {
        console.log('2');
        const paragraph2 = document.createElement('p'); 
        paragraph2.textContent="This is not a JSON file!";
        paragraph2.style="font-size=18px;color:red";
        my_div2.appendChild(paragraph2);
      }
    });
    reader2.readAsText(file2); 
  }
});


const sub_button2=document.getElementById("submit_prod2");
var jsonProduct2=null;
sub_button2.addEventListener('click',function(){
    if(file_ready2){
      var products2 = new XMLHttpRequest();
      products2.open("POST", "upload_prices.php", true);
      products2.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
  
      const jsonDataString2 = JSON.stringify(jsonData2);
  
      products2.send(jsonDataString2);
      const paragraph2 = document.createElement('p'); 
      paragraph2.textContent="You have successfully sumbited the products!";
      paragraph2.style="font-size=18px;color:blue";
      my_div2.appendChild(paragraph2);
    }
    else{
        const paragraph2 = document.createElement('p'); 
        paragraph2.textContent="You cannot submit this file!";
        paragraph2.style="font-size=18px;color:red";
        my_div2.appendChild(paragraph2);
    }
});
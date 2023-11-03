
let ajax= new XMLHttpRequest();
ajax.open('get','../jsons/products_and_categories.json',true);
ajax.send();
ajax.onload=function(){
    if(this.readyState==4 && this.status==200)
    {
        let data = JSON.parse(this.responseText);
        const select = document.querySelector('#select_pr'); 
        for(let categorie of data.categories){
        let newOption = new Option(categorie.name,categorie.name);
        select.add(newOption,undefined);
        }
        select.addEventListener("change",function()
        {

            const select_sub=document.querySelector('#select_sub');
            while (select_sub.options.length > 0) {
                select_sub.remove(0);
              }              
            const index=select.options[select.selectedIndex].value;
            const selected_categorie=data.categories.find(categories=> categories.name===index);
            for(let subcategorie of selected_categorie.subcategories){
                let newSub= new Option(subcategorie.name,subcategorie.uuid);
                select_sub.add(newSub,undefined);
            }
                       
        });
    }
    else{console.log("Something went wrong!")}
}

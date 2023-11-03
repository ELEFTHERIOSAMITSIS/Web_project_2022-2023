let mymap = L.map('map');
let osmUrl = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
let osmAttrib = 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
let osm = new L.TileLayer(osmUrl, { attribution: osmAttrib });
mymap.addLayer(osm);

mymap.setView([38.246242, 21.7350847], 16);

let position; 


function onMapClick(e) {

    if (position) {
        mymap.removeLayer(position);
    }

      position = L.marker(e.latlng).addTo(mymap);
      position.bindPopup("MY POSITION").openPopup();
      
}

mymap.on('click', onMapClick);
let originalMarkerData = [];
markers = [];
nodeNames=[];
let poiRequest = new XMLHttpRequest();
poiRequest.open('GET', '../uploaded_files/POI.json', true);
poiRequest.send();
poiRequest.onload = function () {
    if (this.readyState === 4 && this.status === 200) {
      let data = JSON.parse(this.responseText);
      for (let element of data.elements) {
        originalMarkerData.push({
          lat: element.lat,
          lon: element.lon,
          id: element.id,
          name: element.tags.name,
          category: element.tags.shop
      });}
      for(let convos of originalMarkerData){
        createMarker(convos);}
      
const Searchname=document.getElementById("Search_name");

nodeNames.forEach(name => {
  let option= new Option(name,name);
  Searchname.add(option,undefined);
});
//////////////////////////////
Searchname.addEventListener("change", function () {
  const selectedName = this.value;
  filterMarkers(selectedName);
});

var offer = new XMLHttpRequest();
offer.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
    var responseData = JSON.parse(offer.responseText);
let filter= new XMLHttpRequest();
const selectOffer=document.getElementById("Search_Category");
filter.open('get','../jsons/products_and_categories.json',true);
filter.send();
filter.onreadystatechange=function(){
  if(this.readyState==4 && this.status==200)
  {
      let data = JSON.parse(this.responseText);
      console.log(data);
      for(let categorie of data.categories){
          let newOption = new Option(categorie.name,categorie.id);
          selectOffer.add(newOption,undefined);
          }
      selectOffer.addEventListener("change",function(){
        const selectedCategory=this.value;
        responseData.forEach(offer_data => {
          console.log(offer_data.Category); 
          if (offer_data.Category == selectedCategory) {
            filterMarkers2(offer_data.Shop_id);
          }
          else if (selectedCategory=='All'){
            showAllMarkers();
          }
      });
        //filterMarkers(selectedCategory);
      });

  }}
}
};

offer.open("GET", "../get_from_db/GetOffer.php", true);
offer.send();
///////////////////////////////
    }
  };

  
  function createMarker(element) {
    let name = element.name || 'Unamed';
    let category = element.shop || 'No Category';
    if (!nodeNames.includes(name)){
      nodeNames.push(name);
    }
    
    let marker = L.marker([element.lat, element.lon]).addTo(mymap);
    marker.bindPopup(`<div class="popup-content">
    <p class="br1">id: ${element.id}</p>
    <p class="br1">Name: ${name}</p>
    <p class="br1">Category: ${category}</p>
    <div class="scrollable-div">
      <ul id="offerslist_${element.id}"></ul>
    </div>
    <button class="node_button">Add Offer!</button>
    <button class="node_button" id="rate">Rate offer</button>
    <button class="node_button" id="remove">Remove Offer</button>
    </div>
    <style>
      .scrollable-div {
        max-height: 80px; /* Set the maximum height for scrolling */
        overflow-y: auto; /* Add scrollbar if content exceeds max height */
      }
      .node_button{
        font-size:16px;
        margin-bottom:5px;
      }
    </style>
    `).openPopup();
  
    marker.element = { id: element.id, shopName: name};
    marker.options.name = name;
   // marker.options.id = id;
    
    markers.push(marker); 
    marker.on('popupopen', function (event) {
        let popup = event.popup;
        let list = popup._contentNode.querySelector(`#offerslist_${element.id}`);
        console.log(element.id);
        // Clear previous list items
        list.innerHTML = '';

        var offer = new XMLHttpRequest();
        offer.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var responseData = JSON.parse(offer.responseText);
                responseData.forEach(offer_data => {
                    if (offer_data.Shop_id == element.id) {
                        const newItem = document.createElement('li');
                        newItem.textContent = offer_data.Product +" - " + offer_data.Price + "€";
                        newItem.style.fontSize="16px";
                        list.appendChild(newItem);
                    }
                });
                let remove = document.getElementById("remove");
                let rating = document.getElementById("rate");
               var distance = position.getLatLng().distanceTo(event.target.getLatLng());
                console.log(distance.toFixed(2));
                remove.addEventListener("click",function(){
                    localStorage.setItem('admin',element.id);
                    window.location.href = "remove_offers.php";
                });
                if (distance<=50){
                  rating.addEventListener("click",function(){
                    localStorage.setItem('offers',element.id);
                     window.location.href = "../add_offers_User/offers.php";
                    });
              
                }
      let popupButton = event.popup._contentNode.querySelector(".node_button");
     
      if (popupButton) {   //1
        popupButton.addEventListener("click", function () {  //2
        
            
            let ajax= new XMLHttpRequest();
            ajax.open('get','../jsons/products_and_categories.json',true);
            ajax.send();
            ajax.onload=function(){
    if(this.readyState==4 && this.status==200)
    {
        let data = JSON.parse(this.responseText);
        if (distance<=50){
        const selector=`<h1 style="font-size:22px; text-align:center;">Pick a product</h1>
        <select class="select_offer" id="offer_cat">
        <option value="">Please choose a category</option>
        </select>
        <select class="select_offer" id="offer_sub">
        <option value="">Please choose a Subcategory</option>
        </select>
        <select class="select_offer" id="offer_prod">
        <option value="">Please choose a Product</option>
        </select>
        <input type="number" id="price" name="price" step="0.1" placeholder="Enter price" required>
        <br>
        <button class="submit_button" id="submit_button">Submit Offer</button>
        <div id="messages"></div>`;
        
        const myDiv = document.getElementById("close");
        myDiv.innerHTML=selector;
        const frame=document.getElementById("messages");
        const select= document.getElementById("offer_cat");
        const select_sub=document.getElementById("offer_sub");
        const select_prod=document.getElementById("offer_prod");
        for(let categorie of data.categories){
        let newOption = new Option(categorie.name,categorie.id);
        select.add(newOption,undefined);
        }
        select.addEventListener("change",function()
        {
            for (let i = select_sub.options.length - 1; i >= 1; i--) {
                select_sub.remove(i);
                select_prod.remove(i);
              }          
             id=select.options[select.selectedIndex].value;
            const selected_categorie=data.categories.find(categories=> categories.id===id);
            for(let subcategorie of selected_categorie.subcategories){
                let newSub= new Option(subcategorie.name,subcategorie.uuid);
                select_sub.add(newSub,undefined);
            }
        });
        select_sub.addEventListener("change",function(){
            
            for (let i = select_prod.options.length - 1; i >= 1; i--) {
                select_prod.remove(i);
              }
              var product = new XMLHttpRequest();
              product.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                const sub_id=select_sub.options[select_sub.selectedIndex].value;
                //console.log(id);
                //console.log(sub_id);   
                var prods = JSON.parse(this.responseText);
                console.log(prods); 
                 for(let products of prods){
                     if(products.Category===id && products.SubCategory===sub_id){
                     let newprod= new Option(products.Product_name,products.Product_name);
                     select_prod.add(newprod,undefined);
                     length=select_prod.options.length;
                    }
                    //console.log(length);
                     
                 }
                const offer_data= new FormData();
                const shop=event.target.element.id;
                const shopName = event.target.element.shopName; 
                const price= document.getElementById("price");
                priceF=parseFloat(price.value,10);
                const submit=document.getElementById("submit_button");
                submit.addEventListener("click",function(){
                 offer_data.append('id',id);
                 offer_data.append('sub_id',sub_id);
                 offer_data.append('price',parseFloat(price.value));
                 offer_data.append('shop',shop);
                 offer_data.append("shop_name", shopName);
                 offer_data.append('prod_name',select_prod.options[select_prod.selectedIndex].value);
                 console.log(offer_data); 
                 const send = new XMLHttpRequest();
                 send.open("POST","../get_from_db/post_offer.php",true);
                 send.onload=function(){
                  if(this.readyState==4 && this.status==200)
                  {
                    const paragraph1 = document.createElement('p'); 
                    frame.innerHTML = '';
                    paragraph1.textContent="  "+this.responseText.replace(/"/g, '');
                    paragraph1.style="font-size:20px;color:blue;marginTop:10px;margin-Left:10px";
                    frame.appendChild(paragraph1);   
                    
                  }
                }
                send.send(offer_data);
              
              
                });
            }
        };
            product.open("GET", "../get_from_db/retrieve_products.php", true);
            product.send();            
            
        });               
        }
      else{
        const myDiv = document.getElementById("close");
        const paragraph = document.createElement('p'); 
        paragraph.textContent="Get closer to the store!";
        paragraph.style.fontSize = "30px";
        paragraph.style.color = "red"; 
        paragraph.style.textAlign="center";
        paragraph.style.marginTop = "30px"; 
        myDiv.appendChild(paragraph);
      }} //4 το 2ο
    else{console.log("Something went wrong!")}
}//3
           

        });//2 το πρωτο
        
      }//1
    }
  };

  offer.open("GET", "../get_from_db/GetOffer.php", true);
  offer.send();
    });
 
  }

  function filterMarkers(selectedName) {
    if (selectedName === "All"){
      showAllMarkers();
      console.log("hi");
      return;
    }
    for (let marker of markers) {
        const markerName = marker.options.name;
       
        if ( markerName === selectedName) {
            if (!mymap.hasLayer(marker)) {
                mymap.addLayer(marker); 
            }
        } else {
            if (mymap.hasLayer(marker)) {
                mymap.removeLayer(marker); 
            }
        }
    }}

    function filterMarkers2(shop_id) {
    
      for (let marker of markers) {
          const markerName2 = marker.element.id;
          //console.log(markerName);
          if ( markerName2 == shop_id) {
              if (!mymap.hasLayer(marker)) {
                  mymap.addLayer(marker); 
              }
          } else {
              if (mymap.hasLayer(marker)) {
                  mymap.removeLayer(marker); 
              }
          }
      }}
  



    function showAllMarkers() {
      //markers=[];
      for (let marker of markers) {
          mymap.removeLayer(marker);
      }
      

      for (let markerData of originalMarkerData) {
          createMarker(markerData);}
    
  }
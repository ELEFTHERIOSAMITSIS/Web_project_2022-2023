let mymap = L.map('map');
let osmUrl='https://tile.openstreetmap.org/{z}/{x}/{y}.png';
let osmAttrib='Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
let osm = new L.TileLayer(osmUrl, {attribution: osmAttrib});
mymap.addLayer(osm);
mymap.setView([38.246242, 21.7350847], 16);

let poiRequest = new XMLHttpRequest();
poiRequest.open('GET', '../uploaded_files/POI.json', true);
poiRequest.send();
poiRequest.onload = function() {
  if (this.readyState === 4 && this.status === 200) {
    let data = JSON.parse(this.responseText);
    for (let element of data.elements) {
      let name = element.tags.name || 'No Name'; 
      let category = element.tags.shop || 'No Category'; 

      let marker = L.marker([element.lat, element.lon]).addTo(mymap);
      marker.bindPopup(`<b>${name}</b><br>Category: ${category}`).openPopup();
    }
  }
};



document.getElementById("delete_button").addEventListener("click",function(){
var del= new XMLHttpRequest();
del.open("GET", "delete.php", true);
del.send();
});


document.getElementById("add_tokens").addEventListener("click", function () {
 
  var tok = new XMLHttpRequest(); //Πάει στο tokens.php για να τα βάλει στην βάση
  tok.open("GET", "../get_from_db/tokens.php", true);
  
  tok.onload = function () {
      if (tok.readyState === 4 && tok.status === 200) {
          var response = tok.responseText;
          console.log(response); 
      }
  };
  
  tok.send();
});


const sharedData = localStorage.getItem('admin');
var list_frame=document.getElementById("offer_bframe");
var offeradmin = new XMLHttpRequest();
offeradmin.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
        console.log(sharedData);
        var offers=JSON.parse(this.responseText);
        offers.forEach(element => {
            if (element.Shop_id == sharedData) {
                const container = document.createElement('div');
                const label = document.createElement('label');
                const button = document.createElement('button');
                button.textContent="Remove Offer";
                button.style.marginRight= "10px";
                button.style.marginLeft= "20px";
                button.style.width="200px";
                button.style.height="30px";
                button.style.fontSize="16px";
                button.style.paddingTop="5px";
                label.textContent = element.Product +" - " + element.Price + "€";
                label.style.fontSize="16px";
                label.style.marginBottom= "10px";
                label.style.marginRight= "20px";
                label.style.display = "block";
                container.appendChild(label);
                container.appendChild(button);
                container.style.display = "flex";
                container.style.alignItems = "center";

                list_frame.appendChild(container); 
                const sender=new FormData();
                const line = document.createElement('br');
                list_frame.appendChild(line);
                button.addEventListener('click',function(){
                    if (confirm("Are you sure you want to delete this offer?")) {
                        var offeradmin = new XMLHttpRequest();
                        offeradmin.onreadystatechange = function() {
                            if (this.readyState === 4 && this.status === 200) {
                                console.log(this.responseText);
                            }
                        };
                        offeradmin.open("POST", "../get_from_db/delete_offers_fromDB.php", true);
                        sender.append("id", element.offer_id);
                        offeradmin.send(sender);
                    }
                })
            }
        });
    }}
    offeradmin.open("GET", "../get_from_db/GetOffer.php", true);
    offeradmin.send();
const sharedData = localStorage.getItem('offers');
console.log(sharedData);
var listclicker=document.getElementById("products_scroll");
var offer = new XMLHttpRequest();
offer.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
        var responseData = JSON.parse(offer.responseText);
        console.log(responseData);
        responseData.forEach(offer_data => {
            if (offer_data.Shop_id == sharedData) {
                var clicked=false;
                var dld = "";
                console.log(offer_data.person_id);
                const container = document.createElement('div');
                const label = document.createElement('label');
                const like=document.createElement('button');
                const dislike=document.createElement('button');
                const like_count=document.createElement('p');
                const dislike_count=document.createElement('p');
                const valiable=document.createElement('button');
                const unvaliable=document.createElement('button');
                const or=document.createElement('p');
                const spaner=document.createElement('button');
                var spaner_var=1;
                spaner.textContent="+";
                spaner.style.height="20px";     
                spaner.style.marginRight="5px";
                or.textContent='or';
                or.style.fontSize='20px';
                unvaliable.textContent='Unvaliable';
                unvaliable.style.marginRight= "10px";
                unvaliable.style.marginLeft= "10px";
                unvaliable.style.width="100px";
                unvaliable.style.height="30px";
                unvaliable.style.fontSize="16px";
                unvaliable.style.paddingTop="5px";
                valiable.textContent='Valiable';
                valiable.style.marginRight= "10px";
                valiable.style.marginLeft= "300px";
                valiable.style.width="100px";
                valiable.style.height="30px";
                valiable.style.fontSize="16px";
                valiable.style.paddingTop="5px";
                label.textContent = offer_data.Product +" - " + offer_data.Price + "€";
                label.style.fontSize="16px";
                label.style.marginBottom= "10px";
                label.style.marginRight= "20px";
                label.style.display = "block"; 
                like.textContent='LIKE';
                like.style.marginRight= "10px";
                like.style.marginLeft= "20px";
                like.style.width="100px";
                like.style.height="30px";
                like.style.fontSize="16px";
                like.style.paddingTop="5px";
                dislike.textContent='DISLIKE';
                dislike.style.marginRight= "10px";
                dislike.style.width="100px";
                dislike.style.height="30px";
                dislike.style.fontSize="16px";
                dislike.style.paddingTop="5px";
                like_count.style.marginRight="10px";
                like.appendChild(like_count);
                dislike.appendChild(dislike_count);
               // const likeCounter = { countlikes: 0, countdislikes: 0 };
                like_count.textContent = "Likes: " + offer_data.Likes;
                dislike_count.textContent= "Dislikes: " + offer_data.Dislikes;
                container.appendChild(spaner);
                container.appendChild(label);
                container.appendChild(like);
                container.appendChild(like_count);

                container.appendChild(dislike);
                container.appendChild(dislike_count);
                container.appendChild(valiable);
                container.appendChild(or);
                container.appendChild(unvaliable);
                const info_div = document.createElement('div');
                var ldl = new XMLHttpRequest();
            ldl.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var check=JSON.parse(this.responseText);
                console.log(check);
                console.log(offer_data);  
                check.forEach(offerlike=>{ 
                if(offerlike.offer_id==offer_data.offer_id){
                    console.log(offerlike);
                    if(offerlike.Click1=='dislike'){
                    console.log('hi');
                    dislike.disabled=true;
                    dislike.border="1px solid blue";
                    dislike.color="blue";
                    dld="dislike";
                     }
                else if(offerlike.Click1=='like'){
                    like.disabled=true;
                    like.border="1px solid blue";
                    like.color="blue";
                    dld="like";
                }
                }

            })
        }}
        ldl.open("GET", "../get_from_db/get_ldl.php", true);
        ldl.send();
            

                var score=offer_data.Score;
                spaner.addEventListener('click', function () {
                    if (spaner_var == 1 ) {
                        if(score==null){
                             score= "Unscored"
                        }                 
                        info_content=`Offer by: ${offer_data.First_name} ${offer_data.Last_name}<br>Score: ${score}`;
                        info_div.innerHTML=info_content;
                        info_div.style.marginLeft = "10px";
                        container.insertAdjacentElement('afterend', info_div);
                        spaner_var=0;
            
                    }
                    else{
                        info_div.remove();
                        spaner_var=1;
                    }
                });
                
                if(offer_data.Apothema==0){
                    like.disabled=true;
                    dislike.disabled=true;
                    valiable.addEventListener('click',function(){
                        offer_data.Apothema=1;
                        if(dld=='like'){
                            dislike.disabled=false;
                        }
                        else{
                        like.disabled=false;}
                        let ilike = new XMLHttpRequest();
                        ilike.open("POST", "../get_from_db/add_ldl.php", true);
                        let rating = new FormData();
                        rating.append('shop', offer_data.Shop_id);
                        rating.append('product', offer_data.Product);
                        rating.append('likes', offer_data.Likes);
                        rating.append('dislikes', offer_data.Dislikes);
                        rating.append('apothema', offer_data.Apothema);
                        rating.append('offer_id', offer_data.offer_id);
                        rating.append('user', offer_data.Pusername);
                        rating.append('Click1',dld);
                        ilike.onload = function() {
                            if (this.readyState === 4 && this.status === 200) {
                                console.log(this.responseText);
                            }
                        };
                        ilike.send(rating);
                    })
                    
                }
                else{
                unvaliable.addEventListener('click',function(){
                    offer_data.Apothema=0;
                    like.disabled=true;
                    dislike.disabled=true;
                    let ilike = new XMLHttpRequest();
                        ilike.open("POST", "../get_from_db/add_ldl.php", true);
                        let rating = new FormData();
                        rating.append('shop', offer_data.Shop_id);
                        rating.append('product', offer_data.Product);
                        rating.append('likes', offer_data.Likes);
                        rating.append('dislikes', offer_data.Dislikes);
                        rating.append('apothema', offer_data.Apothema);
                        rating.append('offer_id', offer_data.offer_id);
                        rating.append('user', offer_data.Pusername);
                        rating.append('Click1',dld);
                        console.log('hi');
                        ilike.onload = function() {
                            if (this.readyState === 4 && this.status === 200) {
                                console.log(this.responseText);
                            }
                        };
                        ilike.send(rating);
                    })
                    
                like.addEventListener('click', function() {
                    
                    if(dld=="dislike"){
                        offer_data.Dislikes--;
                        like.disabled=true;
                        dislike.disabled=false;
                    }
                    if (!clicked) {
                        console.log(!clicked);
                        offer_data.Likes++;
                        updateCounterDisplay(like_count, offer_data.Likes);
                        clicked = true;
                        let ilike = new XMLHttpRequest();
                        ilike.open("POST", "../get_from_db/add_ldl.php", true);

                        let rating = new FormData();
                        rating.append('shop', offer_data.Shop_id);
                        rating.append('product', offer_data.Product);
                        rating.append('likes', offer_data.Likes);
                        rating.append('dislikes', offer_data.Dislikes);
                        rating.append('apothema',offer_data.Apothema);
                        rating.append('offer_id', offer_data.offer_id);
                        rating.append('user', offer_data.Pusername);
                        rating.append('Click1', 'like');
 
                        ilike.onload = function() {
                            if (this.readyState === 4 && this.status === 200) {
                                console.log(this.responseText);
                            }
                        };
                        ilike.send(rating);
                    }
                });

                dislike.addEventListener('click', function() {
                    if(dld=="like"){
                        offer_data.Likes--;
                        dislike.disabled=true;
                        like.disabled=false;
                    }
                    if(!clicked){
                    console.log(!clicked);
                    offer_data.Dislikes++;
                    updateCounterDisplay(dislike_count, offer_data.Dislikes);
                    clicked=true;

                    let ilike = new XMLHttpRequest();
                    ilike.open("POST", "../get_from_db/add_ldl.php", true);
                    
                        let rating = new FormData();
                        rating.append('shop', offer_data.Shop_id);
                        rating.append('product', offer_data.Product);
                        rating.append('likes', offer_data.Likes);
                        rating.append('dislikes', offer_data.Dislikes);
                        rating.append('apothema',offer_data.Apothema);
                        rating.append('offer_id', offer_data.offer_id);
                        rating.append('Click1', 'dislike');
                        rating.append('user', offer_data.Pusername);

                        ilike.onload = function() {
                            if (this.readyState === 4 && this.status === 200) {
                                console.log(this.responseText);
                            }
                        };
                        ilike.send(rating);
                }
                }); 
            }
               
                container.style.display = "flex";
                container.style.alignItems = "center";

                listclicker.appendChild(container); 
                const line = document.createElement('br');
                listclicker.appendChild(line);
            
          
            }
        });

    }
};


function updateCounterDisplay(element, count) {
    element.textContent = "Likes: " + count;
}



offer.open("GET", "../get_from_db/GetOffer.php", true);
offer.send();

var timeoutDuration = 600000; //10 minutes
var timeout = setTimeout(function() {
    window.location.href = "../login_register/log_in.php";
}, timeoutDuration);

window.addEventListener('mousemove', resetTimer);
window.addEventListener('click', resetTimer);

function resetTimer() {
    clearTimeout(timeout);
    timeout = setTimeout(function() {
        window.location.href = "../login_register/log_in.php";
    }, timeoutDuration);
}
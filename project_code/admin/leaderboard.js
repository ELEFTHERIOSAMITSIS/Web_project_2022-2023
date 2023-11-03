const frame=document.getElementById("leaderboard");
const itemList = document.getElementById("itemList");
var GetUsers = new XMLHttpRequest();
GetUsers.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
        var User = JSON.parse(this.responseText);
        User.forEach(user_data => {
            const li = document.createElement("li");
            const text=document.createElement("p");
            text.innerText=`${user_data.Username}     Score:${user_data.score}, Tokens: ${user_data.tokens}, Total Tokens: ${user_data.total_tokens}`;
            text.style.fontSize= "18px";
            li.appendChild(text);   
            itemList.appendChild(li);
        })
    }
}
GetUsers.open("GET", "../get_from_db/GetUsers.php", true);
GetUsers.send();
let searchinput = document.getElementById('search123');
let result_div = document.getElementById('search_div');
let iduser = document.getElementById('idclient');

document.getElementById('searchbtn123').addEventListener('click', () => {
    fetch('http://localhost/edutrack/api.php',{
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            action: 'search',
            id: iduser.value,
            search_content : searchinput.value,
        })
    })
    
    .then(res => res.json())
    .then(res => {
        console.log(searchinput.value);
        console.log(res);
        searchresultat(res.data1, res.data2, res.data3);
    })
});


function searchresultat(data1, data2, data3) {
    result_div.style.display = 'flex';
    let divsearches = document.createElement('ul');
    divsearches.innerHTML = ""; 
    if(data1.length !== 0 || data2.length !== 0 || data3.length !== 0){
        data1.forEach(result => {
            divsearches.innerHTML += `<li class="searchlist"><a class="searchline" href="courscree.php#cours_${result.id_cours}"><span>${result.nom_cours}<sup><small>Cours</small></sup></span><span>${result.date_post}</span></a></li>`;
        });
        result_div.innerHTML = "";
        result_div.appendChild(divsearches);
        divsearches.classList.add('searchcontainer');
        
        data2.forEach(result2 => {
            divsearches.innerHTML += `<li class="searchlist"><a class="searchline2" href="outils/cartes.php#cours_${result2.id_carte}"><span>${result2.question}<sup><small>Carte</small></sup></span><span>${result2.date}</span></a></li>`;
        });
        result_div.innerHTML = "";
        result_div.appendChild(divsearches);
        divsearches.classList.add('searchcontainer');

        data3.forEach(result3 => {
            divsearches.innerHTML += `<li class="searchlist"><a class="searchline3" href="taches.php#cours_${result3.id_tache}"><span>${result3.tache}<sup><small>Tache</small></sup></span><span>${result3.date}</span></a></li>`;
        });
        result_div.innerHTML = "";
        result_div.appendChild(divsearches);
        divsearches.classList.add('searchcontainer');
    }
    else{
        result_div.innerHTML = "";
        divsearches.innerHTML = '<li class="searchlist"><a class="searchline" >Aucune cours</a></p></li>';
        result_div.appendChild(divsearches);
        divsearches.classList.add('searchcontainer');
    }
}
    document.addEventListener('click', (event) => {
            if(result_div.style.display !== 'none' && !result_div.contains(event.target)){
                result_div.style.display = 'none';
            }
        }
    );
window.onload = function() {
  if (location.hash) {
    const target = document.querySelector(location.hash);
    if (target) {
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
  }
};


    let delete_container = document.querySelector("#delete_notif");
    console.log(delete_container.style.display);
    document.querySelector(".delete_notif_button_cancel").addEventListener("click", () => {
        if(delete_container.style.display !== "none"){
            delete_container.style.display = "none";
            console.log(delete_container.style.display);
        }
    });
    document.querySelector("#cancel_delete_container").addEventListener("click", () => {
        if(delete_container.style.display !== "none"){
            delete_container.style.display = "none";
            console.log(delete_container.style.display);
        }
    });
    document.querySelector(".btn_delete_acc").addEventListener("click", () => {
        if(delete_container.style.display !== "flex"){
            delete_container.style.display = "flex";
            console.log(delete_container.style.display);
        }
    });
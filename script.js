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
        console.log(res.data)
        searchresultat(res.data)
    })
});


function searchresultat(data) {
    result_div.style.display = 'flex';
    let divsearches = document.createElement('ul');
    divsearches.innerHTML = ""; 
    if(data.length !== 0){
        data.forEach(result => {
            divsearches.innerHTML += `<li class="searchlist"><a class="searchline" href="courscree.php#cours_${result.id_cours}"><span>${result.nom_cours}</span><span>${result.date_post}</span></a></li>`;
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


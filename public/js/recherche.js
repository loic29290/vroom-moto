//Ajax

document.addEventListener('DOMContentLoaded', () => {

    let motoList = document.querySelector('.moto-list');
    let form = document.getElementById('searchForm');
    let categorieSelect = document.getElementById('categorieRecherche');
    let bridageSelect = document.getElementById('bridageRecherche');

    let updateMotoList = () => {
        let formData = new FormData(form);
        
        fetch('index.php?page=searchAction', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la requête AJAX');
            }
            return response.text();
        })
        .then(data => {
                motoList.innerHTML = data;
        })
        .catch(error => {
            console.error('Erreur réseau lors de la requête AJAX', error);
        });
    };

    categorieSelect.addEventListener('change', updateMotoList);

    bridageSelect.addEventListener('change', updateMotoList);
    
    form.addEventListener('reset', updateMotoList);
});

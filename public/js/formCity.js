function city() {
    zipCodeInput = document.getElementById('zipCode');
    cityInput = document.getElementById('cityName');

    // Vide le select et empêche l'utilisateur d'accéder à son contenu tant qu'il n'a pas remplit le champ "code postal"
    if(zipCodeInput.value.length < 5) {
        hideCity = cityInput.setAttribute('readonly', true);

        // Vide le select en créant un select vide
        selectParentNode = cityInput.parentNode;
        newSelectObj = cityInput.cloneNode(false);
        selectParentNode.replaceChild(newSelectObj, cityInput);
    }

    // quand l'utilisateur a remplit le champ "code postal", execute la requête ajax et récupère les villes liées au code postal
    if(zipCodeInput.value.length == 5) {

        cityArr = [];
        ajaxGet("https://geo.api.gouv.fr/communes?codePostal="+zipCodeInput.value+"", function (reponse) {
            var city = JSON.parse(reponse);

            city.forEach(function(cityName){
                cityArr.push(cityName.nom);
            });

            if(cityInput.length == 0) {
                if(cityArr.length != 0) {
                    for (var i =0; i < cityArr.length; i++) {
                        opt = cityArr[i];
                        el = document.createElement("option");
                        el.textContent = opt;
                        el.value = opt;
                        cityInput.appendChild(el);
                    }
                    showCity = cityInput.removeAttribute('readonly');
                }
                else {
                    el = document.createElement("option");
                    el.textContent = 'Votre code postal n\'est pas correct !';
                    el.value = 'Votre code postal n\'est pas correct !';
                    cityInput.appendChild(el);
                }
            }
        });
    }
}



// Verification et modification de la valeur du nombre de ticket saisis automatique si necessaire
function verification() {
    $result = document.getElementById('result');
    $goal = document.getElementById('ticketsToGoal');
    console.log($goal.innerHTML);
    // Modifie la valeur des inputs si l'utilisateur saisit une valeur supérieur à son nombre de ticket
    if (parseInt($result.value) >= $result.max) {
        $result.value = $result.max;
    }
    // Modifie la valeur des inputs si l'utilisateur saisit une valeur supérieur au nombre de ticket requis pour le lot
    if(parseInt($result.value) >= $goal.innerHTML) {
        $result.value = $goal.innerHTML;
    }
}
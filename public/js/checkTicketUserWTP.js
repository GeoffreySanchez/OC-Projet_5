// Verification et modification de la valeur du nombre de ticket saisis automatique si necessaire
function verification() {
    $result = document.getElementById('result');
    $goal = document.getElementById('ticketsToGoal');
    $range = document.getElementById('rangeValue');

    // Modifie la valeur de l'input result avec la valeur du range max si on dépasse sa valeur
    if (parseInt($result.value) >= $range.max) {
        $result.value = $range.max;
    }
    // Modifie la valeur des inputs si l'utilisateur saisit une valeur supérieur au nombre de ticket requis pour le lot
    if (parseInt($result.value) >= $goal.innerHTML) {
        $result.value = $goal.innerHTML;
    }
    // Modifie le range max pour ne pas dépasser la limite du lot
    if(parseInt($range.value) >= $goal.innerHTML) {
        $range.max = $goal.innerHTML;
    }
    // Modifie le range max à 1000 si nombre de ticket necessaires sont supérieur à 1000
    if ($range.max >= 1000) {
        $range.max = 1000;
    }
}
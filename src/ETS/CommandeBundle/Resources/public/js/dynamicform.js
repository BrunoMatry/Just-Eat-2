// Récupère le div qui contient la collection de selections
var collectionHolder = $('ul.selection');

// ajoute un lien « Ajouter un selection »
var $addSelectionLink = $('<a href="#" class="add_selection_link">Ajouter une selection</a>');
var $newLinkLi = $('<li></li>').append($addSelectionLink);

$(document).ready(function() {
    // ajoute un lien de suppression à tous les éléments li de
    // formulaires de selections existants
    collectionHolder.find('li').each(function() {
        addSelectionFormDeleteLink($(this));
    });

    // ajoute l'ancre « ajouter un selection » et li à la balise ul
    collectionHolder.append($newLinkLi);

    $addSelectionLink.on('click', function(e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // ajoute un nouveau formulaire selection
        addSelectionForm(collectionHolder, $newLinkLi);
    });     
});

function addSelectionForm(collectionHolder, $newLinkLi) {
    // Récupère l'élément ayant l'attribut data-prototype comme expliqué plus tôt
    var prototype = collectionHolder.attr('data-prototype');

    // Remplace '__name__' dans le HTML du prototype par un nombre basé sur
    // la longueur de la collection courante
    var newForm = prototype.replace(/__name__/g, collectionHolder.children().length);

    // Affiche le formulaire dans la page dans un li, avant le lien "ajouter un selection"
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    
    // ajoute un lien de suppression au nouveau formulaire
    addSelectionFormDeleteLink($newFormLi);
}    

function addSelectionFormDeleteLink($selectionFormLi) {
    var $removeFormA = $('<a href="#">Supprimer cette selection</a>');
    $selectionFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // supprime l'élément li pour le formulaire de selection
        $selectionFormLi.remove();
    });
}
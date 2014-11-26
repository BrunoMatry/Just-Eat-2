// Récupère le div qui contient la collection de plats
var collectionHolder = $('ul.plats');

// ajoute un lien « Ajouter un plat »
var $addPlatLink = $('<a href="#" class="add_plat_link">Ajouter un plat</a>');
var $newLinkLi = $('<li></li>').append($addPlatLink);

$(document).ready(function() {
    // ajoute un lien de suppression à tous les éléments li de
    // formulaires de plats existants
    collectionHolder.find('li').each(function() {
        addPlatFormDeleteLink($(this));
    });

    // ajoute l'ancre « ajouter un plat » et li à la balise ul
    collectionHolder.append($newLinkLi);

    $addPlatLink.on('click', function(e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // ajoute un nouveau formulaire plat
        addPlatForm(collectionHolder, $newLinkLi);
    });     
});

function addPlatForm(collectionHolder, $newLinkLi) {
    // Récupère l'élément ayant l'attribut data-prototype comme expliqué plus tôt
    var prototype = collectionHolder.attr('data-prototype');

    // Remplace '__name__' dans le HTML du prototype par un nombre basé sur
    // la longueur de la collection courante
    var newForm = prototype.replace(/__name__/g, collectionHolder.children().length);

    // Affiche le formulaire dans la page dans un li, avant le lien "ajouter un plat"
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    
    // ajoute un lien de suppression au nouveau formulaire
    addPlatFormDeleteLink($newFormLi);
}    

function addPlatFormDeleteLink($platFormLi) {
    var $removeFormA = $('<a href="#">Supprimer ce plat</a>');
    $platFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // supprime l'élément li pour le formulaire de plat
        $platFormLi.remove();
    });
}
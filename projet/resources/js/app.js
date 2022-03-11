require("./bootstrap");
// require("./functions");

import * as F from "./functions";

feather.replace({ "aria-hidden": "true" });

$(function () {
    $(".input-valeur").keyup(function () {
        const valeur = getSlug($(".input-valeur").val());
        $("#input-slug").val(valeur);
    });

    function initialTabCaisse () {
        if ($('#resultat-affichage').val()) {
            $('#resultat-tab').html(`${$('#resultat-affichage').val()} €`)
        }
    }

    initialTabCaisse()

    console.log('ready');

    /** DatePicker */
    /*$('[data-toggle="datepicker"]').datepicker({
        language: "fr-FR",
        format: "dd-mm-yyyy",
    });*/

    const picker = datepicker('[data-toggle="datepicker"]', {
        format: 'dd/mm/yyyy',
        startDay: 1,
        onShow: instance => {
            console.log('Calendar showing.', instance)
        },
        // Event callbacks.
        onSelect: (instance) => {
            // Show which date was selected.
            console.log('onSelect', instance.dateSelected);
        },
        // Customizations.
        formatter: (input, date, instance) => {
            // This will display the date as `1/1/2019`.
            // console.log(date, F.formatDate(new Date(date)))

            // input.value = date.toDateString();
            input.value = F.formatDate(new Date(date));
        },
        customDays: ["D", "L", "M", "M", "J", "V", "S"],
        customMonths: [
            "Jan",
            "Fev",
            "Mar",
            "Apr",
            "Mai",
            "Jun",
            "Jul",
            "Aout",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
        ],
    });

    /** Billets */
    function billet() {
        const $elementsNominal = $(".nominal-billet");
        const $elementsQuantite = $(".quantite-billet");

        const somme = F.calcul($elementsNominal, $elementsQuantite);

        F.updateTotal($("#billet"), somme);

        F.updatePrincipal();
    }

    $("#btn-ajout-billet").click(function (e) {
        e.preventDefault();

        const $element = $(".clone-billets");
        const $end = $("#billet-end");

        F.addElement($element, $end, "billet");
    });

    $("body").on("click", ".btn-delete-billet", function () {
        F.removeElement(this);
        billet();
    });

    $("body").on("change", ".input-billet", function () {
        billet();
    });

    /** Pieces */
    function piece() {
        const $elementsNominal = $(".nominal-piece");
        const $elementsQuantite = $(".quantite-piece");

        const somme = F.calcul($elementsNominal, $elementsQuantite);

        F.updateTotal($("#piece"), somme);

        F.updatePrincipal();
    }

    $("#btn-ajout-piece").click(function (e) {
        e.preventDefault();

        const $element = $(".clone-pieces");
        const $end = $("#piece-end");

        F.addElement($element, $end, "piece");

        F.updateTotal($("#piece"), 100);
    });

    $("body").on("click", ".btn-delete-piece", function () {
        F.removeElement(this);
        piece();
    });

    $("body").on("change", ".input-piece", function () {
        piece();
    });

    /** Centimes */
    function centime() {
        const $elementsNominal = $(".nominal-centime");
        const $elementsQuantite = $(".quantite-centime");

        const somme = F.calcul($elementsNominal, $elementsQuantite);

        F.updateTotal($("#centime"), somme);

        F.updatePrincipal();
    }

    $("#btn-ajout-centime").click(function (e) {
        e.preventDefault();

        const $element = $(".clone-centimes");
        const $end = $("#centime-end");

        F.addElement($element, $end, "centiment");

        F.updateTotal($("#centiment"), 110);
    });

    $("body").on("click", ".btn-delete-centime", function () {
        F.removeElement(this);
        centime();
    });

    $("body").on("change", ".input-centime", function () {
        centime();
    });

    /** Formulaire */
    $("#form-caisse").submit(async function (event) {
        event.preventDefault();

        let data = new FormData(this);
        let method = 'POST'

        data.append('ajax', true)

        if ($('[name="_method"]').val() === 'PUT') {
            method = 'PUT'
        }

        console.log("entries");
        for (var pair of data.entries()) {
            console.log(`Key: ${pair[0]} === Value: ${pair[1]}`);
        }


        let url = $(this).attr('action')

        console.log(
            'URL', 
            url, 
            $('[name="_method"]').val(),
            $('[name="_method"]').val() ? 'PUT' : 'POST',
            method
        )

        try {
            let response = await fetch(
              url, {
              method: method,
              headers: {
                'X-Requested-With': 'xmlhttprequest',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              body: data
            })
            let responseData = await response.json()
            // La réponse n'est pas bonne (pas 200), on affiche les erreurs
            if (response.ok === false) {
              console.log('error', responseData)

              F.alert('alert-danger', responseData);
            // La réponse est ok, on vide le formulaire
            } else {
                console.log('success', responseData)

                F.alert('alert-success', 'Enregistrement success');
            }
          } catch (e) {
            console.log('error', e)

            F.alert('alert-danger', e);
          }
    });
});

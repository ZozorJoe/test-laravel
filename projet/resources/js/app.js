require("./bootstrap");
// require("./functions");

import * as F from "./functions";

feather.replace({ "aria-hidden": "true" });

$(function () {
    $(".input-valeur").keyup(function () {
        const valeur = getSlug($(".input-valeur").val());
        $("#input-slug").val(valeur);
    });

    /** DatePicker */
    /*$('[data-toggle="datepicker"]').datepicker({
        language: "fr-FR",
        format: "dd-mm-yyyy",
    });*/

    const picker = datepicker('[data-toggle="datepicker"]', {
        startDay: 1,
        // Event callbacks.
        onSelect: (instance) => {
            // Show which date was selected.
            // console.log(instance.dateSelected);
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
    $("#form-caisse").submit(function (event) {
        event.preventDefault();

        let data = new FormData(this);

        console.log("submit", data.toString());

        console.log("entries");
        for (var pair of data.entries()) {
            console.log(`Key: ${pair[0]} === Value: ${pair[1]}`);
        }
    });
});

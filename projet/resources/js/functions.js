/** Format date */
function padTo2Digits(num) {
    return num.toString().padStart(2, "0");
}

export function formatDate(date) {
    return [
        padTo2Digits(date.getDate()),
        padTo2Digits(date.getMonth() + 1),
        date.getFullYear(),
    ].join("/");
}

export function addElement($element = null, $end = null, value = "") {
    let html = $element.html();

    const id = `id-${Date.now()}`;

    switch (value) {
        case "billet":
            html = html.replace("billets_nominal_id_clone", id);
            break;
        case "piece":
            html = html.replace("pieces_nominal_id_clone", id);
            break;
        case "centiment":
            html = html.replace("centimes_nominal_id_clone", id);
            break;
    }

    html = html.replace("d-none", " ");
    html = html.replace("clone-billets", "");
    html = html.replace(/clone/gi, "");

    $end.before(`<div class="row mt-1 ${id}">${html}</div>`);
}

export function removeElement($parent) {
    // const data_1 = $(this).attr("data-id")
    const data = $($parent).data("id");

    $($parent).parents(`.${data}`).remove();
}

export function updateTotal($element, value) {
    $element.html(`${value} €`);
}

export function updatePrincipal() {
    let billet = Number($("#billet").text().split(" ")[0]);
    let piece = Number($("#piece").text().split(" ")[0]);
    let centime = Number($("#centime").text().split(" ")[0]);

    $("#caisse").html(`${billet + piece + centime} €`);
}

export function calcul($elementsNominal, $elementsQuantite) {
    let tabNominalValues = [];
    let tabQuantiteValues = [];

    $elementsNominal.each(function () {
        if (!$(this).hasClass("clone")) {
            tabNominalValues = [...tabNominalValues, Number($(this).val())];
        }
    });

    $elementsQuantite.each(function () {
        if (!$(this).hasClass("clone")) {
            tabQuantiteValues = [...tabQuantiteValues, Number($(this).val())];
        }
    });

    let somme = null;

    for (const [index, value] of tabNominalValues.entries()) {
        somme += Number(value) * Number(tabQuantiteValues[index]);
    }

    return somme;
}

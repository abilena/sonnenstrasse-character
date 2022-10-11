
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Partys
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

var isLoading = false;
var isEditing = false;
var isCreating = false;

function getSelectedParty(doShowPartyDetails) {

    var partySelector = document.getElementById("rp-character-admin-select-party");
    if (partySelector.selectedIndex < 0)
        return;

    var selectedParty = partySelector.options[partySelector.selectedIndex];

    document.getElementById("rp-character-admin-table-party-add-shading").style.display = "block";
    isLoading = true;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (doShowPartyDetails) {
                var party = JSON.parse(this.responseText);
                setParty(party);
                showPartyDetails(false);
            }
            else {
                var params = (new URL(document.location)).searchParams;
                var page = params.get("page");
                reloadScroll("page=" + page + "&party_id=" + selectedParty.value);
            }
        }
    };
    xhttp.open("GET", "../wp-content/plugins/sonnenstrasse-character/get-party.php?id=" + selectedParty.value, true);
    xhttp.send();
}

function getSelectedHero() {

    var heroSelector = document.getElementById("rp-character-admin-select-hero");
    if (heroSelector.selectedIndex < 0)
        return;

    var selectedHero = heroSelector.options[heroSelector.selectedIndex];
    var params = (new URL(document.location)).searchParams;
    var page = params.get("page");
    var party = params.get("party_id");

    document.getElementById("rp-character-admin-table-party-add-shading").style.display = "block";
    isLoading = true;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            reloadScroll("page=" + page + "&party_id=" + party + "&hero_id=" + selectedHero.value);
        }
    };
    xhttp.open("GET", "../wp-content/plugins/sonnenstrasse-character/get-heroes.php?party_id=" + party, true);
    xhttp.send();
}

function setParty(party) {

    if (party == null) {
        document.getElementById("rp-character-admin-table-party-add-headline").textContent = "Neue Gruppe";
        document.getElementById("rp-character-admin-create-party-new").style.display = "inline-block";
        document.getElementById("rp-character-admin-create-party-edit").style.display = "none";
        document.getElementById("rp-character-admin-create-party-name").value = "Gruppe";
        gotoCurrentDate();
    }
    else {
        document.getElementById("rp-character-admin-table-party-add-headline").textContent = "Gruppe bearbeiten";
        document.getElementById("rp-character-admin-create-party-new").style.display = "none";
        document.getElementById("rp-character-admin-create-party-edit").style.display = "inline-block";
        document.getElementById("rp-character-admin-create-party-name").value = party.name;
        document.getElementById("rp-character-admin-create-party-current-year").value = party.current_year;
        document.getElementById("rp-character-admin-create-party-current-month").value = party.current_month;
        document.getElementById("rp-character-admin-create-party-current-day").value = party.current_day;
    }

    isLoading = false;
    document.getElementById("rp-character-admin-table-party-add-shading").style.display = "none";
}

function hidePartyDetails() {

    document.getElementById("rp-character-admin-table-party-add").style.display = "none";
    isCreating = false;
    isEditing = false;
}

function showPartyDetails(empty) {
    document.getElementById("rp-character-admin-table-party-add").style.display = "block";
    isCreating = empty;
    isEditing = !empty;
}

function openPartyDetails(empty) {

    if ((empty && isCreating) || (!empty && isEditing)) {
        hidePartyDetails();
    } 
    else if (empty) {
        // show empty party data
        setParty(null);
        showPartyDetails(empty);
    }
    else {
        // load and show party data
        isCreating = false;
        getSelectedParty(true);
    }
}

function updateSelectedMonth() {

    var current_month = document.getElementById("rp-character-admin-create-party-current-month").value;
    var hideDays = (current_month == 13);
    var current_day_element = document.getElementById("rp-character-admin-create-party-current-day");
    for (var index = 0; index < 30; index++) {
        var day_option = current_day_element.options[index];
        day_option.style.display = (hideDays && (index >= 5)) ? "none" : "block";
    }
    if (hideDays && (current_day_element.selectedIndex >= 5)) {
        current_day_element.selectedIndex = 0;
    }
}

function gotoCurrentDate() {
    
    var today = new Date();
    var newYear = new Date("07/01/" + (today.getFullYear() + (today.getMonth() < 6 ? -1 : 0)));
    var dayDiff = Math.min(364, Math.floor((today.getTime() - newYear.getTime()) / (1000 * 3600 * 24)));
    var dsaYear = today.getFullYear() - 977 + (today.getMonth() < 6 ? -1 : 0);
    var dsaMonth = Math.floor(dayDiff / 30) + 1;
    var dsaDay = dayDiff - ((dsaMonth - 1) * 30) + 1;

    document.getElementById("rp-character-admin-create-party-current-year").value = dsaYear;
    document.getElementById("rp-character-admin-create-party-current-month").value = dsaMonth;
    document.getElementById("rp-character-admin-create-party-current-day").value = dsaDay;
}

function addNewParty() {

    var name = document.getElementById("rp-character-admin-create-party-name").value;
    var current_year = document.getElementById("rp-character-admin-create-party-current-year").value;
    var current_month = document.getElementById("rp-character-admin-create-party-current-month").value;
    var current_day = document.getElementById("rp-character-admin-create-party-current-day").value;

    name = encodeURIComponent(name);
    current_year = encodeURIComponent(current_year);
    current_month = encodeURIComponent(current_month);
    current_day = encodeURIComponent(current_day);

    var parameters = "name=" + name;
    parameters += "&current_year=" + current_year;
    parameters += "&current_month=" + current_month;
    parameters += "&current_day=" + current_day;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText.substring(0, 9).toLowerCase() != "")
                alert(this.responseText);

            reloadScroll();
        }
    };

    xhttp.open("POST", "../wp-content/plugins/sonnenstrasse-character/create-party.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.setRequestHeader("Content-length", parameters.length);
    xhttp.send(parameters);
}

function editParty() {

    var partySelector = document.getElementById("rp-character-admin-select-party");
    if (partySelector.selectedIndex < 0)
        return;

    var selectedParty = partySelector.options[partySelector.selectedIndex];

    var name = document.getElementById("rp-character-admin-create-party-name").value;
    var current_year = document.getElementById("rp-character-admin-create-party-current-year").value;
    var current_month = document.getElementById("rp-character-admin-create-party-current-month").value;
    var current_day = document.getElementById("rp-character-admin-create-party-current-day").value;

    name = encodeURIComponent(name);
    current_year = encodeURIComponent(current_year);
    current_month = encodeURIComponent(current_month);
    current_day = encodeURIComponent(current_day);

    var parameters = "name=" + name;
    parameters += "&current_year=" + current_year;
    parameters += "&current_month=" + current_month;
    parameters += "&current_day=" + current_day;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText.substring(0, 9).toLowerCase() != "")
                alert(this.responseText);

            reloadScroll();
        }
    };

    xhttp.open("POST", "../wp-content/plugins/sonnenstrasse-character/edit-party.php?id=" + selectedParty.value, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.setRequestHeader("Content-length", parameters.length);
    xhttp.send(parameters);
}

function deleteParty() {

    var partySelector = document.getElementById("rp-character-admin-select-party");
    if (partySelector.selectedIndex < 0)
        return;

    var selectedParty = partySelector.options[partySelector.selectedIndex];
    if (!confirm("Sind sie sicher, dass sie die Abenteuergruppe '" + selectedParty.text + "' inkl. aller darin enthaltenen Helden löschen wollen?"))
        return;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText.substring(0, 9).toLowerCase() != "succeeded")
                alert(this.responseText);

            reloadScroll();
        }
    };
    xhttp.open("GET", "../wp-content/plugins/sonnenstrasse-character/delete-party.php?id=" + selectedParty.value, true);
    xhttp.send();
}

function regroupHero(id) {
	var partySelector = document.getElementById("regroupHeroPartys");
	if (partySelector.selectedIndex < 0)
        return;
	
	var selectedParty = partySelector.options[partySelector.selectedIndex];

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText.substring(0, 9).toLowerCase() != "succeeded")
                alert(this.responseText);

            reloadScroll();
        }
    };
    xhttp.open("GET", "../wp-content/plugins/sonnenstrasse-character/regroup-hero.php?id=" + id + "&group=" + selectedParty.value, true);
    xhttp.send();
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Heroes
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function createNewHero() {
    
    var partySelector = document.getElementById("rp-character-admin-select-party");
    if (partySelector.selectedIndex < 0)
        return;

    var selectedParty = partySelector.options[partySelector.selectedIndex];

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText.substring(0, 9).toLowerCase() != "")
                alert(this.responseText);

            reloadScroll();
        }
    };
    xhttp.open("GET", "../wp-content/plugins/sonnenstrasse-character/create-hero.php?party_id=" + selectedParty.value, true);
    xhttp.send();
}

function deleteHero(id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText.substring(0, 9).toLowerCase() != "succeeded")
                alert(this.responseText);

            reloadScroll();
        }
    };
    xhttp.open("GET", "../wp-content/plugins/sonnenstrasse-character/delete-hero.php?id=" + id, true);
    xhttp.send();
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Properties
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function saveProperty(hero_id, property_type, property_id) {
    var cost = document.getElementById("rp-character-admin-table-property-cost").value;
    var gp = document.getElementById("rp-character-admin-table-property-gp").value;
    var tgp = document.getElementById("rp-character-admin-table-property-tgp").value;
    var ap = document.getElementById("rp-character-admin-table-property-ap").value;
    var name = document.getElementById("rp-character-admin-table-property-name").value;
    var mod = document.getElementById("rp-character-admin-table-property-mod").value;
    var info = document.getElementById("rp-character-admin-table-property-info").value;
    var value = document.getElementById("rp-character-admin-table-property-value").value;
    var variant = document.getElementById("rp-character-admin-table-property-variant").value;
    var at = document.getElementById("rp-character-admin-table-property-at").value;
    var pa = document.getElementById("rp-character-admin-table-property-pa").value;
    var ebe = document.getElementById("rp-character-admin-table-property-ebe").value;
    var rarity = document.getElementById("rp-character-admin-table-property-rarity").value;
    var requirements = document.getElementById("rp-character-admin-table-property-requirements").value;
    var progression = document.getElementById("rp-character-admin-table-property-progression").value;
    var group = document.getElementById("rp-character-admin-table-property-group").value;
    var flavor = document.getElementById("rp-character-admin-table-property-flavor").value;
    var hyperlink = document.getElementById("rp-character-admin-table-property-hyperlink").value;

    hero_id = encodeURIComponent(hero_id);
    property_type = encodeURIComponent(property_type);
    property_id = encodeURIComponent(property_id);
    name = encodeURIComponent(name);
    mod = encodeURIComponent(mod);
    info = encodeURIComponent(info);
    value = encodeURIComponent(value);
    variant = encodeURIComponent(variant);
    cost = encodeURIComponent(cost);
    gp = encodeURIComponent(gp);
    tgp = encodeURIComponent(tgp);
    ap = encodeURIComponent(ap);
    at = encodeURIComponent(at);
    pa = encodeURIComponent(pa);
    ebe = encodeURIComponent(ebe);
    rarity = encodeURIComponent(rarity);
    requirements = encodeURIComponent(requirements);
    progression = encodeURIComponent(progression);
    group = encodeURIComponent(group);
    flavor = encodeURIComponent(flavor);
    hyperlink = encodeURIComponent(hyperlink);

    var parameters = "hero=" + hero_id;
    parameters += "&type=" + property_type;
    parameters += "&name=" + name;
    parameters += "&mod=" + mod;
    parameters += "&info=" + info;
    parameters += "&value=" + value;
    parameters += "&variant=" + variant;
    parameters += "&cost=" + cost;
    parameters += "&gp=" + gp;
    parameters += "&tgp=" + tgp;
    parameters += "&ap=" + ap;
    parameters += "&at=" + at;
    parameters += "&pa=" + pa;
    parameters += "&ebe=" + ebe;
    parameters += "&rarity=" + rarity;
    parameters += "&requirements=" + requirements;
    parameters += "&progression=" + progression;
    parameters += "&group=" + group;
    parameters += "&flavor=" + flavor;
    parameters += "&hyperlink=" + hyperlink;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText.substring(0, 9).toLowerCase() != "")
                alert(this.responseText);

            var query = document.location.search;
            if (query.indexOf("property_edit") < 0) {
                reloadScroll();
            }
            else {
                query = query.replace(new RegExp("\\&property_edit\\=[0-9]+", "ig"), "");
                reloadScroll(query);
            }
        }
    };

    xhttp.open("POST", "../wp-content/plugins/sonnenstrasse-character/edit-property.php?property_id=" + property_id, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(parameters);
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Details
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function saveDetail(hero_id, detail_type) {
    var detail_value = document.getElementById("rp-character-admin-table-detail").value;

    hero_id = encodeURIComponent(hero_id);
    detail_type = encodeURIComponent(detail_type);
    detail_value = encodeURIComponent(detail_value);

    var parameters = "hero=" + hero_id;
    parameters += "&type=" + detail_type;
    parameters += "&value=" + detail_value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText.substring(0, 9).toLowerCase() != "succeeded")
                alert(this.responseText);

            var query = document.location.search;
            if (query.indexOf("detail") < 0) {
                reloadScroll();
            }
            else {
                query = query.replace(new RegExp("\\&detail\\=[A-Za-z_]+", "ig"), "");
                query = query.replace(new RegExp("\\&detail_label\\=[A-Za-z_]+", "ig"), "");
                reloadScroll(query);
            }
        }
    };

    xhttp.open("POST", "../wp-content/plugins/sonnenstrasse-character/edit-detail.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(parameters);    
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Experience
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function addExperience() {

    var params = (new URL(document.location)).searchParams;
    var page = params.get("page");
    var party = params.get("party_id");
    var hero = params.get("hero_id");
    if (hero > 0)
        party = null;
    else
        hero = null;

    document.getElementById("rp-character-admin-table-party-add-shading").style.display = "block";
    isLoading = true;

    var date = document.getElementById("rp-character-admin-table-experience-date-year").value.padStart(4, '0') + "-" +
        document.getElementById("rp-character-admin-table-experience-date-month").value.padStart(2, '0') + "-" +
        document.getElementById("rp-character-admin-table-experience-date-day").value.padStart(2, '0');

    var parameters = (hero != null ? "hero_id=" + hero : "");
    parameters += (party != null ? "&party_id=" + party : "");
    parameters += "&ap=" + encodeURIComponent(document.getElementById("rp-character-admin-table-experience-ap").value);
    parameters += "&adventure=" + encodeURIComponent(document.getElementById("rp-character-admin-table-experience-adventure").value);
    parameters += "&dm=" + encodeURIComponent(document.getElementById("rp-character-admin-table-experience-dm").value);
    parameters += "&date=" + encodeURIComponent(date);
    parameters += "&region=" + encodeURIComponent(document.getElementById("rp-character-admin-table-experience-region").value);
    parameters += "&se=" + encodeURIComponent(document.getElementById("rp-character-admin-table-experience-se").value);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200 && this.responseText.substring(0, 9).toLowerCase() != "succeeded")
            reloadScroll("page=" + page + "&action=add" + (party != null ? "&party_id=" + party : "") + (hero != null ? "&hero_id=" + hero : ""));
        else console.error(this.responseText);
    };

    xhttp.open("POST", "../wp-content/plugins/sonnenstrasse-character/add-experience.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(parameters);
}

function editExperience(experience_id) {

    var params = (new URL(document.location)).searchParams;
    var page = params.get("page");
    var party = params.get("party_id");
    var hero = params.get("hero_id");

    document.getElementById("rp-character-admin-table-party-add-shading").style.display = "block";
    isLoading = true;

    var date = document.getElementById("rp-character-admin-table-experience-date-year").value.padStart(4, '0') + "-" +
        document.getElementById("rp-character-admin-table-experience-date-month").value.padStart(2, '0') + "-" +
        document.getElementById("rp-character-admin-table-experience-date-day").value.padStart(2, '0');

    var parameters = "id=" + encodeURIComponent(experience_id);
    parameters += "&ap=" + encodeURIComponent(document.getElementById("rp-character-admin-table-experience-ap").value);
    parameters += "&adventure=" + encodeURIComponent(document.getElementById("rp-character-admin-table-experience-adventure").value);
    parameters += "&dm=" + encodeURIComponent(document.getElementById("rp-character-admin-table-experience-dm").value);
    parameters += "&date=" + encodeURIComponent(date);
    parameters += "&region=" + encodeURIComponent(document.getElementById("rp-character-admin-table-experience-region").value);
    parameters += "&se=" + encodeURIComponent(document.getElementById("rp-character-admin-table-experience-se").value);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200 && this.responseText.substring(0, 9).toLowerCase() != "succeeded")
            reloadScroll("page=" + page + (party != null ? "&party_id=" + party : "") + (hero != null ? "&hero_id=" + hero : ""));
        else console.error(this.responseText);
    };

    xhttp.open("POST", "../wp-content/plugins/sonnenstrasse-character/edit-experience.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(parameters);
}

function deleteExperience(experience_id) {

    var params = (new URL(document.location)).searchParams;
    var page = params.get("page");
    var party = params.get("party_id");
    var hero = params.get("hero_id");
    if (hero > 0)
        party = null;
    else
        hero = null;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            reloadScroll("page=" + page + "&action=delete" + "&experience_id=" + experience_id + (party != null ? "&party_id=" + party : "") + (hero != null ? "&hero_id=" + hero : ""));
        }
    };
    xhttp.open("GET", "../wp-content/plugins/sonnenstrasse-character/delete-experience.php?id=" + experience_id, true);
    xhttp.send();

    return false;
}

function fillExperienceDate(dateString) {

    var splits = dateString.split("-");

    if (splits.length != 3)
        return;

    var year = splits[0];
    var month = splits[1];
    var day = splits[2];

    document.getElementById("rp-character-admin-table-experience-date-year").value = year;
    document.getElementById("rp-character-admin-table-experience-date-month").selectedIndex = (month - 1);
    document.getElementById("rp-character-admin-table-experience-date-day").value = day;
}


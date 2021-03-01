
function setClass(id, className)
{
	var characterWindow = document.getElementById(id); // "aventurien-character-window");
	characterWindow.className = className; // "aventurien-character-window-" + className;
	return false;
}

function blink(target)
{
    target.addEventListener("animationend", function ()
    {
        this.classList.remove("blink");
    });
    target.classList.add("blink");
}

var SKT = [
  [1, 1, 1, 2, 4, 5, 6, 8, 9, 11, 12, 14, 15, 17, 19, 20, 22, 24, 25, 27, 29, 31, 32, 34, 36, 38, 40, 42, 43, 45, 48],
  [1, 2, 3, 4, 6, 7, 8, 10, 11, 13, 14, 16, 17, 19, 21, 22, 24, 26, 27, 29, 31, 33, 34, 36, 38, 40, 42, 44, 45, 47, 50],
  [2, 4, 6, 8, 11, 14, 17, 19, 22, 25, 28, 32, 35, 38, 41, 45, 48, 51, 55, 58, 62, 65, 69, 73, 76, 80, 84, 87, 91, 95, 100],
  [2, 6, 9, 13, 17, 21, 25, 29, 34, 38, 43, 47, 51, 55, 60, 65, 70, 75, 80, 85, 95, 100, 105, 110, 115, 120, 125, 130, 135, 140, 150],
  [3, 7, 12, 17, 22, 27, 33, 39, 45, 50, 55, 65, 70, 75, 85, 90, 95, 105, 110, 115, 125, 130, 140, 145, 150, 160, 165, 170, 180, 190, 200],
  [4, 9, 15, 21, 28, 34, 41, 48, 55, 65, 70, 80, 85, 95, 105, 110, 120, 130, 135, 145, 155, 165, 170, 180, 190, 200, 210, 220, 230, 240, 250],
  [6, 14, 22, 32, 41, 50, 60, 75, 85, 95, 105, 120, 130, 140, 155, 165, 180, 195, 210, 220, 230, 250, 260, 270, 290, 300, 310, 330, 340, 350, 375],
  [8, 18, 30, 42, 55, 70, 85, 95, 110, 125, 140, 160, 175, 190, 210, 220, 240, 260, 270, 290, 310, 330, 340, 360, 380, 400, 420, 440, 460, 480, 500],
  [16, 35, 60, 85, 110, 140, 165, 195, 220, 250, 280, 320, 350, 380, 410, 450, 480, 510, 550, 580, 620, 650, 690, 720, 760, 800, 830, 870, 910, 950, 1000]
];

function levelupCalculateAp(initial, plan)
{
    var ap = 0;
    var steps = plan.split('|').filter(Boolean);
    var stepsCount = steps.length;
    for (var stepIndex = 0; stepIndex < stepsCount; stepIndex++)
    {
        var step = steps[stepIndex];

        var splits = step.split(';');
        var category = splits[1].toUpperCase().charCodeAt(0) - 64;
        category = Math.max(0, Math.min(8, category));

        var costs = SKT[category];
        ap += costs[Math.min(30, initial + stepIndex)];
    }

    return ap;
}

function levelupUpdateProgressionSteps(id, progression, plan)
{
    var progression_html = "";
    var plannedProgression = progression + "|" + plan;
    var steps = plannedProgression.split('|').filter(Boolean);
    var stepsCount = steps.length;
    for (var stepIndex = 0; stepIndex < stepsCount; stepIndex++)
    {
        var step = steps[stepIndex];

        var splits = step.split(';');
        var source = splits[0];
        var text = (splits.length > 3 ? splits[3] : "");

        if (text == "") {
            progression_html += '<span class="step ' + source + '"></span>';
        } else {
            progression_html += '<span class="step ' + source + '" data-tooltip="' + text + '"></span>';
        }
    }

    var progressionStepsElement = document.getElementById("aventurien-character-sheet-levelup-property-" + id + "-progression-steps");
    progressionStepsElement.innerHTML = progression_html;
}

function levelupChangeSe(inputElement, id)
{
    var propertyElement = document.getElementById("aventurien-character-sheet-levelup-property-" + id);
    propertyElement.dataset.se = inputElement.checked ? "1" : "0";
}

function levelupUpdateFreeAp()
{
    var totalInvest = 0;
    var propertyElements = document.getElementsByClassName("aventurien-character-sheet-levelup-property");
    var propertyElementsCount = propertyElements.length;
    for (var i = 0; i < propertyElementsCount; i++)
    {
        var propertyElement = propertyElements[i];
        var invest = Number(propertyElement.dataset.invest);
        if (!isNaN(invest))
            totalInvest += invest;
    }

    var levelupElement = document.getElementById("aventurien-character-sheet-levelup");
    var free = Number(levelupElement.dataset.free);
    levelupElement.dataset.invest = totalInvest;
    var remaining = free - totalInvest;

    var overviewElement = document.getElementById("aventurien-character-sheet-levelup-overview");
    overviewElement.dataset.remaining = remaining;
}

function levelupRecalculateDependencies()
{
    var propertyElements = document.getElementsByClassName("aventurien-character-sheet-levelup-property");
    var propertyElementsCount = propertyElements.length;
    for (var i = 0; i < propertyElementsCount; i++)
    {
        levelupCleanupModifications(propertyElements[i]);
    }
    for (var i = 0; i < propertyElementsCount; i++)
    {
        levelupApplyModifications(propertyElements[i]);
    }
    for (var i = 0; i < propertyElementsCount; i++)
    {
        var propertyElement = propertyElements[i];
        levelupRecalculateValue(propertyElement);
        levelupRecalculateRequirements(propertyElement);
    }
    levelupUpdateFreeAp();
}

function levelupCleanupModifications(propertyElement)
{
    propertyElement.dataset.category = propertyElement.dataset.initialcategory;
    propertyElement.dataset.factor = 1.0;
}

function levelupApplyModifications(propertyElement)
{
    var isTemplate = propertyElement.dataset.template;
    var queryModifier = propertyElement.dataset.modquery;
    if (queryModifier == null || queryModifier == "" || isTemplate != "false")
        return;

    var propertyElements = document.getElementsByClassName("aventurien-character-sheet-levelup-property");
    var propertyElementsCount = propertyElements.length;
    for (var i = 0; i < propertyElementsCount; i++)
    {
        var otherPropertyElement = propertyElements[i];
        var matchModifier = otherPropertyElement.dataset.modmatch;
        if (matchModifier != null && matchModifier.includes(queryModifier))
        {
            var categoryModifier = Number(propertyElement.dataset.modcategory);
            if (categoryModifier != 0)
            {
                var category = otherPropertyElement.dataset.category.charCodeAt(0) - 64 + categoryModifier;
                category = Math.max(0, Math.min(8, category));
                otherPropertyElement.dataset.category = String.fromCharCode(category + 64);
            }

            var factorModifier = propertyElement.dataset.modfactor;
            if (factorModifier != 0)
            {
                var factor = otherPropertyElement.dataset.factor;
                factor *= factorModifier;
                otherPropertyElement.dataset.factor = factor;
            }
        }
    }
}

function levelupRecalculateRequirements(propertyElement)
{
	try
	{
		var reqvalue = eval(propertyElement.dataset.req);
		propertyElement.dataset.reqvalue = reqvalue;
		if ((reqvalue == false) && (propertyElement.dataset.template == 'true'))
			propertyElement.dataset.invest = 0;
	}
	catch (e) { alert(e); }
}

function hasKampfAPs(ap)
{
	return false;
}

function has(id, minimum = 0)
{
    id = id.toLowerCase();
    id = id.replace(' ', '-');
    id = id.replace(' ', '-');
    id = id.replace(':', '-');
    id = id.replace('(', '-');
    id = id.replace(')', '-');
    id = id.replace('\'', '-');
    id = id.replace('\u00df' /*ß*/, 'ss');
    id = id.replace('\u00e4' /*ä*/, 'ae');
    id = id.replace('\u00f6' /*ö*/, 'oe');
    id = id.replace('\u00fc' /*ü*/, 'ue');

    var propertyElement = document.getElementById("aventurien-character-sheet-levelup-property-" + id);
    if (propertyElement == null)
        return false;

	if (minimum <= 0)
	{
		return !(propertyElement.dataset.template == "true"); 
	}

    var value = propertyElement.dataset.value;
    if (isNaN(value))
        return false;

    return (value >= minimum);
}

function levelupRecalculateValue(propertyElement)
{
    var id = propertyElement.dataset.id;
    var value = levelupGetVal(id);
    propertyElement.dataset.value = value;

    var valueElement = document.getElementById("aventurien-character-sheet-levelup-property-" + id + "-value");
    if (valueElement != null)
        valueElement.innerText = value;
}

function levelupGetVal(id)
{
    var propertyElement = document.getElementById("aventurien-character-sheet-levelup-property-" + id);
    var initial = Number(propertyElement.dataset.initial);
    if (isNaN(initial))
        return "-";
    var increase = Number(propertyElement.dataset.increase);
    var bonus = Number(eval(propertyElement.dataset.bonus));
    increase = isNaN(increase) ? 0 : increase;
    var value = initial + increase + bonus;
    return value;
}

function levelupProperty(id, inc)
{
    var apIncElement = document.getElementById("aventurien-character-sheet-levelup-property-" + id + "-ap-invest");
    var seBoxElement = document.getElementById("aventurien-character-sheet-levelup-property-" + id + "-se");
    var propertyElement = document.getElementById("aventurien-character-sheet-levelup-property-" + id);
    var initial = Number(propertyElement.dataset.initial);
    var increase = Number(propertyElement.dataset.increase);
    var invest = Number(propertyElement.dataset.invest);
    var category = propertyElement.dataset.category;
    var progression = propertyElement.dataset.progression;
    var plan = propertyElement.dataset.plan;
    var se = seBoxElement.checked;

    if (plan == undefined)
    {
        plan = "";
    }

    var prevInvest = levelupCalculateAp(initial, plan);

    if (inc < 0)
    {
        if (isNaN(increase))
            return false;

        increase += inc;

        var splits = plan.split('|');
        splits.pop();
        plan = splits.join('|');
    }
    else
    {
        if (isNaN(increase))
            increase = 0;

        increase += inc;

        var newPlanStep;
        if (se)
        {
            category = String.fromCharCode(category.charCodeAt(0) - 1);
            newPlanStep = "s;" + category + ";;Spezielle Erfahrung";
        }
        else
        {
            newPlanStep = "x;" + category;
        }

        var splits = plan.split('|').filter(Boolean);
        splits.push(newPlanStep);
        plan = splits.join('|');
    }

    var newInvest = levelupCalculateAp(initial, plan);

    var levelupElement = document.getElementById("aventurien-character-sheet-levelup");
    var freeAp = Number(levelupElement.dataset.free) - Number(levelupElement.dataset.invest);
    var neededAp = newInvest - prevInvest;

    if (neededAp > freeAp)
    {
        var overview = document.getElementById("aventurien-character-sheet-levelup-overview");
        blink(overview);
        return false;
    }

    invest = newInvest;

    if (increase == 0) { propertyElement.removeAttribute("data-increase"); }
    else { propertyElement.dataset.increase = increase; }

    propertyElement.dataset.invest = invest;
    propertyElement.dataset.plan = plan;
    apIncElement.innerText = (invest > 0 ? invest : "");
    seBoxElement.checked = false;
    levelupChangeSe(seBoxElement, id);
    levelupUpdateProgressionSteps(id, progression, plan);
    levelupRecalculateDependencies();
    return false;
}

function levelupFeat(propertyElement)
{
    var template = propertyElement.dataset.template.toLowerCase();
    var reqvalue = propertyElement.dataset.reqvalue.toLowerCase();
    if ((template == 'false') || (reqvalue == 'false'))
        return false;

    var cost = Number(propertyElement.dataset.cost);
    var invest = Number(propertyElement.dataset.invest);
    var factor = Number(propertyElement.dataset.factor);
    invest = (invest > 0) ? 0 : (cost * factor);

    var levelupElement = document.getElementById("aventurien-character-sheet-levelup");
    var freeAp = Number(levelupElement.dataset.free) - Number(levelupElement.dataset.invest);
    var neededAp = invest;

    if (neededAp > freeAp)
    {
        var overview = document.getElementById("aventurien-character-sheet-levelup-overview");
        blink(overview);
        return false;
    }

    propertyElement.dataset.invest = invest;
    levelupRecalculateDependencies();
    return false;
}

function levelupSave()
{
    var overview = document.getElementById("aventurien-character-sheet-levelup-overview");
    blink(overview);
    return false;
}

function levelupToggleActivate(groupElementId)
{
	var groupElement = document.getElementById(groupElementId);
	groupElement.dataset.activate = !(groupElement.dataset.activate == "true");
	return false;
}